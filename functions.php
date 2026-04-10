<?php

/**
 * Fonctions du thème nathalie_mota
 */

/**
 * Activation du thème
 */
function nathalie_mota_setup()
{

  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');

  register_nav_menus([
    'main-menu'   => 'Menu principal',
    'footer-menu' => 'Menu du footer',
  ]);

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

  wp_enqueue_script('jquery');

  wp_enqueue_style(
    'nathalie-mota-fonts',
    get_template_directory_uri() . '/fonts/fonts.css'
  );

  wp_enqueue_style(
    'nathalie-mota-style',
    get_template_directory_uri() . '/style.css',
    [],
    filemtime(get_template_directory() . '/style.css')
  );

  // ✔ On charge le JS UNE SEULE FOIS
  wp_enqueue_script(
    'nathalie-mota-script',
    get_template_directory_uri() . '/js/main_scripts.js',
    ['jquery'],
    filemtime(get_template_directory() . '/js/main_scripts.js'),
    true
  );

  // ✔ On localise ajax_params sur le BON script
  wp_localize_script('nathalie-mota-script', 'ajax_params', [
    'ajax_url' => admin_url('admin-ajax.php'),
  ]);
}
add_action('wp_enqueue_scripts', 'nathalie_mota_assets');


// Font Awesome
function theme_enqueue_fontawesome()
{
  wp_enqueue_style(
    'fontawesome',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css'
  );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_fontawesome');


// --------------------------------------
// AJAX : Pagination infinie
// --------------------------------------
function load_more_photos_ajax()
{

  $paged = isset($_POST['page']) ? intval($_POST['page']) : 1;
  // On récupère l'ordre envoyé par le JS (ASC ou DESC)
  $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';

  $query = new WP_Query([
    'post_type'      => 'photo',
    'posts_per_page' => 8,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => $order,
  ]);

  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
      get_template_part('template-parts/photo-block');
    endwhile;
  endif;

  wp_reset_postdata();
  wp_die();
}
add_action('wp_ajax_load_more_photos', 'load_more_photos_ajax');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos_ajax');


// --------------------------------------
// AJAX : Filtres
// --------------------------------------
function filter_photos_ajax()
{

  $category = sanitize_text_field($_POST['category']);
  $format   = sanitize_text_field($_POST['format']);
  $order    = sanitize_text_field($_POST['order']);

  $args = [
    'post_type'      => 'photo',
    'posts_per_page' => $is_filtered ? -1 : 8,
    'paged'          => 1,
    'order'          => $order,
    'orderby'        => 'date',
    'tax_query'      => []
  ];

  if ($category) {
    $args['tax_query'][] = [
      'taxonomy' => 'categorie',
      'field'    => 'slug',
      'terms'    => $category
    ];
  }

  if ($format) {
    $args['tax_query'][] = [
      'taxonomy' => 'format',
      'field'    => 'slug',
      'terms'    => $format
    ];
  }

  $query = new WP_Query($args);

  // On capture le HTML
  ob_start();
  if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
      get_template_part('template-parts/photo-block');
    endwhile;
  else :
    echo '<p>Aucune photo trouvée.</p>';
  endif;
  $html = ob_get_clean();

  // On renvoie JSON
  echo json_encode([
    'html' => $html,
    'max'  => 1 // Pas de pagination dans ce cas, on affiche tout
  ]);

  wp_reset_postdata();
  wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos_ajax');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos_ajax');


//chargement du js de la lightbox
wp_enqueue_script(
  'lightbox',
  get_template_directory_uri() . '/js/lightbox.js',
  ['jquery'],
  null,
  true
);
