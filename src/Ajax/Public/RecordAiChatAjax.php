<?php

namespace MainGPT\Ajax\Public;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\PostMeta\AiChat\MessagesObject;
use MainGPT\Helpers\Utils;

class RecordAiChatAjax extends AbstractActionable
{
    use HookableTrait;

    public const AJAX_ACTION = App::ID . '_record_ai_chat_ajax';
    public const INIT_NAME = 'wp_ajax_nopriv_' . self::AJAX_ACTION;
    public const INIT_NAME_LOGGED = 'wp_ajax_' . self::AJAX_ACTION; // Añadido para usuarios logueados

    public function init(): void
    {
        // not loged users
        add_action(self::INIT_NAME, [$this, $this->getMethodName()]);
        // loged users
        add_action(self::INIT_NAME_LOGGED, [$this, $this->getMethodName()]);
    }

    public function execute(): void
    {
        Utils::setCorsHeaders();

        try {
            $data = $_POST['data'];

            $response = $this->recordChatHistory($data);

            wp_send_json([
                'message' => $response,
            ], 200);
        } catch (Throwable $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode()
            ], $exception->getCode());
        }
    }

    public function recordChatHistory(array $data): int | bool
    {
        $postId = (int) $data['aiChatId'];
        $newMessages = $data['aiChatMessage'];
        $previousMessages = get_post_meta($postId, MessagesObject::FIELD_ID, true);
        $decodedPreviousMessages = base64_decode($previousMessages);

        $newContent = $this->decodeMessage($newMessages, true);

        $decodedMessages = [];

        if ($previousMessages !== '') {
            $decodedMessages = $this->decodeMessage($decodedPreviousMessages, false);
        }

        if (is_array($newContent) && isset($newContent['role']) && isset($newContent['content'])) {
            $role = $newContent['role'];
            $content = $newContent['content'];

            // Add the new content to the existing messages
            $decodedMessages[] = [
                'role' => $role,
                'content' => $content
            ];
        }

        $contentJson = json_encode($decodedMessages);
        $encodedContentJson = base64_encode($contentJson);

        if (!$contentJson) {
            // Encoding failed
            error_log(__FILE__ . ':' . __LINE__ . ' | JSON Error: ' . json_last_error_msg());
            throw new Exception('json_error', json_last_error_msg());
        }

        $updateResult = update_post_meta($postId, MessagesObject::FIELD_ID, $encodedContentJson);

        if ($updateResult === false) {
            throw new Exception('update_error', json_last_error_msg());
        }

        return $updateResult;
    }

    /**
     * Decodes a JSON string into an array.
     *
     * @param string $message The JSON string to decode.
     * @param bool $stripslashes Whether to remove backslashes from the string before decoding.
     * @return array The decoded array.
     * @throws Exception If there was a problem decoding the JSON.
     */
    private function decodeMessage(string $message, bool $stripslashes = true): array
    {
        if ($stripslashes) {
            $unescapedJsonStr = stripslashes($message);
            // Decode the JSON string
            $data = json_decode($unescapedJsonStr, true);
        }

        if (!$stripslashes) {
            $data = json_decode($message, true);
        }

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            error_log(__FILE__ . ':' . __LINE__ . ' | JSON Error: ' . json_last_error_msg());
            throw new Exception('json_error', json_last_error());
        }

        return $data;
    }
}
