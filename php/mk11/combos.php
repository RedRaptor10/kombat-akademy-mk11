<?php
	// Default Values
	$character = '';
	$variation = '';
	$difficulty = 'beginner';
	$category = 'midscreen';

	// Character Slug and Name
	// $slug = get_page($post->post_parent)->post_name;
	if(isset($_GET['character'])) { $character = $_GET['character']; }
	$slug = $character;
	$snake = str_replace('-', '_', $character);
	$character = ucwords(str_replace('-', ' ', $character));

	if ($slug == 'robocop') { $character = 'RoboCop'; }
	else if ($slug == 'sub-zero') { $character = 'Sub-Zero'; }

	// Variation
	//$variation = get_the_category()[0]->name;
	if(isset($_GET['variation'])) { $variation = $_GET['variation']; }
	$variation_slug = $variation;
	$variation = str_replace('-', ' ', $variation);
	$variation = ucwords($variation);

	// Handle variations with hyphens
	if ($variation == 'Fan Fare' || $variation == 'Ten Hut') { $variation = str_replace(' ', '-', $variation); }

	// Handle variations with single quotes
	if ($variation == 'Grinnin Barrett') { $variation = "Grinnin' Barrett"; }
	if ($variation == 'Locked N Loaded') { $variation = "Locked n' Loaded"; }

	// Difficulty
	// $difficulty_slug = get_the_tags()[0]->slug;
	if(isset($_GET['difficulty'])) { $difficulty = $_GET['difficulty']; }

	// Category
	if(isset($_GET['category'])){ $category = $_GET['category']; }

	// Get Server, Database, Username, and Password
	$servername = "";
	$database = "";
	$database_variations = "";
	$database_abilities = "";
	$username = "";
	$password = "";

	// Create Connection
	$db = mysqli_connect($servername, $username, $password, $database);
	$db_variations = mysqli_connect($servername, $username, $password, $database_variations);
	$db_abilities = mysqli_connect($servername, $username, $password, $database_abilities);

	// Check Connection
	if (!$db || !$db_variations || !$db_abilities) { die("Connection failed: " . mysqli_connect_error()); }

	// Handle single quotes and ampersand in variation
	$variation = mysqli_real_escape_string($db, $variation);
	$variation = str_replace('&amp;', '&', $variation);

	// Select Query
	$query1 = "SELECT * FROM $snake" . "__" . "$difficulty WHERE variation='$variation' AND category='Midscreen'";
	$query2 = "SELECT * FROM $snake" . "__" . "$difficulty WHERE variation='$variation' AND category='Corner'";
	$query3 = "SELECT * FROM variations WHERE char_name='$character' AND variation='$variation'";
	$query4 = "SELECT * FROM $snake";

	// Get Results
	$result1 = mysqli_query($db, $query1) or die("");
	$result2 = mysqli_query($db, $query2) or die("");
	$result3 = mysqli_query($db_variations, $query3) or die("");
	$result4 = mysqli_query($db_abilities, $query4) or die("");

	// Fetch Data
	$combos_midscreen = mysqli_fetch_all($result1, MYSQLI_ASSOC);
	$combos_corner = mysqli_fetch_all($result2, MYSQLI_ASSOC);
	$variation_array = mysqli_fetch_assoc($result3);
	$abilities_array = mysqli_fetch_all($result4, MYSQLI_ASSOC);

	// Replace With Notations
	foreach ($combos_midscreen as $row => $value) {
		$combos_midscreen[$row]['subcategory'] = do_shortcode('[notation]' . $value['subcategory'] . '[/notation]');
		$combos_midscreen[$row]['combo'] = do_shortcode('[notation]' . $value['combo'] . '[/notation]');
	}
	foreach ($combos_corner as $row => $value) {
		$combos_corner[$row]['subcategory'] = do_shortcode('[notation]' . $value['subcategory'] . '[/notation]');
		$combos_corner[$row]['combo'] = do_shortcode('[notation]' . $value['combo'] . '[/notation]');
	}

	// Set JavaScript Combo Arrays
	echo '<script>let combosMidscreen = ' . json_encode($combos_midscreen) .';</script>';
	echo '<script>let combosCorner = ' . json_encode($combos_corner) .';</script>';

	// Set Image Paths
	$characters_path = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/characters/';
	$abilities_path = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/abilities/';

	// Convert String to Slug
	$ability_1_slug = slugify($variation_array['ability_1']);
	$ability_2_slug = slugify($variation_array['ability_2']);
	$ability_3_slug = slugify($variation_array['ability_3']);

	// Get Ability Position
	$ability_1_pos = searchAbilities($variation_array['ability_1'], $abilities_array);
	$ability_2_pos = searchAbilities($variation_array['ability_2'], $abilities_array);
	$ability_3_pos = searchAbilities($variation_array['ability_3'], $abilities_array);

	// Rename Specific Abilities
	$ability_1_slug = rename_ability($slug, $ability_1_slug);
	$ability_2_slug = rename_ability($slug, $ability_2_slug);
	$ability_3_slug = rename_ability($slug, $ability_3_slug);
?>

<div id="variation">
	<div class="variation-character" style="background: url('<?php echo $characters_path . $slug ?>.png')"></div>
	<div class="variation-abilities">
		<div class="abilities-container">
			<table>
				<tr><td><div>
				<div class="ability-header"><div><?php echo $variation_array['ability_1'] ?></div><div><?php echo do_shortcode('[notation]' . $abilities_array[$ability_1_pos]['input'] . '[/notation]'); ?></div></div>
				<div class="ability-main"><div><img src="<?php echo $abilities_path . $ability_1_slug ?>.png"></div><div><?php echo $abilities_array[$ability_1_pos]['description'] ?></div></div>
				</div></td></tr>

				<?php if ($variation_array['ability_2']) { // Check if ability is not empty ?>
				<tr><td><div>
				<div class="ability-header"><div><?php echo $variation_array['ability_2'] ?></div><div><?php echo do_shortcode('[notation]' . $abilities_array[$ability_2_pos]['input'] . '[/notation]'); ?></div></div>
				<div class="ability-main"><div><img src="<?php echo $abilities_path . $ability_2_slug ?>.png"></div><div><?php echo $abilities_array[$ability_2_pos]['description'] ?></div></div>
				</div></td></tr>
				<?php } ?>

				<?php if ($variation_array['ability_3']) { // Check if ability is not empty ?>
				<tr><td><div>
				<div class="ability-header"><div><?php echo $variation_array['ability_3'] ?></div><div><?php echo do_shortcode('[notation]' . $abilities_array[$ability_3_pos]['input'] . '[/notation]'); ?></div></div>
				<div class="ability-main"><div><img src="<?php echo $abilities_path . $ability_3_slug ?>.png"></div><div><?php echo $abilities_array[$ability_3_pos]['description'] ?></div></div>
				</div></td></tr>
				<?php } ?>
		</table></div>
	</div>
</div>

<?php // Combos ?>
<div id="combo-list-container">
<div id="combo-category-container">
	<div class="combo-category" id="midscreen">MIDSCREEN</div>
	<div class="combo-category" id="corner">CORNER</div>
</div>

<div id="tag-list"></div>

<table id="combo-list"></table>
</div>

<?php
// Close Database
mysqli_close($db);
mysqli_close($db_variations);
mysqli_close($db_abilities);
?>

<?php
// Search Multidimensional Array
function searchAbilities($ability, $array) {
	// Loop through rows
	foreach ($array as $key => $val) {
		// If row's 'ability' column is equal to searched ability, return row position
		if ($val['ability'] == $ability) {
			return $key;
		}
	}
	return null;
}

// Convert String to Slug
function slugify($text) {
	// Remove single quotes and dots
	$text = preg_replace("/['\.]/", '', $text);

	// Replace non letter or digits with '-'
	$text = preg_replace('~[^\pL\d]+~u', '-', $text);

	// Transliterate
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	// Remove unwanted characters
	$text = preg_replace('~[^-\w]+~', '', $text);

	// Trim
	$text = trim($text, '-');

	// Remove duplicate '-'
	$text = preg_replace('~-+~', '-', $text);

	// Convert to lowercase
	$text = strtolower($text);

	if (empty($text)) {
		return '';
	}

	return $text;
}

function rename_ability($slug, $ability) {
	$new_slug = $ability;

	if ($slug == 'cassie-cage' && $ability == 'flippin-out') { $new_slug = 'flippin-out-1'; }
	else if ($slug == 'cetrion' && $ability == 'deadly-winds') { $new_slug = 'deadly-winds-1'; }
	else if ($slug == 'dvorah' && $ability == 'flippin-out') { $new_slug = 'flippin-out-2'; }
	else if ($slug == 'jax-briggs' && $ability == 'ground-shatter') { $new_slug = 'ground-shatter-1'; }
	else if ($slug == 'mileena' && $ability == 'rolling-thunder') { $new_slug = 'rolling-thunder-1'; }
	else if ($slug == 'rain' && $ability == 'wave-dash') { $new_slug = 'wave-dash-banned'; }
	else if ($slug == 'shao-kahn' && $ability == 'ground-shatter') { $new_slug = 'ground-shatter-2'; }

	return $new_slug;
}
?>