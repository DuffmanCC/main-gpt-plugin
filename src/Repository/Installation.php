<?php

namespace MainGPT\Repository;

use Throwable;
use MainGPT\Repository\Config;
use MainGPT\Service\OpenAiClient;
use MainGPT\PostMeta\AiChatter\ModelNameObject;
use MainGPT\Service\PineconeClient;

if (!defined('ABSPATH')) exit;

// TODO check at installation point if pretty permalinks are enabled
// if not, request to rest api will fail

final class Installation
{
    /**
     * @return bool
     */
    public static function checkOpenAiCredentials(): bool
    {
        $client = new \GuzzleHttp\Client();

        try {
            $client->get('https://api.openai.com/v1/models', [
                'headers' => [
                    'Authorization' => 'Bearer ' . Config::getOption(Config::OPTION_OPENAI_API_KEY),
                    'Content-Type' => 'application/json',
                ]
            ]);

            return true;
        } catch (Throwable $error) {
            error_log(__FILE__ . ':' . __LINE__ . $error->getMessage());
            return false;
        }
    }

    /**
     * @return bool
     */
    public static function checkPineconeCredentials(): bool
    {
        $config = new Config();
        $client = new \GuzzleHttp\Client();
        $PineconeClient = new PineconeClient($config, $client);

        try {
            $PineconeClient->listIndexes();

            return true;
        } catch (Throwable $error) {
            error_log(__FILE__ . ':' . __LINE__ . $error->getMessage());
            return false;
        }
    }
}
