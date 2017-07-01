<?php

// Image sizes
add_image_size( '1900x900', 1900, 900 );
add_image_size( '500x300', 500, 300 );

// POST TYPE
add_action( 'init', 'create_post_type' );
function create_post_type() {
  register_post_type( 'vehicule',
    array(
      'labels' => array(
        'name' => __( 'Véhicules' ),
        'singular_name' => __( 'Véhicule' )
      ),
      'public' => true
    )
  );
}

// CUSTOM TAXONOMY
register_taxonomy(
  'contrat',
  'vehicule',
  array(
    'label' => 'Contrat',
    'labels' => array(
    'name' => 'Contrats',
    'singular_name' => 'Contrat'
	),
	'hierarchical' => true
  )
);

register_taxonomy(
  'gamme',
  'vehicule',
  array(
    'label' => 'Gamme',
    'labels' => array(
    'name' => 'Gammes',
    'singular_name' => 'Gamme'
	),
	'hierarchical' => true
  )
);

register_taxonomy(
  'carburant',
  'vehicule',
  array(
    'label' => 'Carburant',
    'labels' => array(
    'name' => 'Carburants',
    'singular_name' => 'Carburant'
	),
	'hierarchical' => true
  )
);

register_taxonomy(
  'marque',
  'vehicule',
  array(
    'label' => 'Marque',
    'labels' => array(
    'name' => 'Marques',
    'singular_name' => 'Marque'
	),
	'hierarchical' => true
  )
);


// OPTION PAGE

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' => "Configuration"
	));
}


// Correspondance des pages
function get_catalogue_link(){
	$idCatalogue = get_field('catalogue_page', 'option');
	$urlCatalogue = get_page_link($idCatalogue);

	return $urlCatalogue;
}

?>
