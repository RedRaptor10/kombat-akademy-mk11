<?php
/*
Plugin Name: List Category Posts - Template "List"
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

//Add 'starting' tag. Here, I'm using an unordered list (ul) as an example:
//$lcp_display_output .= '<ul class="lcp_catlist">';

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
global $post;
while ( have_posts() ):
  the_post();

  $post_id = get_the_ID();

  // Start a List Item for each post:
  $lcp_display_output .= '<div class="list-item">';

  // Post Thumbnail
  $lcp_display_output .= '<div class="list-item-thumb-container">';
  $lcp_display_output .= $this->get_thumbnail($post, 'img', 'list-item-thumb');

  // Post Default Thumbnail
  if (!has_post_thumbnail()) {
    $lcp_display_output .= '<a href="' . get_permalink($post_id) . '" title="' . esc_attr(get_the_title($post_id)) . '">
    <img class="list-item-thumb" src="https://www.mk11.kombatakademy.com/wp-content/uploads/images/default-thumb.jpg"></a>';
  }
 
  $lcp_display_output .= '</div>';

  $lcp_display_output .= '<div class="list-item-details">';

  // Show the title and link to the post:
  $lcp_display_output .= $this->get_post_title($post, 'h2', 'list-item-title');

  // Metadata
  $lcp_display_output .= '<div class="list-item-meta">';

  // Show date:
  $lcp_display_output .= '<a href="' . get_permalink($post_id) . '" title="' . esc_attr(get_the_title($post_id)) . '">
  <span class="list-item-date">' . $this->get_date($post) . '</span></a>';

  // Show date modified:
  $lcp_display_output .= '<a href="' . get_permalink($post_id) . '" title="' . esc_attr(get_the_title($post_id)) . '">
  <span class="list-item-modified-date">' . $this->get_modified_date($post) . '</span></a>';

  // Show comments:
  $lcp_display_output .= '<a href="' . get_permalink($post_id) . '#comments" title="' . esc_attr(get_the_title($post_id)) . '">
  <span class="list-item-comments">' . str_replace(array('(', ')'), '', $this->get_comments($post)) . ' Comments</span></a>';

  // Show tags:
  $lcp_display_output .= '<span class="list-item-tags">' . get_the_tag_list('', ', ') . '</span>';

  // Show author
  $lcp_display_output .= $this->get_author($post);

  $lcp_display_output .= '</div>';

  // Custom fields:
  $lcp_display_output .= $this->get_custom_fields($post);

  // Show content
  $lcp_display_output .= $this->get_content($post, 'p', 'list-item-content');

  // Show excerpt
  $lcp_display_output .= $this->get_excerpt($post, 'div', 'list-item-excerpt');

  // Get Posts "More" link:
  $lcp_display_output .= $this->get_posts_morelink($post);

  $lcp_display_output .= '</div>';

  // Close li tag
  //$lcp_display_output .= '</li>';
  $lcp_display_output .= '</div>';
endwhile;

// Close the wrapper I opened at the beginning:
//$lcp_display_output .= '</ul>';

// If there's a "more link", show it:
$lcp_display_output .= $this->get_morelink();

// Get category posts count
$lcp_display_output .= $this->get_category_count();

// Pagination
$lcp_display_output .= $this->get_pagination();

$this->lcp_output = $lcp_display_output;