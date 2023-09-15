<div class="grid grid-cols-3 gap-4 my-4">
    <?php foreach ($args['items'] as $item) {
        echo wp_get_attachment_image(
            intval($item),
            'large',
            false,
            ['class' => 'w-full h-auto']
        );
    } ?>
</div>
