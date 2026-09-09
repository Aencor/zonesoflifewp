<?php
function register_acf_block_types() {
	// Solo defines los nombres aquí
	$block_names = [
		'hero',
		'side-by-side',
		'cards',
		'tabs',
		'stats',
		'cta-label',
		'logo-grid',
		'styleguide',
	];

	foreach ($block_names as $name) {
		// Generar título legible automáticamente (Hero, CTA Label, etc.)
		$title = ucwords(str_replace(['-', '_'], ' ', $name));

		// Crear arreglo base del bloque
		$block = [
			'name'            => $name,
			'title'           => __($title),
			'description'     => __($title),
			'render_template' => "blocks/{$name}.php",
			'category'        => 'common',
			'icon'            => 'editor-alignleft',
			'keywords'        => [$name],
		];

		// Si existe un JS con el mismo nombre, lo agrega automáticamente
		$js_path = get_template_directory() . "/assets/js/{$name}.js";
		if (file_exists($js_path)) {
			$block['enqueue_script'] = get_template_directory_uri() . "/assets/js/{$name}.js";
		}

		// Registrar bloque
		acf_register_block_type($block);
	}
}

if (function_exists('acf_register_block_type')) {
	add_action('acf/init', 'register_acf_block_types');
}
