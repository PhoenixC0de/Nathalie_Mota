<?php

/**
 * Fonctions du thème nathalie_mota
 */

/**
 * Activation du thème
 */
function nathalie_mota_setup()
{

  // Gestion automatique du <title>
  add_theme_support('title-tag');

  // Images mises en avant
  add_theme_support('post-thumbnails');

  //les Menu 
  register_nav_menus([
    'main-menu' => 'Menu principal',
    'footer-menu' => 'Menu du footer',
  ]);


  // Support HTML5
  add_theme_support('html5', [
    'search-form',
    'gallery',
    'caption',
    'style',
    'script'
  ]);
}
add_action('after_setup_theme', 'nathalie_mota_setup');


/**
 * Chargement des styles et scripts
 */
function nathalie_mota_assets()
{

  //Appel des polices Google Fonts.css
  wp_enqueue_style(
    'nathalie-mota-fonts',
    get_template_directory_uri() . '/fonts/fonts.css',
    [],
    null
  );

  // CSS principal
  wp_enqueue_style(
    'nathalie-mota-style',
    get_template_directory_uri() . '/style.css',
    [],
    filemtime(get_template_directory() . '/style.css')
  );


  // JS principal
  wp_enqueue_script(
    'nathalie-mota-script',
    get_template_directory_uri() . '/js/main_scripts.js',
    [],
    filemtime(get_template_directory() . '/js/main_scripts.js'),
    true
  );
}
add_action('wp_enqueue_scripts', 'nathalie_mota_assets');

// Personnalisation du thème
function nathalie_mota_customizer_preview()
{
  wp_enqueue_script(
    'nathalie-mota-customizer',
    get_template_directory_uri() . '/js/customizer.js',
    ['customize-preview'],
    null,
    true
  );
}
add_action('customize_preview_init', 'nathalie_mota_customizer_preview');
