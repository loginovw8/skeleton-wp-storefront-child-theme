<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
    <?php foreach ($args['items'] as $item) {
        echo wp_get_attachment_image(
            intval($item),
            'large',
            false,
            ['class' => 'w-full h-auto']
        );
    } ?>
</div>
