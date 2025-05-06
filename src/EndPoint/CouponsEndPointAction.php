<?php

namespace MainGPT\EndPoint;

use MainGPT\AbstractActionable;

final class CouponsEndPointAction extends AbstractActionable
{
    public const INIT_NAME = 'rest_api_init';
    public const METHOD_NAME = 'execute';

    /**
     * Execute the action logic.
     *
     * /wp-json/wp/v2/coupons
     * 
     * @return void
     */
    public function execute(): void
    {
        register_rest_route(
            'wp/v2',
            '/coupons',
            [
                'methods'  => 'GET',
                'callback' => [$this, 'callback'],
                'permission_callback' => function () {
                    return current_user_can('manage_options');
                }
            ]
        );
    }

    public function callback(): array | \WP_Error
    {
        $args = [
            'post_type'      => 'shop_coupon',
            'posts_per_page' => -1
        ];

        $coupons = get_posts($args);

        return array_map(function ($coupon) {
            return [
                'id' => $coupon->ID,
                'title' => [
                    'rendered' => $coupon->post_title,
                ]
            ];
        }, $coupons);
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
