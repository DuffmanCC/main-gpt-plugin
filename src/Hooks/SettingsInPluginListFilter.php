<?php

namespace MainGPT\Hooks;

use MainGPT\AbstractFilterable;

final class SettingsInPluginListFilter extends AbstractFilterable
{
    public const INIT_NAME = 'plugin_action_links_main-gpt/main-gpt.php';
    public const METHOD_NAME = 'myMethod';

    /**
     * Execute the action logic.
     *
     * @return void
     */
    public function execute(): void {}

    public function myMethod($links): array
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=main-gpt-settings') . '">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    /**
     * Get the initialization name.
     *
     * @return string
     */
    public function getInitName(): string
    {
        return self::INIT_NAME;
    }

    /**
     * Get the method name.
     *
     * @return string
     */
    public function getMethodName(): string
    {
        return self::METHOD_NAME;
    }
}
