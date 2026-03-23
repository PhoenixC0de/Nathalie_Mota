<?php
/* Template Name: Accueil */
get_header(); ?>

<section class="hero">
  <h1 class="hero-title">PHOTOGRAPHE EVENT</h1>
</section>

<section class="photo-gallery">

  <?php
  // Récupération des photos
  $photos = new WP_Query([
    'post_type'      => 'photo',
    'posts_per_page' => 8,
    'post_status'    => 'publish'
  ]);

  if ($photos->have_posts()) :
    while ($photos->have_posts()) : $photos->the_post();

      // Appel du template réutilisable
      get_template_part('template-parts/photo-block');

    endwhile;
  else :
    echo '<p>Aucune photo disponible pour le moment.</p>';
  endif;

  wp_reset_postdata();
  ?>

</section>

<?php get_footer(); ?>