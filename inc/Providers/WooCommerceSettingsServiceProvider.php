<?php

namespace Inc\Providers;

class WooCommerceSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Redirect cart page to checkout/home
         */
        add_action('template_redirect', [$this, 'template_redirect']);

        add_action('init', [$this, 'remove_default_hooks']);

        /**
         * Modify WooCommerce templates path
         */
        add_filter('woocommerce_template_path', [$this, 'template_path']);

        add_action('woocommerce_before_main_content', [$this, 'before_main_content']);

        add_action('woocommerce_after_main_content', [$this, 'after_main_content']);

        add_action('woocommerce_shop_loop_item_title', [$this, 'shop_loop_item_title']);

        add_action('woocommerce_before_shop_loop_item', [$this, 'before_shop_loop_item']);

        add_action('woocommerce_before_shop_loop_item', [$this, 'before_shop_loop_item']);
        add_action('woocommerce_after_shop_loop_item', [$this, 'after_shop_loop_item']);

        add_filter('woocommerce_show_page_title', function () {
            return false;
        });

        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
        remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

        /**
         * Remove downloads tab from user account page
         */
        add_filter('woocommerce_account_menu_items', function ($menu_links) {
            unset($menu_links['downloads']);
            unset($menu_links['dashboard']);

            return $menu_links;
        });

        /**
         * Insert cart view into checkout page
         */
        add_action('woocommerce_before_checkout_form', [$this, 'before_checkout_form'], 5);

        /**
         * Edit billing fields on checkout form
         */
        add_filter('woocommerce_checkout_fields', [$this, 'checkout_fields']);

        /**
         * Edit billing fields on address my account form
         */
        add_filter('woocommerce_billing_fields', [$this, 'billing_fields']);

        add_filter('woocommerce_enable_order_notes_field', '__return_false');

        add_filter('default_checkout_billing_country', function () {
            return 'RU';
        });
    }

    public function template_redirect()
    {
        if (!function_exists('is_cart') || !is_cart()) {
            return;
        }

        $url = get_home_url();

        if (!WC()->cart->is_empty()) {
            $url = wc_get_checkout_url();
        }

        wp_redirect($url, 302);

        exit;
    }

    public function remove_default_hooks()
    {
        remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title');
        remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
        remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close');
    }

    public function template_path($path)
    {
        $my_path = get_stylesheet_directory() . '/resources/templates/woocommerce/';

        return file_exists($my_path) ? 'resources/templates/woocommerce/' : $path;
    }

    public function before_main_content()
    {
        wc_get_template('particles/before-main-content-wrapper.php');
    }

    public function after_main_content()
    {
        wc_get_template('particles/after-main-content-wrapper.php');
    }

    public function shop_loop_item_title()
    {
        wc_get_template('particles/content-product/title.php');
    }

    public function before_shop_loop_item()
    {
        wc_get_template('particles/content-product/link-open.php');
    }

    public function after_shop_loop_item()
    {
        wc_get_template('particles/content-product/link-close.php');
    }

    public function before_checkout_form()
    {
        if (is_wc_endpoint_url('order-received')) {
            return;
        }

        echo do_shortcode('[woocommerce_cart]');
    }

    function checkout_fields($fields)
    {
        unset($fields['billing']['billing_company']);
        unset($fields['billing']['billing_city']);
        unset($fields['billing']['billing_address_2']);
        unset($fields['billing']['billing_state']);
        unset($fields['billing']['billing_postcode']);

        return $fields;
    }

    function billing_fields($fields)
    {
        if (is_wc_endpoint_url('edit-address')) {
            unset($fields['billing_company']);
            unset($fields['billing_address_2']);
            unset($fields['billing_state']);
            unset($fields['billing_postcode']);
            unset($fields['billing_city']);
        }

        return $fields;
    }
}
