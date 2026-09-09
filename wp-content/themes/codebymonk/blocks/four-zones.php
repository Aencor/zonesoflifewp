<?php
/**
 * Block Name: Four Zones
 * Class: block-four-zones
 */

$blockClasses = ['block-four-zones', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('four_zones_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Cards
$zones = get_field('zones');
if (empty($zones)) {
    $zones = [
        [
            'title'       => __('Red', 'codebymonk'),
            'level'       => 1,
            'icon'        => 'compass',
            'icon_style'  => 'navy',
            'title_color' => 'var(--red)',
            'description' => __('Out of flow. You react to what happens rather than directing it. Effort produces little.', 'codebymonk'),
        ],
        [
            'title'       => __('Amber', 'codebymonk'),
            'level'       => 2,
            'icon'        => 'spark',
            'icon_style'  => 'gold',
            'title_color' => '#B98F0C',
            'description' => __('Awake. You can name what is not working, but change still depends on how you feel that day.', 'codebymonk'),
        ],
        [
            'title'       => __('Green', 'codebymonk'),
            'level'       => 3,
            'icon'        => 'chart',
            'icon_style'  => 'green',
            'title_color' => 'var(--shgreen)',
            'description' => __('In flow. Results come consistently because structure holds them, not willpower.', 'codebymonk'),
        ],
        [
            'title'       => __('Golden Magic', 'codebymonk'),
            'level'       => 4,
            'icon'        => 'target',
            'icon_style'  => 'gold',
            'title_color' => '#8A7440',
            'description' => __('Mastery. You operate in your Zone and you can take others there.', 'codebymonk'),
        ],
    ];
}

// CTA Banner
$showCTA = get_field('show_cta');
if ($showCTA === null || $showCTA === '') {
    $showCTA = true;
}
$ctaTitle = get_field('cta_title') ?: __('Reading about the Zones is not the same as knowing yours', 'codebymonk');
$ctaDesc = get_field('cta_description') ?: __('Fourteen questions, two minutes, no card.', 'codebymonk');
$ctaBtnText = get_field('cta_button_text') ?: __('Find your Zone', 'codebymonk');
$ctaBtnLink = get_field('cta_button_link');
if (empty($ctaBtnLink) || $ctaBtnLink === '#quiz') {
    $ctaBtnLink = home_url('/short-quiz/');
}
?>

<section id="<?= esc_attr($blockID); ?>" data-block="four-zones" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <div class="g4">
      <?php foreach ($zones as $zone): 
        $level = intval($zone['level'] ?? 1);
        $icon = !empty($zone['icon']) ? $zone['icon'] : 'compass';
        $iconBoxClass = 'iconbox mb16';
        if (!empty($zone['icon_style']) && $zone['icon_style'] !== 'navy') {
            $iconBoxClass .= ' ' . esc_attr($zone['icon_style']);
        }
        $titleColor = !empty($zone['title_color']) ? $zone['title_color'] : 'var(--ink)';
      ?>
        <div class="card">
          <div class="<?= esc_attr($iconBoxClass); ?>">
            <svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-<?= esc_attr($icon); ?>"/></svg>
          </div>
          
          <div class="zones dim">
            <i class="z1 <?= $level >= 1 ? 'on' : ''; ?>"></i>
            <i class="z2 <?= $level >= 2 ? 'on' : ''; ?>"></i>
            <i class="z3 <?= $level >= 3 ? 'on' : ''; ?>"></i>
            <i class="z4 <?= $level >= 4 ? 'on' : ''; ?>"></i>
          </div>

          <h4 class="mt16" style="color:<?= esc_attr($titleColor); ?>"><?= esc_html($zone['title']); ?></h4>
          <p class="sm mt8"><?= esc_html($zone['description']); ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <?php if ($showCTA): ?>
      <div class="card tint pad-lg mt32 split cta-banner" style="align-items:center">
        <div>
          <h3><?= esc_html($ctaTitle); ?></h3>
          <p class="sm mt8"><?= esc_html($ctaDesc); ?></p>
        </div>
        <div class="cta-action">
          <a class="btn btn-go" href="<?= esc_url($ctaBtnLink); ?>"><?= esc_html($ctaBtnText); ?></a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</section>
