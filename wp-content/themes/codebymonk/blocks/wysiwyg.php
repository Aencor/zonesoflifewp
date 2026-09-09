<?php
/**
 * Block Name: WYSIWYG Content
 * Class: block-wysiwyg
 */

$blockClasses = ['block-wysiwyg', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('wysiwyg_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Background style
$bgStyle = get_field('background_style') ?: 'default';
if ($bgStyle === 'tint') {
    $blockClasses[] = 'bg-tint';
} elseif ($bgStyle === 'dark') {
    $blockClasses[] = 'bg-dark';
}

// Padding style
$padding = get_field('padding') ?: 'normal';
$blockClasses[] = 'pad-' . esc_attr($padding);

// Content & layout settings
$content = get_field('content');
$maxWidth = get_field('max_width') ?: '760px';
$customClass = get_field('custom_class') ?: 'legalpage';
?>

<section id="<?= esc_attr($blockID); ?>" data-block="wysiwyg" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap wysiwyg-wrap <?= esc_attr($customClass); ?>" style="max-width: <?= esc_attr($maxWidth); ?>;">
    <?php if (!empty($content)): ?>
      <?= wp_kses_post($content); ?>
    <?php elseif (is_admin()): ?>
      <p class="text-muted"><em><?= esc_html__('WYSIWYG Block: Add content in block settings.', 'codebymonk'); ?></em></p>
    <?php endif; ?>
  </div>
</section>
