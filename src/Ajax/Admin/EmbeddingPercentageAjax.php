<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;
use Exception;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\Helpers\Utils;

class EmbeddingPercentageAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_embedding_percentage_ajax';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $id = (int) $_POST['data']['postId'];

            $percentage = get_post_meta($id, 'embedding-percentage', true);

            wp_send_json(
                [
                    'progress' => $percentage
                ],
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
}
