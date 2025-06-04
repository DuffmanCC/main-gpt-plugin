<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use GuzzleHttp\Exception\ClientException;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\Helpers\Utils;

class GetPostsAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_get_posts';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $type = $_POST['data']['type'] ?? 'posts';

            if ($type === 'shipping_method') {
                $shipping_methods = $this->getShippingMethods();
                wp_send_json($shipping_methods, 200);
                return;
            }

            $perPage = (int) ($_POST['data']['perPage'] ?? 10);
            $page = (int) ($_POST['data']['page'] ?? 1);
            $taxonomy = $_POST['data']['taxonomy'] ?? '';
            $term = $_POST['data']['term'] ?? '';
            $search = $_POST['data']['search'] ?? '';

            $args = [
                'post_type'      => $type,
                'posts_per_page' => $perPage,
                'paged'          => $page,
                's'              => $search,
                'post_status'    => 'publish',
                'fields'         => 'ids',
            ];

            // Taxonomy filter
            if ($taxonomy && $term) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => $taxonomy,
                        'field'    => 'term_id',
                        'terms'    => [$term],
                    ],
                ];
            }

            $query = new \WP_Query($args);
            $posts = [];
            foreach ($query->posts as $post_id) {
                $posts[] = [
                    'id'    => $post_id,
                    'title' => get_the_title($post_id),
                ];
            }

            wp_send_json($posts, 200);
        } catch (ClientException $exception) {
            error_log(__FILE__ . ":" . __LINE__ . " | execute unexpected error.");
            error_log($exception->getCode() . ' - ' . $exception->getMessage());

            $response = $exception->getResponse();
            $responseBody = $response->getBody()->getContents();

            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json(
                [
                    "message" => $responseBody,
                ],
                500
            );
        } catch (Exception $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json(
                [
                    "code" => $exception->getCode(),
                    "message" => $exception->getMessage(),
                ],
                $exception->getCode()
            );
        }
    }

    private function getShippingMethods(): array
    {
        $shipping_zones = \WC_Shipping_Zones::get_zones();

        $shipping_methods = [];

        foreach ($shipping_zones as $zone) {
            $methods = $zone['shipping_methods'];

            foreach ($methods as $method) {
                if (!$method->is_enabled()) continue;

                $shipping_methods[] = [
                    'id' => $zone['id'] . '-' . $method->id,
                    'title' => $zone['zone_name'] . ' - ' . $method->method_title
                ];
            }
        }

        return $shipping_methods;
    }
}
