<?php

namespace MainGPT\Page\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use MainGPT\App;
use MainGPT\PostType\AiChatter;

final class AiChatterPage extends AbstractAdminPage
{
    public const PAGE_TITLE = 'AiChatter';
    public const MENU_TITLE = 'AiChatter';
    public const CAPABILITY = 'manage_options';
    public const MENU_SLUG = 'edit.php?post_type=' . AiChatter::POST_TYPE;

    public function execute(): void
    {
        add_submenu_page(
            MainAiPage::MENU_SLUG,
            __(self::PAGE_TITLE, App::TEXT_DOMAIN),
            __(self::MENU_TITLE, App::TEXT_DOMAIN),
            self::CAPABILITY,
            self::MENU_SLUG,
            '',
            3
        );
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function render(): void {}
}
