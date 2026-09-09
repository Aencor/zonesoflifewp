<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo("charset"); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="<?php bloginfo("template_directory"); ?>/assets/img/favicon.png">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php
  if (function_exists('wp_body_open')) {
    wp_body_open();
  }
  ?>
  <?php get_template_part('template-parts/svg-icons'); ?>

  <header class="site">
    <div class="wrap bar">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="hgroup">
        <span class="hgroup">
          <?php if (has_custom_logo()): ?>
            <?php the_custom_logo(); ?>
          <?php else: ?>
            <span class="wordmark"><?php bloginfo('name'); ?></span>
            <span class="pendingmark">logo TBD</span>
          <?php endif; ?>
        </span>
      </a>

      <nav class="main">
        <?php
        if (has_nav_menu('primary')) {
          wp_nav_menu([
            'theme_location' => 'primary',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'fallback_cb'    => false,
          ]);
        } else {
        ?>
          <a href="<?php echo esc_url(home_url('/#zones')); ?>">The Zones</a>
          <a href="<?php echo esc_url(home_url('/#assessment')); ?>">The Assessment</a>
          <a href="<?php echo esc_url(home_url('/#cohorts')); ?>">Cohorts</a>
          <a href="<?php echo esc_url(home_url('/#stories')); ?>">Stories</a>
          <a href="<?php echo esc_url(home_url('/#articles')); ?>">Articles</a>
        <?php } ?>
      </nav>

      <div class="hgroup">
        <a class="btn btn-go btn-sm" href="<?php echo esc_url(home_url('/short-quiz/')); ?>">Find your Zone</a>
        <button class="burger" aria-label="<?php esc_attr_e('Menu', 'codebymonk'); ?>"><i></i><i></i><i></i></button>
      </div>
    </div>
  </header>