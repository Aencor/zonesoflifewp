<?php
/**
 * Block Name: Newsletter
 * Class: block-newsletter
 */

$blockClasses = ['block-newsletter'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('newsletter_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Content fields
$kicker = get_field('kicker') ?: 'Free weekly';
$title = get_field('title') ?: 'In The Zone Newsletter';
$is_es = function_exists('pll_current_language') && pll_current_language() === 'es';
$default_desc = $is_es 
    ? 'Una idea por semana para avanzar en las Zonas, más nuevas fechas de eventos antes de que abran públicamente.'
    : 'One idea a week on moving up the Zones, plus new event dates before they open publicly.';
$description = get_field('description') ?: $default_desc;
$formType = get_field('form_type') ?: 'default';
$embedCode = get_field('mailchimp_embed_code');
$placeholder = get_field('email_placeholder') ?: 'jane@example.com';
$buttonText = get_field('button_text') ?: 'Subscribe';
$privacyText = get_field('privacy_text') ?: 'I agree to the Privacy Policy. Unsubscribe anytime.';
?>

<section id="<?= esc_attr($blockID); ?>" data-block="newsletter" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <div class="newsband">
      <div class="split" style="align-items:center;gap:32px">
        <div>
          <?php if ($kicker): ?>
            <div class="kicker">
              <svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-mail"/></svg>
              <?= esc_html($kicker); ?>
            </div>
          <?php endif; ?>

          <?php if ($title): ?>
            <h3 class="news-title mt8"><?= esc_html($title); ?></h3>
          <?php endif; ?>

          <?php if ($description): ?>
            <p class="news-desc sm mt8"><?= nl2br(esc_html($description)); ?></p>
          <?php endif; ?>
        </div>

        <div>
          <?php if ($formType === 'embed' && !empty($embedCode)): ?>
            <div class="embed-container">
              <?= $embedCode; ?>
            </div>
          <?php else: ?>
            <div class="newsForm">
              <div class="newsrow">
                <input class="input nMail" type="email" placeholder="<?= esc_attr($placeholder); ?>" aria-label="<?= esc_attr($placeholder); ?>" required>
                <button class="btn btn-primary nGo" type="button"><?= esc_html($buttonText); ?></button>
              </div>
              <label class="xs privacy-label">
                <input type="checkbox" class="nOk">
                <span><?= esc_html($privacyText); ?></span>
              </label>
            </div>
            <div class="newsDone" hidden>
              <h4 style="color:var(--shgreen)"><?php esc_html_e('You are subscribed', 'codebymonk'); ?></h4>
              <p class="sm mt8 newsTxt"></p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
