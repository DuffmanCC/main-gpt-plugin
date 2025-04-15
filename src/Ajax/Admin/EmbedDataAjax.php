<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\PostMeta\AiMemory\ChunksNumberObject;
use MainGPT\PostMeta\AiMemory\EmbeddedDataObject;
use MainGPT\PostMeta\AiMemory\EmbedModelObject;
use MainGPT\PostMeta\AiMemory\TokenizedChunksObject;
use MainGPT\Service\OpenAiClient;
use MainGPT\Validation;
use MainGPT\Helpers\Utils;
use Exception;

class EmbedDataAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_embed_data_ajax';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    protected OpenAiClient $client;

    public function __construct(OpenAiClient $client)
    {
        $this->client = $client;
    }

    public function execute(): void
    {
        try {
            if (!check_ajax_referer('wp_rest', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            $id = (int) $_POST['data']['postId'];
            $chunks = get_post_meta($id, TokenizedChunksObject::FIELD_ID, true);

            $countChunks = count($chunks);
            $chunksNumber = (int) ChunksNumberObject::DEFAULT_VALUE;

            $batch = ($countChunks > $chunksNumber)
                ? array_chunk($chunks, $chunksNumber)
                : [$chunks];

            $embeddedData = [];
            $promptTokens = $totalTokens = $totalDimension = 0;

            $index = 0;
            update_post_meta($id, 'embedding-percentage', 0);

            foreach ($batch as $data) {
                $percentage = round(($index / count($batch)) * 100, 2);

                update_post_meta($id, 'embedding-percentage', $percentage);

                $index++;

                $texts = array_map(
                    function (array $chunk): string {
                        return $chunk['text'];
                    },
                    $data
                );

                $embeddingModel = EmbedModelObject::DEFAULT_VALUE;

                if (!Validation::validateEmbeddingModel($embeddingModel)) {
                    throw new \Exception('Invalid embedding model', 400);
                }

                $response = $this->client->embedData($embeddingModel, $texts);

                $result = array_map(
                    function (array $chunk, $embedding): array {
                        return [
                            'id' => $chunk['id'],
                            'values' => $embedding['embedding'],
                            'dimension' => count($embedding['embedding']),
                            'metadata' => [
                                'text' => $chunk['text'],
                                'chunk' => $chunk['chunk'],
                                'url' => $chunk['url']
                            ],
                        ];
                    },
                    $data,
                    $response['data']
                );

                $response['usage']['dimension'] = array_reduce(
                    $result,
                    function (int $carry, array $data): int {
                        $carry += $data['dimension'];
                        return $carry;
                    },
                    0
                );

                $embeddedData[] = [
                    'usage' => $response['usage'],
                    'data' => $result
                ];
                $promptTokens += $response['usage']['prompt_tokens'];
                $totalTokens += $response['usage']['total_tokens'];
                $totalDimension += $response['usage']['dimension'];
            }

            update_post_meta($id, 'embedding-percentage', 100);

            $array = [
                'embeddedData' => $embeddedData,
                'totalUsage' => [
                    'promptTokens' => $promptTokens,
                    'totalTokens' => $totalTokens,
                    'totalDimension' => $totalDimension
                ],
                'model' => $embeddingModel,
                'chunks' => $chunks
            ];

            update_post_meta($id, EmbeddedDataObject::FIELD_ID, $array);

            wp_send_json(
                [
                    'message' => 'Embedded ' . count($chunks) . ' chunks.',
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
