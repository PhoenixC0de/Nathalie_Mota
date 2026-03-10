<footer id="colophon" class="site-footer">
  <div class="footer-container">
    <?php
    wp_nav_menu([
      'theme_location' => 'footer-menu',
      'container'      => false,
      'menu_class'     => 'footer-menu',
    ]);
    ?>
  </div>
</footer>

<?php get_template_part('template-parts/modal_contact'); ?>

<?php wp_footer(); ?>
</body>

</html>