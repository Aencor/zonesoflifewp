<?php
/**
 * Block Name: Assessment Tiers
 * Class: block-assessment-tiers
 */

$blockClasses = ['block-assessment-tiers', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('tiers_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Card 1
$c1Badge = get_field('card_1_badge') ?: __('Step 1 · free', 'codebymonk');
$c1Title = get_field('card_1_title') ?: __('Short profile', 'codebymonk');
$c1Desc  = get_field('card_1_desc') ?: __('Twenty questions, two minutes. You get your Zone, why you are in it, and which of the three areas is holding you back.', 'codebymonk');
$c1BtnText = get_field('card_1_btn_text') ?: __('Start', 'codebymonk');
$c1BtnLink = get_field('card_1_btn_link');
if (empty($c1BtnLink) || $c1BtnLink === '#quiz') {
    $c1BtnLink = home_url('/short-quiz/');
}

// Card 2
$c2Badge = get_field('card_2_badge') ?: __('Step 2 · paid', 'codebymonk');
$c2Title = get_field('card_2_title') ?: __('Full Report Automated', 'codebymonk');
$c2Desc  = get_field('card_2_desc') ?: __('Question-by-question breakdown of all three areas, what to move first and in what order, and what the Green Zone looks like in your specific case.', 'codebymonk');
$c2Price = get_field('card_2_price') ?: 'price TBD';

// Card 3
$c3Badge = get_field('card_3_badge') ?: __('60 minutes of Personalized Coaching', 'codebymonk');
$c3Title = get_field('card_3_title') ?: __('Full Report One on One', 'codebymonk');
$c3Desc  = get_field('card_3_desc') ?: __('A cohort with a start date and a group here, or continuous one-to-one coaching with an assigned coach at ACLC.', 'codebymonk');
$c3BtnText = get_field('card_3_btn_text') ?: __('See options', 'codebymonk');
$c3BtnLink = get_field('card_3_btn_link') ?: '/cohorts/';

// Guarantee
$showGuarantee = get_field('show_guarantee');
if ($showGuarantee === null || $showGuarantee === '') {
    $showGuarantee = true;
}
$guaranteeTitle = get_field('guarantee_title') ?: __('Money-back guarantee', 'codebymonk');
$guaranteeDesc = get_field('guarantee_desc') ?: __('The guarantee already exists on the current site and improves conversion. Keep it visible next to every buy button, not buried in the footer.', 'codebymonk');
?>

<section id="<?= esc_attr($blockID); ?>" data-block="assessment-tiers" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <div class="g3">
      <!-- Card 1 -->
      <div class="card tier-card">
        <div class="tiny" style="color:var(--shgreen)"><?= esc_html($c1Badge); ?></div>
        <h4 class="mt8"><?= esc_html($c1Title); ?></h4>
        <p class="sm mt16"><?= esc_html($c1Desc); ?></p>
        <div class="mt24">
          <a class="btn btn-go btn-sm btn-block js-scroll-to-quiz" href="<?= esc_url($c1BtnLink); ?>">
            <?= esc_html($c1BtnText); ?>
          </a>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="card tier-card">
        <div class="tiny" style="color:var(--fuego)"><?= esc_html($c2Badge); ?></div>
        <h4 class="mt8"><?= esc_html($c2Title); ?></h4>
        <p class="sm mt16"><?= esc_html($c2Desc); ?></p>
        <div class="mt24">
          <span class="pending"><?= esc_html($c2Price); ?></span>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="card tier-card">
        <div class="tiny"><?= esc_html($c3Badge); ?></div>
        <h4 class="mt8"><?= esc_html($c3Title); ?></h4>
        <p class="sm mt16"><?= esc_html($c3Desc); ?></p>
        <div class="mt24">
          <a class="btn btn-ghost btn-sm btn-block" href="<?= esc_url($c3BtnLink); ?>">
            <?= esc_html($c3BtnText); ?>
          </a>
        </div>
      </div>
    </div>

    <?php if ($showGuarantee): ?>
      <div class="card tint pad-lg mt32 guarantee-card">
        <div class="tiny mb8"><?= esc_html($guaranteeTitle); ?></div>
        <p class="sm"><?= esc_html($guaranteeDesc); ?></p>
      </div>
    <?php endif; ?>
  </div>
</section>
