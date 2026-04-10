<div id="lightbox" class="lightbox">
  <div class="lightbox-overlay"></div>

  <div class="lightbox-content">

    <button class="lightbox-close" aria-label="Fermer">
      <img src="<?php echo get_template_directory_uri(); ?>/images/Vector.svg" alt="Fermer" class="lightbox-close">
    </button>

    <div class="lightbox-img-container">
      <img id="lightbox-img" src="" alt="">
    </div>

    <div class="lightbox-infos">
      <h3 id="lightbox-title"></h3>
    </div>

  </div>

  <div class="lightbox-nav">
    <button id="lightbox-prev" class="lightbox-arrow">
      <span class="arrow-icon">
        <img src="<?php echo get_template_directory_uri(); ?>/images/arrow_left.svg" alt="Précédente" class="arrow-svg">
      </span>
    </button>

    <button id="lightbox-next" class="lightbox-arrow">
      <span class="arrow-icon">
        <img src="<?php echo get_template_directory_uri(); ?>/images/arrow_right.svg" alt="Suivante" class="arrow-svg">
      </span>
    </button>
  </div>

</div>