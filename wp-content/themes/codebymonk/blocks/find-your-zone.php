<?php
/**
 * Block Name: Find Your Zone
 * Class: block-find-your-zone
 */

$blockClasses = ['block-find-your-zone', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('fyz_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

$bgStyle = get_field('background_style') ?: 'tint';
$kicker = get_field('kicker');
$title = get_field('title') ?: __('The monthly franchise', 'codebymonk');
$description = get_field('description') ?: __('One real story a month with its profile chart, before and after. It is the proof no competitor can copy, because it depends on the assessment.', 'codebymonk');
$buttonText = get_field('button_text') ?: __('Find your Zone', 'codebymonk');
$buttonLink = get_field('button_link');
if (empty($buttonLink) || $buttonLink === '#quiz') {
    $buttonLink = home_url('/short-quiz/');
}
?>

<section id="<?= esc_attr($blockID); ?>" data-block="find-your-zone" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <div class="card <?= esc_attr($bgStyle); ?> pad-lg split cta-banner" style="align-items:center">
      <div class="cta-content">
        <?php if (!empty($kicker)): ?>
          <div class="tiny kicker-mono"><?= esc_html($kicker); ?></div>
        <?php endif; ?>
        <h3 class="<?= !empty($kicker) ? 'mt8' : ''; ?>"><?= esc_html($title); ?></h3>
        <?php if (!empty($description)): ?>
          <p class="sm mt8"><?= esc_html($description); ?></p>
        <?php endif; ?>
      </div>
      <div class="cta-action">
        <a class="btn btn-go" href="<?= esc_url($buttonLink); ?>"><?= esc_html($buttonText); ?></a>
      </div>
    </div>
  </div>
</section>
