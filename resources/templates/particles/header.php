<div class="max-w-screen-xl mx-auto pt-10 py-2 border-b">
    <div class="flex flex-col md:flex-row justify-between">
        <a class="mb-4 md:m-0 font-bold text-3xl hover:text-gray-500" href="/"><?php echo get_bloginfo('name'); ?></a>
        <form class="mb-2 md:m-0" role="search" method="get" action="/">
            <input type="search" name="s" placeholder="<?php echo __('Search products...', 'woocommerce'); ?>">
            <input type="hidden" name="post_type" value="product" />
            <button class="bg-black text-white px-4 py-2 border border-black hover:bg-gray-800" type="submit" value=""><?php echo __('Search') ?></button>
        </form>
    </div>

    <div class="flex justify-between items-center">
        <?php
        $menu_name = 'primary';
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations[$menu_name]);

        $menuItems = wp_get_nav_menu_items($menu->term_id);

        if (count($menuItems) > 0) { ?>

            <ul class="ml-[-8px] md:ml-[-16px]">
                <?php foreach ($menuItems as $item) { ?>
                    <li class="inline-block"><a class="inline-block px-2 py-3 text-sm sm:text-base sm:py-6 sm:px-4 text-gray-700 hover:text-gray-500" href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a></li>
                <?php } ?>
            </ul>

        <?php }
        ?>
        <div class="flex items-center">
            <?php
            $currency = get_woocommerce_currency();
            $currencySymbol = get_woocommerce_currency_symbol($currency);
            $cart = WC()->cart;
            ?>
            <!-- <span class="inline-block mr-2">
                <?php echo $currencySymbol; ?><?php echo number_format(floatval(WC()->cart->cart_contents_total), 2); ?>
            </span> -->
            <a class="inline-block mr-2 md:mr-4" href="/my-account">
                <?php get_template_part('resources/templates/svg/user', null, [
                    'class' => 'text-black hover:text-gray-500 w-5 h-5 sm:w-6 sm:h-6',
                ]) ?>
            </a>
            <a class="inline-block" href="/cart">
                <?php get_template_part('resources/templates/svg/shopping-bag', null, [
                    'class' => 'text-black hover:text-gray-500 w-5 h-5 sm:w-6 sm:h-6',
                ]) ?>
            </a>
        </div>
    </div>
</div>
