<?php

namespace MainGPT\Page\Admin;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use MainGPT\App;
use MainGPT\PostType\AiCampaign;

final class AiCampaignPage extends AbstractAdminPage
{
    public const PAGE_TITLE = 'AiCampaign';
    public const MENU_TITLE = 'AiCampaign';
    public const CAPABILITY = 'manage_options';
    public const MENU_SLUG = 'edit.php?post_type=' . AiCampaign::POST_TYPE;

    public function execute(): void
    {
        add_submenu_page(
            MainAiPage::MENU_SLUG,
            __(self::PAGE_TITLE, App::TEXT_DOMAIN),
            __(self::MENU_TITLE, App::TEXT_DOMAIN),
            self::CAPABILITY,
            self::MENU_SLUG,
            '',
            6
        );
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     */
    public function render(): void {}
}
