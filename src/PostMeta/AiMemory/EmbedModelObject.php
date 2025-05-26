<?php

namespace MainGPT\PostMeta\AiMemory;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

class EmbedModelObject
{
    public const DEFAULT_VALUE = 'text-embedding-3-small';
    public const MODELS = ['text-embedding-ada-002', 'text-embedding-3-small', 'text-embedding-3-large'];
    public const DIMENSIONS = [
        'text-embedding-ada-002' => 1536,
        'text-embedding-3-small' => 1536,
        'text-embedding-3-large' => 3072,
    ];
    /*
     * prices per 1M tokens
     * https://platform.openai.com/docs/pricing
    */
    public const PRICES = [
        'text-embedding-ada-002' => 0.10,
        'text-embedding-3-small' => 0.02,
        'text-embedding-3-large' => 0.13,
    ];
}
