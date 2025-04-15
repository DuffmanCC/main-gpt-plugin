<?php

namespace MainGPT\Repository;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use MainGPT\App;

final class Config
{
    public const PREFIX = 'main-gpt_';
    public const SUFFIX = '_settings';
    public const OPTION_OPENAI_API_KEY = 'openai_api_key';
    public const OPTION_OPENAI_ORGANIZATION = 'openai_organization';
    public const OPTION_PINECONE_API_KEY = 'pinecone_api_key';
    public const OPTION_GDPR_SEMAPHORE = 'gdpr_semaphore';
    public const ALLOWED_OPTIONS = [
        self::OPTION_OPENAI_API_KEY,
        self::OPTION_OPENAI_ORGANIZATION,
        self::OPTION_PINECONE_API_KEY,
        self::OPTION_GDPR_SEMAPHORE,
    ];

    static public function getOptions(): false|array
    {
        return get_option(self::getOptionsName(), []);
    }

    /**
     * @param string $optionName
     * @return bool
     */
    static public function getOption(string $optionName): mixed
    {
        $options = self::getOptions();

        if (!array_key_exists($optionName, $options)) {
            error_log(__FILE__ . ':' . __LINE__ . " | config option name doesn't exists: " . $optionName);
            return null;
        }

        return $options[$optionName];
    }

    static public function setOptions(array $options, $autoload = null): bool
    {
        return update_option(self::getOptionsName(), $options);
    }

    static public function setOption(string $optionName, mixed $optionValue, $autoload = null): bool
    {
        $options = self::getOptions();
        $options[$optionName] = $optionValue;
        return self::setOptions($options, $autoload);
    }

    static public function getOptionsName(): string
    {
        return self::PREFIX . App::ID . self::SUFFIX;
    }

    static public function getVersion(): string | null
    {
        if (!function_exists('get_plugin_data')) {
            require_once ABSPATH . 'wp-admin/includes/plugin.php';
        }

        $pluginFile = WP_PLUGIN_DIR . '/main-gpt/main-gpt.php';

        if (!file_exists($pluginFile)) {
            return null;
        }

        $pluginData = get_plugin_data($pluginFile, false, false);

        return $pluginData['Version'] ?? null;
    }
}
