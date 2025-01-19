<?php
// Characters
$chars = array(
	'Baraka',
	'Cassie Cage',
	'Cetrion',
	'Dvorah',
	'Erron Black',
	'Frost',
	'Fujin',
	'Geras',
	'Jacqui Briggs',
	'Jade',
	'Jax Briggs',
	'Johnny Cage',
	'The Joker',
	'Kabal',
	'Kano',
	'Kitana',
	'Kollector',
	'Kotal Kahn',
	'Kung Lao',
	'Liu Kang',
	'Mileena',
	'Nightwolf',
	'Noob Saibot',
	'Raiden',
	'Rain',
	'Rambo',
	'RoboCop',
	'Scorpion',
	'Shang Tsung',
	'Shao Kahn',
	'Sheeva',
	'Sindel',
	'Skarlet',
	'Sonya',
	'Spawn',
	'Sub-Zero',
	'The Terminator'
);

// Categories
$cats = array(
	'baraka' => 6,
	'cassie-cage' => 7,
	'cetrion' => 8,
	'dvorah' => 9,
	'erron-black' => 10,
	'frost' => 11,
	'fujin' => 142,
	'geras' => 12,
	'jacqui-briggs' => 13,
	'jade' => 14,
	'jax-briggs' => 15,
	'johnny-cage' => 16,
	'the-joker' => 138,
	'kabal' => 17,
	'kano' => 18,
	'kitana' => 19,
	'kollector' => 20,
	'kotal-kahn' => 21,
	'kung-lao' => 22,
	'liu-kang' => 23,
	'mileena' => 154,
	'nightwolf' => 95,
	'noob-saibot' => 24,
	'raiden' => 25,
	'rain' => 158,
	'rambo' => 162,
	'robocop' => 144,
	'scorpion' => 5,
	'shang-tsung' => 39,
	'shao-kahn' => 26,
	'sheeva' => 143,
	'sindel' => 98,
	'skarlet' => 27,
	'sonya' => 28,
	'spawn' => 101,
	'sub-zero' => 29,
	'the-terminator' => 134
);
?>

<?php // Table of Contents ?>
<div id="toc_container">
<p class="toc_title" style="font-weight: bold;">Table of Kontents</p>
<ul class="toc_list">
<li><details open><summary><a href="https://www.mk11.kombatakademy.com/">1 Introduction</a></summary>
	<ul>
		<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/general/mortal-kombat-11-how-to-play/">Mortal Kombat 11: How to Play</a>
			<div class="mk11_toc_tags">
				<?php echo get_the_tag_list('', ', ', '<br>', 2079); ?>
			</div>
		</li>
		<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/controls/">Controls</a></li>
		<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/glossary/">Glossary</a></li>
		<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/frame-data-tutorial">Frame Data Tutorial</a>
			<div class="mk11_toc_tags">
				<?php echo get_the_tag_list('', ', ', '<br>', 3948); ?>
			</div>
		</li>
		<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/general/mortal-kombat-11-general-frame-data-information/">Mortal Kombat 11 General Frame Data Information</a>
			<div class="mk11_toc_tags">
				<?php echo get_the_tag_list('', ', ', '<br>', 6303); ?>
			</div>
		</li>
	</ul>
</details></li>
<li><details open><summary><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/general/">2 General</a></summary>
<?php echo do_shortcode('
	[catlist template=mk11-table-of-contents orderby=title order=asc id=34 excludeposts=2079,3948,6303]
'); ?>
</details></li>

<?php
for ($char_index = 0, $char_index_alt = 3; $char_index <= sizeof($chars) - 1; $char_index++, $char_index_alt++) {
	// Category ID
	$cats_values = array_values($cats);
	$cat_id = $cats_values[$char_index];

	// Slug
	$slug_keys = array_keys($cats);
	$slug = $slug_keys[$char_index];

	// Get Character
	$character = $chars[$char_index];

	// Sets $character for Characters with Single Quotes
	if ($character == 'Dvorah') { $character = "D'Vorah"; }
?>

<li><details><summary><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/<?php echo $slug ?>/"><?php echo $char_index_alt . ' ' . $character ?></a></summary>
	<ul>

	<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/<?php echo $slug ?>/#move-list"><?php echo $char_index_alt ?>.1 Move List</a></li>
	<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/<?php echo $slug ?>/#strategy"><?php echo $char_index_alt ?>.2 Strategy</a></li>
	<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/<?php echo $slug ?>/#abilities-list"><?php echo $char_index_alt ?>.3 Abilities</a></li>
	<li><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/<?php echo $slug ?>/#variations"><?php echo $char_index_alt ?>.4 Variations</a></li>
	<li><details open><summary><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/<?php echo $slug ?>/#extra-guides"><?php echo $char_index_alt ?>.5 Extra Guides</a></summary>
		<?php echo do_shortcode('
		[catlist template=mk11-table-of-contents orderby=title order=asc id='.$cat_id.' child_categories=false tags=beginner]
		[catlist template=mk11-table-of-contents orderby=title order=asc id='.$cat_id.' child_categories=false tags=advanced]
		'); ?>
	</details></li>
	</ul>
</details></li>
<?php }; ?>

</ul>
</div>