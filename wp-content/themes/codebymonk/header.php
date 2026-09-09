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
        <?php if (has_custom_logo()): ?>
          <?php the_custom_logo(); ?>
        <?php else: ?>
          <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logos/logo-white.png" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" class="logo">
        <?php endif; ?>
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
          <a href="<?php echo esc_url(home_url('/#zones')); ?>"><?php esc_html_e('The Zones', 'codebymonk'); ?></a>
          <a href="<?php echo esc_url(home_url('/#assessment')); ?>"><?php esc_html_e('The Assessment', 'codebymonk'); ?></a>
          <a href="<?php echo esc_url(home_url('/#cohorts')); ?>"><?php esc_html_e('Cohorts', 'codebymonk'); ?></a>
          <a href="<?php echo esc_url(home_url('/#stories')); ?>"><?php esc_html_e('Stories', 'codebymonk'); ?></a>
          <a href="<?php echo esc_url(home_url('/#articles')); ?>"><?php esc_html_e('Articles', 'codebymonk'); ?></a>
        <?php } ?>
      </nav>

      <div class="hgroup">
        <?php
        $languages = function_exists('apply_filters') ? apply_filters('wpml_active_languages', NULL, 'skip_missing=0') : [];
        if (!empty($languages) && count($languages) > 1):
        ?>
          <div class="lang-switch">
            <?php foreach ($languages as $l): ?>
              <a href="<?php echo esc_url($l['url']); ?>" class="lang-btn <?php echo !empty($l['active']) ? 'active' : ''; ?>" title="<?php echo esc_attr($l['native_name']); ?>">
                <?php echo esc_html(strtoupper($l['language_code'])); ?>
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php
        $currentLang = function_exists('apply_filters') ? apply_filters('wpml_current_language', null) : (defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en');
        $quiz_url = ($currentLang === 'es') ? home_url('/es/perfil-corto/') : home_url('/short-quiz/');
        ?>
        <a class="btn btn-go btn-sm" href="<?php echo esc_url($quiz_url); ?>"><?php esc_html_e('Find your Zone', 'codebymonk'); ?></a>
        <button class="burger" aria-label="<?php esc_attr_e('Menu', 'codebymonk'); ?>"><i></i><i></i><i></i></button>
      </div>
    </div>
  </header>