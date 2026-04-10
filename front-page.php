<?php
/* Template Name: Accueil */
get_header();

// Récupération des champs SCF
$hero_image = SCF::get('hero_image', get_the_ID());
$hero_titre = SCF::get('hero_title', get_the_ID());

// Gestion de l'image (ID ou URL)
if ($hero_image) {
  if (is_numeric($hero_image)) {
    $hero_url = wp_get_attachment_image_url($hero_image, 'full');
  } else {
    $hero_url = $hero_image;
  }
}
?>

<section class="hero_image"
  style="background-image: url('<?php echo esc_url($hero_url); ?>');">

  <h1 class="hero_title">
    <?php echo esc_html($hero_titre); ?>
  </h1>

</section>

<!-- afficher les filtres dynamiques pour categorie, format et trie -->

<div class="filters">
  <div class="filter-left">
    <div class="custom-select" data-filter="category">
      <div class="custom-select-trigger" data-placeholder="Catégories">
        <span>Catégories</span>
        <img class="arrow" src="/wp-content/themes/Nathalie_Mota/images/icon-down.png" alt="">
      </div>

      <div class="custom-options">
        <!-- OPTION RESET -->
        <div class="custom-option reset-option" data-value="">Catégories</div>
        <?php
        $categories = get_terms('categorie');
        foreach ($categories as $cat) {
          echo '<div class="custom-option" data-value="' . $cat->slug . '">' . $cat->name . '</div>';
        }
        ?>
      </div>
    </div>

    <div class="custom-select" data-filter="format">
      <div class="custom-select-trigger" data-placeholder="Formats">
        <span>Formats</span>
        <img class="arrow" src="/wp-content/themes/Nathalie_Mota/images/icon-down.png" alt="">
      </div>

      <div class="custom-options">
        <!-- OPTION RESET -->
        <div class="custom-option reset-option" data-value="">Formats</div>
        <?php
        $formats = get_terms('format');
        foreach ($formats as $format) {
          echo '<div class="custom-option" data-value="' . $format->slug . '">' . $format->name . '</div>';
        }
        ?>
      </div>
    </div>
  </div>


  <div class="filter-right">
    <div class="custom-select" data-filter="order">
      <div class="custom-select-trigger" data-placeholder="Trier par">
        <span>Trier par</span>
        <img class="arrow" src="/wp-content/themes/Nathalie_Mota/images/icon-down.png" alt="">
      </div>

      <div class="custom-options">
        <!-- OPTION RESET -->
        <div class="custom-option reset-option" data-value="">Trier par</div>
        <div class="custom-option" data-value="DESC">Plus récentes</div>
        <div class="custom-option" data-value="ASC">Plus anciennes</div>
      </div>
    </div>
  </div>
</div>

<section class="photo-gallery">

  <?php
  // Récupération des photos
  $photos = new WP_Query([
    'post_type'      => 'photo',
    'posts_per_page' => 8,
    'post_status'    => 'publish',
    'orderby'        => 'date',
    'order'          => 'DESC'
  ]);

  if ($photos->have_posts()) :
    $index = 0; // Initialisation de l'index pour la lightbox
    while ($photos->have_posts()) : $photos->the_post();

      // Appel du template réutilisable
      get_template_part('template-parts/photo-block', null, ['index' => $index]);
      $index++; // Incrémentation pour photo suivante

    endwhile;
  else :
    echo '<p>Aucune photo disponible pour le moment.</p>';
  endif;

  wp_reset_postdata();
  ?>

</section>

<div id="load-more"
  data-page="1"
  data-max="<?php echo $photos->max_num_pages; ?>">
  Charger plus
</div>

<?php get_footer(); ?>