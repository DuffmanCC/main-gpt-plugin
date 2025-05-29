<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\PostMeta\AiChatter\AiChatObject;
use MainGPT\PostType\AiChatter;
use MainGPT\Helpers\Utils;
use MainGPT\Validation;

class SaveAiChatterAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_save_ai_chatter';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    public function execute(): void
    {
        try {
            check_ajax_referer(self::AJAX_ACTION, 'security');

            $id = $_POST['data']['postId'];
            $aiChatter = $_POST['data']['aiChatter'];
            $postStatus = get_post_status($id);

            if (Validation::isValidAiChatObject($aiChatter)) {
                if ($postStatus === 'auto-draft') {
                    // the ID returned is the same as the one passed in auto-draft
                    $id = wp_insert_post([
                        'ID'           => $id,
                        'post_status'  => 'publish',
                        'post_type'    => AiChatter::POST_TYPE
                    ]);

                    if (is_wp_error($id)) {
                        throw new Exception('Error creating post from auto-draft: ' . $id->get_error_message());
                    }
                }

                update_post_meta($id, AiChatObject::FIELD_ID, $aiChatter);
            } else {
                throw new Exception('Invalid AI Chat object.', 400);
            }

            wp_send_json(
                [
                    'message' => 'Data saved successfully.',
                ],
                200
            );
        } catch (Throwable $exception) {
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
