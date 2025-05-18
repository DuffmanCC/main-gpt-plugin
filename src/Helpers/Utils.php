<?php

namespace MainGPT\Helpers;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use Throwable;

final class Utils
{
    public static function errorLog(string $file, int $line, Throwable $exception, bool $isAbsolute = false): void
    {
        $basePath = WP_PLUGIN_DIR . '/main-gpt/';

        $shortFile = str_starts_with($file, $basePath) ? substr($file, strlen($basePath)) : $file;

        $route = !$isAbsolute ? $shortFile : $file;

        error_log($route . ':' . $line . ' | ' . $exception->getCode() . ' - ' . $exception->getMessage());
    }

    public static function setCorsHeaders()
    {
        // header('Access-Control-Allow-Origin: https://www.maingpt.chat');
        header('Access-Control-Allow-Origin: http://localhost:3000');
    }
}
