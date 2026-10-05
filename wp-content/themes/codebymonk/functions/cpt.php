<?php
/**
 * Register Custom Post Types
 * Fully prepared for WPML Multilingual Translation
 */

function zol_register_post_types() {
	// 1. Stories CPT
	$story_labels = [
		'name'                  => _x('Stories', 'Post type general name', 'codebymonk'),
		'singular_name'         => _x('Story', 'Post type singular name', 'codebymonk'),
		'menu_name'             => _x('Stories', 'Admin Menu text', 'codebymonk'),
		'name_admin_bar'        => _x('Story', 'Add New on Toolbar', 'codebymonk'),
		'add_new'               => __('Add New', 'codebymonk'),
		'add_new_item'          => __('Add New Story', 'codebymonk'),
		'new_item'              => __('New Story', 'codebymonk'),
		'edit_item'             => __('Edit Story', 'codebymonk'),
		'view_item'             => __('View Story', 'codebymonk'),
		'all_items'             => __('All Stories', 'codebymonk'),
		'search_items'          => __('Search Stories', 'codebymonk'),
		'not_found'             => __('No stories found.', 'codebymonk'),
		'not_found_in_trash'    => __('No stories found in Trash.', 'codebymonk'),
		'featured_image'        => _x('Story Cover Image', 'Overrides the “Set featured image” phrase', 'codebymonk'),
		'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase', 'codebymonk'),
		'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase', 'codebymonk'),
		'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase', 'codebymonk'),
		'supports'              => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'],
	];

	register_post_type('story', [
		'labels'             => $story_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => ['slug' => 'story', 'with_front' => false],
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'menu_icon'          => 'dashicons-format-quote',
		'supports'           => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'],
		'show_in_rest'       => true,
	]);

	// 2. Events CPT (formerly Cohorts)
	$event_labels = [
		'name'                  => _x('Events', 'Post type general name', 'codebymonk'),
		'singular_name'         => _x('Event', 'Post type singular name', 'codebymonk'),
		'menu_name'             => _x('Events', 'Admin Menu text', 'codebymonk'),
		'name_admin_bar'        => _x('Event', 'Add New on Toolbar', 'codebymonk'),
		'add_new'               => __('Add New', 'codebymonk'),
		'add_new_item'          => __('Add New Event', 'codebymonk'),
		'new_item'              => __('New Event', 'codebymonk'),
		'edit_item'             => __('Edit Event', 'codebymonk'),
		'view_item'             => __('View Event', 'codebymonk'),
		'all_items'             => __('All Events', 'codebymonk'),
		'search_items'          => __('Search Events', 'codebymonk'),
		'not_found'             => __('No events found.', 'codebymonk'),
		'not_found_in_trash'    => __('No events found in Trash.', 'codebymonk'),
	];

	register_post_type('cohort', [
		'labels'             => $event_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => ['slug' => 'events', 'with_front' => false],
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => 21,
		'menu_icon'          => 'dashicons-calendar-alt',
		'supports'           => ['title', 'custom-fields', 'page-attributes'],
		'show_in_rest'       => true,
	]);

	// 3. Event Registrations / Leads CPT (Submenu of Events)
	$lead_labels = [
		'name'                  => _x('Event Registrations', 'Post type general name', 'codebymonk'),
		'singular_name'         => _x('Event Registration', 'Post type singular name', 'codebymonk'),
		'menu_name'             => _x('Registrations / Leads', 'Admin Menu text', 'codebymonk'),
		'name_admin_bar'        => _x('Event Registration', 'Add New on Toolbar', 'codebymonk'),
		'add_new'               => __('Add New Registration', 'codebymonk'),
		'add_new_item'          => __('Add New Registration', 'codebymonk'),
		'edit_item'             => __('View Registration', 'codebymonk'),
		'all_items'             => __('Registrations / Leads', 'codebymonk'),
	];

	register_post_type('cohort_application', [
		'labels'             => $lead_labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => 'edit.php?post_type=cohort',
		'capability_type'    => 'post',
		'capabilities'       => [
			'create_posts' => 'do_not_allow', // Leads are created via the quiz form
		],
		'map_meta_cap'       => true,
		'supports'           => ['title'],
		'show_in_rest'       => false,
	]);

	// 4. Personal Zones Profile Leads
	$profile_lead_labels = [
		'name'          => _x('Profile Leads', 'Post type general name', 'codebymonk'),
		'singular_name' => _x('Profile Lead', 'Post type singular name', 'codebymonk'),
		'menu_name'     => _x('Profile Leads', 'Admin Menu text', 'codebymonk'),
		'all_items'     => __('Profile Leads', 'codebymonk'),
	];

	register_post_type('profile_lead', [
		'labels'             => $profile_lead_labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-chart-pie',
		'menu_position'      => 22,
		'capability_type'    => 'post',
		'capabilities'       => [
			'create_posts' => 'do_not_allow',
		],
		'map_meta_cap'       => true,
		'supports'           => ['title'],
		'show_in_rest'       => false,
	]);
}
add_action('init', 'zol_register_post_types');

/**
 * Custom Admin Columns for Profile Leads
 */
function zol_profile_lead_columns($columns) {
	return [
		'cb'             => $columns['cb'],
		'title'          => __('Name', 'codebymonk'),
		'lead_email'     => __('Email', 'codebymonk'),
		'lead_phone'     => __('WhatsApp / Phone', 'codebymonk'),
		'funnel_stage'   => __('Funnel Stage', 'codebymonk'),
		'lowest_ability' => __('Lowest Ability', 'codebymonk'),
		'zone'           => __('Assigned Zone', 'codebymonk'),
		'lead_lang'      => __('Lang', 'codebymonk'),
		'date'           => __('Submission Date', 'codebymonk'),
	];
}
add_filter('manage_profile_lead_posts_columns', 'zol_profile_lead_columns');

function zol_profile_lead_custom_column($column, $post_id) {
	switch ($column) {
		case 'lead_email':
			$email = get_post_meta($post_id, 'lead_email', true);
			echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—';
			break;
		case 'lead_phone':
			$phone = get_post_meta($post_id, 'lead_phone', true);
			$wa = get_post_meta($post_id, 'whatsapp_optin', true);
			if ($phone) {
				$clean = preg_replace('/[^0-9]/', '', $phone);
				echo esc_html($phone) . ($wa === '1' ? ' <a href="https://wa.me/' . esc_attr($clean) . '" target="_blank" style="text-decoration:none;" title="WhatsApp Opt-in">💬</a>' : '');
			} else {
				echo '—';
			}
			break;
		case 'funnel_stage':
			$stage = get_post_meta($post_id, 'funnel_stage', true) ?: 'R1_completed';
			if ($stage === 'profile_completed') {
				echo '<span style="background:#dcfce7; color:#15803d; padding:2px 7px; border-radius:10px; font-size:11px; font-weight:700;">✓ Completed</span>';
			} elseif ($stage === 'purchased_profile') {
				echo '<span style="background:#dbeafe; color:#1d4ed8; padding:2px 7px; border-radius:10px; font-size:11px; font-weight:700;">$ Purchased</span>';
			} elseif ($stage === 'in_progress') {
				echo '<span style="background:#fef3c7; color:#b45309; padding:2px 7px; border-radius:10px; font-size:11px; font-weight:700;">⏳ In Progress</span>';
			} else {
				echo '<span style="background:#f3f4f6; color:#4b5563; padding:2px 7px; border-radius:10px; font-size:11px; font-weight:700;">Mini Profile (R1)</span>';
			}
			break;
		case 'lowest_ability':
			$ab = get_post_meta($post_id, 'lowest_ability', true);
			echo $ab ? '<strong style="color:#d97706;">' . esc_html($ab) . '</strong>' : '—';
			break;
		case 'zone':
			$zone = get_post_meta($post_id, 'zone', true);
			$color = '#333';
			if (in_array($zone, ['Red', 'Roja'])) $color = '#D93829';
			if (in_array($zone, ['Amber', 'Amarilla'])) $color = '#B98F0C';
			if (in_array($zone, ['Green', 'Verde'])) $color = '#00A84F';
			if (in_array($zone, ['Golden Magic', 'Magia Dorada'])) $color = '#8A7440';
			echo '<strong style="color:' . esc_attr($color) . '">' . esc_html($zone ?: '—') . '</strong>';
			break;
		case 'lead_lang':
			$lang = get_post_meta($post_id, 'lead_lang', true) ?: 'es';
			echo '<span style="font-weight:700; font-size:11px; text-transform:uppercase;">' . esc_html($lang) . '</span>';
			break;
	}
}
add_action('manage_profile_lead_posts_custom_column', 'zol_profile_lead_custom_column', 10, 2);

/**
 * Custom Admin Columns for Cohort Applications / Leads
 */
function zol_cohort_app_columns($columns) {
	$new_columns = [
		'cb'          => $columns['cb'],
		'title'       => __('Applicant Name', 'codebymonk'),
		'lead_email'  => __('Email', 'codebymonk'),
		'cohort_name' => __('Event', 'codebymonk'),
		'step_area'   => __('Area to Move', 'codebymonk'),
		'step_time'   => __('Time / Week', 'codebymonk'),
		'step_exp'    => __('Experience', 'codebymonk'),
		'date'        => __('Submission Date', 'codebymonk'),
	];
	return $new_columns;
}
add_filter('manage_cohort_application_posts_columns', 'zol_cohort_app_columns');

function zol_cohort_app_custom_column($column, $post_id) {
	switch ($column) {
		case 'lead_email':
			$email = get_post_meta($post_id, 'lead_email', true);
			echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—';
			break;
		case 'cohort_name':
			echo esc_html(get_post_meta($post_id, 'cohort_name', true) ?: '—');
			break;
		case 'step_area':
			echo esc_html(get_post_meta($post_id, 'step_1_area', true) ?: '—');
			break;
		case 'step_time':
			echo esc_html(get_post_meta($post_id, 'step_2_time', true) ?: '—');
			break;
		case 'step_exp':
			echo esc_html(get_post_meta($post_id, 'step_3_experience', true) ?: '—');
			break;
	}
}
add_action('manage_cohort_application_posts_custom_column', 'zol_cohort_app_custom_column', 10, 2);

/**
 * Metabox for Profile Lead Details in WP Admin
 */
function zol_add_profile_lead_metaboxes() {
	add_meta_box(
		'zol_profile_lead_details',
		__('Mini Profile Results & Lead Details', 'codebymonk'),
		'zol_render_profile_lead_metabox',
		'profile_lead',
		'normal',
		'high'
	);
}
add_action('add_meta_boxes', 'zol_add_profile_lead_metaboxes');

function zol_render_profile_lead_metabox($post) {
	$name           = get_post_meta($post->ID, 'lead_name', true) ?: $post->post_title;
	$email          = get_post_meta($post->ID, 'lead_email', true);
	$phone          = get_post_meta($post->ID, 'lead_phone', true);
	$wa             = get_post_meta($post->ID, 'whatsapp_optin', true);
	$stage          = get_post_meta($post->ID, 'funnel_stage', true) ?: 'R1_completed';
	$lang           = get_post_meta($post->ID, 'lead_lang', true) ?: 'es';
	$have_level     = get_post_meta($post->ID, 'have_level', true);
	$have_name      = get_post_meta($post->ID, 'have_level_name', true);
	$have_quote     = get_post_meta($post->ID, 'have_level_quote', true);
	$have_text      = get_post_meta($post->ID, 'have_level_text', true);
	$have_zone      = get_post_meta($post->ID, 'have_zone', true) ?: get_post_meta($post->ID, 'zone', true);
	$lowest_ability = get_post_meta($post->ID, 'lowest_ability', true);
	$lowest_quote   = get_post_meta($post->ID, 'lowest_ability_quote', true);
	$fin_zone       = get_post_meta($post->ID, 'financial_zone', true);
	$life_zone      = get_post_meta($post->ID, 'life_zone', true);
	$body_zone      = get_post_meta($post->ID, 'body_zone', true);
	$overall_zone   = get_post_meta($post->ID, 'overall_zone', true);

	$clean_phone = preg_replace('/[^0-9]/', '', $phone);
	?>
	<style>
		.zol-lead-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px; }
		.zol-lead-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px 18px; }
		.zol-lead-card h4 { margin: 0 0 10px 0; font-size: 13px; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; }
		.zol-lead-card p { margin: 6px 0; font-size: 14px; line-height: 1.5; }
		.zol-badge { display: inline-block; padding: 3px 9px; border-radius: 12px; font-weight: 700; font-size: 12px; }
	</style>

	<div class="zol-lead-grid" style="margin-top:10px;">
		<div class="zol-lead-card">
			<h4>👤 <?php esc_html_e('Contact Information', 'codebymonk'); ?></h4>
			<p><strong><?php esc_html_e('Name:', 'codebymonk'); ?></strong> <?php echo esc_html($name); ?></p>
			<p><strong><?php esc_html_e('Email:', 'codebymonk'); ?></strong> <?php echo $email ? '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>' : '—'; ?></p>
			<p><strong><?php esc_html_e('Phone:', 'codebymonk'); ?></strong> <?php echo esc_html($phone ?: '—'); ?>
				<?php if ($clean_phone): ?>
					<a href="https://wa.me/<?php echo esc_attr($clean_phone); ?>" target="_blank" class="button button-small" style="margin-left:6px; color:#15803d; border-color:#86efac; font-weight:600;">💬 WhatsApp</a>
				<?php endif; ?>
			</p>
			<p><strong><?php esc_html_e('WhatsApp Opt-in:', 'codebymonk'); ?></strong> <?php echo $wa === '1' ? '✅ Yes' : '❌ No'; ?></p>
			<p><strong><?php esc_html_e('Language:', 'codebymonk'); ?></strong> <span class="zol-badge" style="background:#e0e7ff; color:#3730a3;"><?php echo strtoupper(esc_html($lang)); ?></span></p>
			<p><strong><?php esc_html_e('Funnel Stage:', 'codebymonk'); ?></strong> <span class="zol-badge" style="background:#fef3c7; color:#92400e;"><?php echo esc_html($stage); ?></span></p>
		</div>

		<div class="zol-lead-card">
			<h4>📊 <?php esc_html_e('Have Level & Zones Assessment', 'codebymonk'); ?></h4>
			<p><strong><?php esc_html_e('Have Level:', 'codebymonk'); ?></strong> <span style="font-size:15px; font-weight:bold; color:#0f172a;"><?php echo esc_html($have_name ?: $have_level ?: '—'); ?></span></p>
			<p><strong><?php esc_html_e('Have Zone:', 'codebymonk'); ?></strong> <strong style="color:#d97706;"><?php echo esc_html($have_zone ?: '—'); ?></strong></p>
			<p><strong><?php esc_html_e('Overall Zone:', 'codebymonk'); ?></strong> <?php echo esc_html($overall_zone ?: '—'); ?></p>
			<p><strong><?php esc_html_e('Financial Zone:', 'codebymonk'); ?></strong> <?php echo esc_html($fin_zone ?: '—'); ?></p>
			<p><strong><?php esc_html_e('Life Zone:', 'codebymonk'); ?></strong> <?php echo esc_html($life_zone ?: '—'); ?></p>
			<p><strong><?php esc_html_e('Body Zone:', 'codebymonk'); ?></strong> <?php echo esc_html($body_zone ?: '—'); ?></p>
		</div>

		<div class="zol-lead-card" style="grid-column: 1 / -1;">
			<h4>🎯 <?php esc_html_e('Lowest Ability Identified', 'codebymonk'); ?></h4>
			<p><strong><?php esc_html_e('Ability:', 'codebymonk'); ?></strong> <span style="color:#dc2626; font-weight:bold; font-size:15px;"><?php echo esc_html($lowest_ability ?: '—'); ?></span></p>
			<?php if ($lowest_quote): ?>
				<blockquote style="margin:8px 0; padding:10px 14px; background:#fff; border-left:4px solid #dc2626; border-radius:4px; font-style:italic; color:#334155;">
					"<?php echo esc_html($lowest_quote); ?>"
				</blockquote>
			<?php endif; ?>
		</div>

		<?php if ($have_text || $have_quote): ?>
		<div class="zol-lead-card" style="grid-column: 1 / -1;">
			<h4>📖 <?php esc_html_e('Result Interpretation Text', 'codebymonk'); ?></h4>
			<?php if ($have_quote): ?>
				<p style="font-weight:600; color:#475569;">"<?php echo esc_html($have_quote); ?>"</p>
			<?php endif; ?>
			<?php if ($have_text): ?>
				<div style="background:#fff; border:1px solid #cbd5e1; border-radius:6px; padding:14px; font-size:13px; line-height:1.6; color:#334155; margin-top:8px;">
					<?php echo nl2br(esc_html($have_text)); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>
	</div>
	<?php
}

