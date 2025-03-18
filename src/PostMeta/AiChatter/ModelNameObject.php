<?php

namespace MainGPT\PostMeta\AiChatter;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use MainGPT\App;

class ModelNameObject
{
    public const FIELD_ID = App::ID . '_ai_chatter_model_name';
    public const GPT3 = 'gpt-3.5-turbo';
    public const GPT4 = 'gpt-4';
    public const GPT4_TURBO = 'gpt-4-turbo';
    public const GPT4_4o = 'gpt-4o';
    public const GPT4_4o_MINI = 'gpt-4o-mini';
    public const DEFAULT_VALUE = self::GPT4_4o_MINI;
    public const VALUES = [self::GPT3, self::GPT4, self::GPT4_TURBO, self::GPT4_4o, self::GPT4_4o_MINI];
}
