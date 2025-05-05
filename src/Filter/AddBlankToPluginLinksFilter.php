<?php

namespace MainGPT\Filter;

use MainGPT\AbstractFilterable;

final class AddBlankToPluginLinksFilter extends AbstractFilterable
{
    public const INIT_NAME = 'plugin_row_meta';
    public const METHOD_NAME = 'myMethod';

    public function init(): void
    {
        $this->addFilter(10, 2);
    }

    /**
     * Execute the action logic.
     *
     * @return void
     */
    public function execute(): void {}

    public function myMethod(array $links, string $file): array
    {
        if ($file === 'main-gpt/main-gpt.php') {
            foreach ($links as &$link) {
                if (strpos($link, 'href') !== false) {
                    $link = str_replace('<a ', '<a target="_blank" ', $link);
                }
            }
        }
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
