<?php

namespace MainGPT\Service;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Exception;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use MainGPT\Repository\Config;

class OpenAiClient
{
    protected string $apiKey;
    protected string $organization;
    protected ClientInterface $client;
    protected string $embedUrl;
    protected string $chatCompletionUrl;

    public function __construct(
        Config $config,
        ClientInterface $client,
        string $embedUrl,
        string $chatCompletionUrl
    ) {
        $this->apiKey = $config::getOption($config::OPTION_OPENAI_API_KEY) ?? '';;
        $this->organization = $config::getOption($config::OPTION_OPENAI_ORGANIZATION) ?? '';;
        $this->client = $client;
        $this->embedUrl = $embedUrl;
        $this->chatCompletionUrl = $chatCompletionUrl;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function embedData(string $modelName, string|array $data): array
    {
        $response = $this->client->request(
            'POST',
            $this->embedUrl,
            [
                'headers' => $this->getAuthenticatedHeaders(),
                'json' => [
                    'model' => $modelName,
                    'input' => $data
                ]
            ]
        );

        $body = $response->getBody()->getContents();

        if (200 != $response->getStatusCode()) {
            /**
             * @todo Substitute this with an Exception class
             */
            throw new Exception(
                __FILE__ . ":" . __LINE__ . " | embedData response error with body: " . $body
            );
        }

        $responseArray = json_decode($body, true);

        $lastError = json_last_error();
        if (JSON_ERROR_NONE != $lastError) {
            /**
             * @todo Substitute this with an Exception class
             */
            throw new Exception(
                __FILE__ . ":" . __LINE__ . " | embedData cannot decode body, error id: " . $lastError .
                    " and body: " . $body
            );
        }

        return $responseArray;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    public function chatCompletion(string $modelName, array $messages): void
    {
        $response = $this->client->request(
            'POST',
            $this->chatCompletionUrl,
            [
                'stream' => true, // Guzzle stream option
                'headers' => $this->getAuthenticatedHeaders(),
                'json' => [
                    'model' => $modelName,
                    'messages' => $messages,
                    'stream' => true // OpenAI stream option
                ]
            ]
        );

        $body = $response->getBody();

        $buffer = '';

        // While the stream hasn't reached the end, we read the lines
        while (!$body->eof()) {
            $buffer .= $body->read(1024); // Read in 1024-byte chunks, but this is just to avoid blocking on a very long block

            // Process each line when we have a complete one
            $lines = explode("\n", $buffer);
            $buffer = array_pop($lines);  // Save the last part (possibly incomplete)

            foreach ($lines as $line) {
                $line = trim($line);

                if (empty($line) || !str_starts_with($line, 'data: ')) {
                    continue;
                }

                $json = substr($line, 6); // Remover 'data: '

                if ($json === "[DONE]") {
                    echo $json;
                    flush();
                    break;
                }

                $decoded = json_decode($json, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    error_log(__FILE__ . ':' . __LINE__ . " | JSON decode error: " . json_last_error() . " | Data: " . $json);
                    continue;
                }

                if (isset($decoded['choices'][0]['delta']['content'])) {
                    $content = $decoded['choices'][0]['delta']['content'];
                    echo "$content";
                    flush();
                    ob_flush();
                }
            }
        }
    }

    /**
     * @throws GuzzleException
     */
    protected function getAuthenticatedHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'OpenAI-Organization' => $this->organization
        ];
    }
}
