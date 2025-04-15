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
use JsonSchema\Validator;

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

            // To validate $aiChatter against the JSON schema, we need to:
            // Remove backslashes from the JSON string and decode it but what 
            // we save in the database is the original JSON string, $aiChatter.
            $unescaped_json_string = stripslashes($aiChatter);
            $json_object = json_decode($unescaped_json_string);

            if ($json_object === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("JSON decoding failed with error: " . json_last_error_msg());
            }

            $validator = new Validator;
            $validator->validate(
                $json_object,
                AiChatObject::jsonSchema()
            );

            if ($validator->isValid()) {
                if ($postStatus === 'auto-draft') {
                    // el ID que devuelve es el mismo que el que se le pasa en auto-draft
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
                $error_string =  "<strong>JSON does not validate</strong>. Violations:<br/>";

                foreach ($validator->getErrors() as $error) {
                    $error_string .= "<b>{$error['property']}</b>: {$error['message']}<br/>";
                }

                throw new Exception($error_string);
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
