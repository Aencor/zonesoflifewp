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
