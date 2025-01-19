<?php
function video_shortcode($atts = array()) {
	// Default Parameters
	extract(shortcode_atts(array(
		'url' => '',
		'width' => '480px',
		'height' => 'auto',
		'align' => 'left',
		'wrap' => false
	), $atts));

	$gfyvidClass = ''; // Gfycat Video Class
	$styleSize = ''; // Change size if set

	$poster = 'https://thumbs.gfycat.com/' . $url . '-poster.jpg';
	$webm = 'https://giant.gfycat.com/' . $url . '.webm';
	$mp4 = 'https://thumbs.gfycat.com/' . $url . '-mobile.mp4';
	$gif = 'https://giant.gfycat.com/' . $url . '.gif';

	if ($wrap) {
		if ($align == 'left') { $gfyvidClass = 'gfyvidLeftWrap'; }
		else if ($align == 'right') { $gfyvidClass = 'gfyvidRightWrap'; }
	}
	else {
		if ($align == 'left') { $gfyvidClass = 'gfyvidLeft'; }
		else if ($align == 'right') { $gfyvidClass = 'gfyvidRight'; }
	}
	if ($align == 'center') { $gfyvidClass = 'gfyvidCenter'; }

	// If size is not default, set new width & height
	if (($width != '480px') || ($height != 'auto')) {
		$styleSize = 'style="width: ' . $width . '; height: ' . $height . ';"';
	}

	$v =
		'<div class="' . $gfyvidClass . '" ' . $styleSize . '>
		<video autoplay controls loop muted preload="none" style="width: 100%; height: auto;" poster="' . $poster . '">
			<source src="' . $mp4 . '" type="video/mp4">
			<img src="' . $gif . '">
		</video>
		</div>';

	return $v;
}
add_shortcode('gfyvid', 'video_shortcode');
?>