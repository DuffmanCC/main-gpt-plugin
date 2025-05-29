<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use GuzzleHttp\Exception\ClientException;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\Helpers\Utils;

class GetTermsByTaxonomyAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_get_terms_by_taxonomy';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $taxonomy = sanitize_text_field($_POST['data']['taxonomy'] ?? '');

            if (!$taxonomy || !taxonomy_exists($taxonomy)) {
                wp_send_json_error('Invalid taxonomy', 400);
            }

            $all_terms = [];
            $page = 1;
            $per_page = 100;

            do {
                $terms = get_terms([
                    'taxonomy' => $taxonomy,
                    'hide_empty' => false,
                    'number' => $per_page,
                    'offset' => ($page - 1) * $per_page,
                ]);

                if (is_wp_error($terms)) {
                    wp_send_json_error($terms->get_error_message());
                }

                $all_terms = array_merge($all_terms, $terms);
                $page++;
            } while (count($terms) === $per_page);

            $response = array_map(function ($term) {
                return [
                    'id' => $term->term_id,
                    'name' => $term->name,
                    'count' => $term->count,
                ];
            }, $all_terms);

            wp_send_json($response);
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
