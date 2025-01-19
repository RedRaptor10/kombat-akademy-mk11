<?php
function php_shortcode($atts = array()) {
	// Default Parameters
	extract(shortcode_atts(array(
		'file' => '',
	), $atts));

	$url = $_SERVER['REQUEST_URI']; // Get current url
	$subdomain = NULL;

	// Check if url contains subdomain
	if (strpos($url, 'mortal-kombat-11') !== false) {
		$subdomain = 'mk11';
	}

	// Check subdomain then output PHP file
	if (is_null($subdomain)) {
		ob_start();
		include $file . '.php';
	} else {
		ob_start();
		include $subdomain . '/' . $file . '.php';
	}

	return ob_get_clean();
}
add_shortcode('php', 'php_shortcode');
?>