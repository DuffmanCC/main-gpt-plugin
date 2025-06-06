<?php

namespace MainGPT\Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use MainGPT\PostMeta\AiMemory\AiMemoryObject;
use MainGPT\PostMeta\AiMemory\IndexNameObject;
use MainGPT\PostMeta\AiMemory\PostIdsObject;
use MainGPT\Service\PineconeClient;
use MainGPT\Repository\Config;
use MainGPT\PostMeta\AiMemory\AmountOfSpaceObject;
use MainGPT\Helpers\Utils;

final class AiMemoryHelper
{
    public static function aiMemory($postId): array | object
    {
        $jsonString = get_post_meta($postId, AiMemoryObject::FIELD_ID, true);

        if (empty($jsonString)) {
            return AmountOfSpaceObject::DEFAULT;
        }

        $phpObject = json_decode($jsonString);

        if ($phpObject === null && json_last_error() !== JSON_ERROR_NONE) {
            error_log(self::class . "JSON decoding failed with error: " . json_last_error_msg());

            return AmountOfSpaceObject::DEFAULT;
        }

        return json_decode($jsonString);
    }

    /**
     * get the status of a Pinecone index
     * 
     * @param string $name
     */
    public static function indexStatus($postId): string
    {
        $indexName = get_post_meta($postId, IndexNameObject::FIELD_ID, true);

        if (empty($indexName)) {
            return 'disconnected';
        }

        $config = new Config();
        $client = new \GuzzleHttp\Client();

        $pineconeClient = new PineconeClient(
            $config,
            $client
        );

        $numberOfVectors = $pineconeClient->numberOfVectors($indexName);

        if ($numberOfVectors === -1) {
            return 'disconnected';
        }

        if ($numberOfVectors === 0) {
            return 'connected';
        }

        return 'trained';
    }

    public static function deleteIndex($indexName): bool
    {
        $config = new Config();
        $client = new \GuzzleHttp\Client();

        $pineconeClient = new PineconeClient(
            $config,
            $client
        );

        try {
            $response = $pineconeClient->deleteIndex($indexName);

            if ($response->getStatusCode() === 202) {
                return true;
            }

            return false;
        } catch (\Exception $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            return false;
        }
    }

    public static function addedPosts($postId): string
    {
        $addedPosts = get_post_meta($postId, PostIdsObject::FIELD_ID, true);

        if (empty($addedPosts)) {
            return json_encode([], true);
        }

        return $addedPosts;
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public static function getPostTypes(): array
    {
        if (class_exists('WooCommerce')) {
            return [
                ['value' => 'post', 'label' => 'Posts'],
                ['value' => 'page', 'label' => 'Pages'],
                ['value' => 'product', 'label' => 'Products'],
                ['value' => 'shop_coupon', 'label' => 'Coupons'],
                ['value' => 'shipping_method', 'label' => 'Shipping Methods']
            ];
        }

        return [
            ['value' => 'post', 'label' => 'Posts'],
            ['value' => 'page', 'label' => 'Pages']
        ];
    }
}
