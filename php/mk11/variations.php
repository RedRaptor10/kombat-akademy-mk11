<?php
/* Reads variations from database and outputs to screen. */

// Slug & Snake
$slug = get_post_field('post_name');
$snake = str_replace('-', '_', $slug);

// Character
$character = the_title('', '', false);

if ($slug == 'dvorah') { $character = "DVorah"; }

// Get Server, Database, Username, and Password
$servername = "";
$database1 = ""; // Variations
$database2 = ""; // Abilities
$username = "";
$password = "";

// Create Connection
$db1 = mysqli_connect($servername, $username, $password, $database1);
$db2 = mysqli_connect($servername, $username, $password, $database2);

// Check Connection
if (!$db1 || !$db2) { die("Connection failed: " . mysqli_connect_error()); }

// Select Query
$query1 = "SELECT * FROM variations WHERE char_name='$character'";
$query2 = "SELECT * FROM $snake";

// Get Result
$result1 = mysqli_query($db1, $query1) or die("Error querying database.");
$result2 = mysqli_query($db2, $query2) or die("Error querying database.");

// Fetch Array
$variations_array = mysqli_fetch_all($result1);
$abilities_array = mysqli_fetch_all($result2, MYSQLI_ASSOC); // Use MYSQLI_ASSOC to include column names

// Get Total Rows
$total = sizeof($variations_array);

// Free Result Set
mysqli_free_result($result1);

// Get Result
$result1 = mysqli_query($db1, $query1) or die("Error querying database.");
?>

<div id="variations-container">
<?php
$path = 'https://www.mk11.kombatakademy.com/mortal-kombat-11/';
$characters_path = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/characters/';
$abilities_path = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/abilities/';

// Fetch Result Set
while ($row = mysqli_fetch_array($result1)) {
	// Convert String to Slug
	$variation_slug = slugify($row['variation']);
	$ability_1_slug = slugify($row['ability_1']);
	$ability_2_slug = slugify($row['ability_2']);
	$ability_3_slug = slugify($row['ability_3']);

	// Get Ability Position
	$ability_1_pos = searchAbilities($row['ability_1'], $abilities_array);
	$ability_2_pos = searchAbilities($row['ability_2'], $abilities_array);
	$ability_3_pos = searchAbilities($row['ability_3'], $abilities_array);

	// Rename Specific Abilities
	$ability_1_slug = rename_ability($slug, $ability_1_slug);
	$ability_2_slug = rename_ability($slug, $ability_2_slug);
	$ability_3_slug = rename_ability($slug, $ability_3_slug);
?>
	<div class="variation-title"><?php echo $row['variation'] ?></div>
	<div class="variation">
<div class="variation-character" style="background: url('<?php echo $characters_path . $slug ?>.png')">
<div class="variation-details-container">
		<div class="variation-details">
			<div class="variation-combos-container">
				<div class="variation-combos-button"><a href="<?php echo $path ?>combos?character=<?php echo $slug ?>&variation=<?php echo $variation_slug ?>&difficulty=beginner">Beginner Combos</a></div>
				<div class="variation-combos-button"><a href="<?php echo $path ?>combos?character=<?php echo $slug ?>&variation=<?php echo $variation_slug ?>&difficulty=advanced">Advanced Combos</a></div>
			</div>
			<div class="variation-rating">
			<?php for ($i = 0; $i < $row['rating']; $i++) { // Star Symbol ?>
				&#9733;
			<?php } ?>
			</div>
		</div>
</div>
</div>
		<div class="variation-abilities">
			<div class="abilities-container">
			<table>
				<tr><td><div>
				<div class="ability-header"><div><?php echo $row['ability_1'] ?></div><div><?php echo do_shortcode('[notation]' . $abilities_array[$ability_1_pos]['input'] . '[/notation]'); ?></div></div>
				<div class="ability-main"><div><img src="<?php echo $abilities_path . $ability_1_slug ?>.png"></div><div><?php echo $abilities_array[$ability_1_pos]['description'] ?></div></div>
				</div></td></tr>

				<?php if ($row['ability_2']) { // Check if ability is not empty ?>
				<tr><td><div>
				<div class="ability-header"><div><?php echo $row['ability_2'] ?></div><div><?php echo do_shortcode('[notation]' . $abilities_array[$ability_2_pos]['input'] . '[/notation]'); ?></div></div>
				<div class="ability-main"><div><img src="<?php echo $abilities_path . $ability_2_slug ?>.png"></div><div><?php echo $abilities_array[$ability_2_pos]['description'] ?></div></div>
				</div></td></tr>
				<?php } ?>

				<?php if ($row['ability_3']) { // Check if ability is not empty ?>
				<tr><td><div>
				<div class="ability-header"><div><?php echo $row['ability_3'] ?></div><div><?php echo do_shortcode('[notation]' . $abilities_array[$ability_3_pos]['input'] . '[/notation]'); ?></div></div>
				<div class="ability-main"><div><img src="<?php echo $abilities_path . $ability_3_slug ?>.png"></div><div><?php echo $abilities_array[$ability_3_pos]['description'] ?></div></div>
				</div></td></tr>
				<?php } ?>
			</table></div>
		</div>
	</div>
<?php }
?>
</div>

<?php
mysqli_close($db1);
mysqli_close($db2);
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
?>