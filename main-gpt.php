<?php

/**
 * Main GPT Plugin
 *
 * @package           Main GPT
 * @author            Carlos Ortiz
 * @copyright         2024 Carlos Ortiz
 * @license           LGPL-3.0-only
 *
 * Plugin Name:       Main GPT
 * Description:       Integrate generative AI to your business to endless possibilities
 * Version:           1.0.35_beta
 * Plugin URI:        https://github.com/DuffmanCC/main-gpt-plugin
 * Requires at least: 6.6.2
 * Requires PHP:      8.2
 * Author:            Carlos Ortiz
 * Author URI:        https://carlosortiz.dev/
 * Text Domain:       main-gpt
 * License:           LGPL-3.0-only
 * License URI:       https://www.gnu.org/licenses/lgpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

use MainGPT\App;
use MainGPT\Repository\Config;

if (file_exists(plugin_dir_path(__FILE__) . 'vendor/autoload.php')) {
    require plugin_dir_path(__FILE__) . 'vendor/autoload.php';
} else {
    error_log("Error locating autoloader. Please run composer install.");
    return;
}

// Register deactivation hook
register_uninstall_hook(__FILE__, 'main_gpt_uninstall');

function main_gpt_uninstall()
{
    delete_option(Config::getOptionsName());
}

new App(plugin_dir_path(__FILE__));
