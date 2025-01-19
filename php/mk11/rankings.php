<?php
$category = '';
$dir = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/';
$ext = 'jpg';
$ver = '1.28';
$count_char = 'scorpion'; // Default Character to Count
if(isset($_GET['category'])) { $category = $_GET['category']; }
if(isset($_GET['ver'])) { $ver = $_GET['ver']; }

if (!$category) { ?>

<div class="box-container">
	<div class="box"><a href="?category=community">Community Rankings</a></div>
	<div class="box"><a href="?category=competitive">Competitive Rankings</a></div>
</div>

<?php
}

if ($category == 'community' || $category == 'competitive') {

$rank_colors = array(
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
	'rgba(255,0,125,.25)' // Raspberry
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

// Get Result
$result = mysqli_query($db, $query) or die("Error querying database.");

// Set Color Index
$index = 0;
?>

<div id="rankings-info">The following is a list of character rankings based on the cumulative average of <?php echo $total ?> tier lists by <?php echo $category ?> players. <?php if ($category == 'community') { ?>To add your own scores to the Community Rankings, use the <a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-maker/">Tier Maker</a> and submit a tier list.<?php } else { ?>Scores are taken from the <a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=competitive">Competitive Tier Lists</a> page.<?php } ?></div>

<div id="rankings-title-container">
	<div id="rankings-title">Character Rankings<br><?php echo ucfirst($category) ?></div>
	<div id="rankings-version">Version <?php echo $ver ?></div>
</div>

<div id="rankings-container">
	<div id="rankings-header">
		<div id="rankings-header-rank">Rank</div>
		<div id="rankings-header-character">Character</div>
		<div id="rankings-header-rating">Rating</div>
	</div>
	<?php while ($row = mysqli_fetch_array($result)) {
		// Replace spaces with hyphens and lowercase first letter of each word
		$character = strtolower(str_replace(' ', '-', $row['name']));
		$percentage = $row['rating'] * 100; ?>

		<div class="rank-container">
			<div class="rank-number"><?php echo $row['ranking'] ?></div>
			<div class="rank">
				<div class="character-container">
					<img id="<?php echo $row['name'] ?>" class="character lazyloaded" src="<?php echo $dir . $character ?>.<?php echo $ext ?>" loading="lazy">
				</div>
				<div class="rating" style="background: <?php echo $rank_colors[$index] ?>; width: <?php echo $percentage ?>%"><?php echo $row['rating'] ?></div>
			</div>
		</div>

		<?php
		// Loop back to beginning color
		if ($index == count($rank_colors) - 1) { $index = 0; } else { $index++; }
	} ?>
</div>

<?php
// Close Database
mysqli_close($db);
}