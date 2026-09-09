<?php
/**
 * Block Name: Contact
 * Class: block-contact
 */

$blockClasses = ['block-contact', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('contact_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'contact';

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Form logic
$formId = get_field('cf7_form_id');
$shortcode = get_field('cf7_shortcode');

if (!empty($formId)) {
    $shortcode = sprintf('[contact-form-7 id="%d"]', intval($formId));
} elseif (empty($shortcode)) {
    $shortcode = '[contact-form-7 id="54" title="Contact form 1"]';
}

// Info Card
$showInfo = get_field('show_info_card');
if ($showInfo === null || $showInfo === '') {
    $showInfo = true;
}

$company = get_field('company_name') ?: __('Advanced Coaching & Leadership Center, Inc.', 'codebymonk');
$address = get_field('address') ?: "1400 Camp Letoli Road\nSaint Jo, Texas 76265\nUnited States";
$phone   = get_field('phone') ?: '+1 940-995-2054';
$devNote = get_field('dev_note');
?>

<section id="<?= esc_attr($blockID); ?>" data-block="contact" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap split top">
    <div class="contact-form-col">
      <?php if (!empty($shortcode)): ?>
        <div class="cf7-container">
          <?= do_shortcode($shortcode); ?>
        </div>
      <?php else: ?>
        <p class="text-muted"><em><?= esc_html__('No contact form selected.', 'codebymonk'); ?></em></p>
      <?php endif; ?>
    </div>

    <?php if ($showInfo): ?>
      <div class="contact-info-col">
        <div class="card tint pad-lg">
          <div class="tiny kicker-pin mb16">
            <svg class="ic" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-pin"/></svg>
            <span><?= esc_html($company); ?></span>
          </div>

          <p class="sm address-text"><?= nl2br(esc_html($address)); ?></p>

          <hr class="rule my20">

          <p class="sm phone-text">
            <a href="tel:<?= esc_attr(preg_replace('/[^0-9\+]/', '', $phone)); ?>" class="mono">
              <?= esc_html($phone); ?>
            </a>
          </p>

          <?php if (!empty($devNote)): ?>
            <div class="note mt24">
              <span class="tiny"><?= esc_html__('Note', 'codebymonk'); ?></span>
              <?= esc_html($devNote); ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
