<?php

namespace MainGPT\Page\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use MainGPT\App;
use MainGPT\PostType\AiContact;

final class AiContactPage extends AbstractAdminPage
{
    public const PAGE_TITLE = 'AiContact';
    public const MENU_TITLE = 'AiContact';
    public const CAPABILITY = 'manage_options';
    public const MENU_SLUG = 'edit.php?post_type=' . AiContact::POST_TYPE;

    public function execute(): void
    {
        add_submenu_page(
            MainAiPage::MENU_SLUG,
            __(self::PAGE_TITLE, App::TEXT_DOMAIN),
            __(self::MENU_TITLE, App::TEXT_DOMAIN),
            self::CAPABILITY,
            self::MENU_SLUG,
            '',
            5
        );
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function render(): void {}
}
