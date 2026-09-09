<?php
/**
 * Block Name: Assessment Quiz
 * Class: block-assessment-quiz
 */

$blockClasses = ['block-assessment-quiz', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('quiz_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'quiz';

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

$introKicker = get_field('intro_kicker') ?: __('Free · two minutes', 'codebymonk');
$introTitle = get_field('intro_title') ?: __('Twenty questions', 'codebymonk');
$introDesc = get_field('intro_desc') ?: __('No right answers. Nobody else sees this. We ask for your email at the end, not now.', 'codebymonk');
$btnText = get_field('start_button_text') ?: __('Start', 'codebymonk');
?>

<section id="<?= esc_attr($blockID); ?>" data-block="assessment-quiz" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap qwrap">
    
    <!-- Screen 1: Intro -->
    <div id="quizIntro" class="quiz-screen">
      <div class="kicker" style="color:var(--shgreen)"><?= esc_html($introKicker); ?></div>
      <h1 class="mt16"><?= esc_html($introTitle); ?></h1>
      <p class="lede mt16"><?= esc_html($introDesc); ?></p>
      <button type="button" class="btn btn-go btn-block mt32" id="startQuiz"><?= esc_html($btnText); ?></button>
    </div>

    <!-- Screen 2: Running Quiz (20 Questions) -->
    <div id="quizRun" class="quiz-screen" hidden>
      <div class="hgroup" style="justify-content:space-between">
        <span class="tiny" id="qArea">Area</span>
        <span class="tiny" id="qCount">1 / 20</span>
      </div>
      <div class="progress" id="qBar"></div>
      <h2 id="qText" class="mt16" style="min-height:74px"></h2>
      <div class="stack mt24" id="qOpts"></div>
      <div class="hgroup mt32" style="justify-content:space-between;align-items:center;">
        <button type="button" class="btn btn-ghost btn-sm" id="qBack"><?= esc_html__('Back', 'codebymonk'); ?></button>
        <span class="tiny text-muted"><?= esc_html__('Answers saved automatically', 'codebymonk'); ?></span>
      </div>
    </div>

    <!-- Screen 3: Email Gate -->
    <div id="quizGate" class="quiz-screen" hidden>
      <div class="kicker" style="color:var(--shgreen)"><?= esc_html__('Almost there', 'codebymonk'); ?></div>
      <h1 class="mt16"><?= esc_html__('Where should we send your result?', 'codebymonk'); ?></h1>
      <p class="lede mt16"><?= esc_html__('You will see it on the next screen too. The email is so you can come back to it.', 'codebymonk'); ?></p>
      
      <div class="card pad-lg mt32">
        <div class="field">
          <label for="gName"><?= esc_html__('First name', 'codebymonk'); ?></label>
          <input class="input" id="gName" placeholder="Jane" required>
        </div>
        <div class="field">
          <label for="gMail"><?= esc_html__('Email', 'codebymonk'); ?></label>
          <input class="input" type="email" id="gMail" placeholder="jane@example.com" required>
        </div>
        <label class="xs" style="display:flex;gap:9px;align-items:flex-start;margin-top:16px;">
          <input type="checkbox" id="gOk" style="margin-top:3px" checked> 
          <?= esc_html__('I agree to the Privacy Policy and to receiving my result by email.', 'codebymonk'); ?>
        </label>
        <div id="quizGateError" class="xs mt8" style="color:var(--red);display:none;"></div>
        <button type="button" class="btn btn-go btn-block mt24" id="gGo"><?= esc_html__('See my Zone', 'codebymonk'); ?></button>
      </div>
    </div>

    <!-- Screen 4: Result -->
    <div id="quizResult" class="quiz-screen" hidden>
      <div class="split top result-grid">
        <!-- Left Column: Result & Breakdown -->
        <div class="result-main">
          <div class="kicker" style="color:var(--shgreen)"><?= esc_html__('Your result', 'codebymonk'); ?></div>
          <h1 class="mt16" id="rZone"></h1>
          
          <div class="mt24" id="rBar"></div>
          <div class="zlabels">
            <span class="tiny">Red</span>
            <span class="tiny" id="rHere"></span>
            <span class="tiny">Green</span>
            <span class="tiny">Golden</span>
          </div>

          <p class="lede mt24" id="rBody"></p>
          
          <hr class="rule mt32 mb32">

          <div class="tiny mb16" style="font-weight:600;"><?= esc_html__('By area', 'codebymonk'); ?></div>
          <div id="rAreas" class="areas-breakdown mb32"></div>

          <button type="button" class="btn btn-ghost btn-sm" id="retake"><?= esc_html__('Retake the profile', 'codebymonk'); ?></button>
        </div>

        <!-- Right Column: Exits / Next Steps -->
        <div class="result-sidebar">
          <div class="card pad-lg tint" style="border-color:#D6EDE0">
            <div class="kicker"><?= esc_html__('Next step', 'codebymonk'); ?></div>
            <h3 class="mt8"><?= esc_html__('You know where you are.', 'codebymonk'); ?><br><?= esc_html__('This is how you get out.', 'codebymonk'); ?></h3>
            <p class="sm mt16"><?= esc_html__('The full report breaks down all twenty answers and builds the route: what to move first, with what, and in what order.', 'codebymonk'); ?></p>
            <div class="hgroup mt24" style="justify-content:space-between;align-items:center;">
              <span class="tiny"><?= esc_html__('Full report', 'codebymonk'); ?></span>
              <span class="pending"><?= esc_html__('price TBD', 'codebymonk'); ?></span>
            </div>
            <button type="button" class="btn btn-go btn-block mt16"><?= esc_html__('Get the full report', 'codebymonk'); ?></button>
            <div class="tiny center mt16 text-muted"><?= esc_html__('Money-back guarantee', 'codebymonk'); ?></div>
          </div>

          <a class="card card-link mt20" href="<?= esc_url(home_url('/cohorts/')); ?>" style="display:block">
            <div class="tiny text-muted"><?= esc_html__('Or do it with a group', 'codebymonk'); ?></div>
            <h4 class="mt8"><?= esc_html__('Autumn cohort', 'codebymonk'); ?></h4>
            <div class="tiny mt8" style="color:var(--fuego)"><?= esc_html__('Starts 14 October', 'codebymonk'); ?></div>
          </a>

          <div class="card mt20">
            <div class="tiny mb8"><?= esc_html__('Or with a coach, at your own pace', 'codebymonk'); ?></div>
            <p class="xs text-muted"><?= esc_html__('Vital Fundamentals and one-to-one coaching are delivered by ACLC at Letoli Ranch.', 'codebymonk'); ?></p>
            <a class="btn btn-ghost btn-sm btn-block mt16" href="<?= esc_url(home_url('/#contact')); ?>">
              <?= esc_html__('Talk to a coach', 'codebymonk'); ?>
            </a>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
