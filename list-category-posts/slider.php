<?php
/*
Plugin Name: List Category Posts - Template "slider"
Plugin URI: http://picandocodigo.net/programacion/wordpress/list-category-posts-wordpress-plugin-english/
Description: Template file for List Category Post Plugin for Wordpress which is used by plugin by argument template=value.php
Version: 0.9
Author: Radek Uldrych & Fernando Briano
Author URI: http://picandocodigo.net http://radoviny.net
*/

/*
Copyright 2009 Radek Uldrych (email : verex@centrum.cz)
Copyright 2009-2015 Fernando Briano (http://picandocodigo.net)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or any
later version.

This program is distributed in the hope that it will be useful, but
WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301
USA
*/

/**
* The format for templates changed since version 0.17.  Since this
* code is included inside CatListDisplayer, $this refers to the
* instance of CatListDisplayer that called this file.
*/

/* This is the string which will gather all the information.*/
$lcp_display_output = '';

// Show category link:
$lcp_display_output .= $this->get_category_link('strong');

// Show the conditional title:
$lcp_display_output .= $this->get_conditional_title();

// Add 'starting' tag:
$lcp_display_output .= '<div class="slider">';

/* Posts Loop
 *
 * The code here will be executed for every post in the category.  As
 * you can see, the different options are being called from functions
 * on the $this variable which is a CatListDisplayer.
 *
 * CatListDisplayer has a function for each field we want to show.  So
 * you'll see get_excerpt, get_thumbnail, etc.  You can now pass an
 * html tag as a parameter. This tag will sorround the info you want
 * to display. You can also assign a specific CSS class to each field.
*/
// Post Index
$post_index = 0;

global $post;
while ( have_posts() ):

  // New Slide After Every 4 Posts
  if ($post_index == 0 || $post_index == 4 || $post_index == 8 || $post_index == 12) {
  	$lcp_display_output .= '<div class="slide">';
  }

  the_post();

  // Start a Div Item for each post:
  $lcp_display_output .= '<div class="slider-item">';

  // Post Thumbnail
  $lcp_display_output .= $this->get_thumbnail($post);

  // Post Default Thumbnail
  if (!has_post_thumbnail()) {
  	$post_id = get_the_ID();
  	$lcp_display_output .= '<a href="' . get_permalink( $post_id ) . '" title="' . esc_attr( get_the_title( $post_id ) ) . '">
	<img class="slider-item-thumb" src="https://www.mk11.kombatakademy.com/wp-content/uploads/images/default-thumb.jpg"></a>';
  }

  // Show the title and link to the post:
  $lcp_display_output .= $this->get_post_title($post, 'div', 'slider-item-title');

  // Slider Item Details
  $lcp_display_output .= '<div class="slider-item-details">';
  // Show date:
  $lcp_display_output .= $this->get_date($post);

  // Show date modified:
  $lcp_display_output .= $this->get_modified_date($post);

  // Show author
  $lcp_display_output .= $this->get_author($post);

  // Show comments:
  $lcp_display_output .= ' • ' . str_replace(array('(', ')'), '', $this->get_comments($post)) . ' Comments';

  // Close Slider Item Details Div Tag
  $lcp_display_output .= '</div>';

  // Custom fields:
  $lcp_display_output .= $this->get_custom_fields($post);

  /**
   * Post content - Example of how to use tag and class parameters:
   * This will produce:<p class="lcp_content">The content</p>
   */
  $lcp_display_output .= $this->get_content($post, 'p', 'lcp_content');

  /**
   * Post content - Example of how to use tag and class parameters:
   * This will produce:<div class="lcp_excerpt">The content</div>
   */
  $lcp_display_output .= $this->get_excerpt($post, 'div', 'lcp_excerpt');

  // Show Tags:
  $lcp_display_output .= '<div class="slider-item-tags">';
  $lcp_display_output .= get_the_tag_list('', ', ', '<br>');
  $lcp_display_output .= '</div>';

  // Get Posts "More" link:
  $lcp_display_output .= $this->get_posts_morelink($post);

  // Close Div Tag
  $lcp_display_output .= '</div>';

  // Close New Slide After Every 4 Posts
  if ($post_index == 3 || $post_index == 7 || $post_index == 11 || $post_index == 15) {
  	$lcp_display_output .= '</div>';
  }

  // Increment Post Index
  $post_index++;
endwhile;

// Close the wrapper at the beginning:
$lcp_display_output .= '</div>';

// If there's a "more link", show it:
$lcp_display_output .= $this->get_morelink();

// Get category posts count
$lcp_display_output .= $this->get_category_count();

// Pagination
$lcp_display_output .= $this->get_pagination();

$this->lcp_output = $lcp_display_output;