<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use GuzzleHttp\Exception\ClientException;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\Helpers\Utils;
use MainGPT\PostMeta\AiMemory\EmbedModelObject;

class TokenEstimationAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_token_estimation';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $ids = $_POST['data']['ids'] ?? '[]';

            if (!is_array($ids)) {
                new \WP_Error('invalid_params', 'ids must be an array', ['status' => 400]);
            }

            $results = array_map(function ($id) {
                $post = get_post($id);

                if (!$post) return null;

                $word_count = str_word_count(strip_tags($post->post_content));
                $estimated_tokens = (int) round($word_count * 1.33);

                return [
                    'id' => $id,
                    'word_count' => $word_count,
                    'estimated_tokens' => $estimated_tokens,
                ];
            }, $ids);


            $results = array_filter($results);

            $total_tokens = array_sum(array_column($results, 'estimated_tokens'));

            wp_send_json([
                'estimate_cost' => round($total_tokens * EmbedModelObject::PRICES[EmbedModelObject::DEFAULT_VALUE] / 1000000, 5),
                'total_tokens' => $total_tokens,
                'total_word_count' => array_sum(array_column($results, 'word_count')),
            ], 200);
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
}
