<?php
/**
 * Block Name: Articles
 * Class: block-articles
 */

$blockClasses = ['block-articles', 'block'];

// Handle block ID
$id = !empty($block['id']) ? $block['id'] : uniqid('articles_');
$customID = get_field('block_id');
$blockID = $customID ? $customID : 'block-' . $id;

if (!empty($block['className'])) {
    $blockClasses[] = $block['className'];
}

// Fields
$source = get_field('articles_source') ?: 'latest';
$postsPerPage = get_field('posts_per_page') ?: 3;
$selectedPosts = get_field('selected_posts');
$showReadMore = get_field('show_read_more');
if ($showReadMore === null || $showReadMore === '') {
    $showReadMore = true;
}
$readMoreText = get_field('read_more_text') ?: __('Read more', 'codebymonk');

$articlesList = [];

if ($source === 'custom' && !empty($selectedPosts)) {
    foreach ($selectedPosts as $p) {
        $postID = is_object($p) ? $p->ID : $p;
        $authorLabel = get_field('author_label', $postID);
        if (empty($authorLabel)) {
            $categories = get_the_category($postID);
            $authorLabel = !empty($categories) ? $categories[0]->name : get_the_author_meta('display_name', get_post_field('post_author', $postID));
        }

        $articlesList[] = [
            'id'          => $postID,
            'title'       => get_the_title($postID),
            'url'         => get_permalink($postID),
            'excerpt'     => get_the_excerpt($postID),
            'label'       => $authorLabel,
            'has_thumb'   => has_post_thumbnail($postID),
            'thumb_id'    => get_post_thumbnail_id($postID),
        ];
    }
} else {
    $query = new WP_Query([
        'post_type'        => 'post',
        'posts_per_page'   => intval($postsPerPage),
        'post_status'      => 'publish',
        'orderby'          => 'date',
        'order'            => 'DESC',
        'suppress_filters' => false,
    ]);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $postID = get_the_ID();
            $authorLabel = get_field('author_label', $postID);
            if (empty($authorLabel)) {
                $categories = get_the_category($postID);
                $authorLabel = !empty($categories) ? $categories[0]->name : get_the_author();
            }

            $articlesList[] = [
                'id'          => $postID,
                'title'       => get_the_title(),
                'url'         => get_permalink(),
                'excerpt'     => get_the_excerpt(),
                'label'       => $authorLabel,
                'has_thumb'   => has_post_thumbnail(),
                'thumb_id'    => get_post_thumbnail_id(),
            ];
        }
        wp_reset_postdata();
    }
}

// Fallback if no posts in DB yet
if (empty($articlesList)) {
    $articlesList = [
        [
            'id'        => 0,
            'title'     => 'The one constant in a world of change',
            'url'       => '#',
            'excerpt'   => 'Instability abounds, and yet one thing has not changed: you — the spiritual being, the life force, the energiser.',
            'label'     => 'Jeff Crippen',
            'has_thumb' => false,
        ],
        [
            'id'        => 0,
            'title'     => 'What am I? Who am I?',
            'url'       => '#',
            'excerpt'   => 'Why you do what you do, and how you choose what you choose and who you choose it with.',
            'label'     => 'Ceil Stanford',
            'has_thumb' => false,
        ],
        [
            'id'        => 0,
            'title'     => 'Ability is what survives a bad week',
            'url'       => '#',
            'excerpt'   => 'The difference between knowing how and being able to do it consistently.',
            'label'     => 'Coaching & Training',
            'has_thumb' => false,
        ],
    ];
}
?>

<section id="<?= esc_attr($blockID); ?>" data-block="articles" class="<?= esc_attr(implode(' ', $blockClasses)); ?>">
  <div class="wrap">
    <div class="g3">
      <?php foreach ($articlesList as $art): ?>
        <div class="card card-article">
          <?php if (!empty($art['has_thumb'])): ?>
            <div class="article-card-thumb mb16">
              <a href="<?= esc_url($art['url']); ?>" tabindex="-1" aria-hidden="true">
                <?= wp_get_attachment_image($art['thumb_id'], 'medium_large', false, ['class' => 'img-responsive']); ?>
              </a>
            </div>
          <?php endif; ?>

          <?php if (!empty($art['label'])): ?>
            <div class="tiny article-label" style="color:var(--shgreen)"><?= esc_html($art['label']); ?></div>
          <?php endif; ?>

          <h4 class="mt8 article-title">
            <a href="<?= esc_url($art['url']); ?>"><?= esc_html($art['title']); ?></a>
          </h4>

          <?php if (!empty($art['excerpt'])): ?>
            <p class="sm mt8 article-excerpt"><?= esc_html($art['excerpt']); ?></p>
          <?php endif; ?>

          <?php if ($showReadMore): ?>
            <div class="mt20 article-action">
              <a class="btn btn-ghost btn-sm" href="<?= esc_url($art['url']); ?>">
                <?= esc_html($readMoreText); ?> &rarr;
              </a>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
