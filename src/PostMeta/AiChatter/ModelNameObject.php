<?php

namespace MainGPT\PostMeta\AiChatter;

if (!defined('ABSPATH')) exit; // Exit if accessed directly

use MainGPT\App;

class ModelNameObject
{
    public const FIELD_ID = App::ID . '_ai_chatter_model_name';
    public const GPT_4_1 = 'gpt-4.1';
    public const GPT_4_1_MINI = 'gpt-4.1-mini';
    public const GPT_4_1_NANO = 'gpt-4.1-nano';
    public const GPT_4_5_PREVIEW = 'gpt-4.5-preview';
    public const GPT_4_0 = 'gpt-4o';
    public const GPT_4_0_MINI = 'gpt-4o-mini';
    public const DEFAULT_VALUE = self::GPT_4_1_NANO;
    public const VALUES = [self::GPT_4_1, self::GPT_4_1_MINI, self::GPT_4_1_NANO, self::GPT_4_5_PREVIEW, self::GPT_4_0, self::GPT_4_0_MINI];
}
