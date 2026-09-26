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

$is_es = function_exists('pll_current_language') && pll_current_language() === 'es';
if (!$is_es && function_exists('apply_filters')) {
    $is_es = (apply_filters('wpml_current_language', null) === 'es');
}

// Card 1
$c1Badge = get_field('card_1_badge') ?: ($is_es ? 'Paso 1 · gratuito' : 'Step 1 · free');
$c1Title = get_field('card_1_title') ?: ($is_es ? 'Mini Perfil Financiero' : 'Financial Mini Profile');
$c1Desc  = get_field('card_1_desc') ?: ($is_es ? '20 preguntas, 3 minutos. Mide con precisión tu Habilidad para Tener dinero y conservarlo, tu nivel en la gráfica de 3 zonas y tu siguiente paso.' : '20 questions, 3 minutes. Precisely measures your Ability to Have money and keep it, your level on the 3-zone chart, and your next step.');
$c1BtnText = get_field('card_1_btn_text') ?: ($is_es ? 'Comenzar gratis' : 'Start for free');
$c1BtnLink = get_field('card_1_btn_link');
if (empty($c1BtnLink) || $c1BtnLink === '#quiz') {
    $c1BtnLink = home_url('/short-quiz/');
}

// Card 2
$c2Badge = get_field('card_2_badge') ?: ($is_es ? 'Paso 2 · automatizado' : 'Step 2 · automated');
$c2Title = get_field('card_2_title') ?: ($is_es ? 'Perfil de Salud Financiera' : 'Financial Health Profile');
$c2Desc  = get_field('card_2_desc') ?: ($is_es ? 'Las 6 habilidades financieras clave (Producir, Enfocar, Investigar, Tener, Invertir y Crear riqueza), lección en audio de Alan C. Walter y cuaderno de trabajo digital descargable.' : 'All 6 key financial abilities (Produce, Focus, Investigate, Have, Invest, and Create Wealth), Alan C. Walter audio lesson, and downloadable digital workbook.');
$c2Price = get_field('card_2_price');
if (empty($c2Price) || in_array(trim($c2Price), ['price TBD', '$500 USD', '$50 USD', '$1,000 MXN', 'precio por definir'])) {
    $c2Price = $is_es ? '$500 MXN' : '$25 USD';
}
$aclc_user = class_exists('ACLC_Auth') ? ACLC_Auth::get_logged_user() : null;
$is_logged_in = !empty($aclc_user);
$pay_url_base = $is_es ? home_url('/es/adquirir/') : home_url('/pay/');
$access_url_base = $is_es ? home_url('/es/acceso/') : home_url('/access/');

$pay_profile = add_query_arg('package', 'profile', $pay_url_base);
$pay_session = add_query_arg('package', 'session', $pay_url_base);

$c2BtnText = get_field('card_2_btn_text') ?: ($is_es ? 'Obtener Perfil ($500 MXN)' : 'Get Profile ($25 USD)');
$c2BtnLink = get_field('card_2_btn_link');
if (empty($c2BtnLink) || in_array($c2BtnLink, ['/finance/', '/es/finance/', home_url('/finance/'), home_url('/es/perfil-financiero/')])) {
    $c2BtnLink = $is_es ? home_url('/es/perfil-financiero/') : home_url('/finance/');
}

// Card 3
$c3Badge = get_field('card_3_badge') ?: ($is_es ? 'Paso 3 · con sesión privada' : 'Step 3 · with private session');
$c3Title = get_field('card_3_title') ?: ($is_es ? 'Perfil + Sesión Privada (60 min)' : 'Profile + Private Session (60 min)');
$c3Desc  = get_field('card_3_desc') ?: ($is_es ? 'Incluye el Perfil de Salud Financiera completo, el audio y cuaderno de trabajo, más una sesión privada de 60 minutos con un coach certificado de ACLC para analizar tus resultados y trazar tu plan.' : 'Includes the complete Financial Health Profile, audio lesson, and workbook, plus a 60-minute private session with a certified ACLC coach to analyze your results and map out your plan.');
$c3Price = get_field('card_3_price');
if (empty($c3Price)) {
    $c3Price = $is_es ? '$1,640 MXN' : '$85 USD';
}
$c3BtnText = get_field('card_3_btn_text') ?: ($is_es ? 'Elegir con Sesión ($1,640 MXN)' : 'Choose with Session ($85 USD)');
$c3BtnLink = get_field('card_3_btn_link');
if (empty($c3BtnLink) || in_array($c3BtnLink, ['/cohorts/', '/events/', '/finance/?package=session', '/es/perfil-financiero/?package=session', home_url('/finance/?package=session'), home_url('/es/perfil-financiero/?package=session')])) {
    $c3BtnLink = $is_es ? home_url('/es/perfil-financiero/?package=session') : home_url('/finance/?package=session');
}

// Guarantee
$showGuarantee = get_field('show_guarantee');
if ($showGuarantee === null || $showGuarantee === '') {
    $showGuarantee = true;
}
$guaranteeTitle = get_field('guarantee_title') ?: ($is_es ? 'Garantía de satisfacción del 100%' : '100% Money-back guarantee');
$guaranteeDesc = get_field('guarantee_desc') ?: ($is_es ? 'Si al revisar tus resultados sientes que este perfil no te dio claridad inmediata sobre tus números y tu siguiente paso, te devolvemos el 100% de tu dinero sin preguntas.' : 'If after reviewing your results you feel this profile did not give you immediate clarity on your numbers and your next step, we will refund 100% of your money, no questions asked.');
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
        <div class="tiny" style="color:var(--fuego)"><?= esc_html($c3Badge); ?></div>
        <h4 class="mt8"><?= esc_html($c3Title); ?></h4>
        <p class="sm mt16"><?= esc_html($c3Desc); ?></p>
        <div class="mt24">
          <?php if (!empty($c3Price)): ?>
            <div class="hgroup mb12" style="justify-content:space-between;align-items:center;">
              <span class="tiny" style="font-weight:700;color:var(--ink);"><?= $is_es ? 'Pago único:' : 'One-time payment:'; ?></span>
              <span class="price-tag" style="font-size:17px;font-weight:700;color:var(--shgreen);"><?= esc_html($c3Price); ?></span>
            </div>
          <?php endif; ?>
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

