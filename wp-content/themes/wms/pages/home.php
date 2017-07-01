<?php /* Template Name: HomePage */?>
<?php get_header(); ?>

    <?php
        $idHead = get_field('img_head_search');
        $url    = wp_get_attachment_image_src($idHead, '1900x900');

        $contrats = get_terms( array(
            'taxonomy' => 'contrat',
            'hide_empty' => false,
        ));

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
                <div class="col-sm-12 text-center">
                    <form class="search-vehicule" action="<?php echo get_catalogue_link() ?>" method="get">
                        <div class="title-search">
                            Location & Achat
                            <div class="sub-title">
                                De véhicules toutes catégories
                            </div>
                        </div>

                        <div class="container-inputs">
                            <?php if($contrats): ?>
                                <select name="sale">
                                    <option value="">Achat / Vente</option>
                                    <?php foreach ($contrats as $contrat): ?>
                                            <option value="<?php echo $contrat->slug; ?>"><?php echo $contrat->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>

                            <?php if($gammes): ?>
                                <select name="gamme">
                                    <option value="">Gamme</option>
                                    <?php foreach ($gammes as $gamme) :?>
                                        <option value="<?php echo $gamme->slug; ?>"><?php echo $gamme->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                            <?php if($carburants): ?>
                                <select class="" name="carburant">
                                    <option value="">Carburant</option>
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
                <div class="col-sm-4">
                    <a href="#" class="article-vehicule">
                        <div class="img-vehicule">
                            <img src="http://fakeimg.pl/500x300/">
                        </div>
                        <div class="category">
                            4x4
                        </div>
                        <div class="title-vehicule">
                            Mercedes Benz M Class
                        </div>
                        <div class="price">
                            125€ / J
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="#" class="article-vehicule">
                        <div class="img-vehicule">
                            <img src="http://fakeimg.pl/500x300/">
                        </div>
                        <div class="category">
                            4x4
                        </div>
                        <div class="title-vehicule">
                            Mercedes Benz M Class
                        </div>
                        <div class="price">
                            125€ / J
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="#" class="article-vehicule">
                        <div class="img-vehicule">
                            <img src="http://fakeimg.pl/500x300/">
                        </div>
                        <div class="category">
                            4x4
                        </div>
                        <div class="title-vehicule">
                            Mercedes Benz M Class
                        </div>
                        <div class="price">
                            125€ / J
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="#" class="article-vehicule">
                        <div class="img-vehicule">
                            <img src="http://fakeimg.pl/500x300/">
                        </div>
                        <div class="category">
                            4x4
                        </div>
                        <div class="title-vehicule">
                            Mercedes Benz M Class
                        </div>
                        <div class="price">
                            125€ / J
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="#" class="article-vehicule">
                        <div class="img-vehicule">
                            <img src="http://fakeimg.pl/500x300/">
                        </div>
                        <div class="category">
                            4x4
                        </div>
                        <div class="title-vehicule">
                            Mercedes Benz M Class
                        </div>
                        <div class="price">
                            125€ / J
                        </div>
                    </a>
                </div>
                <div class="col-sm-4">
                    <a href="#" class="article-vehicule">
                        <div class="img-vehicule">
                            <img src="http://fakeimg.pl/500x300/">
                        </div>
                        <div class="category">
                            4x4
                        </div>
                        <div class="title-vehicule">
                            Mercedes Benz M Class
                        </div>
                        <div class="price">
                            125€ / J
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="temoignage">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <div class="list-interview">

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
