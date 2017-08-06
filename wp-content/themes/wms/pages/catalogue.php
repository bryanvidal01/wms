<?php /* Template Name: Catalogue */?>
<?php get_header(); ?>

    <?php
    $idHeader = get_field('image_header');
    $urlHeader = wp_get_attachment_image_src($idHeader, '1900x900');

    $contrat = "achat";

    if($_GET['filter_home']  && ($_GET['sale']!='' or $_GET['gamme']!='' or $_GET['carburant']!='')):
        $gamme = $_GET['gamme'];
        $carburant = $_GET['carburant'];

        $args = array(
            'posts_per_page' => -1,
            'order' => 'DESC',
            'post_type' => 'vehicule',
            'tax_query' => array(
        		'relation' => 'OR',
        		array(
        			'taxonomy' => 'gamme',
        			'field'    => 'slug',
        			'terms'    => array( $gamme ),
        		),
        		array(
        			'taxonomy' => 'carburant',
        			'field'    => 'slug',
        			'terms'    => array( $carburant ),
        		),
        	),
        );

    elseif(($_GET['filter']) && (isset($_GET['carburant']) or isset($_GET['gamme']) or (isset($_GET['marque'])))):
        $carburant = $_GET['carburant'];
        $gamme = $_GET['gamme'];
        $marque = $_GET['marque'];

        $args = array(
            'posts_per_page' => -1,
            'order' => 'DESC',
            'post_type' => 'vehicule',
            'tax_query' => array(
        		'relation' => 'OR',
        		array(
        			'taxonomy' => 'gamme',
        			'field'    => 'slug',
        			'terms'    => $gamme,
        		),
        		array(
        			'taxonomy' => 'marque',
        			'field'    => 'slug',
        			'terms'    => $marque,
        		),
        		array(
        			'taxonomy' => 'carburant',
        			'field'    => 'slug',
        			'terms'    => $carburant,
        		)
        	),
        );
    else:
        $args = array(
            'posts_per_page' => -1,
            'order' => 'DESC',
            'post_type' => 'vehicule'
        );

    endif;


    $query = new WP_Query($args);
    ?>


    <div class="header-catalogue" style="background-image: url('<?php echo $urlHeader[0]; ?>')">
        <div class="text-catalogue">
            Catalogue

            <div class="catalogue-name">
                <?php echo $contrat; ?>
            </div>
        </div>
    </div>


    <!-- Filtres -->

    <?php
        $carburants = get_terms( array(
            'taxonomy' => 'carburant',
            'hide_empty' => false,
        ));
        $gammes = get_terms( array(
            'taxonomy' => 'gamme',
            'hide_empty' => false,
        ));
        $marques = get_terms( array(
            'taxonomy' => 'marque',
            'hide_empty' => false,
        ));
    ?>
    <div class="container container-catalogue">
        <div class="row">
            <div class="col-sm-2">
                <div class="filter">
                    <div class="title-site">
                        Filtres
                    </div>
                </div>

                <form class="filter_catalog_view" action="#" method="get">
                    <ul>
                        <li class="parent-filter">
                            <div class="title-filter">
                                Carburant
                            </div>
                            <ul class="child-filter">
                                <?php foreach ($carburants as  $carburant): ?>
                                    <li>
                                        <input type="checkbox" id="<?php echo $carburant->slug; ?>" name="carburant[]" value="<?php echo $carburant->slug; ?>" <?php if(($_GET['carburant']) && (isset($_GET['filter'])) && (in_array($carburant->slug, $_GET['carburant']))):?>checked<?php endif;?>>
                                        <label class="text-checkbox" for="<?php echo $carburant->slug; ?>"><?php echo $carburant->name; ?></label>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li class="parent-filter">
                            <div class="title-filter">
                                Gamme
                            </div>
                            <ul class="child-filter">
                                <?php foreach ($gammes as  $gamme): ?>
                                    <li>
                                        <input type="checkbox" id="<?php echo $gamme->slug; ?>" name="gamme[]" value="<?php echo $gamme->slug; ?>" <?php if(($_GET['gamme']) && (isset($_GET['filter'])) && (in_array($gamme->slug, $_GET['gamme']))):?>checked<?php endif;?>>
                                        <label for="<?php echo $gamme->slug; ?>" class="text-checkbox"><?php echo $gamme->name; ?></label>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                        <li class="parent-filter">
                            <div class="title-filter">
                                Marque
                            </div>
                            <ul class="child-filter">
                                <?php foreach ($marques as  $marque): ?>
                                    <li>
                                        <input type="checkbox" id="<?php echo $marque->slug; ?>" name="marque[]" value="<?php echo $marque->slug; ?>" <?php if(($_GET['marque']) && (isset($_GET['filter'])) && (in_array($marque->slug, $_GET['marque']))):?>checked<?php endif;?>>
                                        <label for="<?php echo $marque->slug; ?>" class="text-checkbox"><?php echo $marque->name; ?></label>
                                    </li>
                                <?php endforeach;?>
                            </ul>
                        </li>
                    </ul>

                    <input type="hidden" name="filter" value="1">
                </form>
            </div>
            <div class="col-sm-10">
                <div class="row">
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
                    <?php
                endwhile; endif;
                wp_reset_postdata();?>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
