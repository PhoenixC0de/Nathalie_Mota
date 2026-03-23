<article class="photo-card">

  <a href="<?php the_permalink(); ?>" class="photo-card-link">

    <div class="photo-card-image">
      <?php echo get_the_post_thumbnail(get_the_ID(), 'medium'); ?>
    </div>

    <!-- Hover -->
    <div class="photo-card-hover">
      <span class="hover-eye">
        <img src="<?php echo get_template_directory_uri(); ?>/images/Icon_eye.png" alt="">
      </span>
      <span class="hover-fullscreen">
        <img src="<?php echo get_template_directory_uri(); ?>/images/icon_expand.png" alt="">
      </span>
      <span class="hover-title"><?php the_title(); ?></span>
      <span class="hover-category">
        <?php
        $terms = get_the_terms(get_the_ID(), 'categorie');
        if (!empty($terms) && !is_wp_error($terms)) {
          echo esc_html($terms[0]->name);
        }
        ?>
      </span>




    </div>

    <div class="photo-card-info">
      <h3 class="photo-card-title"><?php the_title(); ?></h3>

      <?php
      $ref = get_post_meta(get_the_ID(), 'reference', true);
      if ($ref) :
      ?>
        <span class="photo-card-ref">Réf : <?php echo esc_html($ref); ?></span>
      <?php endif; ?>

      <?php
      $cats = get_the_category();
      if (!empty($cats) && !is_wp_error($cats)) :
      ?>
        <span class="photo-card-cat"><?php echo esc_html($cats[0]->name); ?></span>
      <?php endif; ?>

    </div>

  </a>

</article>