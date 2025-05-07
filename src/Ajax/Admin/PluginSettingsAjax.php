<?php

namespace MainGPT\Ajax\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;
use MainGPT\AbstractActionable;
use MainGPT\App;
use MainGPT\HookableTrait;
use MainGPT\Repository\Config;
use MainGPT\Validation;
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

            wp_send_json([
                'message' => 'Settings saved.',
            ], 200);
        } catch (Throwable $exception) {
            Utils::errorLog(__FILE__, __LINE__, $exception);

            wp_send_json([
                'message' => $exception->getMessage(),
            ], $exception->getCode());
        }
    }
}
