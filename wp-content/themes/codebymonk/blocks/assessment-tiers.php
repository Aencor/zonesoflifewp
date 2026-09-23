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

$is_es = function_exists('pll_current_language') && pll_current_language() === 'es';
if (!$is_es && function_exists('apply_filters')) {
    $is_es = (apply_filters('wpml_current_language', null) === 'es');
}

$c2Badge = get_field('card_2_badge') ?: ($is_es ? 'Paso 2 · de pago' : 'Step 2 · paid');
$c2Title = get_field('card_2_title') ?: ($is_es ? 'Reporte Completo Automatizado' : 'Full Report Automated');
$c2Desc  = get_field('card_2_desc') ?: ($is_es ? 'Desglose pregunta por pregunta de las tres áreas, qué mover primero y en qué orden, y cómo se ve la Zona Verde en tu caso específico.' : 'Question-by-question breakdown of all three areas, what to move first and in what order, and what the Green Zone looks like in your specific case.');
$c2Price = get_field('card_2_price');
if (empty($c2Price) || in_array(trim($c2Price), ['price TBD', '$500 USD', '$50 USD', '$1,000 MXN', 'precio por definir'])) {
    $c2Price = $is_es ? '$500 MXN' : '$25 USD';
}
$c2BtnText = get_field('card_2_btn_text') ?: ($is_es ? 'Obtener el reporte completo' : 'Get the full report');
$c2BtnLink = get_field('card_2_btn_link');
if (empty($c2BtnLink) || $c2BtnLink === '/finance/' || $c2BtnLink === '/es/finance/') {
    $c2BtnLink = $is_es ? home_url('/es/perfil-financiero/') : home_url('/finance/');
}

// Card 3
$c3Badge = get_field('card_3_badge') ?: ($is_es ? '60 minutos de Coaching Personalizado' : '60 minutes of Personalized Coaching');
$c3Title = get_field('card_3_title') ?: ($is_es ? 'Reporte Completo Uno a Uno' : 'Full Report One on One');
$c3Desc  = get_field('card_3_desc') ?: ($is_es ? 'Un evento con fecha de inicio y un grupo aquí, o coaching continuo uno a uno con un coach asignado en ACLC.' : 'An event with a start date and a group here, or continuous one-to-one coaching with an assigned coach at ACLC.');
$c3BtnText = get_field('card_3_btn_text') ?: ($is_es ? 'Ver opciones' : 'See options');
$c3BtnLink = get_field('card_3_btn_link');
if (empty($c3BtnLink) || $c3BtnLink === '/cohorts/' || $c3BtnLink === '/events/') {
    $c3BtnLink = $is_es ? home_url('/es/eventos/') : home_url('/events/');
}

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
          <?php if (!empty($c2Price)): ?>
            <div class="hgroup mb12" style="justify-content:space-between;align-items:center;">
              <span class="tiny" style="font-weight:700;color:var(--ink);"><?= $is_es ? 'Pago único:' : 'One-time payment:'; ?></span>
              <span class="price-tag" style="font-size:17px;font-weight:700;color:var(--shgreen);"><?= esc_html($c2Price); ?></span>
            </div>
          <?php endif; ?>
          <?php if (!empty($c2BtnText)): ?>
            <a class="btn btn-go btn-sm btn-block" href="<?= esc_url($c2BtnLink); ?>">
              <?= esc_html($c2BtnText); ?>
            </a>
          <?php endif; ?>
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
