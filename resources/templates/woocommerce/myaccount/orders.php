<?php

/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders); ?>

<?php if ($has_orders) : ?>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
        <?php
        foreach ($customer_orders->orders as $customer_order) {
            $order      = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
            $item_count = $order->get_item_count() - $order->get_item_count_refunded();
        ?>
            <div class="border p-4">
                <a href="<?php echo $order->get_view_order_url(); ?>">
                    <p class="mb-1">Заказ <?php echo esc_html(_x('#', 'hash before order number', 'woocommerce') . $order->get_order_number()); ?></p>
                    <p class="mb-1"><time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>"><?php echo esc_html(wc_format_datetime($order->get_date_created())); ?></time></p>
                    <p class="mb-1">Статус: <?php echo esc_html(wc_get_order_status_name($order->get_status())); ?></p>
                    <p class="mb-1">Сумма: <?php echo wp_kses_post(sprintf(_n('%1$s for %2$s item', '%1$s for %2$s items', $item_count, 'woocommerce'), $order->get_formatted_order_total(), $item_count)); ?></p>
                </a>
            </div>
        <?php
        }
        ?>
    </div>

    <?php do_action('woocommerce_before_account_orders_pagination'); ?>

    <?php if (1 < $customer_orders->max_num_pages) : ?>
        <div class="woocommerce-pagination woocommerce-pagination--without-numbers woocommerce-Pagination">
            <?php if (1 !== $current_page) : ?>
                <a class="woocommerce-button woocommerce-button--previous woocommerce-Button woocommerce-Button--previous button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page - 1)); ?>"><?php esc_html_e('Previous', 'woocommerce'); ?></a>
            <?php endif; ?>

            <?php if (intval($customer_orders->max_num_pages) !== $current_page) : ?>
                <a class="woocommerce-button woocommerce-button--next woocommerce-Button woocommerce-Button--next button<?php echo esc_attr($wp_button_class); ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders', $current_page + 1)); ?>"><?php esc_html_e('Next', 'woocommerce'); ?></a>
            <?php endif; ?>
        </div>
    <?php endif; ?>

<?php else : ?>

    <?php wc_print_notice(esc_html__('No order has been made yet.', 'woocommerce') . ' <a class="woocommerce-Button button' . esc_attr($wp_button_class) . '" href="' . esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))) . '">' . esc_html__('Browse products', 'woocommerce') . '</a>', 'notice'); // phpcs:ignore WooCommerce.Commenting.CommentHooks.MissingHookComment
    ?>

<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>
