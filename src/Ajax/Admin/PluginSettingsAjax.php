<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\Repository\Config;
use MainGPT\Validation;
use MainGPT\Repository\Installation;
use MainGPT\Helpers\Utils;

class PluginSettingsAjax extends AbstractActionable
{
    use HookableTrait;
    public const AJAX_ACTION = App::ID . '_plugin_settings_ajax';
    public const INIT_NAME = 'wp_ajax_' . self::AJAX_ACTION;

    public function execute(): void
    {
        try {
            check_ajax_referer(self::AJAX_ACTION, 'security');

            $settings = json_decode(stripslashes($_POST['data']['settings']), true);

            $areOpenAiCredentialsValid = Config::getOption(Config::OPTION_ARE_OPENAI_CREDENTIALS_VALID) ? true : false;
            $isPineconeApiKeyValid = Config::getOption(Config::OPTION_ARE_PINECONE_CREDENTIALS_VALID) ? true : false;

            foreach ($settings as $key => $value) {
                if (
                    in_array($key, Config::ALLOWED_OPTIONS, true) &&
                    Validation::validateLowerUpperWithHyphens($value)
                ) {
                    Config::setOption($key, $value);
                } else {
                    throw new \Exception("Invalid value for $key");
                }
            }

            foreach ($settings as $key => $value) {
                if (
                    $key === Config::OPTION_PINECONE_API_KEY
                ) {
                    $isPineconeApiKeyValid = Installation::checkPineconeCredentials();

                    Config::setOption(Config::OPTION_ARE_PINECONE_CREDENTIALS_VALID, $isPineconeApiKeyValid);

                    $this->checkIsMainGptConfigured();

                    if (!$isPineconeApiKeyValid) {
                        throw new \Exception("Invalid pinecone credentials");
                    }
                }

                if (
                    $key === Config::OPTION_OPENAI_API_KEY ||
                    $key === Config::OPTION_OPENAI_ORGANIZATION
                ) {
                    $areOpenAiCredentialsValid = Installation::checkOpenAiCredentials();

                    Config::setOption(Config::OPTION_ARE_OPENAI_CREDENTIALS_VALID, $areOpenAiCredentialsValid);

                    $this->checkIsMainGptConfigured();

                    if (!$areOpenAiCredentialsValid) {
                        throw new \Exception("Invalid openai credentials");
                    }
                }
            }

            wp_send_json([
                'message' => 'Settings saved.',
                'isPineconeApiKeyValid' => Config::getOption(Config::OPTION_ARE_PINECONE_CREDENTIALS_VALID) ? true : false,
                'areOpenAiCredentialsValid' => Config::getOption(Config::OPTION_ARE_OPENAI_CREDENTIALS_VALID) ? true : false,
                'isPluginConfigured' => Config::getOption(Config::OPTION_IS_PLUGIN_CONFIGURED) ? true : false,
                'isActivePlugin' => Config::getOption(Config::OPTION_IS_ACTIVE_PLUGIN) ? true : false,
            ], 200);
        } catch (Throwable $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json([
                'message' => $exception->getMessage(),
                'code' => $exception->getCode(),
                'isPineconeApiKeyValid' => Config::getOption(Config::OPTION_ARE_PINECONE_CREDENTIALS_VALID) ? true : false,
                'areOpenAiCredentialsValid' => Config::getOption(Config::OPTION_ARE_OPENAI_CREDENTIALS_VALID) ? true : false,
            ], $exception->getCode());
        }
    }

    private function checkIsMainGptConfigured(): void
    {
        $isPineconeApiKeyValid = Config::getOption(Config::OPTION_ARE_PINECONE_CREDENTIALS_VALID) ? true : false;
        $areOpenAiCredentialsValid = Config::getOption(Config::OPTION_ARE_OPENAI_CREDENTIALS_VALID) ? true : false;

        if (
            $areOpenAiCredentialsValid &&
            $isPineconeApiKeyValid
        ) {
            Config::setOption(Config::OPTION_IS_PLUGIN_CONFIGURED, true);
        } else {
            Config::setOption(Config::OPTION_IS_PLUGIN_CONFIGURED, false);
        }
    }
}
