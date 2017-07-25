<?php
get_header();
the_post();


// If send mail
if((isset($_POST['send'])) && ($_POST['first_name'] != '') && ($_POST['second_name'] != '') && ($_POST['second_name'] != '') && ($_POST['phone'])):
    $idPost = get_the_id();
    $firstName = $_POST['first_name'];
    $secondName = $_POST['second_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $mailHtml = "
        <h2>". $firstName ." souhaite acheter un de vos véhicules</h2>
        <p>Bonjour. Vous avez reçu une demande d'achat de véhicule sur www.webmotorservice.com</p>
        <p>Voici les informations du client</p>
        <ul>
            <li>Nom : ". $secondName ."</li>
            <li>Prénom : ". $firstName ."</li>
            <li>Email : ". $email ."</li>
            <li>Téléphone : ". $phone ."</li>
        </ul>
        <p>Le véhicule demandé est : <strong>". get_the_title() ."</strong></p>
        <p>Lien de l'annonce : <strong>". get_the_permalink($idPost) ."</strong></p>
    ";

    wp_mail("bryan.vidal@hetic.net", "Achat véhicule WMS", $mailHtml, $headers = 'Content-Type: text/html; charset=UTF-8', $attachments = array());

else:
    $error = "Tous les champs sont obligatoires";
endif;


$postID    = get_the_id();
$postTerms = get_the_terms($postID, 'gamme');
$idImage   = get_field('image_bg_product', 'option');
$urlImg    = wp_get_attachment_image_src($idImage, '1900x900');

?>

<?php echo $error; ?>
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
                    <a href="<?php echo $urlImg[0]; ?>" data-lightbox="car">
                        <img src="<?php echo $urlImg[0]; ?>" alt="">
                    </a>
                </div>
                <div class="container-thumb clearfix">
                    <?php
                    $galerie = get_field('images_vehicule');
                    foreach ($galerie as  $image) {
                        $imageID = $image['ID'];
                        $urlImage = wp_get_attachment_image_src($imageID, '600x600');
                        ?>

                        <div class="image-item">
                            <a href="<?php echo  $urlImage[0]; ?>" data-lightbox="car">
                                <img src="<?php echo  $urlImage[0]; ?>" alt="">
                            </a>
                        </div>

                        <?php
                    }
                    ?>
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
                    <?php echo get_field('price_vehicule');?>€
                </div>
            </div>
        </div>
        <?php endwhile; endif;
        wp_reset_postdata(); ?>
    </div>
</div>

<form class="form-achat" action="#" method="POST">
    <input type="hidden" name="id_vehicule" value="<?php echo get_the_id(); ?>">
    <input type="text" name="first_name" placeholder="Votre Prénom">
    <input type="text" name="second_name" placeholder="Votre Nom de Famille">
    <input type="text" name="email" placeholder="Votre Email">
    <input type="text" name="phone" placeholder="Votre numero de téléphone">
    <input type="hidden" name="send" value="1">
    <input type="submit" value="envoyer">
</form>

<?php get_footer(); ?>
