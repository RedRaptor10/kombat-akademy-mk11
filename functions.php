<?php
// Register Scripts/Styles
function register_scripts() {
	// Parent Theme Style
	wp_register_style('customify-style', get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme()->parent()->get('Version')
	);
	// Child Theme Style
	wp_register_style('customify-child-style', get_stylesheet_uri(),
		array('customify-style'), 
		time() // wp_get_theme()->get('Version')
	);

	// jQuery
	wp_register_script('jquery-3-4-1-js', get_stylesheet_directory_uri() . '/js/jquery-3.4.1.js');

	// Subdomains
	wp_register_style('mk11-css', get_stylesheet_directory_uri() . '/css/mk11/style.css', '', time());

	// Gfyvid
	wp_register_style('mk11-gfyvid-css', get_stylesheet_directory_uri() . '/css/mk11/gfyvid.css', '', time());

	// Sliders
	wp_register_script('slider-js', get_stylesheet_directory_uri() . '/js/slider.js', array(), time(), true);

	// Character Page
	wp_register_style('mk11-move-list-css', get_stylesheet_directory_uri() . '/css/mk11/move-list.css', '', time());
	wp_register_script('mk11-move-list-js', get_stylesheet_directory_uri() . '/js/mk11/move-list.js', array(), time(), true);
	wp_register_style('mk11-character-css', get_stylesheet_directory_uri() . '/css/mk11/character.css', '', time());

	// Combos Page
	wp_register_style('mk11-combos-css', get_stylesheet_directory_uri() . '/css/mk11/combos.css', '', time());
	wp_register_script('mk11-combos-js', get_stylesheet_directory_uri() . '/js/mk11/combos.js', array(), time(), true);

	// Keywords
	wp_register_style('mk11-keywords-css', get_stylesheet_directory_uri() . '/css/mk11/keywords.css', '', time());
	wp_register_script('mk11-keywords-js', get_stylesheet_directory_uri() . '/js/mk11/keywords.js', array(), time(), true);

	// Tier Maker
	wp_register_style('mk11-tier-maker-css', get_stylesheet_directory_uri() . '/css/mk11/tier-maker.css', '', time());
	wp_register_script('html2canvas-js', get_stylesheet_directory_uri() . '/js/mk11/html2canvas.js');
	wp_register_script('Sortable-js', get_stylesheet_directory_uri() . '/js/mk11/Sortable.js');
	wp_register_script('mk11-tier-maker-js', get_stylesheet_directory_uri() . '/js/mk11/tier-maker.js', array(), time(), true);
	// Tier Submit
	wp_register_script('mk11-tier-submit-js', get_stylesheet_directory_uri() . '/js/mk11/tier-submit.js', array(), time(), true);

	// Tier Lists
	wp_register_style('mk11-tier-lists-css', get_stylesheet_directory_uri() . '/css/mk11/tier-lists.css', '', time());
	wp_register_style('mk11-tier-list-player-css', get_stylesheet_directory_uri() . '/css/mk11/tier-list-player.css', '', time());

	// Rankings
	wp_register_style('mk11-rankings-css', get_stylesheet_directory_uri() . '/css/mk11/rankings.css', '', time());

	// Notations
	wp_register_script('mk11-notation-selector-js', get_stylesheet_directory_uri() . '/js/mk11/notation-selector.js', array(), time(), true);
}
add_action('wp_loaded', 'register_scripts');

// Enqueue Scripts/Styles
function enqueue_scripts() {
	// Subdomain
	global $wp;
	$current_url = home_url($wp->request);
	$game = NULL;
	if (strpos($current_url, 'kombatakademy.com/mortal-kombat-11') !== false) {
		$game = 'mk11';
	}

	// Parent Theme
	wp_enqueue_style('customify-style');
	// Child Theme
	wp_enqueue_style('customify-child-style');

	// jQuery
	wp_enqueue_script('jquery-3-4-1-js');

	// Gfyvid
	wp_enqueue_style('mk11-gfyvid-css');

	// Sliders
	if (is_page('mortal-kombat-11')) {
		wp_enqueue_script('slider-js');
	}

	// Games
	if ($game == 'mk11') {
		wp_enqueue_style('mk11-css');

		// Character Page
		if (is_page_template('templates/mk11-character.php')) {
			wp_enqueue_style('mk11-move-list-css');
			wp_enqueue_script('mk11-move-list-js');
			wp_enqueue_style('mk11-character-css');
		}

		// Combos Page
		if (is_page('combos')) {
			wp_enqueue_style('mk11-combos-css');
			wp_enqueue_script('mk11-combos-js');
		}

		 // Keywords
		 if ((get_post_type() == 'post') || (is_page_template('templates/mk11-character.php'))) {
			wp_enqueue_style('mk11-keywords-css');
			wp_enqueue_script('mk11-keywords-js');
		 }

		// Tier Maker
		if (is_page('tier-maker')) {
			wp_enqueue_style('mk11-tier-maker-css');
			wp_enqueue_script('html2canvas-js');
			wp_enqueue_script('Sortable-js');
			wp_enqueue_script('mk11-tier-maker-js');

			// Tier Submit
			wp_enqueue_script('mk11-tier-submit-js');
			wp_localize_script('mk11-tier-submit-js', 'tier_submit_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
		}

		// Tier Lists
		if (is_page('tier-lists')) {
			wp_enqueue_style('mk11-tier-lists-css');
		}
		if (is_page('tier-list')) {
			wp_enqueue_style('mk11-tier-maker-css');
			wp_enqueue_style('mk11-tier-list-player-css');
		}

		// Rankings
		if (is_page('rankings')) {
			wp_enqueue_style('mk11-rankings-css');
		}
	}

	// Notations
	wp_enqueue_script('mk11-notation-selector-js');
}
add_action('wp_enqueue_scripts', 'enqueue_scripts');

// PHP
include('php/php.php');
include('php/mk11/notation.php'); // Notation
include('php/mk11/gfyvid.php'); // Gfyvid

// Tier Submit
include('php/mk11/tier-submit.php');

// Automatically Update Plugins
add_filter( 'auto_update_plugin', '__return_true' );

// Add Excerpts for Pages
add_post_type_support( 'page', 'excerpt' );

// Add Star to Posts with Premium Tag
function premium_title( $title, $id = null ) {
    if ( has_tag( 'Premium' ) && in_the_loop()) { 
        return '&#9733 ' . $title;
    } else {
        return $title;
    }
}
add_filter( 'the_title', 'premium_title', 10, 2 );

// Autolink Featured Images
function autolink_featured_images( $html, $post_id, $post_image_id ) {
	if (! is_singular()) {
		$html = '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">' . $html . '</a>';
		return $html;
	} else {
		return $html;
	}
}
add_filter( 'post_thumbnail_html', 'autolink_featured_images', 10, 3 );