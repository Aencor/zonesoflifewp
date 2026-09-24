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
$currentLang = function_exists('apply_filters') ? apply_filters('wpml_current_language', null) : (defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : 'en');
$isSpanish   = ($currentLang === 'es');

$defaultPhone = '+1 469-501-1161';
$acfPhone     = get_field('phone');
$phone        = (!empty($acfPhone) && $acfPhone !== '+1 940-995-2054' && $acfPhone !== '+52 1 55 4063 5251') ? $acfPhone : $defaultPhone;
$cleanPhone   = preg_replace('/[^0-9]/', '', $phone);
$devNote      = get_field('dev_note');
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

          <div class="sm phone-text" style="display:flex; flex-direction:column; gap:10px;">
            <div>
              <a href="tel:<?= esc_attr(preg_replace('/[^0-9\+]/', '', $phone)); ?>" class="mono" style="font-size:15px; font-weight:600;">
                <?= esc_html($phone); ?>
              </a>
            </div>
            <div>
              <a href="https://wa.me/<?= esc_attr($cleanPhone); ?>" target="_blank" rel="noopener noreferrer" class="mono" style="display:inline-flex; align-items:center; gap:7px; color:#25D366; text-decoration:none; font-size:13.5px; font-weight:600; background:rgba(37,211,102,0.12); padding:6px 14px; border-radius:8px; border:1px solid rgba(37,211,102,0.25);" title="WhatsApp">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>WhatsApp</span>
              </a>
            </div>
          </div>

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
