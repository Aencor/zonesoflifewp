<?php
/**
 * Block Name: Home Hero
 * Class: block-home-hero
 */

$blockClasses = ['block-home-hero', 'hero', 'tint'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('home_hero_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Fields
$kicker = get_field('kicker') ?: __('The assessment', 'codebymonk');
$title = get_field('title') ?: __('Which Zone are you in today?', 'codebymonk');
$description = get_field('description') ?: __('Your level of success, prosperity, happiness and the quality of your relationships depend on the Zone you are operating from. Twenty questions to find out which one.', 'codebymonk');
$primaryBtnText = get_field('button_primary_text') ?: __('Find your Zone — free', 'codebymonk');
$primaryBtnLink = get_field('button_primary_link');
if (empty($primaryBtnLink) || $primaryBtnLink === '#quiz') {
    $primaryBtnLink = home_url('/short-quiz/');
}
$secondaryBtnText = get_field('button_secondary_text') ?: __('How it works', 'codebymonk');
$secondaryBtnLink = get_field('button_secondary_link');
if (empty($secondaryBtnLink) || $secondaryBtnLink === '#assessment') {
    $secondaryBtnLink = home_url('/assessment/');
}

$cardTitle = get_field('card_title') ?: __('The three areas it measures', 'codebymonk');

$areas = get_field('areas');
if (empty($areas)) {
    $areas = [
        [
            'title'    => __('Financial Profile', 'codebymonk'),
            'subtitle' => __('MEASURE YOUR ABILITY TO CREATE WEALTH', 'codebymonk'),
        ],
        [
            'title'    => __('Life & Skills Profile', 'codebymonk'),
            'subtitle' => __('FIND OUT WHAT YOU THINK OF YOURSELF AND HOW YOU UTILIZE OR RESTRAINT YOUR LIFE SKILLS', 'codebymonk'),
        ],
        [
            'title'    => __('Body Profile', 'codebymonk'),
            'subtitle' => __('DISCOVER YOUR FUTURE PHYSICAL SHAPE', 'codebymonk'),
        ],
    ];
}

$zonesTitle = get_field('zones_title') ?: __('The four Zones', 'codebymonk');
?>

<section id="<?= esc_attr($blockID); ?>" data-block="home-hero" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap split">
    <div>
      <?php if (!empty($kicker)): ?>
        <div class="kicker">
          <svg class="ic" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-compass"/></svg>
          <?= esc_html($kicker); ?>
        </div>
      <?php endif; ?>

      <h1 class="hero-title mt16"><?= esc_html($title); ?></h1>

      <p class="lede mt24"><?= nl2br(esc_html($description)); ?></p>

      <div class="hgroup mt32">
        <?php if (!empty($primaryBtnText)): ?>
          <a class="btn btn-go" href="<?= esc_url($primaryBtnLink); ?>">
            <?= esc_html($primaryBtnText); ?>
            <svg class="ic" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-arrow"/></svg>
          </a>
        <?php endif; ?>

        <?php if (!empty($secondaryBtnText)): ?>
          <a class="btn btn-ghost" href="<?= esc_url($secondaryBtnLink); ?>">
            <?= esc_html($secondaryBtnText); ?>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="card hero-card">
      <div class="tiny mb16">
        <svg class="ic" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-target"/></svg>
        <?= esc_html($cardTitle); ?>
      </div>

      <?php foreach ($areas as $index => $area): 
        $isLast = ($index === count($areas) - 1);
      ?>
        <div class="row"<?= $isLast ? ' style="border:0;"' : '' ?>>
          <div class="grow"><?= esc_html($area['title']); ?></div>
          <span class="tiny"><?= esc_html($area['subtitle']); ?></span>
        </div>
      <?php endforeach; ?>

      <hr class="rule">

      <div class="tiny mb16"><?= esc_html($zonesTitle); ?></div>
      <div class="zones">
        <i class="z1"></i>
        <i class="z2"></i>
        <i class="z3"></i>
        <i class="z4"></i>
      </div>
      <div class="zlabels">
        <span class="tiny"><?php esc_html_e('Red', 'codebymonk'); ?></span>
        <span class="tiny"><?php esc_html_e('Yellow', 'codebymonk'); ?></span>
        <span class="tiny"><?php esc_html_e('Green', 'codebymonk'); ?></span>
        <span class="tiny"><?php esc_html_e('Golden', 'codebymonk'); ?></span>
      </div>
    </div>
  </div>
</section>
