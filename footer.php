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