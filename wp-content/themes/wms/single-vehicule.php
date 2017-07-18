<?php
get_header();
the_post();

$postID    = get_the_id();
$postTerms = get_the_terms($postID, 'gamme');
$idImage   = get_field('image_bg_product', 'option');
$urlImg    = wp_get_attachment_image_src($idImage, '1900x900');

?>
<div class="header-single" style="background-image: url('<?php echo $urlImg[0]; ?>')">
    <div class="title-single">
        <ul class="category">
            <?php foreach ($postTerms as $postTerm):?>
                <li>
                    <?php echo $postTerm->name; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="title">
            <?php echo get_the_title(); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <?php
                $imgId     = get_field('car_img');
                $urlImg    = wp_get_attachment_image_src($imgId, '600x600');
            ?>

            <div class="galerie-car">
                <div class="img-full">
                    <img src="<?php echo $urlImg[0]; ?>" alt="">
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="info-vehicule">
                <div class="description">
                    <?php echo get_field('car_info'); ?>
                </div>
                <div class="price">
                    <?php echo get_field('price_vehicule');?>€
                </div>
                <div class="call-to-action">
                    <a href="#" class="button black">
                        Acheter le véhicule
                    </a>
                    <a href="#" class="button border">
                        Plus d'informations
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row related-product">
        <div class="col-sm-12">
            <div class="title-site">
                Véhicules similaires
            </div>
        </div>

        <?php
         $args = array(
            'posts_per_page' => 3,
            'order' => 'DESC',
            'post_type' => 'vehicule',
            'post__not_in'=> array(get_the_id()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'gamme',
                    'field' => 'slug',
                    'terms' => $postTerms[0]->slug
                ),
            )
        );

        $query = new WP_Query($args);
        ?>
        <?php if($query->have_posts()) : while ($query->have_posts() ) : $query->the_post();
        $postID    = get_the_id();
        $postTerms = get_the_terms($postID, 'gamme');
        $imgId     = get_field('car_img');
        $urlImg    = wp_get_attachment_image_src($imgId, '1900x900');
        ?>
        <div class="col-sm-4 item-catalogue">
            <div class="article-vehicule">
                <a href="<?php echo get_the_permalink(); ?>" class="img-vehicule">
                    <img src="<?php echo $urlImg[0]; ?>">
                </a>
                <ul class="category">
                    <?php foreach ($postTerms as $postTerm):?>
                        <li>
                            <a href="<?php echo get_term_link($postTerm->term_id) ?>">
                                <?php echo $postTerm->name; ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="title-vehicule">
                    <?php echo get_the_title(); ?>
                </div>
                <div class="price">
                    125€ / J
                </div>
            </div>
        </div>
        <?php endwhile; endif;
        wp_reset_postdata(); ?>
    </div>
</div>

<?php get_footer(); ?>
