<?php
/**
 * Block Name: Short Stories
 * Class: block-short-stories
 */

$blockClasses = ['block-short-stories', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('short_stories_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Fields
$layout = get_field('layout') ?: 'simple';
$showHeader = get_field('show_header');
if ($showHeader === null || $showHeader === '') {
    $showHeader = ($layout === 'simple');
}

$title = get_field('title') ?: __('People who changed Zone', 'codebymonk');
$buttonText = get_field('button_text') ?: __('All stories', 'codebymonk');
$buttonLink = get_field('button_link') ?: '/stories/';
$source = get_field('stories_source') ?: 'latest';
$selectedStories = get_field('selected_stories');
$postsPerPage = get_field('posts_per_page') ?: ($layout === 'detailed' ? 4 : 3);

$storiesList = [];

if ($source === 'custom' && !empty($selectedStories)) {
    foreach ($selectedStories as $storyPost) {
        $postID = is_object($storyPost) ? $storyPost->ID : $storyPost;
        $quote = get_field('story', $postID) ?: get_the_excerpt($postID);
        $author = get_field('author', $postID) ?: get_the_title($postID);
        $position = get_field('position', $postID) ?: '';
        $location = get_field('location', $postID) ?: '';
        $photo = get_field('photo', $postID);
        $beforeLevel = intval(get_field('before_level', $postID) ?: 1);
        $afterLevel = intval(get_field('after_level', $postID) ?: 3);

        $storiesList[] = [
            'id'           => $postID,
            'story'        => $quote,
            'author'       => $author,
            'position'     => $position,
            'location'     => $location,
            'photo'        => $photo,
            'before_level' => $beforeLevel,
            'after_level'  => $afterLevel,
        ];
    }
} else {
    // Query stories ordered by menu_order then date
    $query = new WP_Query([
        'post_type'        => 'story',
        'posts_per_page'   => intval($postsPerPage),
        'post_status'      => 'publish',
        'orderby'          => [
            'menu_order' => 'ASC',
            'date'       => 'DESC',
        ],
        'suppress_filters' => false, // Ensure WPML filters query by current language
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postID = get_the_ID();
            $quote = get_field('story', $postID) ?: get_the_excerpt($postID);
            $author = get_field('author', $postID) ?: get_the_title($postID);
            $position = get_field('position', $postID) ?: '';
            $location = get_field('location', $postID) ?: '';
            $photo = get_field('photo', $postID);
            $beforeLevel = intval(get_field('before_level', $postID) ?: 1);
            $afterLevel = intval(get_field('after_level', $postID) ?: 3);

            $storiesList[] = [
                'id'           => $postID,
                'story'        => $quote,
                'author'       => $author,
                'position'     => $position,
                'location'     => $location,
                'photo'        => $photo,
                'before_level' => $beforeLevel,
                'after_level'  => $afterLevel,
            ];
        }
        wp_reset_postdata();
    }
}

// Fallback if no stories exist in DB
if (empty($storiesList)) {
    $storiesList = [
        [
            'story'        => 'She says the training gave her ways to stay focused, that the health skills balanced her wellbeing, and that she moved from the red Zone to green in two days at the ranch.',
            'author'       => 'Rita Khagram',
            'position'     => 'Business owner and investor',
            'location'     => 'England, Kenya & India',
            'photo'        => null,
            'before_level' => 1,
            'after_level'  => 3,
        ],
        [
            'story'        => 'He says he regained hidden abilities to enjoy life and expand his leadership.',
            'author'       => 'Rigoberto Acosta',
            'position'     => 'Master business coach',
            'location'     => 'Mexico',
            'photo'        => null,
            'before_level' => 2,
            'after_level'  => 4,
        ],
        [
            'story'        => 'He says he learned more in seven days at the ranch than in a lifetime of struggling without it, and that he thinks differently and has more time.',
            'author'       => 'David Pritchett',
            'position'     => 'Business owner',
            'location'     => 'USA & South Africa',
            'photo'        => null,
            'before_level' => 1,
            'after_level'  => 3,
        ],
        [
            'story'        => 'He describes the coaching and training work as a genuine edge in business, relationships, wealth and peace of mind.',
            'author'       => 'Blair Singer',
            'position'     => 'Author and entrepreneur',
            'location'     => '',
            'photo'        => null,
            'before_level' => 2,
            'after_level'  => 4,
        ],
    ];
}
?>

<section id="<?= esc_attr($blockID); ?>" data-block="short-stories" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <?php if ($showHeader): ?>
      <div class="hgroup mb24" style="justify-content:space-between">
        <h2><?= esc_html($title); ?></h2>
        <?php if (!empty($buttonText)): ?>
          <a class="btn btn-ghost btn-sm" href="<?= esc_url($buttonLink); ?>"><?= esc_html($buttonText); ?></a>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if ($layout === 'detailed'): ?>
      <div class="g2">
        <?php foreach ($storiesList as $item): 
          $beforeLvl = max(1, min(4, intval($item['before_level'] ?? 1)));
          $afterLvl = max(1, min(4, intval($item['after_level'] ?? 3)));
          $metaParts = [];
          if (!empty($item['position'])) $metaParts[] = $item['position'];
          if (!empty($item['location'])) $metaParts[] = $item['location'];
          $metaString = implode(' · ', $metaParts);
        ?>
          <div class="card card-detailed">
            <div class="author-header">
              <div class="avatar-box">
                <?php if (!empty($item['photo']['url'])): ?>
                  <img src="<?= esc_url($item['photo']['url']); ?>" alt="<?= esc_attr($item['author']); ?>" />
                <?php else: ?>
                  <svg class="ic" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><use href="#i-users"/></svg>
                <?php endif; ?>
              </div>
              <div>
                <h4><?= esc_html($item['author']); ?></h4>
                <?php if (!empty($metaString)): ?>
                  <div class="meta-role"><?= esc_html($metaString); ?></div>
                <?php endif; ?>
              </div>
            </div>

            <div class="storyzones">
              <div class="zone-col">
                <div class="zone-label"><?= esc_html__('Before', 'codebymonk'); ?></div>
                <div class="zones dim">
                  <i class="z1 <?= $beforeLvl >= 1 ? 'on' : ''; ?>"></i>
                  <i class="z2 <?= $beforeLvl >= 2 ? 'on' : ''; ?>"></i>
                  <i class="z3 <?= $beforeLvl >= 3 ? 'on' : ''; ?>"></i>
                  <i class="z4 <?= $beforeLvl >= 4 ? 'on' : ''; ?>"></i>
                </div>
              </div>
              <span class="arrow">→</span>
              <div class="zone-col">
                <div class="zone-label"><?= esc_html__('After', 'codebymonk'); ?></div>
                <div class="zones dim">
                  <i class="z1 <?= $afterLvl >= 1 ? 'on' : ''; ?>"></i>
                  <i class="z2 <?= $afterLvl >= 2 ? 'on' : ''; ?>"></i>
                  <i class="z3 <?= $afterLvl >= 3 ? 'on' : ''; ?>"></i>
                  <i class="z4 <?= $afterLvl >= 4 ? 'on' : ''; ?>"></i>
                </div>
              </div>
            </div>

            <p class="story-quote"><?= esc_html($item['story']); ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <div class="g3">
        <?php foreach ($storiesList as $item): ?>
          <div class="card">
            <p class="sm" style="font-style:italic"><?= esc_html($item['story']); ?></p>
            <div class="tiny mt16">
              <?= esc_html($item['author']); ?><?php if (!empty($item['location'])): ?> · <?= esc_html($item['location']); ?><?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
