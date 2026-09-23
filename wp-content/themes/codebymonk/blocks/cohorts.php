<?php
/**
 * Block Name: Cohorts
 * Class: block-cohorts
 */

$blockClasses = ['block-cohorts', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('events_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'events';

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Fields
$source = get_field('cohorts_source') ?: 'latest';
$selectedCohorts = get_field('selected_cohorts');
$showSteps = get_field('show_steps');
if ($showSteps === null || $showSteps === '') {
    $showSteps = true;
}

$step1Title = get_field('step_1_title') ?: __('Step one', 'codebymonk');
$step1Strong = get_field('step_1_strong') ?: __('Take the profile.', 'codebymonk');
$step1Desc = get_field('step_1_desc') ?: __('The event starts already knowing which Zone you are in.', 'codebymonk');

$step2Title = get_field('step_2_title') ?: __('Step two', 'codebymonk');
$step2Strong = get_field('step_2_strong') ?: __('Check fit in three steps.', 'codebymonk');
$step2Desc = get_field('step_2_desc') ?: __('Two minutes, to see whether this event is the right one.', 'codebymonk');

$step3Title = get_field('step_3_title') ?: __('Step three', 'codebymonk');
$step3Strong = get_field('step_3_strong') ?: __('A short call.', 'codebymonk');
$step3Desc = get_field('step_3_desc') ?: __('Fit is confirmed and your place is held.', 'codebymonk');

$cohortsList = [];

if ($source === 'custom' && !empty($selectedCohorts)) {
    foreach ($selectedCohorts as $cohortPost) {
        $postID = is_object($cohortPost) ? $cohortPost->ID : $cohortPost;
        $title = get_the_title($postID);
        $month = get_field('month', $postID) ?: 'OCT';
        $day = get_field('day', $postID) ?: '14';
        $startDateFull = get_field('start_date_full', $postID) ?: ($day . ' ' . $month);
        $details = get_field('details', $postID) ?: '';
        $status = get_field('status', $postID) ?: 'open';
        $badgeText = get_field('badge_text', $postID);
        $highlight = get_field('highlight', $postID);
        $btnText = get_field('button_text', $postID);

        $cohortsList[] = [
            'id'              => $postID,
            'title'           => $title,
            'month'           => $month,
            'day'             => $day,
            'start_date_full' => $startDateFull,
            'details'         => $details,
            'status'          => $status,
            'badge_text'      => $badgeText,
            'highlight'       => $highlight,
            'button_text'     => $btnText,
        ];
    }
} else {
    // Query all published cohorts ordered by menu_order
    $query = new WP_Query([
        'post_type'        => 'cohort',
        'posts_per_page'   => -1,
        'post_status'      => 'publish',
        'orderby'          => [
            'menu_order' => 'ASC',
            'date'       => 'ASC',
        ],
        'suppress_filters' => false,
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postID = get_the_ID();
            $title = get_the_title();
            $month = get_field('month', $postID) ?: 'OCT';
            $day = get_field('day', $postID) ?: '14';
            $startDateFull = get_field('start_date_full', $postID) ?: ($day . ' ' . $month);
            $details = get_field('details', $postID) ?: '';
            $status = get_field('status', $postID) ?: 'open';
            $badgeText = get_field('badge_text', $postID);
            $highlight = get_field('highlight', $postID);
            $btnText = get_field('button_text', $postID);

            $cohortsList[] = [
                'id'              => $postID,
                'title'           => $title,
                'month'           => $month,
                'day'             => $day,
                'start_date_full' => $startDateFull,
                'details'         => $details,
                'status'          => $status,
                'badge_text'      => $badgeText,
                'highlight'       => $highlight,
                'button_text'     => $btnText,
            ];
        }
        wp_reset_postdata();
    }
}

// Fallback if no cohorts created yet
if (empty($cohortsList)) {
    $cohortsList = [
        [
            'id'              => 0,
            'title'           => 'Autumn event',
            'month'           => 'OCT',
            'day'             => '14',
            'start_date_full' => '14 October',
            'details'         => 'Eight weeks · online · maximum 12 people',
            'status'          => 'open',
            'badge_text'      => 'price TBD',
            'highlight'       => true,
            'button_text'     => 'Check fit',
        ],
        [
            'id'              => 0,
            'title'           => 'Winter event',
            'month'           => 'JAN',
            'day'             => '20',
            'start_date_full' => '20 January',
            'details'         => 'Eight weeks · online',
            'status'          => 'waitlist',
            'badge_text'      => 'Waiting list',
            'highlight'       => false,
            'button_text'     => 'Notify me',
        ],
    ];
}
?>

<section id="<?= esc_attr($blockID); ?>" data-block="events" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div id="cohorts" style="position:relative; top:-90px; visibility:hidden;"></div>
  <div class="wrap">
    
    <!-- Events Schedule List -->
    <div class="rowbox mb32">
      <?php foreach ($cohortsList as $cohort): 
        $isOpen = ($cohort['status'] === 'open');
        $rowClass = 'row cohort-row';
        if (!empty($cohort['highlight'])) {
            $rowClass .= ' highlight';
        }
      ?>
        <div class="<?= esc_attr($rowClass); ?>">
          <div class="datebox">
            <div class="tiny month-label"><?= esc_html($cohort['month']); ?></div>
            <div class="d" style="color:<?= $isOpen ? 'var(--shgreen)' : 'var(--muted)'; ?>">
              <?= esc_html($cohort['day']); ?>
            </div>
          </div>
          
          <div class="grow">
            <div class="cohort-title"><?= esc_html($cohort['title']); ?></div>
            <div class="xs cohort-details"><?= esc_html($cohort['details']); ?></div>
          </div>

          <div class="cohort-actions">
            <?php if (!empty($cohort['badge_text'])): 
              $badge = $cohort['badge_text'];
              $isPending = (stripos($badge, 'tbd') !== false || stripos($badge, 'pending') !== false);
            ?>
              <?php if ($isOpen): ?>
                <?php if ($isPending): ?>
                  <span class="pending"><?= esc_html($badge); ?></span>
                <?php else: ?>
                  <span class="price-tag"><?= esc_html($badge); ?></span>
                <?php endif; ?>
              <?php else: ?>
                <span class="tiny waitlist-label"><?= esc_html($badge); ?></span>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($isOpen): ?>
              <button type="button" class="btn btn-go btn-sm js-trigger-cohort-quiz"
                data-cohort-id="<?= esc_attr($cohort['id']); ?>"
                data-cohort-name="<?= esc_attr($cohort['title']); ?>"
                data-cohort-date="<?= esc_attr($cohort['start_date_full']); ?>">
                <?= esc_html(!empty($cohort['button_text']) ? $cohort['button_text'] : __('Check fit', 'codebymonk')); ?>
              </button>
            <?php else: ?>
              <button type="button" class="btn btn-ghost btn-sm js-trigger-cohort-waitlist"
                data-cohort-id="<?= esc_attr($cohort['id']); ?>"
                data-cohort-name="<?= esc_attr($cohort['title']); ?>"
                data-cohort-date="<?= esc_attr($cohort['start_date_full']); ?>">
                <?= esc_html(!empty($cohort['button_text']) ? $cohort['button_text'] : __('Notify me', 'codebymonk')); ?>
              </button>
            <?php endif; ?>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- 3 Steps Cards -->
    <?php if ($showSteps): ?>
      <div class="g3">
        <div class="card step-card">
          <div class="tiny" style="color:var(--shgreen)"><?= esc_html($step1Title); ?></div>
          <p class="sm mt8"><strong><?= esc_html($step1Strong); ?></strong> <?= esc_html($step1Desc); ?></p>
        </div>
        <div class="card step-card">
          <div class="tiny" style="color:var(--shgreen)"><?= esc_html($step2Title); ?></div>
          <p class="sm mt8"><strong><?= esc_html($step2Strong); ?></strong> <?= esc_html($step2Desc); ?></p>
        </div>
        <div class="card step-card">
          <div class="tiny" style="color:var(--shgreen)"><?= esc_html($step3Title); ?></div>
          <p class="sm mt8"><strong><?= esc_html($step3Strong); ?></strong> <?= esc_html($step3Desc); ?></p>
        </div>
      </div>
    <?php endif; ?>

  </div>

  <!-- Interactive In-Page Quiz Modal / Drawer -->
  <div id="cohortQuizModal" class="cohort-quiz-modal" hidden aria-hidden="true">
    <div class="cohort-quiz-backdrop js-close-quiz"></div>
    <div class="cohort-quiz-dialog" role="dialog" aria-modal="true">
      <button type="button" class="cohort-quiz-close js-close-quiz" aria-label="Close">&times;</button>
      
      <!-- Quiz Header -->
      <div class="hgroup cohort-quiz-top" style="justify-content:space-between">
        <span class="tiny cohort-header-tag" id="cohortQuizTag">Autumn cohort · starts 14 October</span>
        <span class="tiny cohort-step-indicator" id="cohortQuizStepCount">Step 1 of 3</span>
      </div>

      <!-- Progress Bar (3 steps) -->
      <div class="progress cohort-quiz-progress" id="cohortQuizProgressBar">
        <span class="on"></span>
        <span></span>
        <span></span>
      </div>

      <!-- Steps Container -->
      <div class="cohort-quiz-body" id="cohortQuizBody">
        <!-- Dynamic Step Content Rendered by JS -->
      </div>

      <!-- Controls -->
      <div class="hgroup cohort-quiz-footer mt32" id="cohortQuizFooter" style="justify-content:space-between">
        <button type="button" class="btn btn-ghost btn-sm" id="cohortQuizBack" disabled><?= esc_html__('Back', 'codebymonk'); ?></button>
        <button type="button" class="btn btn-go" id="cohortQuizNext"><?= esc_html__('Continue', 'codebymonk'); ?></button>
      </div>
    </div>
  </div>

</section>
