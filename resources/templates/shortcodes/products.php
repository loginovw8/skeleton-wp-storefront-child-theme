<ul class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
    <?php foreach ($args['items'] as $item) {
        global $product;
        $product = wc_get_product($item);
        wc_get_template_part('content', 'product');
    } ?>
</ul>
