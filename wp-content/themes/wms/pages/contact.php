<?php /* Template Name: Contact */?>
<?php
get_header();
the_post();

// If send mail
if((isset($_POST['send'])) && ($_POST['first_name'] != '') && ($_POST['second_name'] != '') && ($_POST['second_name'] != '') && ($_POST['phone'])):
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
<div class="header-single" style="background-image: url('<?php echo $urlImg[0]; ?>')">
    <div class="title-single">
        <div class="title">
            <?php echo get_the_title(); ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <form class="form-achat form-contact" action="#" method="POST">
                <div class="title-site">
                    Contactez nous par mail
                </div>
                <div class="error"></div>
                <input type="text" name="first_name" placeholder="Votre Prénom">
                <input type="text" name="second_name" placeholder="Votre Nom de Famille">
                <input type="text" name="email" placeholder="Votre Email">
                <input type="text" name="phone" placeholder="Votre Numéro de Téléphone">
                <textarea name="message" placeholder="Message"></textarea>
                <input type="hidden" name="send" value="1">
                <input type="submit" class="button button-green" value="envoyer">
            </form>
            <div class="title-site">
                L'agence
            </div>
            <div class="text-site text-center">
                <?php $textContact =  get_the_content(); ?>
                <?php echo wpautop($textContact); ?>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="map-contact">
                <?php echo get_field('iframe_google'); ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
