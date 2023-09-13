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
    }

    public function modify_template_hierarchy()
    {
        $template_files = [
            'index',
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
}
