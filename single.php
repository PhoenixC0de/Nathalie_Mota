<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package nathalie_mota
 */

get_header();
?>

<main id="primary" class="site-main">

  <?php

  /* Start the Loop */
  while (have_posts()) :
    the_post();

    get_template_part('template-parts/content/content-single');

    if (is_singular('attachment')) {
      // Parent post navigation.
      the_post_navigation(
        array(
          /* translators: %s: Parent post link. */
          'prev_text' => sprintf(__('<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone'), '%title'),
        )
      );
    } elseif (is_singular('post')) {
      // Previous/next post navigation.
      the_post_navigation(
        array(
          'next_text' => '<p class="meta-nav">' . __('Next Post', 'twentytwentyone') . '</p><p class="post-title">%title</p>',
          'prev_text' => '<p class="meta-nav">' . __('Previous Post', 'twentytwentyone') . '</p><p class="post-title">%title</p>',
        )
      );
    }

    // If comments are open or there is at least one comment, load up the comment template.
    if (comments_open() || get_comments_number()) {
      comments_template();
    }

  endwhile; // End of the loop.

  ?>

</main><!-- #main -->

<?php
get_footer();
