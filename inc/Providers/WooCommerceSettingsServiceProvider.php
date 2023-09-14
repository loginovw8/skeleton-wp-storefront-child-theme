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
        add_filter('woocommerce_template_path', [$this, 'template_path']);

        add_action('woocommerce_before_main_content', [$this, 'before_main_content']);

        add_action('woocommerce_after_main_content', [$this, 'after_main_content']);
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
}
