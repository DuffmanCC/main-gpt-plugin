<?php

namespace MainGPT\Ajax\Public;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\PostMeta\AiChat\TimestampObject;
use MainGPT\PostMeta\AiChat\CampaignsObject;
use MainGPT\Validation;
use MainGPT\PostType\AiChat;
use Exception;
use MainGPT\Helpers\Utils;

class CreateAiChatAjax extends AbstractActionable
{
    use HookableTrait;

    public const AJAX_ACTION = App::ID . '_create_ai_chat_ajax';
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
            $aiChatId = $this->createAiChat($data);

            wp_send_json([
                'aiChatId' => $aiChatId
            ], 200);
        } catch (Throwable $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ], $exception->getCode());
        }
    }

    private function createDate()
    {
        date_default_timezone_set('UTC');

        return date('Y-m-d H:i:s');
    }

    private function campaingsIds(array $data): string
    {
        if (is_null($data)) {
            return '';
        }

        return implode(',', $data);
    }

    private function createAiChat(array | null $data): int | \WP_Error
    {
        if (is_null($data)) {
            return new \WP_Error('no_data', 'No data was sent.');
        }

        if (!Validation::validateCampaignIds($data[CampaignsObject::FIELD_ID])) {
            return new \WP_Error('invalid_campaign_ids', 'Invalid campaign ids.');
        }

        $post = [
            'post_author'   => 0,
            'post_title'    => $this->createDate(),
            'post_type'     => AiChat::POST_TYPE,
            'post_status'   => 'publish',
            'meta_input'    => [
                TimestampObject::FIELD_ID   => time(),
                CampaignsObject::FIELD_ID => $this->campaingsIds($data[CampaignsObject::FIELD_ID])
            ]
        ];

        return wp_insert_post($post, true);
    }
}
