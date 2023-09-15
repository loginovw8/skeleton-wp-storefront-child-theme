<?php

namespace Inc\Providers;

class ThemeSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Modify theme templates hierarchy
         */
        $this->modify_template_hierarchy();

        add_action('init', [$this, 'remove_default_hooks']);
        add_action('storefront_header', [$this, 'storefront_header']);
        add_action('storefront_before_content', [$this, 'storefront_before_content']);
        add_action('storefront_loop_before', [$this, 'storefront_loop_before']);
        add_action('storefront_loop_post', [$this, 'loop_post']);
        add_action('storefront_loop_after', [$this, 'storefront_loop_after']);
        add_action('storefront_footer', [$this, 'storefront_footer']);
    }

    public function modify_template_hierarchy()
    {
        $template_files = [
            // 'index',
            'frontpage', 'home', '404', 'archive',
            'author', 'category', 'tag', 'taxonomy', 'date',
            'page', 'paged', 'search', 'single', 'singular', 'attachment',
        ];

        foreach ($template_files as $type) {
            $template_hierarchy = $type . '_template_hierarchy';

            add_filter($template_hierarchy, function ($templates) use ($type) {
                $prefix = 'resources/templates';

                // страницы могут находится в папках
                if ('page' === $type) {
                    global $post;
                    array_unshift(
                        $templates,
                        "$prefix/page-$post->post_name/main.php"
                    );
                }

                foreach ($templates as &$relpath) {
                    if ("$prefix/" !== substr($relpath, 0, 10)) {
                        $relpath = "$prefix/$relpath";
                    }
                }

                return $templates;
            }, 20);
        }
    }

    public function remove_default_hooks()
    {
        remove_action('storefront_header', 'storefront_header_container', 0);
        remove_action('storefront_header', 'storefront_header_container_close', 41);
        remove_action('storefront_before_content', 'woocommerce_breadcrumb', 10);
        remove_action('storefront_loop_post', 'storefront_post_header', 10);
    }

    public function storefront_header()
    {
        remove_action('storefront_header', 'storefront_header_container', 0);
        remove_action('storefront_header', 'storefront_skip_links', 5);
        remove_action('storefront_header', 'storefront_social_icons', 10);
        remove_action('storefront_header', 'storefront_site_branding', 20);
        remove_action('storefront_header', 'storefront_secondary_navigation', 30);
        remove_action('storefront_header', 'storefront_product_search', 40);
        remove_action('storefront_header', 'storefront_header_container_close', 41);
        remove_action('storefront_header', 'storefront_primary_navigation_wrapper', 42);
        remove_action('storefront_header', 'storefront_primary_navigation', 50);
        remove_action('storefront_header', 'storefront_header_cart', 60);
        remove_action('storefront_header', 'storefront_primary_navigation_wrapper_close', 68);

        get_template_part('resources/templates/particles/header');
    }

    public function storefront_before_content()
    {
        remove_action('storefront_before_content', 'woocommerce_breadcrumb');
    }

    public function storefront_loop_before()
    {
        get_template_part('resources/templates/particles/loop-before');
    }

    public function loop_post()
    {
        if (!is_front_page()) {
            get_template_part('resources/templates/particles/page-title');
        }
    }

    public function storefront_loop_after()
    {
        get_template_part('resources/templates/particles/loop-after');
    }

    public function storefront_footer()
    {
        remove_action('storefront_footer', 'storefront_credit', 20);
        remove_action('storefront_footer', 'storefront_handheld_footer_bar', 999);

        get_template_part('resources/templates/particles/footer');
    }
}
