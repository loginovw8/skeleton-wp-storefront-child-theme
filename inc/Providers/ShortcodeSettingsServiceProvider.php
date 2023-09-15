<?php

namespace Inc\Providers;

class ShortcodeSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_shortcode('banner', [$this, 'banner_shortcode']);
        add_shortcode('favorite_products', [$this, 'favorite_products_shortcode']);
    }

    public function banner_shortcode()
    {
        get_template_part('resources/templates/shortcodes/banner', null, [
            'items' => [76, 105, 77],
        ]);
    }

    public function favorite_products_shortcode()
    {
        get_template_part('resources/templates/shortcodes/products', null, [
            'items' => [89, 86, 88, 87],
        ]);
    }
}
