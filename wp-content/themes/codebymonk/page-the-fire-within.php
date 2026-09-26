<?php
/**
 * Template Name: The Fire Within - Book Landing
 * 
 * High-Converting Landing Page for "The Fire Within" (El Fuego Que Llevas Dentro)
 * by Ceil Stanford & Dr. Jeff Crippen · Advanced Coaching & Leadership Center
 */

get_header();

// Detect language (English vs Spanish)
$current_lang = 'en';
if (function_exists('apply_filters')) {
    $current_lang = apply_filters('wpml_current_language', null);
}
if (!$current_lang && defined('ICL_LANGUAGE_CODE')) {
    $current_lang = ICL_LANGUAGE_CODE;
}
if (!$current_lang) {
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    if (strpos($uri, '/es/') !== false || strpos($uri, 'fuego') !== false) {
        $current_lang = 'es';
    } else {
        $current_lang = 'en';
    }
}
$is_es = ($current_lang === 'es');

// Cart Links
$cart_url = $is_es 
    ? 'https://cart.knowledgism.com/el-fuego-dentro/' 
    : 'https://cart.knowledgism.com/the-fire-within/';

// Alternate Language Page URL
$en_page_url = home_url('/the-fire-within/');
$es_page_url = home_url('/es/el-fuego-que-llevas-dentro/');

// Asset paths
$img_dir = get_template_directory_uri() . '/assets/img/the-fire-within';
$book_cover = $img_dir . '/book-cover.webp';
$bonuses_img = $img_dir . '/bonuses.webp';
$kiyosaki_img = $img_dir . '/kiyosaki-endorsement.jpg';
$ceil_img = $img_dir . '/ceil-stanford.png';
$ceil_jeff_img = $img_dir . '/ceil-jeff.webp';

// Price Display
$price_display = '$5 USD';
$price_subtitle = $is_es ? 'Pago único · Acceso digital inmediato + 4 Bonos' : 'One-time payment · Instant digital access + 4 Bonuses';
?>

<style>
/* ==========================================================================
   The Fire Within - Modern Premium Landing Page Styles
   ========================================================================== */
:root {
  --tfw-bg-dark: #070a10;
  --tfw-bg-card: #0e1522;
  --tfw-bg-card-hover: #141f30;
  --tfw-border: rgba(255, 255, 255, 0.08);
  --tfw-border-glow: rgba(245, 158, 11, 0.3);
  --tfw-flame-1: #ff5500;
  --tfw-flame-2: #f59e0b;
  --tfw-flame-3: #fbbf24;
  --tfw-green: #00a84f;
  --tfw-green-glow: rgba(0, 168, 79, 0.35);
  --tfw-text-main: #f3f4f6;
  --tfw-text-muted: #9ca3af;
  --tfw-text-dim: #6b7280;
}

.tfw-landing {
  background-color: var(--tfw-bg-dark);
  color: var(--tfw-text-main);
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
  overflow-x: hidden;
  position: relative;
  line-height: 1.65;
}

.tfw-container {
  max-width: 1140px;
  margin: 0 auto;
  padding: 0 24px;
}

/* Typography Overrides */
.tfw-landing h1, .tfw-landing h2, .tfw-landing h3, .tfw-landing h4 {
  color: #ffffff;
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 1.2;
}

.tfw-lead {
  font-size: 1.2rem;
  color: #d1d5db;
  line-height: 1.7;
}

.tfw-highlight {
  background: linear-gradient(120deg, var(--tfw-flame-1) 0%, var(--tfw-flame-2) 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}

.tfw-green-highlight {
  background: linear-gradient(120deg, #10b981 0%, #34d399 100%);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  display: inline-block;
}

/* Badges */
.tfw-badge {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 6px 16px;
  border-radius: 999px;
  font-size: 0.82rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  background: rgba(245, 158, 11, 0.12);
  border: 1px solid rgba(245, 158, 11, 0.3);
  color: var(--tfw-flame-3);
  margin-bottom: 20px;
}

.tfw-badge-green {
  background: rgba(0, 168, 79, 0.12);
  border-color: rgba(0, 168, 79, 0.3);
  color: #34d399;
}

/* Hero Section */
.tfw-hero {
  position: relative;
  padding: 60px 0 80px;
  background: radial-gradient(circle at 50% 10%, rgba(245, 158, 11, 0.12) 0%, rgba(7, 10, 16, 0.95) 70%), var(--tfw-bg-dark);
  border-bottom: 1px solid var(--tfw-border);
}

.tfw-hero-grid {
  display: grid;
  grid-template-columns: 1.15fr 0.85fr;
  gap: 48px;
  align-items: center;
}

.tfw-hero-title {
  font-size: clamp(2rem, 3.8vw, 3.2rem);
  margin-bottom: 24px;
}

.tfw-hero-visual {
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
}

.tfw-book-card {
  position: relative;
  padding: 20px;
  border-radius: 20px;
  background: linear-gradient(145deg, rgba(255, 255, 255, 0.04) 0%, rgba(255, 255, 255, 0.01) 100%);
  border: 1px solid var(--tfw-border);
  box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 50px -10px rgba(245, 158, 11, 0.2);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
}

.tfw-book-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 35px 70px -15px rgba(0, 0, 0, 0.9), 0 0 70px -5px rgba(245, 158, 11, 0.3);
}

.tfw-book-card img {
  border-radius: 12px;
  max-width: 100%;
  height: auto;
  filter: drop-shadow(0 15px 25px rgba(0,0,0,0.5));
}

.tfw-price-pill {
  position: absolute;
  bottom: -15px;
  right: 20px;
  background: linear-gradient(135deg, #ff5500 0%, #e63900 100%);
  color: #fff;
  padding: 10px 22px;
  border-radius: 50px;
  font-weight: 800;
  font-size: 1.25rem;
  box-shadow: 0 8px 24px rgba(255, 85, 0, 0.5);
  border: 2px solid #fff;
}

/* Call to Action Button */
.tfw-btn-cta {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 12px;
  background: linear-gradient(135deg, #00963d 0%, #00bb4e 100%);
  color: #ffffff !important;
  font-size: 1.2rem;
  font-weight: 800;
  padding: 18px 36px;
  border-radius: 12px;
  text-decoration: none;
  box-shadow: 0 8px 28px rgba(0, 168, 79, 0.45);
  transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
  letter-spacing: 0.02em;
  text-transform: uppercase;
  border: 1px solid rgba(255, 255, 255, 0.2);
}

.tfw-btn-cta:hover {
  transform: translateY(-3px) scale(1.02);
  background: linear-gradient(135deg, #00aa45 0%, #00d459 100%);
  box-shadow: 0 14px 36px rgba(0, 168, 79, 0.6);
  color: #ffffff !important;
}

.tfw-btn-subtext {
  margin-top: 12px;
  font-size: 0.88rem;
  color: var(--tfw-text-muted);
  display: flex;
  align-items: center;
  gap: 8px;
}

.tfw-btn-subtext svg {
  color: #10b981;
}

/* Social Proof Banner */
.tfw-social-strip {
  background: #0b1019;
  border-top: 1px solid var(--tfw-border);
  border-bottom: 1px solid var(--tfw-border);
  padding: 24px 0;
}

.tfw-social-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 32px 48px;
  font-size: 0.95rem;
  color: #d1d5db;
}

.tfw-social-item {
  display: flex;
  align-items: center;
  gap: 12px;
}

.tfw-social-item .icon {
  font-size: 1.4rem;
}

/* Sections General */
.tfw-section {
  padding: 90px 0;
  position: relative;
}

.tfw-section-alt {
  background: #0a0f18;
}

.tfw-section-heading {
  text-align: center;
  max-width: 800px;
  margin: 0 auto 60px;
}

.tfw-section-heading h2 {
  font-size: clamp(1.8rem, 3vw, 2.6rem);
  margin-bottom: 16px;
}

/* Ceil's Story Box */
.tfw-story-card {
  background: var(--tfw-bg-card);
  border: 1px solid var(--tfw-border);
  border-radius: 20px;
  padding: 48px;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
  position: relative;
  overflow: hidden;
}

.tfw-story-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 6px;
  height: 100%;
  background: linear-gradient(to bottom, var(--tfw-flame-1), var(--tfw-flame-2));
}

.tfw-story-grid {
  display: grid;
  grid-template-columns: 280px 1fr;
  gap: 40px;
  align-items: flex-start;
}

.tfw-author-frame {
  text-align: center;
}

.tfw-author-frame img {
  width: 220px;
  height: 220px;
  border-radius: 50%;
  object-fit: cover;
  border: 4px solid rgba(245, 158, 11, 0.3);
  box-shadow: 0 10px 30px rgba(0,0,0,0.5);
  margin: 0 auto 16px;
}

.tfw-story-text p {
  margin-bottom: 18px;
  font-size: 1.05rem;
  color: #e5e7eb;
}

/* Testimonial Hero (Robert Kiyosaki) */
.tfw-kiyosaki-card {
  background: linear-gradient(135deg, rgba(31, 58, 95, 0.4) 0%, rgba(14, 21, 34, 0.95) 100%);
  border: 1px solid rgba(89, 186, 204, 0.3);
  border-radius: 20px;
  padding: 40px;
  margin: 40px 0 60px;
  display: grid;
  grid-template-columns: 1fr 340px;
  gap: 40px;
  align-items: center;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
}

.tfw-quote-icon {
  font-size: 3rem;
  line-height: 1;
  color: #59bacc;
  opacity: 0.6;
  margin-bottom: 12px;
}

.tfw-quote-text {
  font-size: 1.25rem;
  font-style: italic;
  line-height: 1.7;
  color: #ffffff;
  margin-bottom: 20px;
}

.tfw-quotee-name {
  font-weight: 800;
  font-size: 1.15rem;
  color: #f59e0b;
}

.tfw-quotee-role {
  color: #9ca3af;
  font-size: 0.9rem;
}

.tfw-kiyosaki-card img {
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.15);
  box-shadow: 0 10px 25px rgba(0,0,0,0.6);
}

/* Grid of Success Stories */
.tfw-stories-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
  gap: 24px;
}

.tfw-story-mini {
  background: var(--tfw-bg-card);
  border: 1px solid var(--tfw-border);
  border-radius: 14px;
  padding: 28px;
  transition: transform 0.3s ease, border-color 0.3s ease;
}

.tfw-story-mini:hover {
  transform: translateY(-4px);
  border-color: rgba(245, 158, 11, 0.3);
}

.tfw-story-mini strong {
  color: #ffffff;
  font-size: 1.1rem;
  display: block;
  margin-bottom: 10px;
}

/* The Five Pillars & Features */
.tfw-features-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 24px;
}

.tfw-feature-card {
  background: var(--tfw-bg-card);
  border: 1px solid var(--tfw-border);
  border-radius: 16px;
  padding: 32px;
  display: flex;
  gap: 20px;
  align-items: flex-start;
  transition: all 0.3s ease;
}

.tfw-feature-card:hover {
  border-color: rgba(0, 168, 79, 0.4);
  background: var(--tfw-bg-card-hover);
}

.tfw-feature-icon {
  width: 52px;
  height: 52px;
  flex-shrink: 0;
  background: rgba(0, 168, 79, 0.12);
  border: 1px solid rgba(0, 168, 79, 0.25);
  color: #10b981;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

.tfw-feature-card h4 {
  font-size: 1.15rem;
  margin-bottom: 8px;
  color: #fff;
}

.tfw-feature-card p {
  font-size: 0.95rem;
  color: var(--tfw-text-muted);
  margin: 0;
}

/* Curiosity Bullets (Look Inside) */
.tfw-bullets-list {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 18px;
}

.tfw-bullet-item {
  background: rgba(255, 255, 255, 0.02);
  border: 1px solid var(--tfw-border);
  border-radius: 12px;
  padding: 20px;
  display: flex;
  gap: 14px;
  align-items: flex-start;
}

.tfw-bullet-check {
  color: #f59e0b;
  font-size: 1.25rem;
  line-height: 1;
  flex-shrink: 0;
  margin-top: 2px;
}

.tfw-bullet-item span {
  font-size: 0.96rem;
  color: #e5e7eb;
}

/* Bonuses Section */
.tfw-bonuses-section {
  background: linear-gradient(180deg, #070a10 0%, #101826 50%, #070a10 100%);
  border-top: 1px solid var(--tfw-border);
  border-bottom: 1px solid var(--tfw-border);
}

.tfw-bonus-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  margin-top: 40px;
}

.tfw-bonus-card {
  background: var(--tfw-bg-card);
  border: 1px solid rgba(245, 158, 11, 0.25);
  border-radius: 18px;
  padding: 32px;
  position: relative;
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
}

.tfw-bonus-tag {
  display: inline-block;
  background: rgba(245, 158, 11, 0.15);
  color: var(--tfw-flame-3);
  font-size: 0.78rem;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  padding: 4px 12px;
  border-radius: 6px;
  margin-bottom: 12px;
  border: 1px solid rgba(245, 158, 11, 0.3);
}

.tfw-bonus-value {
  float: right;
  font-weight: 800;
  color: #10b981;
  font-size: 0.95rem;
}

/* Guarantee Box */
.tfw-guarantee-box {
  background: linear-gradient(135deg, rgba(235, 171, 33, 0.08) 0%, rgba(14, 21, 34, 0.95) 100%);
  border: 2px solid rgba(235, 171, 33, 0.4);
  border-radius: 20px;
  padding: 44px;
  max-width: 860px;
  margin: 60px auto 0;
  text-align: center;
  position: relative;
  box-shadow: 0 20px 60px rgba(0,0,0,0.5);
}

.tfw-guarantee-seal {
  font-size: 3.5rem;
  margin-bottom: 16px;
}

/* Authors Section */
.tfw-authors-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 32px;
  margin-top: 40px;
}

.tfw-author-card {
  background: var(--tfw-bg-card);
  border: 1px solid var(--tfw-border);
  border-radius: 16px;
  padding: 32px;
  text-align: center;
}

.tfw-author-card img {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  object-fit: cover;
  margin: 0 auto 18px;
  border: 3px solid rgba(245, 158, 11, 0.3);
}

/* Sticky Bottom Bar */
.tfw-sticky-bar {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  background: rgba(14, 21, 34, 0.96);
  backdrop-filter: blur(12px);
  border-top: 1px solid rgba(255, 255, 255, 0.12);
  padding: 14px 24px;
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: space-between;
  box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.7);
  transform: translateY(100%);
  transition: transform 0.3s ease;
}

.tfw-sticky-bar.visible {
  transform: translateY(0);
}

.tfw-sticky-info {
  display: flex;
  align-items: center;
  gap: 16px;
}

.tfw-sticky-thumb {
  width: 48px;
  height: 56px;
  object-fit: cover;
  border-radius: 6px;
}

/* Language Switcher Button in Header */
.tfw-lang-toggle {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 6px 14px;
  border-radius: 8px;
  background: rgba(255,255,255,0.06);
  border: 1px solid rgba(255,255,255,0.15);
  font-size: 0.85rem;
  color: #fff;
  text-decoration: none;
  transition: all 0.2s ease;
}
.tfw-lang-toggle:hover {
  background: rgba(255,255,255,0.12);
  color: #fff;
}

/* Responsive adjustments */
@media (max-width: 900px) {
  .tfw-hero-grid {
    grid-template-columns: 1fr;
    text-align: center;
  }
  .tfw-btn-subtext {
    justify-content: center;
  }
  .tfw-story-grid {
    grid-template-columns: 1fr;
    text-align: center;
  }
  .tfw-author-frame img {
    margin: 0 auto;
  }
  .tfw-kiyosaki-card {
    grid-template-columns: 1fr;
    text-align: center;
  }
  .tfw-bonus-grid, .tfw-authors-grid {
    grid-template-columns: 1fr;
  }
  .tfw-sticky-info {
    display: none;
  }
  .tfw-sticky-bar {
    justify-content: center;
  }
}
</style>

<div class="tfw-landing">

  <!-- =========================================================================
       HERO SECTION
       ========================================================================= -->
  <section class="tfw-hero">
    <div class="tfw-container">
      
      <!-- Top Bar: Badge & Language Switcher -->
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 12px;">
        <span class="tfw-badge">
          🔥 <?php echo $is_es ? 'LIBRO BESTSELLER · ADVANCED COACHING & LEADERSHIP CENTER' : 'BESTSELLER BOOK · ADVANCED COACHING & LEADERSHIP CENTER'; ?>
        </span>
        <div>
          <?php if ($is_es): ?>
            <a href="<?php echo esc_url($en_page_url); ?>" class="tfw-lang-toggle" title="Switch to English version">
              🇺🇸 Read in English &rarr;
            </a>
          <?php else: ?>
            <a href="<?php echo esc_url($es_page_url); ?>" class="tfw-lang-toggle" title="Ver versión en Español">
              🇲🇽 Leer en Español &rarr;
            </a>
          <?php endif; ?>
        </div>
      </div>

      <div class="tfw-hero-grid">
        <!-- Hero Text -->
        <div>
          <?php if ($is_es): ?>
            <h1 class="tfw-hero-title">
              NO MÁS sentirse <span class="tfw-highlight">estancado, insatisfecho</span> o atrapado en una vida que no es verdaderamente tuya
            </h1>
            <p class="tfw-lead" style="margin-bottom: 30px;">
              Descubre los <strong>Cinco Pilares del Poder</strong> y aprende cómo recuperar tu <strong>Fuerza de Vida</strong> atrapada para vivir y prosperar en la <span class="tfw-green-highlight">Zona Verde</span>.
            </p>
          <?php else: ?>
            <h1 class="tfw-hero-title">
              No More Feeling <span class="tfw-highlight">Stuck, Unfulfilled,</span> or Trapped in a Life That's Not Truly Yours
            </h1>
            <p class="tfw-lead" style="margin-bottom: 30px;">
              Discover the <strong>Five Pillars of Power</strong> and learn how to reclaim your fragmented <strong>Life Force Particles</strong> to thrive in the <span class="tfw-green-highlight">Green Zone</span>.
            </p>
          <?php endif; ?>

          <!-- Buy Button -->
          <div>
            <a href="<?php echo esc_url($cart_url); ?>" class="tfw-btn-cta" target="_blank" rel="noopener">
              <span><?php echo $is_es ? 'Comprar el libro ahora' : 'Get the book now'; ?> (<?php echo esc_html($price_display); ?>)</span>
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            
            <div class="tfw-btn-subtext">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
              <span><?php echo esc_html($price_subtitle); ?></span>
            </div>
            <div class="tfw-btn-subtext" style="margin-top: 6px;">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
              <span><?php echo $is_es ? 'Garantía incondicional de 365 días (1 año completo)' : 'Ironclad 365-day (1 full year) money-back guarantee'; ?></span>
            </div>
          </div>
        </div>

        <!-- Hero Visual Mockup -->
        <div class="tfw-hero-visual">
          <div class="tfw-book-card">
            <img src="<?php echo esc_url($book_cover); ?>" alt="<?php echo $is_es ? 'El Fuego Que Llevas Dentro Libro' : 'The Fire Within Book'; ?>" width="510" height="402">
            <div class="tfw-price-pill">
              <?php echo esc_html($price_display); ?>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       SOCIAL PROOF STRIP
       ========================================================================= -->
  <section class="tfw-social-strip">
    <div class="tfw-container">
      <div class="tfw-social-grid">
        <div class="tfw-social-item">
          <span class="icon">⭐</span>
          <span><strong>Robert Kiyosaki</strong> (Rich Dad Poor Dad) Endorsed</span>
        </div>
        <div class="tfw-social-item">
          <span class="icon">🏆</span>
          <span><strong>Global Woman of the Year</strong> (2022 Award Winner)</span>
        </div>
        <div class="tfw-social-item">
          <span class="icon">⚡</span>
          <span><strong>Thousands Transformed</strong> in Over 25 Countries</span>
        </div>
        <div class="tfw-social-item">
          <span class="icon">🛡️</span>
          <span><strong>365 Days</strong> 100% Satisfaction Guarantee</span>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       CEIL STANFORD'S STORY
       ========================================================================= -->
  <section class="tfw-section">
    <div class="tfw-container">
      <div class="tfw-story-card">
        <div class="tfw-story-grid">
          
          <div class="tfw-author-frame">
            <img src="<?php echo esc_url($ceil_img); ?>" alt="Ceil Stanford">
            <h4 style="margin-bottom: 4px;">Ceil Stanford</h4>
            <div style="font-size: 0.88rem; color: #f59e0b; font-weight: 600;">
              <?php echo $is_es ? 'Presidenta de ACLC' : 'President of ACLC'; ?>
            </div>
            <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 4px;">
              <?php echo $is_es ? 'Ganadora Global Woman of the Year 2022' : 'Global Woman of the Year 2022 Winner'; ?>
            </div>
          </div>

          <div class="tfw-story-text">
            <span class="tfw-badge">
              <?php echo $is_es ? 'DE INSATISFECHA A ABUNDANTE' : 'FROM UNFULFILLED TO ABUNDANT'; ?>
            </span>

            <?php if ($is_es): ?>
              <h2 style="font-size: 2rem; margin-bottom: 20px;">
                «Entiendo exactamente cómo te sientes...»
              </h2>
              <p>
                Al crecer como una niña de rancho humilde y rural en Luisiana, a menudo sentía que estaba en el fondo, luchando con la duda y la inseguridad financiera. Durante años sentí que solo estaba siguiendo la rutina diaria, sin reconocer el potencial que realmente llevaba dentro.
              </p>
              <p>
                Había un anhelo profundo dentro de mí, un deseo de algo más, pero no podía identificarlo con claridad. <strong>Entonces todo cambió.</strong> Descubrí la metodología de Alan C. Walter, y fue como si una luz se encendiera dentro de mí.
              </p>
              <p>
                Por primera vez, entendí la raíz de mis luchas: heridas pasadas, vergüenza y malas decisiones habían creado energía fragmentada y atrapada (Alan llama a esto <em>Partículas de Fuerza de Vida atrapadas</em>).
              </p>
              <p>
                Emprendí un viaje transformador usando las enseñanzas de Alan para reclamar mi poder personal y plenitud mediante los <strong>Cinco Pilares del Poder</strong>. En 2022, fui nominada y recibí el prestigioso premio <strong>Global Woman of the Year</strong>. ¿Yo, la chica de rancho en Luisiana, en un escenario mundial?
              </p>
              <p>
                Hoy soy la presidenta del <strong>Advanced Coaching and Leadership Center</strong>, viviendo con propósito, pasión y abundancia. ¡Y en este libro te entrego la llave exacta para que tú también lo logres!
              </p>
            <?php else: ?>
              <h2 style="font-size: 2rem; margin-bottom: 20px;">
                "I understand exactly how you feel..."
              </h2>
              <p>
                Growing up as a poor, rural farm girl in Louisiana, I often felt like I was at the bottom, struggling with self-doubt and financial insecurity. For years, I felt like I was just going through the motions without realizing my true potential.
              </p>
              <p>
                There was a deep longing inside me, a yearning for something more. <strong>Then, everything changed.</strong> I discovered Alan C. Walter’s methodology, and it was as if a light had been switched on inside me.
              </p>
              <p>
                For the first time, I understood the root of my struggles – past hurts, shame, and poor choices had created fragmented & trapped energy (Alan calls these <em>trapped Life Force Particles</em>).
              </p>
              <p>
                I embarked on a transformative journey using Alan’s teachings to reclaim my personal power through the <strong>Five Pillars of Power</strong>. In 2022, I stood on a global stage as the recipient of the <strong>Global Woman of the Year award</strong>.
              </p>
              <p>
                Now, I’m the proud president of the <strong>Advanced Coaching and Leadership Center</strong>, leading a thriving organization that helps individuals unlock their true potential. In this book, Jeff and I share the exact roadmap to ignite your Inner Fire!
              </p>
            <?php endif; ?>

            <div style="margin-top: 30px;">
              <a href="<?php echo esc_url($cart_url); ?>" class="tfw-btn-cta" target="_blank" rel="noopener" style="font-size: 1rem; padding: 14px 28px;">
                <span><?php echo $is_es ? 'Quiero mi copia por $5 USD' : 'Get my copy for $5 USD'; ?> &rarr;</span>
              </a>
            </div>

          </div>

        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       ROBERT KIYOSAKI & SOCIAL PROOF
       ========================================================================= -->
  <section class="tfw-section tfw-section-alt">
    <div class="tfw-container">
      
      <div class="tfw-section-heading">
        <span class="tfw-badge tfw-badge-green">
          <?php echo $is_es ? 'RESPALDO DE LÍDERES GLOBALES' : 'GLOBAL LEADER ENDORSEMENTS'; ?>
        </span>
        <h2>
          <?php echo $is_es ? 'Este sistema transformador ha funcionado para miles de personas' : 'This Transformational System Has Worked for Thousands'; ?>
        </h2>
        <p class="tfw-lead">
          <?php echo $is_es ? 'Desde autores bestseller hasta empresarios internacionales que transformaron sus vidas.' : 'From world-renowned authors to entrepreneurs who scaled from survival to abundance.'; ?>
        </p>
      </div>

      <!-- Featured Endorsement: Robert Kiyosaki -->
      <div class="tfw-kiyosaki-card">
        <div>
          <div class="tfw-quote-icon">“</div>
          <div class="tfw-quote-text">
            <?php if ($is_es): ?>
              «En un mundo en constante evolución y cada vez más complejo, todos necesitamos personas sumamente preparadas y dedicadas... ‘guías y orientadores’ que posean las habilidades para aclarar nuestro pasado y alumbrar el camino hacia un futuro floreciente.<br><br>
              <strong>Ceil Stanford y Jeff Crippen han sido mis guías durante más de 15 años, y no sé dónde estaría sin ellos.</strong>»
            <?php else: ?>
              "In an ever more complex evolving world, we all need highly-trained, dedicated individuals… ‘guides, way-showers’ who possess the abilities to clarify our past and shine a light to a flourishing future.<br><br>
              <strong>Ceil Stanford and Jeff Crippen have been my guides for 15 years, and I don’t know where I’d be without them.</strong>"
            <?php endif; ?>
          </div>
          <div class="tfw-quotee-name">ROBERT KIYOSAKI</div>
          <div class="tfw-quotee-role"><?php echo $is_es ? 'Autor de «Padre Rico, Padre Pobre»' : 'Author of Rich Dad Poor Dad'; ?></div>
        </div>

        <div>
          <img src="<?php echo esc_url($kiyosaki_img); ?>" alt="Robert Kiyosaki Endorsement for Ceil and Jeff" width="340" height="255">
        </div>
      </div>

      <!-- Kim Kiyosaki Endorsement -->
      <div style="background: var(--tfw-bg-card); border: 1px solid var(--tfw-border); border-radius: 16px; padding: 32px; margin-bottom: 40px;">
        <div class="tfw-quote-icon" style="color: #f59e0b;">“</div>
        <p style="font-size: 1.15rem; font-style: italic; color: #e5e7eb; line-height: 1.7; margin-bottom: 16px;">
          <?php if ($is_es): ?>
            «Algo mágico ha ocurrido aquí. A través de su brillante tecnología, no solo logran que identifiques y descubras la verdad de lo que te está frenando para ser todo lo que puedes ser, sino que su experiencia también te guía para crear el futuro que verdaderamente deseas para ti mismo. Si quieres encender esa chispa para vivir la vida al máximo, Ceil y Jeff pueden mostrarte el camino.»
          <?php else: ?>
            "Something magical has happened here. Through their brilliant technology, not only do they get you to pinpoint and uncover the truth of what is holding you back from being all that you are, but their expertise can then also guide you to create the future that you truly want for yourself. If you want to ignite that spark to live life to its fullest, then Ceil and Jeff can show you the way."
          <?php endif; ?>
        </p>
        <div class="tfw-quotee-name">KIM KIYOSAKI</div>
        <div class="tfw-quotee-role"><?php echo $is_es ? 'Co-fundadora y CEO de The Rich Dad Company' : 'Co-founder and CEO of The Rich Dad Company'; ?></div>
      </div>

      <!-- Additional Client Cases -->
      <div class="tfw-stories-grid">
        <div class="tfw-story-mini">
          <div style="font-size: 1.8rem; margin-bottom: 8px;">📈</div>
          <strong>Ms. Cony</strong>
          <p style="font-size: 0.92rem; color: #9ca3af;">
            <?php echo $is_es 
              ? 'Líder en mercadeo en red. Aplicó los principios de liderazgo de la «Zona Verde» y aumentó la productividad de su equipo en un 366% en 7 años.' 
              : 'Network marketing leader who used Green Zone principles to increase team productivity by 366% over 7 years.'; ?>
          </p>
        </div>

        <div class="tfw-story-mini">
          <div style="font-size: 1.8rem; margin-bottom: 8px;">💎</div>
          <strong>David (Sudáfrica)</strong>
          <p style="font-size: 0.92rem; color: #9ca3af;">
            <?php echo $is_es 
              ? 'Pasó de una mentalidad de escasez a la abundancia: escaló su empresa hasta $9 millones de dólares en ingresos y sanó una lesión de columna considerada irreversible.' 
              : 'Turned scarcity into abundance, grew his business to $9M in revenue, and achieved physical recovery from a spinal injury.'; ?>
          </p>
        </div>

        <div class="tfw-story-mini">
          <div style="font-size: 1.8rem; margin-bottom: 8px;">🏡</div>
          <strong>Artemio (Texas)</strong>
          <p style="font-size: 0.92rem; color: #9ca3af;">
            <?php echo $is_es 
              ? 'Pasó de luchar con deudas a duplicar sus ingresos, salvar su matrimonio y vivir 100% libre de deudas con su familia.' 
              : 'Went from drowning in debt to doubling his income, saving his marriage, and living completely debt-free.'; ?>
          </p>
        </div>

        <div class="tfw-story-mini">
          <div style="font-size: 1.8rem; margin-bottom: 8px;">🎯</div>
          <strong>Tom</strong>
          <p style="font-size: 0.92rem; color: #9ca3af;">
            <?php echo $is_es 
              ? 'Empresario consolidado que reencontró la pasión, claridad y el propósito en su trabajo diario.' 
              : 'Successful businessman who reignited passion, clarity, and deep personal fulfillment in his career.'; ?>
          </p>
        </div>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       WHAT THE BOOK EMPOWERS YOU TO DO
       ========================================================================= -->
  <section class="tfw-section">
    <div class="tfw-container">
      
      <div class="tfw-section-heading">
        <span class="tfw-badge">
          <?php echo $is_es ? 'TU HOJA DE RUTA' : 'YOUR ROADMAP'; ?>
        </span>
        <h2>
          <?php echo $is_es 
            ? '«El Fuego Que Llevas Dentro» es una guía práctica paso a paso para:' 
            : '"The Fire Within" is a practical, step-by-step blueprint to:'; ?>
        </h2>
      </div>

      <div class="tfw-features-grid">
        <div class="tfw-feature-card">
          <div class="tfw-feature-icon">🔓</div>
          <div>
            <h4><?php echo $is_es ? 'Romper con la Duda' : 'Break Free from Self-Doubt'; ?></h4>
            <p><?php echo $is_es ? 'Vuelve a confiar plenamente en ti mismo para tomar decisiones audaces y firmes hacia tus metas.' : 'Start trusting yourself again so you can take confident action toward your biggest goals.'; ?></p>
          </div>
        </div>

        <div class="tfw-feature-card">
          <div class="tfw-feature-icon">🔥</div>
          <div>
            <h4><?php echo $is_es ? 'Encontrar tu Propósito' : 'Find Your True Purpose'; ?></h4>
            <p><?php echo $is_es ? 'Enciende tu pasión interior y despierta entusiasmado cada día sabiendo con exactitud hacia dónde vas.' : 'Ignite your passion and wake up excited every morning because you know what you are building.'; ?></p>
          </div>
        </div>

        <div class="tfw-feature-card">
          <div class="tfw-feature-icon">🤝</div>
          <div>
            <h4><?php echo $is_es ? 'Relaciones Profundas' : 'Build Deeper Relationships'; ?></h4>
            <p><?php echo $is_es ? 'Conecta con las personas de una manera donde te sientas verdaderamente comprendido, valorado y respaldado.' : 'Connect with people in a way that makes you feel genuinely understood, supported, and loved.'; ?></p>
          </div>
        </div>

        <div class="tfw-feature-card">
          <div class="tfw-feature-icon">💰</div>
          <div>
            <h4><?php echo $is_es ? 'Éxito Financiero Duradero' : 'Lasting Financial Success'; ?></h4>
            <p><?php echo $is_es ? 'Alcanza tus metas económicas mientras disfrutas de una profunda paz mental y plenitud personal.' : 'Achieve your financial and career milestones while feeling at peace and fulfilled in your personal life.'; ?></p>
          </div>
        </div>

        <div class="tfw-feature-card">
          <div class="tfw-feature-icon">🌱</div>
          <div>
            <h4><?php echo $is_es ? 'Prosperar en la Zona Verde' : 'Thrive in the Green Zone'; ?></h4>
            <p><?php echo $is_es ? 'Sal del modo de supervivencia (Zonas Roja y Amarilla) y accede al estado donde todo fluye con facilidad y alegría.' : 'Escape survival mode and enter the state where you are thriving, joyful, and operating at peak energy.'; ?></p>
          </div>
        </div>

        <div class="tfw-feature-card">
          <div class="tfw-feature-icon">⚡</div>
          <div>
            <h4><?php echo $is_es ? 'Procesos Prácticos en Tiempo Real' : 'Real-Time Practical Drills'; ?></h4>
            <p><?php echo $is_es ? 'Ejercicios guiados paso a paso que puedes aplicar desde hoy mismo para experimentar transformaciones inmediatas.' : 'Specific step-by-step exercises you can execute immediately to release trapped energy.'; ?></p>
          </div>
        </div>
      </div>

      <div style="text-align: center; margin-top: 50px;">
        <a href="<?php echo esc_url($cart_url); ?>" class="tfw-btn-cta" target="_blank" rel="noopener">
          <span><?php echo $is_es ? 'Obtener el libro por solo $5 USD' : 'Get the book for only $5 USD'; ?></span>
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       CHAPTER SECRETS / LOOK INSIDE
       ========================================================================= -->
  <section class="tfw-section tfw-section-alt">
    <div class="tfw-container">
      
      <div class="tfw-section-heading">
        <span class="tfw-badge">
          <?php echo $is_es ? 'UN VISTAZO AL INTERIOR' : 'LOOK INSIDE THE BOOK'; ?>
        </span>
        <h2>
          <?php echo $is_es ? 'Algunos de los secretos que descubrirás en sus páginas:' : 'A Few of the Secrets Revealed Inside:'; ?>
        </h2>
        <p class="tfw-lead">
          <?php echo $is_es ? 'Revelaciones prácticas que cambiarán la forma en que ves tu vida y tus decisiones.' : 'Direct insights and frameworks you can put to work the very moment you open the book.'; ?>
        </p>
      </div>

      <div class="tfw-bullets-list">
        
        <?php if ($is_es): ?>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Página 23:</strong> Descubre una forma poco conocida de mejorar exponencialmente tu claridad mental en cuestión de minutos.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Capítulo 3.2 (Pág. 59):</strong> Un truco sumamente efectivo para cambiar instantáneamente tu estado mental hacia una actitud positiva imparable.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Capítulo 5 (Pág. 89):</strong> <em>ADVERTENCIA:</em> Los 3 errores más comunes en desarrollo personal que frenan tu progreso y qué hacer en su lugar.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Los Pilares del Poder (Pág. 115):</strong> 5 formas sorprendentemente sencillas de construir una base sólida de poder personal en tu vida.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Pilar 1: Presencia (Pág. 119):</strong> Los secretos de autoempoderamiento que sorprenderán a quienes creían que necesitaban un coach para transformarse.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Capítulo 7.4 (Pág. 149):</strong> El secreto para aprovechar tus relaciones actuales y crear lazos indestructibles de apoyo mutuo.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Prólogo (Pág. 1):</strong> Lo que la milagrosa historia de un Buda de oro puede enseñarte sobre la paz interior y tu verdadero valor.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Capítulo 8:</strong> La manera rápida y directa de conseguir que tus necesidades y deseos sean satisfechos sin desgastarte.</span>
          </div>
        <?php else: ?>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Page 23:</strong> Discover a little-known technique to dramatically enhance your mental clarity and focus.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Chapter 3.2 (Page 59):</strong> A sneaky trick you can use immediately to shift your mindset into unstoppable positivity.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Chapter 5 (Page 89):</strong> <em>WARNING:</em> The 3 common personal development mistakes that sabotage progress and what to do instead.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Pillars of Power (Page 115):</strong> 5 surprisingly easy ways to construct an unbreakable foundation of personal power.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Pillar 1: Presence (Page 119):</strong> Self-empowerment secrets that will shock anyone who thought they needed a coach to transform.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Chapter 7.4 (Page 149):</strong> The stunning relationship-building secret to create strong, supportive bonds effortlessly.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Foreword (Page 1):</strong> What the miraculous story of a solid golden Buddha teaches you about your hidden worth and inner peace.</span>
          </div>
          <div class="tfw-bullet-item">
            <span class="tfw-bullet-check">✦</span>
            <span><strong>Chapter 8:</strong> The quick and reliable formula to get your deepest needs and wants met without friction.</span>
          </div>
        <?php endif; ?>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       4 FREE BONUSES ($197 VALUE)
       ========================================================================= -->
  <section class="tfw-section tfw-bonuses-section">
    <div class="tfw-container">
      
      <div class="tfw-section-heading">
        <span class="tfw-badge" style="background: rgba(16, 185, 129, 0.15); color: #34d399; border-color: rgba(16, 185, 129, 0.3);">
          🎁 <?php echo $is_es ? 'VALOR TOTAL $197 USD — HOY 100% GRATIS' : 'TOTAL VALUE $197 USD — 100% FREE TODAY'; ?>
        </span>
        <h2>
          <?php echo $is_es 
            ? 'Adquiere tu copia hoy y recibe estos 4 Bonos Exclusivos Gratis' 
            : 'Order Today & Receive These 4 Transformative Bonuses for Free'; ?>
        </h2>
        <p class="tfw-lead">
          <?php echo $is_es 
            ? 'Diseñados especialmente para poner en práctica las enseñanzas del libro y acelerar tus resultados.' 
            : 'Created specifically to help you execute the teachings in real life and lock in your breakthroughs.'; ?>
        </p>
      </div>

      <!-- Bonuses Mockup Image -->
      <div style="text-align: center; margin-bottom: 40px;">
        <img src="<?php echo esc_url($bonuses_img); ?>" alt="The Fire Within Bonuses Bundle" style="max-width: 820px; width: 100%; border-radius: 16px; margin: 0 auto; box-shadow: 0 20px 50px rgba(0,0,0,0.6);" width="1024" height="683">
      </div>

      <div class="tfw-bonus-grid">
        
        <!-- Bonus 1 -->
        <div class="tfw-bonus-card">
          <span class="tfw-bonus-tag">BONUS #1</span>
          <span class="tfw-bonus-value"><?php echo $is_es ? 'Valor: $47 USD' : 'Value: $47 USD'; ?></span>
          <h3 style="font-size: 1.3rem; margin-bottom: 12px; color: #fff;">
            <?php echo $is_es ? 'Cuaderno de Trabajo «El Fuego Que Llevas Dentro»' : 'The Fire Within Workbook'; ?>
          </h3>
          <p style="color: #d1d5db; font-size: 0.95rem;">
            <?php echo $is_es 
              ? 'Lleva el libro a la práctica con ejercicios clave como el Proceso de Presencia, el Proceso de Amabilidad y el Proceso de Pizarrón Limpio (Clean Slate) para liberar partículas de fuerza de vida.' 
              : 'Bring the book to life with exercises like the Presence Process, Friendliness Process, and Clean Slate Process to release trapped life force and elevate your state.'; ?>
          </p>
        </div>

        <!-- Bonus 2 -->
        <div class="tfw-bonus-card">
          <span class="tfw-bonus-tag">BONUS #2</span>
          <span class="tfw-bonus-value"><?php echo $is_es ? 'Valor: $47 USD' : 'Value: $47 USD'; ?></span>
          <h3 style="font-size: 1.3rem; margin-bottom: 12px; color: #fff;">
            <?php echo $is_es ? 'Reto de Gratitud de 30 Días' : 'Thirty-Day Gratitude Challenge'; ?>
          </h3>
          <p style="color: #d1d5db; font-size: 0.95rem;">
            <?php echo $is_es 
              ? 'Un viaje diario guiado con rutinas matutinas y nocturnas, alineación semanal y ejercicios rotativos para transformar tu estado anímico, relaciones y bienestar general.' 
              : 'A guided journey featuring morning and evening gratitude drills, rotating processes, and weekly alignment checks to shift your mood and expand fulfillment.'; ?>
          </p>
        </div>

        <!-- Bonus 3 -->
        <div class="tfw-bonus-card">
          <span class="tfw-bonus-tag">BONUS #3</span>
          <span class="tfw-bonus-value"><?php echo $is_es ? 'Valor: $57 USD' : 'Value: $57 USD'; ?></span>
          <h3 style="font-size: 1.3rem; margin-bottom: 12px; color: #fff;">
            <?php echo $is_es ? 'Entrenamiento de Optimización de Mentalidad' : 'Mindset Optimization Training'; ?>
          </h3>
          <p style="color: #d1d5db; font-size: 0.95rem;">
            <?php echo $is_es 
              ? 'Aprende a disolver creencias limitantes, preceptos heredados y bloqueos mentales subconscientes para operar desde tu verdadero potencial ilimitado.' 
              : 'Step-by-step training to remove limiting precepts, negative conditioning, and mental barriers holding you back from extraordinary achievement.'; ?>
          </p>
        </div>

        <!-- Bonus 4 -->
        <div class="tfw-bonus-card">
          <span class="tfw-bonus-tag">BONUS #4</span>
          <span class="tfw-bonus-value"><?php echo $is_es ? 'Valor: $47 USD' : 'Value: $47 USD'; ?></span>
          <h3 style="font-size: 1.3rem; margin-bottom: 12px; color: #fff;">
            <?php echo $is_es ? 'Entrenamiento para Mejorar tu Autoestima' : 'Self-Worth Improvement Training'; ?>
          </h3>
          <p style="color: #d1d5db; font-size: 0.95rem;">
            <?php echo $is_es 
              ? 'Aplica el Proceso de Apreciación para redefinir tu valor propio, sanar resentimientos del pasado y restaurar el amor propio y la confianza personal.' 
              : 'Master the Appreciation Process to redefine your self-worth, resolve long-held resentments, and cultivate genuine confidence and inner strength.'; ?>
          </p>
        </div>

      </div>

      <!-- Guarantee Box Inside Bonuses Section -->
      <div class="tfw-guarantee-box">
        <div class="tfw-guarantee-seal">🛡️</div>
        <h3 style="font-size: 1.8rem; margin-bottom: 14px; color: #f59e0b;">
          <?php echo $is_es ? 'Garantía Incondicional de 365 Días' : '365-Day 100% Money-Back Guarantee'; ?>
        </h3>
        <p style="font-size: 1.05rem; color: #e5e7eb; max-width: 680px; margin: 0 auto 24px;">
          <?php if ($is_es): ?>
            Prueba «El Fuego Que Llevas Dentro» y los 4 bonos durante <strong>un año completo</strong>. Si por cualquier motivo sientes que no transformó tu perspectiva o no cumplió tus expectativas, te reembolsamos el 100% de tu dinero ($5 USD). Sin preguntas ni complicaciones.
          <?php else: ?>
            Try "The Fire Within" and all 4 bonuses for a <strong>full 365 days</strong>. If for any reason you don’t feel it was worth tenfold your investment, simply email us and we will promptly refund your $5 in full. Zero hassle, zero risk.
          <?php endif; ?>
        </p>

        <a href="<?php echo esc_url($cart_url); ?>" class="tfw-btn-cta" target="_blank" rel="noopener">
          <span><?php echo $is_es ? 'Adquirir el libro y los 4 bonos por $5 USD' : 'Get the book & all 4 bonuses for $5 USD'; ?></span>
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       ABOUT THE AUTHORS
       ========================================================================= -->
  <section class="tfw-section">
    <div class="tfw-container">
      
      <div class="tfw-section-heading">
        <span class="tfw-badge">
          <?php echo $is_es ? 'SOBRE LOS AUTORES' : 'ABOUT THE AUTHORS'; ?>
        </span>
        <h2>
          Ceil Stanford &amp; Dr. Jeff Crippen
        </h2>
        <p class="tfw-lead">
          <?php echo $is_es 
            ? 'Líderes de Advanced Coaching & Leadership Center apasionados por desbloquear el potencial humano.' 
            : 'Passionate mentors and leaders dedicated to empowering individuals worldwide.'; ?>
        </p>
      </div>

      <!-- Authors Picture -->
      <div style="text-align: center; margin-bottom: 30px;">
        <img src="<?php echo esc_url($ceil_jeff_img); ?>" alt="Ceil Stanford and Dr. Jeff Crippen" style="max-width: 600px; width: 100%; border-radius: 16px; margin: 0 auto; box-shadow: 0 15px 40px rgba(0,0,0,0.5);">
      </div>

      <div class="tfw-authors-grid">
        
        <div class="tfw-author-card">
          <img src="<?php echo esc_url($ceil_img); ?>" alt="Ceil Stanford">
          <h3 style="margin-bottom: 6px;">Ceil Stanford</h3>
          <div style="color: #f59e0b; font-weight: 700; font-size: 0.95rem; margin-bottom: 14px;">
            <?php echo $is_es ? 'Presidenta de ACLC · Galardonada Global Woman of the Year' : 'President of ACLC · Global Woman of the Year'; ?>
          </div>
          <p style="color: #9ca3af; font-size: 0.95rem; text-align: left;">
            <?php echo $is_es 
              ? 'Empresaria exitosa cuyo viaje personal desde una infancia con limitaciones en Luisiana hasta liderar una firma internacional ejemplifica el poder transformador de esta metodología. Lleva más de dos décadas capacitando a líderes y emprendedores.' 
              : 'A successful entrepreneur whose personal journey from humble beginnings to international leadership exemplifies the power of these teachings. Ceil has guided thousands of high-performers for over two decades.'; ?>
          </p>
        </div>

        <div class="tfw-author-card">
          <div style="width: 140px; height: 140px; border-radius: 50%; background: #1e293b; border: 3px solid rgba(245,158,11,0.3); margin: 0 auto 18px; display: flex; align-items: center; justify-content: center; font-size: 3rem;">
            👨‍⚕️
          </div>
          <h3 style="margin-bottom: 6px;">Dr. Jeff Crippen</h3>
          <div style="color: #f59e0b; font-weight: 700; font-size: 0.95rem; margin-bottom: 14px;">
            <?php echo $is_es ? 'CEO de ACLC · Doctor en Quiropráctica' : 'CEO of ACLC · Doctor of Chiropractic'; ?>
          </div>
          <p style="color: #9ca3af; font-size: 0.95rem; text-align: left;">
            <?php echo $is_es 
              ? 'CEO de ACLC y Doctor en Quiropráctica, Jeff aporta una visión holística fundamental al desarrollo personal, enfatizando la conexión indisoluble entre cuerpo, mente y espíritu para sostener la energía vital en la Zona Verde.' 
              : 'CEO of ACLC and Doctor of Chiropractic, Jeff brings an essential holistic perspective to personal transformation, emphasizing the connection between mind, body, and spirit to sustain Green Zone vitality.'; ?>
          </p>
        </div>

      </div>

    </div>
  </section>

  <!-- =========================================================================
       FINAL CALL TO ACTION & RECAP (P.S.)
       ========================================================================= -->
  <section class="tfw-section tfw-section-alt" style="text-align: center; border-top: 1px solid var(--tfw-border);">
    <div class="tfw-container" style="max-width: 820px;">
      
      <h2 style="font-size: clamp(2rem, 3.5vw, 2.8rem); margin-bottom: 20px;">
        <?php echo $is_es ? 'Enciende el Fuego que Llevas Dentro Hoy' : 'Ignite The Fire Within You Today'; ?>
      </h2>
      
      <p class="tfw-lead" style="margin-bottom: 30px;">
        <?php echo $is_es 
          ? 'Por solo $5 USD obtienes el libro completo, los 4 entrenamientos y bonos de regalo ($197 de valor) y 365 días de garantía incondicional.' 
          : 'For just $5 USD you receive the full book, all 4 exclusive bonus trainings ($197 value), and our 365-day 100% money-back guarantee.'; ?>
      </p>

      <a href="<?php echo esc_url($cart_url); ?>" class="tfw-btn-cta" target="_blank" rel="noopener" style="font-size: 1.3rem; padding: 20px 48px;">
        <span><?php echo $is_es ? 'Comprar mi copia ahora ($5 USD)' : 'Get my copy now ($5 USD)'; ?> &rarr;</span>
      </a>

      <!-- P.S. Box -->
      <div style="margin-top: 48px; text-align: left; background: var(--tfw-bg-card); border: 1px solid var(--tfw-border); border-radius: 14px; padding: 28px;">
        <h4 style="color: #f59e0b; margin-bottom: 12px;">
          <?php echo $is_es ? 'P.D. Para quienes leyeron rápido esta página:' : 'P.S. For those who skimmed this page:'; ?>
        </h4>
        <p style="font-size: 0.95rem; color: #d1d5db; margin-bottom: 10px;">
          <?php echo $is_es 
            ? '• Aprenderás los Cinco Pilares del Poder y las herramientas para liberarte de la duda y prosperar en la Zona Verde.' 
            : '• You will learn the Five Pillars of Power and the exact processes to break free from self-doubt and thrive in the Green Zone.'; ?>
        </p>
        <p style="font-size: 0.95rem; color: #d1d5db; margin-bottom: 10px;">
          <?php echo $is_es 
            ? '• Incluye 4 bonos de regalo (Cuaderno de Trabajo, Reto de Gratitud de 30 Días, Entrenamiento de Mentalidad y Taller de Autoestima).' 
            : '• Includes 4 free bonuses (The Workbook, 30-Day Gratitude Challenge, Mindset Training, and Self-Worth Workshop).'; ?>
        </p>
        <p style="font-size: 0.95rem; color: #d1d5db; margin: 0;">
          <?php echo $is_es 
            ? '• Tienes 1 año completo (365 días) de garantía. Si no te encanta, te reembolsamos los $5 USD de inmediato.' 
            : '• You have a full 365-day money-back guarantee. If you don’t love it, we will immediately refund your $5.'; ?>
        </p>
      </div>

    </div>
  </section>

  <!-- =========================================================================
       STICKY FLOATING BOTTOM BAR
       ========================================================================= -->
  <div class="tfw-sticky-bar" id="tfwStickyBar">
    <div class="tfw-sticky-info">
      <img src="<?php echo esc_url($book_cover); ?>" alt="Book Thumbnail" class="tfw-sticky-thumb">
      <div>
        <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">
          <?php echo $is_es ? 'El Fuego Que Llevas Dentro' : 'The Fire Within'; ?>
        </div>
        <div style="font-size: 0.82rem; color: #10b981; font-weight: 600;">
          <?php echo esc_html($price_display); ?> · <?php echo $is_es ? 'Libro + 4 Bonos' : 'Book + 4 Bonuses'; ?>
        </div>
      </div>
    </div>

    <div>
      <a href="<?php echo esc_url($cart_url); ?>" class="tfw-btn-cta" target="_blank" rel="noopener" style="padding: 12px 24px; font-size: 1rem;">
        <span><?php echo $is_es ? 'Comprar por $5 USD' : 'Get The Book ($5)'; ?></span>
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>
  </div>

</div>

<script>
// Show sticky purchase bar after scrolling 350px
document.addEventListener('DOMContentLoaded', function() {
  var bar = document.getElementById('tfwStickyBar');
  if (!bar) return;
  
  window.addEventListener('scroll', function() {
    if (window.scrollY > 350) {
      bar.classList.add('visible');
    } else {
      bar.classList.remove('visible');
    }
  }, { passive: true });
});
</script>

<?php
get_footer();
