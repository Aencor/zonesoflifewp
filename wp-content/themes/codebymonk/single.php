<?php
/**
 * The template for displaying all single posts
 */

get_header();
?>

<main class="site-main single-post-main">
  <?php while (have_posts()) : the_post(); 
    $postID = get_the_ID();
    $authorLabel = get_field('author_label', $postID);
    if (empty($authorLabel)) {
        $categories = get_the_category($postID);
        $authorLabel = !empty($categories) ? $categories[0]->name : get_the_author();
    }
  ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('single-article'); ?>>
      
      <!-- Article Header -->
      <header class="article-hero hero tint">
        <div class="wrap">
          <div class="mb16">
            <a class="back-link tiny" href="<?php echo esc_url(home_url('/articles/')); ?>">
              &larr; <?php esc_html_e('All Articles', 'codebymonk'); ?>
            </a>
          </div>

          <?php if (!empty($authorLabel)): ?>
            <div class="kicker" style="color:var(--shgreen)">
              <?= esc_html($authorLabel); ?>
            </div>
          <?php endif; ?>

          <h1 class="hero-title mt16"><?php the_title(); ?></h1>

          <div class="article-meta-row mt16">
            <span class="meta-item"><?php echo get_the_date('F j, Y'); ?></span>
            <span class="meta-dot">·</span>
            <span class="meta-item"><?php esc_html_e('By', 'codebymonk'); ?> <?php the_author(); ?></span>
            <?php if (has_category()): ?>
              <span class="meta-dot">·</span>
              <span class="meta-item"><?php the_category(', '); ?></span>
            <?php endif; ?>
          </div>
        </div>
      </header>

      <!-- Featured Image Area (with default fallback) -->
      <div class="wrap article-featured-wrap">
        <?php if (has_post_thumbnail()): ?>
          <div class="featured-media">
            <?php the_post_thumbnail('large', ['class' => 'featured-img', 'alt' => get_the_title()]); ?>
          </div>
        <?php else: ?>
          <!-- Default Featured Image -->
          <div class="featured-media default-featured-media">
            <div class="default-img-banner">
              <div class="default-img-badge">
                <div class="mini-zones">
                  <i class="z1 on"></i><i class="z2 on"></i><i class="z3 on"></i><i class="z4 on"></i>
                </div>
                <div class="default-img-icon">
                  <svg class="ic" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-spark"/></svg>
                </div>
                <div class="default-img-watermark">ZONES OF LIFE</div>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <!-- Article Content Body -->
      <div class="wrap article-body-wrap">
        <div class="article-content rich-text">
          <?php the_content(); ?>
        </div>

        <footer class="article-footer mt48 pt32">
          <div class="hgroup" style="justify-content:space-between;align-items:center;">
            <a class="btn btn-ghost btn-sm" href="<?php echo esc_url(home_url('/articles/')); ?>">
              &larr; <?php esc_html_e('Back to all articles', 'codebymonk'); ?>
            </a>
            <a class="btn btn-go btn-sm" href="<?php echo esc_url(home_url('/short-quiz/')); ?>">
              <?php esc_html_e('Find your Zone', 'codebymonk'); ?>
            </a>
          </div>
        </footer>
      </div>

    </article>
  <?php endwhile; ?>
</main>

<?php
get_footer();
