<?php
get_header();

if (have_posts()) :
    while (have_posts()) : the_post(); ?>

        <!-- Display Title of the Service -->
        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <!-- Display Featured Image -->
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
        <?php endif; ?>

        <!-- Display Price Field (If Set) -->
        <p><strong>Price:</strong> ₹<?php echo get_field('service_price'); ?></p>

        <!-- Retrieve WooCommerce Product ID (Custom Field) -->
        <?php $product_id = get_field('product_id'); ?>

        <!-- Add to Cart Button (If Product ID is Set) -->
        <?php if ($product_id) : ?>
    <form action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
        <input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product_id); ?>">
        <button type="submit" class="button add-to-cart-button">Add to Cart</button>
    </form>
<?php endif; ?>


    <?php endwhile;
else :
    echo '<p>No services found.</p>';
endif;
?>
