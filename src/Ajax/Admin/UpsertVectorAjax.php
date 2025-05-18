<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\PostMeta\AiMemory\EmbeddedDataObject;
use MainGPT\PostMeta\AiMemory\IndexNameObject;
use MainGPT\Service\OpenAiClient;
use MainGPT\Service\PineconeClient;
use MainGPT\Helpers\Utils;

class UpsertVectorAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_upsert_vector_ajax';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    protected OpenAiClient $openAiClient;
    protected PineconeClient $pineconeClient;

    public function __construct(
        OpenAiClient $openAiClient,
        PineconeClient $pineconeClient
    ) {
        $this->openAiClient = $openAiClient;
        $this->pineconeClient = $pineconeClient;
    }

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $id = (int) $_POST['data']['postId'];
            $values = get_post_meta($id, EmbeddedDataObject::FIELD_ID, true);
            // $json = get_post_meta($id, EmbeddedDataObject::FIELD_ID, true);

            // $values = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Invalid JSON decoding embedding data ' . json_last_error_msg());
            }

            $indexName = $_POST['data']['indexName'];

            $info = $this->pineconeClient->indexInfo($indexName);
            $stats = $this->pineconeClient->indexStats($indexName);

            if ($stats['totalVectorCount'] > 0) {
                $this->pineconeClient->deleteAllVectors($info['host']);
            }

            $vectors = [];

            foreach ($values['embeddedData'] as $embed) {
                foreach ($embed['data'] as $data) {
                    $vectors[] = [
                        'id' => $data['id'],
                        'values' => $data['values'],
                        'metadata' => $data['metadata']
                    ];
                }
            }

            foreach (array_chunk($vectors, 10) as $vector) {
                $this->pineconeClient->upsert(
                    $info['host'],
                    $vector
                );
            }

            update_post_meta($id, IndexNameObject::FIELD_ID, $indexName);

            wp_send_json(
                [
                    'message' => 'The vectors have been successfully upserted'
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
