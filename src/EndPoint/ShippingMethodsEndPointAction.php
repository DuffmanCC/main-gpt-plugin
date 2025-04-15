<?php

namespace MainGPT\EndPoint;

use MainGPT\AbstractActionable;
// use WooCommerce\Shipping\WC_Shipping_Zones;

final class ShippingMethodsEndPointAction extends AbstractActionable
{
    public const INIT_NAME = 'rest_api_init';
    public const METHOD_NAME = 'execute';

    /**
     * Execute the action logic.
     *
     * /wp-json/wp/v2/shipping-methods
     * 
     * @return void
     */
    public function execute(): void
    {
        register_rest_route(
            'wp/v2',
            '/shipping-methods',
            [
                'methods'  => 'GET',
                'callback' => [$this, 'callback'],
                'permission_callback' => '__return_true'
            ]
        );
    }

    public function callback(): array
    {
        $shipping_zones = \WC_Shipping_Zones::get_zones();

        $shipping_methods = [];

        foreach ($shipping_zones as $zone) {
            $methods = $zone['shipping_methods'];

            foreach ($methods as $method) {
                if (!$method->is_enabled()) continue;

                $shipping_methods[] = [
                    'id' => $zone['id'] . '-' . $method->id,
                    'title' => [
                        'rendered' => $zone['zone_name'] . ' - ' . $method->method_title
                    ],
                ];
            }
        }

        return $shipping_methods;
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
