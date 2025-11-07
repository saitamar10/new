<?php
/**
 * Single Post Template
 *
 * @package OneNav
 */

get_header();
?>

<main class="single">
  <nav class="breadcrumbs">
    <?php if (function_exists('onenav_breadcrumbs')) onenav_breadcrumbs(); ?>
  </nav>

  <?php
  while (have_posts()) :
    the_post();
  ?>

  <article <?php post_class('single__article'); ?>>
    <header class="single__header">
      <h1 class="single__title"><?php the_title(); ?></h1>
      <div class="single__meta">
        <span class="meta__author"><?php the_author(); ?></span>
        <span class="meta__date"><?php echo get_the_date('j F Y'); ?></span>
        <span class="meta__views"><?php echo esc_html(onenav_get_post_views(get_the_ID())); ?></span>
        <button class="like-btn" data-post="<?php the_ID(); ?>">
          <span class="like-icon">❤</span>
          <span class="like-count"><?php echo (int) get_post_meta(get_the_ID(), '_likes', true); ?></span>
        </button>
      </div>
      <?php if (has_post_thumbnail()) : ?>
        <div class="single__thumb"><?php the_post_thumbnail('large'); ?></div>
      <?php endif; ?>
    </header>

    <?php
    // Optional PDF button (custom field)
    $pdf = get_post_meta(get_the_ID(), 'pdf_url', true);
    if ($pdf) {
      echo '<p class="single__pdf"><a class="btn btn--pdf" href="' . esc_url($pdf) . '" target="_blank" rel="noopener nofollow">PDF\'yi Aç</a></p>';
    }
    ?>

    <!-- İçindekiler -->
    <aside id="toc" class="single__toc"></aside>

    <div class="single__content">
      <?php
      the_content();

      // Çok sayfalı yazı (<!--nextpage-->)
      wp_link_pages(array(
        'before'      => '<div class="page-links"><span class="page-links__title">Yazı Sayfaları:</span>',
        'after'       => '</div>',
        'link_before' => '<span class="page-links__num">',
        'link_after'  => '</span>',
        'pagelink'    => '%',
        'separator'   => '',
      ));
      ?>
    </div>

    <footer class="single__footer">
      <div class="single__tags"><?php the_tags('', ' ', ''); ?></div>

      <nav class="single__post-nav">
        <div class="post-nav__prev"><?php previous_post_link('%link', '← %title'); ?></div>
        <div class="post-nav__next"><?php next_post_link('%link', '%title →'); ?></div>
      </nav>
    </footer>
  </article>

  <section class="single__related">
    <h3>Benzer Yazılar</h3>
    <div class="cards cards--related">
      <?php
      $cats = wp_get_post_categories(get_the_ID());
      $q = new WP_Query(array(
        'post__not_in'       => array(get_the_ID()),
        'posts_per_page'     => 6,
        'category__in'       => $cats,
        'ignore_sticky_posts' => 1
      ));
      if ($q->have_posts()) :
        while ($q->have_posts()) : $q->the_post();
          get_template_part('template-parts/card', 'post');
        endwhile;
        wp_reset_postdata();
      endif;
      ?>
    </div>
  </section>

  <?php comments_template(); ?>

  <aside class="single__sidebar"><?php get_sidebar(); ?></aside>

  <?php endwhile; ?>
</main>

<?php get_footer(); ?>
