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

// Default icons and style mapping by level
$defaultZoneIcons = [
    1 => 'zona-roja',
    2 => 'zona-amarilla',
    3 => 'zona-verde',
    4 => 'zona-golden-magic',
];

$defaultZoneStyles = [
    1 => 'red',
    2 => 'yellow',
    3 => 'green',
    4 => 'gold',
];

// Cards
$zones = get_field('zones');
if (empty($zones)) {
    $zones = [
        [
            'title'       => __('Red', 'codebymonk'),
            'level'       => 1,
            'icon'        => 'zona-roja',
            'icon_style'  => 'red',
            'title_color' => 'var(--red)',
            'description' => __('This is someone who is in the wrong place at the wrong time, connected to the wrong people.', 'codebymonk'),
        ],
        [
            'title'       => __('Yellow', 'codebymonk'),
            'level'       => 2,
            'icon'        => 'zona-amarilla',
            'icon_style'  => 'yellow',
            'title_color' => '#B98F0C',
            'description' => __('This is the “daily grind” or “rut” where the person doesn’t take risks but works only for security.', 'codebymonk'),
        ],
        [
            'title'       => __('Green', 'codebymonk'),
            'level'       => 3,
            'icon'        => 'zona-verde',
            'icon_style'  => 'green',
            'title_color' => 'var(--shgreen)',
            'description' => __('This is someone who is in the right place at the right time, making things go right. This person is living their dream.', 'codebymonk'),
        ],
        [
            'title'       => __('Golden Magic', 'codebymonk'),
            'level'       => 4,
            'icon'        => 'zona-golden-magic',
            'icon_style'  => 'gold',
            'title_color' => '#8A7440',
            'description' => __('You are outside of the physical universe. You operate above the laws of the physical universe and are totally telepathic.', 'codebymonk'),
        ],
    ];
}

// CTA Banner
$showCTA = get_field('show_cta');
if ($showCTA === null || $showCTA === '') {
    $showCTA = true;
}
$ctaTitle = get_field('cta_title') ?: __('Reading about the Zones is not the same as knowing yours', 'codebymonk');
$ctaDesc = get_field('cta_description') ?: __('Twenty questions, two minutes, no card.', 'codebymonk');
$ctaBtnText = get_field('cta_button_text') ?: __('Find your Zone', 'codebymonk');
$ctaBtnLink = get_field('cta_button_link');
if (empty($ctaBtnLink) || $ctaBtnLink === '#quiz') {
    $ctaBtnLink = home_url('/short-quiz/');
}
?>

<section id="<?= esc_attr($blockID); ?>" data-block="four-zones" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <div class="g4">
      <?php foreach ($zones as $index => $zone): 
        $level = intval($zone['level'] ?? ($index + 1));
        
        $icon = !empty($zone['icon']) ? $zone['icon'] : ($defaultZoneIcons[$level] ?? 'zona-roja');
        if (in_array($icon, ['compass', 'spark', 'chart', 'target'])) {
            $icon = $defaultZoneIcons[$level] ?? $icon;
        }

        $iconStyle = !empty($zone['icon_style']) ? $zone['icon_style'] : ($defaultZoneStyles[$level] ?? 'navy');
        if ($iconStyle === 'navy' && isset($defaultZoneStyles[$level])) {
            $iconStyle = $defaultZoneStyles[$level];
        }

        $iconBoxClass = 'iconbox mb16 ' . esc_attr($iconStyle);
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
