<?php
/**
 * Plugin Name: Import Product API
 * Description: REST API for import products in multi languages by (Polylang)
 */

if (!defined('ABSPATH')) {
    exit;
}

class MyImportProducts {
    private int $created = 0;
    private int $updated = 0;
    private int $skipped = 0;

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
    }

    public function register_routes(): void {
        register_rest_route('test/v1', '/import-products', [
            'methods' => 'POST',
            'callback' => [$this, 'handle_import_products'],
            'permission_callback' => function () {
                return current_user_can('manage_options');
            },
        ]);
    }

    public function handle_import_products($request): array {
        $this->created = 0;
        $this->updated = 0;
        $this->skipped = 0;

        if (!function_exists('wc_get_product_id_by_sku')) {
            return ['error' => 'WooCommerce not active'];
        }

        $items = $request->get_json_params();

        if (!is_array($items)) {
            return ['error' => 'Invalid JSON'];
        }

        foreach ($items as $item) {

            if (empty($item['sku'])) {
                $this->skipped++;
                continue;
            }

            $sku = sanitize_text_field($item['sku']);
            $product_id = wc_get_product_id_by_sku($sku);

            if ($product_id) {
                $this->update_product($product_id, $item);
            } else {
                $this->create_product($item);
            }
        }

        return [
            'created' => $this->created,
            'updated' => $this->updated,
            'skipped' => $this->skipped,
            'meta' => [
                'total' => count($items),
                'time' => current_time('mysql'),
            ],
        ];
    }

    private function update_product(int $product_id, array $item): void {

        $product = wc_get_product($product_id);

        if (!$product) {
            $this->skipped++;
            return;
        }

        if (!empty($item['name'])) {
            $product->set_name($item['name']);
        }

        if (isset($item['price'])) {
            $product->set_regular_price((float) $item['price']);
        }

        if (isset($item['stock'])) {
            $product->set_stock_quantity((int) $item['stock']);
            $product->set_manage_stock(true);
        }

        $product->save();

        if (function_exists('pll_get_post')) {
            $en_id = pll_get_post($product_id, 'en');

            if ($en_id) {
                $en_product = wc_get_product($en_id);

                if ($en_product) {

                    if (!empty($item['translations']['en']['name'])) {
                        $en_product->set_name($item['translations']['en']['name']);
                    }

                    if (isset($item['price'])) {
                        $en_product->set_regular_price((float) $item['price']);
                    }

                    if (isset($item['stock'])) {
                        $en_product->set_stock_quantity((int) $item['stock']);
                        $en_product->set_manage_stock(true);
                    }

                    $en_product->save();
                }
            }
        }

        $this->updated++;
    }

    private function create_product(array $item): void {

        $product = new WC_Product_Simple();

        $product->set_name($item['name'] ?? 'No name');
        $product->set_sku(sanitize_text_field($item['sku']));
        $product->set_regular_price((float) ($item['price'] ?? 0));

        if (isset($item['stock'])) {
            $product->set_stock_quantity((int) $item['stock']);
            $product->set_manage_stock(true);
        }

        $product_id = $product->save();

        // UA язык
        if (function_exists('pll_set_post_language')) {
            pll_set_post_language($product_id, 'uk');
        }

        // EN перевод
        $en_name = $item['translations']['en']['name'] ?? $item['name'] ?? 'No name';

        $en_product = new WC_Product_Simple();
        $en_product->set_name($en_name);
        $en_product->set_sku($item['sku'] . '-en');
        $en_product->set_regular_price((float) ($item['price'] ?? 0));

        if (isset($item['stock'])) {
            $en_product->set_stock_quantity((int) $item['stock']);
            $en_product->set_manage_stock(true);
        }

        $en_id = $en_product->save();

        // Связка переводов
        if (function_exists('pll_set_post_language')) {
            pll_set_post_language($en_id, 'en');

            pll_save_post_translations([
                'uk' => $product_id,
                'en' => $en_id,
            ]);
        }

        $this->created++;
    }
}

new MyImportProducts();
