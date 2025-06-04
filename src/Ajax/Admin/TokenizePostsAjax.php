<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\PostMeta\AiMemory\ChunkOverlapObject;
use MainGPT\PostMeta\AiMemory\ChunkSizeObject;
use MainGPT\PostMeta\AiMemory\SeparatorsObject;
use MainGPT\PostMeta\AiMemory\TokenizedChunksObject;
use MainGPT\PostMeta\AiMemory\PostIdsObject;
use MainGPT\Service\TokenizerClient;
use MainGPT\Helpers\Utils;

class TokenizePostsAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_tokenize_posts';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    protected TokenizerClient $tokenizer;

    public function __construct(TokenizerClient $tokenizer)
    {
        $this->tokenizer = $tokenizer;
    }

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $postIds = $_POST['data']['posts'];
            $id = (int) $_POST['data']['postId'];

            $data = [];

            foreach ($postIds as $post) {
                $postId = (string) $post['id'];

                if (str_contains($postId, '-')) {
                    $shippingMethod = $this->getShippingMethodById($postId);

                    $data[] = [
                        'url' => '',
                        'text' => $this->formatShippingMethod($shippingMethod)
                    ];
                } else {
                    $postObj = get_post((int) $postId);
                    $postType = get_post_type($postObj);

                    if ($postType === 'product') {
                        $productData = wc_get_product($postId);

                        $data[] = [
                            'url' => get_permalink($postObj->ID),
                            'text' => $this->formatProduct(
                                $productData,
                                wp_get_attachment_url($productData->get_image_id())
                            ),
                        ];
                    } else if ($postType === 'shop_coupon') {
                        $couponData = new \WC_Coupon($postId);

                        $data[] = [
                            'url' => '',
                            'text' => $this->formatCoupon($couponData),
                        ];
                    } else {
                        $data[] = [
                            'url' => get_permalink($postObj),
                            'text' => $postObj->post_content,
                        ];
                    }
                }
            }

            // even if tokenizer fails, we still want to save the posts
            update_post_meta($id, PostIdsObject::FIELD_ID, $postIds);

            // debug
            // error_log(__FILE__ . ':' . __LINE__ . ' | Tokenize posts: ' . print_r($data, true));

            $response['data'] = $this->tokenizer->tokenize(
                (int) ChunkSizeObject::DEFAULT_VALUE,
                (int) ChunkOverlapObject::DEFAULT_VALUE,
                SeparatorsObject::DEFAULT_VALUE,
                $data,
                $id
            );

            $response['message'] = 'Tokenized ' . count($data) . ' posts.';

            update_post_meta($id, TokenizedChunksObject::FIELD_ID, $response['data']['chunks']);

            wp_send_json(
                $response,
                $postIds,
                200
            );
        } catch (Throwable $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json(
                [
                    "code" => $exception->getCode(),
                    "message" => $exception->getMessage()
                ],
                $exception->getCode()
            );
        }
    }

    protected function formatCoupon(\WC_Coupon $couponData): string
    {
        $productIds = $couponData->get_product_ids();
        $products = !empty($productIds) ? implode(', ', $productIds) : 'No specific products';

        return
            "id: {$couponData->get_id()}\n" .
            "code: {$couponData->get_code()}\n" .
            "discount: {$couponData->get_amount()}\n" .
            "type: {$couponData->get_discount_type()}\n" .
            "usage: {$couponData->get_usage_count()}\n" .
            "limit: " . ($couponData->get_usage_limit() ?? 'null') . "\n" .
            "description: " . ($couponData->get_description() ?: 'null') . "\n" .
            "expires: " . ($couponData->get_date_expires() ? $couponData->get_date_expires()->date('Y-m-d H:i:s') : 'null') . "\n" .
            "applicable_products: {$products}\n";
    }

    protected function formatProduct(\WC_Product $productData, string $image): string
    {
        $variationsStock = '';
        $isVariable = $productData->is_type('variable');

        // Si es un producto variable, recorremos sus variaciones
        if ($isVariable) {
            $variation_ids = $productData->get_children();

            foreach ($variation_ids as $vid) {
                $variation = wc_get_product($vid);

                if (!$variation) {
                    continue;
                }

                $attributes = $variation->get_attributes();
                $attrStr = implode(', ', array_map(
                    fn($key, $value) => "$key: $value",
                    array_keys($attributes),
                    $attributes
                ));

                $stockQty = $variation->get_stock_quantity() ?? 'null';
                $stockStatus = $variation->get_stock_status();

                $variationsStock .= "- [$attrStr] => stock_quantity: $stockQty, stock_status: $stockStatus\n";
            }
        }

        return
            "id: {$productData->get_id()}\n" .
            "link: " . get_permalink($productData->get_id()) . "\n" .
            "name: {$productData->get_name()}\n" .
            "description: {$productData->get_description()}\n" .
            "price: {$productData->get_price()}\n" .
            "regular_price: {$productData->get_regular_price()}\n" .
            "sale_price: {$productData->get_sale_price()}\n" .
            "date_on_sale_from: " . ($productData->get_date_on_sale_from()?->date('Y-m-d H:i:s') ?? 'null') . "\n" .
            "date_on_sale_to: " . ($productData->get_date_on_sale_to()?->date('Y-m-d H:i:s') ?? 'null') . "\n" .
            ($isVariable ? '' : "stock_quantity: " . ($productData->get_stock_quantity() ?? 'null') . "\n") .
            ($isVariable ? '' : "stock_status: {$productData->get_stock_status()}\n") .
            "weight: " . ($productData->get_weight() ?: 'null') . "\n" .
            "length: " . ($productData->get_length() ?: 'null') . "\n" .
            "width: " . ($productData->get_width() ?: 'null') . "\n" .
            "height: " . ($productData->get_height() ?: 'null') . "\n" .
            "image: {$image}\n" .
            "variations_of_the_product:\n" . $variationsStock;
    }


    protected function formatShippingMethod(\WC_Shipping_Method $method): string
    {
        $title = $method->get_method_title();
        $description = strip_tags($method->get_method_description());
        $tax_status = $method->tax_status ?? 'not specified';
        $instance_settings = method_exists($method, 'get_instance_option') ? $method->instance_settings : [];
        $requires = $instance_settings['requires'] ?? 'none';
        $min_amount = $instance_settings['min_amount'] ?? '0';
        $ignore_discounts = $instance_settings['ignore_discounts'] ?? 'no';

        return
            "Shipping Method: {$title}\n" .
            "Tax Status: {$tax_status}\n" .
            "Description: {$description}\n" .
            "Requirements: " . match ($requires) {
                'coupon' => 'Requires a valid free shipping coupon',
                'min_amount' => 'Requires a minimum order amount',
                'either' => 'Requires a coupon OR a minimum order amount',
                'both' => 'Requires a coupon AND a minimum order amount',
                default => 'No special requirement',
            } . "\n" .
            "Minimum Order Amount: {$min_amount}\n" .
            "Apply Min Amount Before Discount: " . ($ignore_discounts === 'yes' ? 'Yes' : 'No') . "\n";
    }

    protected function getShippingMethodById(string $id): \WC_Shipping_Method | null
    {
        $arr = explode('-', $id);
        $zone_id = $arr[0];
        $method_id = $arr[1];

        $zone = new \WC_Shipping_Zone($zone_id);
        $methods = $zone->get_shipping_methods();

        foreach ($methods as $m) {
            if ($m->id === $method_id) {
                return $m;
            }
        }

        return null;
    }
}
