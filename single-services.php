<?php
if (have_posts()) :
    while (have_posts()) : the_post(); ?>
        <h1><?php the_title(); ?></h1>
        <div><?php the_content(); ?></div>

        <!-- Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
        <?php endif; ?>

        <!-- Display ACF Fields -->
        <p><strong>Price:</strong> $<?php echo get_field('service_price'); ?></p>

        <?php 
        $extra_image = get_field('service_extra_image');
        if ($extra_image) : ?>
            <img src="<?php echo esc_url($extra_image['url']); ?>" alt="Service Extra Image">
        <?php endif; ?>

    <?php endwhile;
endif;
?>
