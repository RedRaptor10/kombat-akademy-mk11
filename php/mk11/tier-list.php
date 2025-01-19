<?php
$category = 'community';
$ver = '1.28';
$dir = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/';
$ext = 'jpg';
$count_char = 'scorpion'; // Default Character to Count

if(isset($_GET['category'])) { $category = $_GET['category']; }
if(isset($_GET['ver'])) { $ver = $_GET['ver']; }

$tier_letters = array('S', 'A', 'B', 'C', 'D', 'F');
$tier_ratings = array(1.1, 0.8, 0.6, 0.4, 0.2, 0.0);
$tier_colors = array(
	'rgba(255,0,0,.25)', // Red
	'rgba(255,125,0,.25)', // Orange
	'rgba(255,255,0,.25)', // Yellow
	'rgba(125,255,0,.25)', // Spring Green
	'rgba(0,255,0,.25)', // Green
	'rgba(0,255,125,.25)', // Turquoise
	'rgba(0,255,255,.25)', // Cyan
	'rgba(0,125,255,.25)', // Ocean
	'rgba(0,0,255,.25)', // Blue
	'rgba(125,0,255,.25)', // Violet
	'rgba(255,0,255,.25)', // Magenta
	'rgba(255,0,125,.25)', // Raspberry
	'rgba(255,255,255,.25)', // White
	'rgba(125,125,125,.25)', // Gray
	'rgba(0,0,0,.25)' // Black
);

$backgrounds = array(
	'Default' => 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/default-background.jpg',
	'Mortal Kombat 11' => 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/mk11-cover-background.jpg',
	'Aftermath' => 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/aftermath-background.jpg',
	'Aftermath 2' => 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/aftermath-background-alt.jpg',
	'Ultimate' => 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/ultimate-background.jpg',
	'Empty' => 'rgb(16,16,16)'
);

// Get Server, Database, Username, and Password
$servername = "";
if ($category == 'community') {
	$database = "";
} else if ($category == 'competitive') {
	$database = "";
}
$username = "";
$password = "";

// Create Connection
$db = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$db) { die("Connection failed: " . mysqli_connect_error()); }

// Get Total Scores
$query = "SELECT COUNT(*) FROM $count_char WHERE version='$ver'";
$result = mysqli_query($db, $query) or die("Error querying database.");
$total = mysqli_fetch_row($result)[0];

// Select Query
$query = "SELECT * FROM avg WHERE version='$ver' ORDER BY rating DESC";

?>

<div id="tier-list-info">The following tier list is based on the cumulative average of <?php echo $total ?> tier lists by <?php echo $category ?> players. <?php if ($category == 'community') { ?>To add your own scores to the Community Tier List, use the <a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-maker/">Tier Maker</a> and submit a tier list.<?php } else { ?>Scores are taken from the <a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=competitive">Competitive Tier Lists</a> page.<?php } ?></div>

<div id="tier-lists-container">
	<div id="tier-list-header">
		<div id="tier-list-title">MORTAL KOMBAT 11<br><?php echo strtoupper($category) ?> TIER LIST</div>
		<div id="tier-list-description" style="display: unset;">Version <?php echo $ver ?></div>
	</div>
	<div id="tier-list">
	<?php
	for ($index = 0; $index < 5; $index++) {
		// Get Result
		$result = mysqli_query($db, $query) or die("Error querying database."); ?>
		<div class="tier">
			<div class="tier-header-container" style="background: <?php echo $tier_colors[$index] ?>">
				<div class="tier-header">
					<div class="tier-title"><?php echo $tier_letters[$index]; ?></div>
				</div>
			</div>
			<div class="list">
				<?php while ($row = mysqli_fetch_array($result)) {
					if ($row['rating'] < $tier_ratings[$index] && $row['rating'] >= $tier_ratings[$index + 1]) {
						// Replace spaces with hyphens and lowercase first letter of each word
						$character = strtolower(str_replace(' ', '-', $row['name'])); ?><img id="<?php echo $row['name'] ?>" class="character lazyloaded" src="<?php echo $dir . $character ?>.<?php echo $ext ?>"><?php }
					}
				// Free Result Set
				mysqli_free_result($result); ?>
			</div>
		</div>
	<?php
	} ?>
	</div>
</div>

<?php
// Close Database
mysqli_close($db);
?>