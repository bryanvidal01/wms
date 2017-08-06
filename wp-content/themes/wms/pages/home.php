<?php /* Template Name: HomePage */?>
<?php get_header(); ?>

    <?php
        $idHead = get_field('img_head_search');
        $url    = wp_get_attachment_image_src($idHead, '1900x900');

        $gammes = get_terms( array(
            'taxonomy' => 'gamme',
            'hide_empty' => false,
        ));

        $carburants = get_terms( array(
            'taxonomy' => 'carburant',
            'hide_empty' => false,
        ));
    ?>
    <div class="header-home-search" style="background-image: url('<?php echo $url[0] ?>')">
        <div class="container">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1 text-center">
                    <form class="search-vehicule" action="<?php echo get_catalogue_link() ?>" method="get">
                        <div class="title-search">
                            Achat
                            <div class="sub-title">
                                De véhicules toutes catégories
                            </div>
                        </div>

                        <div class="container-inputs">
                            <?php if($gammes): ?>
                                <select name="gamme">
                                    <?php foreach ($gammes as $gamme) :?>
                                        <option value="<?php echo $gamme->slug; ?>"><?php echo $gamme->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                            <?php if($carburants): ?>
                                <select class="" name="carburant">
                                    <?php foreach ($carburants as $carburant) :?>
                                        <option value="<?php echo $carburant->slug; ?>"><?php echo $carburant->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>

                            <input type="hidden" name="filter_home" value="1">

                            <button type="submit" class="search button button-green">
                                Chercher un véhicule
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="last-vehicules">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="title-site">
                        Nos derniers véhicules
                    </div>
                </div>

                <?php $args = array(
                    'posts_per_page' => 6,
                    'order' => 'DESC',
                    'post_type' => 'vehicule'
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
                            <?php echo get_field('price_vehicule');?>€
                        </div>
                    </div>
                </div>
                <?php endwhile; endif;
                wp_reset_postdata(); ?>
            </div>
        </div>
    </div>


    <?php $args = array(
        'posts_per_page' => -1,
        'order' => 'desc',
        'orderby'=>'rand',
        'post_type' => 'avis'
    );

    $query = new WP_Query($args);
    ?>
    <?php if($query->have_posts()) :?>
    <div class="temoignage" style="background-image: url('http://68.media.tumblr.com/f26b1173f49242ce90b9b4c8723024c0/tumblr_oexxatQgZd1tomxvuo8_1280.jpg')">
        <div class="text-center">
            <div class="content">
                <div class="title-site white">
                    Ils nous ont fait confiance
                </div>
                <div class="list-interview owl-carousel owl-theme  slider-bullets">
                    <?php while ($query->have_posts() ) : $query->the_post();
                        $imageID = get_field('image');
                        $imageURL = wp_get_attachment_image_src($imageID, '600x600');
                    ?>
                        <div class="item">
                            <div class="avatar">
                                <img src="<?php echo $imageURL[0] ?>" alt="">
                            </div>
                            <div class="name">
                                <?php echo get_the_title(); ?>
                            </div>
                            <div class="text-interview">
                                <?php echo get_the_content(); ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; wp_reset_postdata(); ?>
<?php get_footer(); ?>
