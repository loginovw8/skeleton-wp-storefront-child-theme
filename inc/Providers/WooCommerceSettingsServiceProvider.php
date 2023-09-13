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

        /**
         * Modify WooCommerce templates path
         */
        add_filter('woocommerce_template_path', [$this, 'woo_template_path']);
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

    public function woo_template_path($path)
    {
        $my_path = get_stylesheet_directory() . '/resources/templates/woocommerce/';

        return file_exists($my_path) ? 'resources/templates/woocommerce/' : $path;
    }
}
