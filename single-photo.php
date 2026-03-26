<?php
get_header();

if (have_posts()) :
  while (have_posts()) :
    the_post();

    // Champs personnalisés
    $ref   = SCF::get('reference');
    $type  = SCF::get('type');
    $year = get_the_date('Y');
    $title = get_the_title();

    // Image principale (image mise en avant)
    $photo_field = SCF::get('photo_image');
    //recuperation de l'image selon le type de champ (url, id ou array)
    if ($photo_field) {
      if (is_string($photo_field)) {
        $photo_url = $photo_field;
      } elseif (is_int($photo_field)) {
        $photo_url = wp_get_attachment_image_url($photo_field, 'large');
      } elseif (is_array($photo_field) && !empty($photo_field['url'])) {
        $photo_url = $photo_field['url'];
      } else {
        $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
      }
    } else {
      $photo_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
    }

    // Taxonomies
    $categories = get_the_terms(get_the_ID(), 'categorie');
    $formats    = get_the_terms(get_the_ID(), 'format');

    $cat_name = (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->name : '';
    $fmt_name = (!empty($formats) && !is_wp_error($formats)) ? $formats[0]->name : '';
    $cat_slug = (!empty($categories) && !is_wp_error($categories)) ? $categories[0]->slug : '';

    // Navigation trié par date et categorie
    $prev = get_previous_post(false, '', 'categorie');
    $next = get_next_post(false, '', 'categorie');

    // Fallback si pas de suivant dans la catégorie
    if (!$next) {
      $next = get_next_post();
    }

    // Miniatures prev/next
    $prev_img = $prev ? get_the_post_thumbnail_url($prev->ID, 'medium') : null;
    $next_img = $next ? get_the_post_thumbnail_url($next->ID, 'medium') : null;
?>

    <main class="single-photo">
      <section class="single-top">
        <div class="single-info">
          <h1 class="single-title"><?php echo esc_html($title); ?></h1>

          <ul class="single-meta">
            <?php if ($ref): ?>
              <li><strong>RÉFÉRENCE :</strong> <?php echo esc_html($ref); ?></li>
            <?php endif; ?>

            <?php if ($cat_name): ?>
              <li><strong>CATÉGORIE :</strong> <?php echo esc_html($cat_name); ?></li>
            <?php endif; ?>

            <?php if ($fmt_name): ?>
              <li><strong>FORMAT :</strong> <?php echo esc_html($fmt_name); ?></li>
            <?php endif; ?>

            <?php if ($type): ?>
              <li><strong>TYPE :</strong> <?php echo esc_html($type); ?></li>
            <?php endif; ?>

            <?php if ($year): ?>
              <li><strong>ANNÉE :</strong> <?php echo esc_html($year); ?></li>
            <?php endif; ?>
          </ul>
        </div>

        <div class="single-image">
          <?php if (!empty($photo_url)): ?>
            <img src="<?php echo esc_url($photo_url); ?>" alt="<?php echo esc_attr($title); ?>">
          <?php endif; ?>
        </div>
      </section>

      <div class="single-sep"></div>

      <section class="single-nav">
        <div class="single-contact">
          <p class="single-cta">Cette photo vous intéresse ?</p>
          <button type="button"
            class="button-contact"
            data-ref="<?php echo esc_attr($ref); ?>">
            Contact
          </button>
        </div>
        <div class="nav-row">
          <div class="nav-next-preview">

            <div class="nav-preview-hover"></div>

            <div class="nav-arrows-under">
              <?php if ($prev) : ?>
                <a class="nav-under left"
                  href="<?php echo esc_url(get_permalink($prev->ID)); ?>"
                  data-preview="<?php echo esc_url($prev_img); ?>"
                  aria-label="Photo précédente">
                </a>
              <?php else: ?>
                <span class="nav-under disabled">←</span>
              <?php endif; ?>

              <?php if ($next) : ?>
                <a class="nav-under right"
                  href="<?php echo esc_url(get_permalink($next->ID)); ?>"
                  data-preview="<?php echo esc_url($next_img); ?>"
                  aria-label="Photo suivante">
                </a>

              <?php else: ?>
                <span class="nav-under disabled">→</span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </section>

      <div class="single-sep2"></div>

      <?php
      // Récupère la catégorie de la photo
      $categories = wp_get_post_terms(get_the_ID(), 'categorie');

      if (!empty($categories)) {

        $cat_id = $categories[0]->term_id;

        $args = [
          'post_type'      => 'photo',
          'posts_per_page' => 2,
          'post__not_in'   => [get_the_ID()],
          'tax_query'      => [
            [
              'taxonomy' => 'categorie',
              'field'    => 'term_id',
              'terms'    => $cat_id,
            ]
          ]
        ];

        $related = new WP_Query($args);
      }
      ?>

      <section class="single-related">
        <h2 class="related-title">Vous aimerez aussi</h2>

        <div class="related-grid">
          <?php
          if ($related && $related->have_posts()) :
            while ($related->have_posts()) : $related->the_post();
              get_template_part('template-parts/photo-block');
            endwhile;
            wp_reset_postdata();
          endif;

          ?>
        </div>
      </section>
    </main>

<?php
  endwhile;
endif;

get_footer(); ?>