<?php
/**
 * Block Name: General Hero
 * Class: block-general-hero
 */

$bgStyle = get_field('background_style') ?: 'tint';
$blockClasses = ['block-general-hero', 'hero', $bgStyle];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('general_hero_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Fields
$kickerIcon = get_field('kicker_icon');
$kicker = get_field('kicker') ?: __('The method', 'codebymonk');
$title = get_field('title') ?: __('Four Zones, and what each one costs you', 'codebymonk');
$description = get_field('description') ?: __('This is the vocabulary the whole ecosystem runs on. Knowing which Zone you are in is what makes every other decision obvious.', 'codebymonk');
$maxWidth = get_field('max_width') ?: '64ch';
?>

<section id="<?= esc_attr($blockID); ?>" data-block="general-hero" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <?php if (!empty($kicker)): ?>
      <div class="kicker">
        <?php if (!empty($kickerIcon)): ?>
          <svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-<?= esc_attr($kickerIcon); ?>"/></svg>
        <?php endif; ?>
        <?= esc_html($kicker); ?>
      </div>
    <?php endif; ?>

    <h1 class="hero-title mt16"><?= esc_html($title); ?></h1>

    <?php if (!empty($description)): ?>
      <p class="lede mt16" style="max-width:<?= esc_attr($maxWidth); ?>"><?= nl2br(esc_html($description)); ?></p>
    <?php endif; ?>
  </div>
</section>
