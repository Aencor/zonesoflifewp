<?php
/**
 * Initial setup and constants
 */
function monk_theme_setup() {
	// Enable plugins to manage the document title
	add_theme_support("title-tag");

	// Add post thumbnails
	add_theme_support("post-thumbnails");

	// Add Menus
	add_theme_support("menus");
	register_nav_menus([
		"primary"     => __("Primary Navigation", "codebymonk"),
		"footer_col1" => __("Footer Assessment", "codebymonk"),
		"footer_col2" => __("Footer Programmes", "codebymonk"),
		"footer_col3" => __("Footer Method", "codebymonk"),
		"footer_col4" => __("Footer Company", "codebymonk"),
	]);

	// Add HTML5 markup for captions
	add_theme_support("html5", ["caption", "comment-form", "comment-list"]);
}
add_action("after_setup_theme", "monk_theme_setup");

// Adding Theme Support
add_theme_support("custom-logo");


