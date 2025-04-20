<?php

namespace MainGPT\Ajax\Public;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;
use Exception;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\PostMeta\AiMemory\EmbedModelObject;
use MainGPT\Service\OpenAiClient;
use MainGPT\Service\PineconeClient;
use MainGPT\Shortcode\Shortcode;
use MainGPT\PostMeta\AiChatter\ModelNameObject;
use MainGPT\PostMeta\AiChatter\PrimerPromptObject;
use MainGPT\PostMeta\AiChatter\NumberOfAnswersObject;
use MainGPT\PostMeta\AiChatter\AiChatObject;
use MainGPT\Helpers\Utils;

class ChatBotAjax extends AbstractActionable
{
    use HookableTrait;

    public const AJAX_ACTION = App::ID . '_chat_bot_ajax';
    public const INIT_NAME = 'wp_ajax_nopriv_' . self::AJAX_ACTION;

    protected OpenAiClient $openAiClient;
    protected PineconeClient $pineconeClient;
    protected string $postType;

    public function __construct(
        OpenAiClient $openAiClient,
        PineconeClient $pineconeClient,
    ) {
        $this->openAiClient = $openAiClient;
        $this->pineconeClient = $pineconeClient;
    }

    public function execute(): void
    {
        session_start();
        session_destroy();
        session_id(uniqid());
        session_start();

        if (!isset($_SESSION['chat_messages'])) {
            $_SESSION['chat_messages'] = [];
        }

        // Desactivar buffering
        // if (function_exists('apache_setenv')) {
        //     @apache_setenv('no-gzip', 1);
        // }
        // @ini_set('zlib.output_compression', 0);
        // @ini_set('implicit_flush', 1);

        try {
            // this line is important, otherwise it doesn't work the stream
            ob_end_clean();

            $this->setHeaders();

            if (!check_ajax_referer('chat_gpt_nonce', 'security', false)) {
                throw new Exception('Invalid nonce', 403);
            }

            // Recibe el mensaje del usuario
            $prevMessage = $_POST['data']['prevMessage'];
            $message = $_POST['data'][Shortcode::QUERY_FIELD];

            if ($prevMessage) {
                $_SESSION['chat_messages'][] = [
                    'role' => 'assistant',
                    'content' => $prevMessage
                ];
            }

            $_SESSION['chat_messages'][] = [
                'role' => 'user',
                'content' => $message
            ];

            $aiChatterId = (int) $_POST['data']['aiChatterId'];
            $aiChatContentArray = [];

            /**
             * if aiChatId is set, means there is already a chat in the 
             * database and the user wants to continue the conversation
             */
            if (isset($_POST['data']['aiChatId'])) {
                $aiChatId = (int) $_POST['data']['aiChatId'];

                if ($aiChatId) {
                    $aiChatContent = get_the_content(null, false, $aiChatId);
                    $aiChatContentArray = $aiChatContent ? json_decode($aiChatContent, true) : [];
                }
            }

            // create the embedding data of our message
            $embed = $this->openAiClient->embedData(
                EmbedModelObject::DEFAULT_VALUE,
                $message
            );

            $request = $embed['data'][0]['embedding'];
            $indexName = $this->getPineconeIndex($aiChatterId);
            $info = $this->pineconeClient->indexInfo($indexName);
            $topK = $this->getTopK($aiChatterId);

            // search in pinecone the embedding message
            $search = $this->pineconeClient->query(
                $info['host'],
                $request,
                $topK,
            );

            // reduce the search results to a string
            $query = array_reduce(
                $search['matches'],
                function (string $carry, array $match): string {
                    $carry .= $match['metadata']['text'] . "\n\n---\n\n";
                    return $carry;
                },
                '' // start with an empty string
            );

            $messages = [
                [
                    'role' => 'system',
                    'content' => $this->getPrimerPrompt($aiChatterId)
                ],
                [
                    'role' => 'system',
                    'content' => 'Always respond in HTML format without escaping tags or wrapping the response in quotes. The tags allowed are: a, p, div, strong, b, ul, ol, li, img, h2, h3, h4, h5, h6, blockquote, pre, code, span.'
                ],
                [
                    'role' => 'system',
                    'content' => 'Below is the context of the conversation from previous messages. Is there is no previous messages means that is the first message of the conversation.'
                ],
                ...$aiChatContentArray,
                ...$_SESSION['chat_messages'],
                [
                    'role' => 'system',
                    'content' => 'Below is the information from the database that is related to the conversation.'
                ],
                [
                    'role' => 'system',
                    'content' => $query
                ]
            ];

            // this is for debugging purposes
            // error_log(print_r($messages, true));

            // this prints the response to the client and it's sent 
            // directly without json response because it's a stream
            $this->openAiClient->chatCompletion(
                $this->getModelName($aiChatterId),
                $messages
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

    private function getPrimerPrompt(int | null $id): string
    {
        if (!$id) return PrimerPromptObject::DEFAULT_VALUE;

        $aiChatString = get_post_meta($id, AiChatObject::FIELD_ID, true);
        $aiChatObject = json_decode($aiChatString, true);
        return $aiChatObject['primerPrompt'];
    }

    private function getModelName(int | null $id): string
    {
        if (!$id) return ModelNameObject::DEFAULT_VALUE;

        $aiChatString = get_post_meta($id, AiChatObject::FIELD_ID, true);
        $aiChatObject = json_decode($aiChatString, true);
        return $aiChatObject['modelName'];
    }

    private function getPineconeIndex(int | null $id): string
    {
        if (!$id) return '';

        $aiChatString = get_post_meta($id, AiChatObject::FIELD_ID, true);
        $aiChatObject = json_decode($aiChatString, true);
        return $aiChatObject['pineconeIndex'];
    }

    private function getTopK(int | null $id): int
    {
        if (!$id) return NumberOfAnswersObject::DEFAULT_VALUE;

        $aiChatString = get_post_meta($id, AiChatObject::FIELD_ID, true);
        $aiChatObject = json_decode($aiChatString, true);
        return $aiChatObject['questionsLimit'];
    }

    private function setHeaders(): void
    {
        // header('Access-Control-Allow-Methods: POST');
        // header('Access-Control-Allow-Credentials: true');

        /*
        * en local con la cabecera -> funciona con streaming
        * en local sin la cabecera -> funciona con streaming pero no se ve la pestaña EventStream
        * en wpengine con la cabecera -> no funciona, no devuelve nada pero aparece la pestaña EventStream
        * en wpengine sin la cabecera -> no funciona, devuelve Bad Getaway, sin pestaña EventStream
        */
        // header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        /*
        * en local con la cabecera -> funciona con streaming
        * en local sin la cabecera -> funciona con streaming
        * en wpengine con la cabecera -> no funciona, no devuelve nada pero aparece la pestaña EventStream
        * en wpengine sin la cabecera -> no funciona pero devuelve la respuesta sin la pestaña EventStream, aunque no lo renderiza el cliente
        */
        // header('Connection: keep-alive');
        // header('Transfer-Encoding: chunked');
        header('X-Accel-Buffering: no');
    }
}
