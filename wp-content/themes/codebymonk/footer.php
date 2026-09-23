<?php
/**
 * The template for displaying the footer
 */
?>
<footer class="site">
  <div class="wrap">
    <div class="footgrid">
      <div>
        <span class="wordmark" style="font-size:12px"><?php bloginfo('name'); ?></span>
        <p class="xs mt16" style="color:rgba(255,255,255,.6);max-width:30ch"><?php echo get_bloginfo('description') ? esc_html(get_bloginfo('description')) : 'The diagnostic behind the method. Part of the Advanced Coaching &amp; Leadership Center.'; ?></p>
        <h4 class="mt24"><?php esc_html_e('Follow', 'codebymonk'); ?></h4>
        <div class="social">
          <a href="https://facebook.com/aclc.us" target="_blank" rel="noopener" aria-label="Facebook">
            <svg class="ic" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-fb"/></svg>
          </a>
          <a href="#contact" class="tbd" aria-label="Instagram — account to be confirmed">
            <svg class="ic" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-ig"/></svg>
          </a>
          <a href="#contact" class="tbd" aria-label="YouTube — account to be confirmed">
            <svg class="ic" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-yt"/></svg>
          </a>
        </div>
        <div class="tiny mt16" style="color:rgba(255,255,255,.42)"><?php esc_html_e('Dashed = account not yet confirmed', 'codebymonk'); ?></div>
      </div>

      <div>
        <h4><?php esc_html_e('Assessment', 'codebymonk'); ?></h4>
        <?php
        if (has_nav_menu('footer_col1')) {
          wp_nav_menu([
            'theme_location' => 'footer_col1',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'fallback_cb'    => false,
          ]);
        } else {
        ?>
          <a href="<?php echo esc_url(home_url('/assessment/')); ?>">How it works</a>
          <a href="<?php echo esc_url(home_url('/short-quiz/')); ?>">Short profile</a>
          <a href="<?php echo esc_url(home_url('/assessment/')); ?>">Full report</a>
        <?php } ?>
      </div>

      <div>
        <h4><?php esc_html_e('Programmes &amp; Events', 'codebymonk'); ?></h4>
        <?php
        if (has_nav_menu('footer_col2')) {
          wp_nav_menu([
            'theme_location' => 'footer_col2',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'fallback_cb'    => false,
          ]);
        } else {
          ?>
          <a href="<?php echo esc_url(home_url('/events/')); ?>"><?php esc_html_e('Events', 'codebymonk'); ?></a>
          <a href="<?php echo esc_url(home_url('/stories/')); ?>"><?php esc_html_e('Stories', 'codebymonk'); ?></a>
          <a href="<?php echo esc_url(home_url('/articles/')); ?>"><?php esc_html_e('Articles', 'codebymonk'); ?></a>
        <?php } ?>
      </div>

      <div>
        <h4><?php esc_html_e('The method', 'codebymonk'); ?></h4>
        <?php
        if (has_nav_menu('footer_col3')) {
          wp_nav_menu([
            'theme_location' => 'footer_col3',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'fallback_cb'    => false,
          ]);
        } else {
        ?>
          <a href="<?php echo esc_url(home_url('/zones/')); ?>">The four Zones</a>
          <a href="<?php echo esc_url(home_url('/assessment/')); ?>">The three areas</a>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>">About ACLC</a>
        <?php } ?>
      </div>

      <div>
        <h4><?php esc_html_e('Company', 'codebymonk'); ?></h4>
        <?php
        if (has_nav_menu('footer_col4')) {
          wp_nav_menu([
            'theme_location' => 'footer_col4',
            'container'      => false,
            'items_wrap'     => '%3$s',
            'depth'          => 1,
            'fallback_cb'    => false,
          ]);
        } else {
        ?>
          <a href="<?php echo esc_url(home_url('/contact/')); ?>">Contact</a>
          <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy policy</a>
          <a href="<?php echo esc_url(home_url('/cookie-policy/')); ?>">Cookie policy</a>
        <?php } ?>
      </div>
    </div>

    <div class="legal">
      <span>© <?php echo date('Y'); ?> <?php esc_html_e('Advanced Coaching & Leadership Center, Inc.', 'codebymonk'); ?></span>
      <?php
      $currentLang = function_exists('apply_filters') ? apply_filters('wpml_current_language', null) : (defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en');
      $footPhone   = ($currentLang === 'es') ? '+52 1 55 4063 5251' : '+1 469-501-1161';
      $footClean   = ($currentLang === 'es') ? '5215540635251' : '14695011161';
      ?>
      <span><?php esc_html_e('Letoli Ranch · Saint Jo, Texas ·', 'codebymonk'); ?> <a href="https://wa.me/<?php echo esc_attr($footClean); ?>" target="_blank" rel="noopener" class="mono" style="color:inherit;text-decoration:none;" title="WhatsApp"><?php echo esc_html($footPhone); ?></a></span>
    </div>
  </div>
</footer>

<div class="cookiebar" id="cookieBar" hidden>
  <div class="wrap cookieinner">
    <div style="flex:1;min-width:260px">
      <div style="font-weight:600;font-size:14px"><?php esc_html_e('We use cookies', 'codebymonk'); ?></div>
      <p class="xs mt8" style="color:rgba(255,255,255,.68);max-width:66ch"><?php esc_html_e('Necessary cookies keep the site working. Analytics and marketing cookies help us understand what people need. You choose.', 'codebymonk'); ?></p>
    </div>
    <div class="hgroup" style="gap:10px;flex-wrap:wrap">
      <a class="btn btn-onDark btn-sm" href="<?php echo esc_url(home_url('/cookie-policy/')); ?>"><?php esc_html_e('Manage', 'codebymonk'); ?></a>
      <button class="btn btn-onDark btn-sm" id="ckReject"><?php esc_html_e('Reject non-essential', 'codebymonk'); ?></button>
      <button class="btn btn-primary btn-sm" id="ckAccept"><?php esc_html_e('Accept all', 'codebymonk'); ?></button>
    </div>
  </div>
</div>

<?php wp_footer(); ?>
</body>
</html>

