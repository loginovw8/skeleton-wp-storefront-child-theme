<?php

namespace Inc\Providers;

class EnqueueServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        add_action('wp_enqueue_scripts', [$this, 'wp_enqueue_styles']);
        add_action('wp_enqueue_scripts', [$this, 'wp_enqueue_scripts']);
    }

    public function wp_enqueue_styles()
    {
        wp_enqueue_style('theme', get_stylesheet_directory_uri() . '/dist/css/app.css', [], filemtime(get_stylesheet_directory() . '/dist/css/app.css'));
    }

    public function wp_enqueue_scripts()
    {
        wp_enqueue_script('theme', get_stylesheet_directory_uri() . '/dist/js/app.js', [], filemtime(get_stylesheet_directory() . '/dist/js/app.js'));
    }
}
