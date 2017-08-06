<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/stylesheets/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/stylesheets/owl.theme.default.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/stylesheets/style.css">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
      <div class="pre-header">
          Besoin d'aide ?
      </div>
      <header class="header">
          <div class="container">
              <div class="row">
                  <div class="col-sm-4">
                      <a href="<?php echo get_site_url(); ?>">
                          <div class="logo">
                              <?php include('assets/images/logo.php'); ?>
                          </div>
                          <h1 class="logo-wording">
                              Web Motors Services
                          </h1>
                      </a>
                  </div>
                  <div class="col-sm-8 text-right">
                      <ul class="nav-principal">
                          <li>
                              <a href="<?php echo get_catalogue_link() ?>">Catalogue de véhicule</a>
                          </li>
                          <li>
                              <a href="<?php echo get_contact_link(); ?>">Contact</a>
                          </li>
                          <li>
                              <a href="#">FAQ</a>
                          </li>
                      </ul>
                  </div>
              </div>
          </div>
      </header>
