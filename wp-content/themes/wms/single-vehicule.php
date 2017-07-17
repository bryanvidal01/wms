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
                $urlImg    = wp_get_attachment_image_src($imgId, '1900x900');
            ?>

            <div class="galerie-car">

            </div>
        </div>
        <div class="col-sm-6">

        </div>
    </div>
</div>

<?php get_footer(); ?>
