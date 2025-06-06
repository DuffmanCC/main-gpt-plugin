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
    public const INIT_NAME_LOGGED = 'wp_ajax_' . self::AJAX_ACTION; // Añadido para usuarios logueados

    public function init(): void
    {
        // not loged users
        add_action(self::INIT_NAME, [$this, $this->getMethodName()]);
        // loged users
        add_action(self::INIT_NAME_LOGGED, [$this, $this->getMethodName()]);
    }

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
        $this->initializeSession();

        if (!isset($_SESSION['chat_messages'])) {
            $_SESSION['chat_messages'] = [];
        }

        try {
            $this->setHeaders();

            $this->checkRateLimit(5, 60);

            // this line is important, otherwise it doesn't work the stream
            ob_end_clean();

            // Recibe el mensaje del usuario
            $prevMessage = $_POST['data']['prevMessage'];
            $message = $_POST['data'][Shortcode::QUERY_FIELD];
            $isNewConversation = filter_var($_POST['data']['isNewConversation'] ?? 'false', FILTER_VALIDATE_BOOLEAN);

            if ($isNewConversation) {
                // Reinicia la conversación si es una nueva
                $_SESSION['chat_messages'] = [];
            }

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
            $dbResponses = array_reduce(
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
                    'content' => 'Below is the information from the database that is related to the last message.'
                ],
                [
                    'role' => 'system',
                    'content' => $dbResponses
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
        error_log(__FILE__ . ':' . __LINE__ . ' | Model name: ' . $aiChatObject['modelName']);
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
        return $aiChatObject['topK'];
    }

    private function setHeaders(): void
    {
        /**
         * Disables response buffering in Nginx to allow real-time data streaming.
         *
         * By setting the 'X-Accel-Buffering' header to 'no', we instruct Nginx
         * to pass the response from the backend directly to the client without
         * buffering. This is useful for features like Server-Sent Events (SSE),
         * long-polling, or any kind of real-time output.
         *
         * Note: This header only has effect when the application is behind Nginx
         * and proxy buffering is enabled by default.
         */
        header('X-Accel-Buffering: no');
        header('Access-Control-Allow-Credentials: true');

        /*
         * CORs headers to allow cross-origin requests.
         */
        Utils::setCorsHeaders();
    }

    private function checkRateLimit(int $limit, int $window): void
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown_ip';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown_agent';
        $key = 'chat_rate_limit_' . md5($ip . '_' . $userAgent);

        $data = get_transient($key);

        if (!$data) {
            $data = ['count' => 1, 'start' => time()];
            set_transient($key, $data, $window);
            return;
        }

        $elapsed = time() - $data['start'];

        if ($elapsed >= $window) {
            $data = ['count' => 1, 'start' => time()];
            set_transient($key, $data, $window);
            return;
        }

        if ($data['count'] >= $limit) {
            throw new Exception('You have exceeded the maximum number of requests. Please try again later.', 429);
        }

        $data['count']++;
        set_transient($key, $data, $window);
    }

    private function initializeSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            $domain = parse_url($_SERVER['HTTP_ORIGIN'] ?? '', PHP_URL_HOST) ?? 'localhost';

            session_set_cookie_params([
                'lifetime' => 0,
                'path' => '/',
                'domain' => $domain,
                'secure' => true,
                'httponly' => true,
                'samesite' => 'None',
            ]);
            session_start();
        }
    }
}
