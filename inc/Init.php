<?php

namespace Inc;

final class Init
{
    /**
     * Loop through the classes, initialize them,
     * and call the register() method if it exists
     *
     * @return void
     */
    public static function registerProviders()
    {
        foreach (self::getProviders() as $class) {
            $provider = self::instantiate($class);

            if (method_exists($provider, 'register')) {
                $provider->register();
            }
        }
    }

    /**
     * Store all the classes inside an array
     *
     * @return array Full list of classes
     */
    public static function getProviders()
    {
        return [
            Providers\EnqueueServiceProvider::class,
            Providers\ThemeSettingsServiceProvider::class,
            Providers\ShortcodeSettingsServiceProvider::class,
            Providers\WooCommerceSettingsServiceProvider::class,
        ];
    }

    /**
     * Initialize the class
     *
     * @param  class  $class  class from the providers array
     *
     * @return class instance  new instance of the class
     */
    private static function instantiate($class)
    {
        $provider = new $class();

        return $provider;
    }
}
