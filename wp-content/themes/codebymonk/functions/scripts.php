<?php

function theme_scripts() {

	if (is_single() && comments_open() && get_option("thread_comments")) {
		wp_enqueue_script("comment-reply");
	}

	// Google Fonts (Fraunces, Inter, Space Mono)
	wp_enqueue_style(
		"zonesoflife-google-fonts",
		"https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=Space+Mono:wght@400;700&display=swap",
		[],
		null
	);

	wp_register_script(
		"theme-defer",
		get_template_directory_uri() . "/assets/build/main.js",
		['jquery'],
		'1.0.1',
		true
	);
	wp_enqueue_script("theme-defer");
	wp_localize_script("theme-defer", "zolData", [
		"ajaxUrl" => admin_url("admin-ajax.php"),
		"nonce"   => wp_create_nonce("zol_cohort_nonce"),
	]);
	
	// Main Style
	wp_enqueue_style(
		"master",
		get_template_directory_uri() . "/assets/build/style.css",
		["zonesoflife-google-fonts"],
		"1.1",
		"all"
	);
}

add_action("wp_enqueue_scripts", "theme_scripts", 9999);

// Add preconnect for Google Fonts
function theme_resource_hints($urls, $relation_type) {
	if ($relation_type === 'preconnect') {
		$urls[] = ['href' => 'https://fonts.googleapis.com', 'crossorigin' => ''];
		$urls[] = ['href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous'];
	}
	return $urls;
}
add_filter('wp_resource_hints', 'theme_resource_hints', 10, 2);

