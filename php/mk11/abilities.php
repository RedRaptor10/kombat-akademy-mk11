<?php
/* Reads abilities from database and outputs to screen. */

// Slug
$slug = get_post_field('post_name');
$snake = str_replace('-', '_', $slug);

// Get Server, Database, Username, and Password
$servername = "";
$database = '';
$username = '';
$password = '';

// Create Connection
$db = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$db) { die("Connection failed: " . mysqli_connect_error()); }

// Select Query
$query = "SELECT * FROM $snake";

// Get Result
$result = mysqli_query($db, $query) or die("Error querying database.");

// Fetch Array
$array = mysqli_fetch_all($result);

// Get Total Rows
$total = sizeof($array);

// Free Result Set
mysqli_free_result($result);

// Get Result
$result = mysqli_query($db, $query) or die("Error querying database.");
?>

<h1 id="abilities-list">Abilities</h1>
<hr class="hr_title">
<div class="abilities-container">
<table>
<?php
$index = 1;
$abilities_path = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/abilities/';

// Fetch Result Set
while ($row = mysqli_fetch_array($result)) {
	// Convert String to Slug
	$ability_slug = slugify($row['ability']);

	// Rename Specific Abilities
	$ability_slug = rename_ability($slug, $ability_slug);
?>
	<tr><td><div>
		<div class="ability-header"><div><?php echo $row['ability'] ?></div><div><?php echo do_shortcode('[notation]' . $row['input'] .'[/notation]'); ?></div></div>
		<div class="ability-main"><div><img src="<?php echo $abilities_path . $ability_slug ?>.png"></div><div><?php echo $row['description'] ?></div></div>
	</div></td></tr>
<?php
	// If index is half of total, create new table
	if (($index == round($total / 2)) && ($total > 3)) {
?>
		</table>
		<table>
<?php
	}
	$index++;
}
?>
</table>
</div>

<?php mysqli_close($db); ?>

<?php
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