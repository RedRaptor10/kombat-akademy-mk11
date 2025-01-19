<?php
$dir = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/';
$ext = 'jpg';
$ver = '1.28';

// Get Server, Database, Username, and Password
$servername = "";
$database_community = "";
$database_competitive = "";
$username = '';
$password = '';

// Create Connection
$db_community = mysqli_connect($servername, $username, $password, $database_community);
$db_competitive = mysqli_connect($servername, $username, $password, $database_competitive);

// Check Connection
if (!$db_community) { die("Connection failed: " . mysqli_connect_error()); }
if (!$db_competitive) { die("Connection failed: " . mysqli_connect_error()); }

// Select Query
$query = "SELECT * FROM avg WHERE version='$ver' ORDER BY rating DESC LIMIT 10";

// Get Result
$result_community = mysqli_query($db_community, $query) or die("Error querying database.");
$result_competitive = mysqli_query($db_competitive, $query) or die("Error querying database.");
?>

<div id="home-rankings">
<div class="home-rankings-category">
<table class="home-rankings">
	<tr><th class="home-rankings-header" colspan="4"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/rankings?category=community">COMMUNITY</a></th></tr>
	<tr>
		<th class="home-rankings-rank-header">Rank</th>
		<th class="home-rankings-character-header" colspan="2">Character</th>
		<th class="home-rankings-rating-header">Rating</th>
	</tr>
	<?php while ($row = mysqli_fetch_array($result_community)) {
		// Replace hyphens with spaces and capitalize first letter of each word
		$character = strtoupper(str_replace('-', ' ', $row['name']));

		if ($row['name'] == 'dvorah') { $character = "D'VORAH"; }
		else if ($row['name'] == 'sub-zero') { $character = 'SUB-ZERO'; } ?>
	<tr><td class="home-rankings-rank"><?php echo $row['ranking'] ?></td><td class="home-rankings-character-image-container"><img class="home-rankings-character-image" src="<?php echo $dir . $row['name'] ?>.<?php echo $ext ?>"></td><td class="home-rankings-character-name"><?php echo $character ?></td><td class="home-rankings-rating"><?php echo $row['rating'] ?></td></tr>
	<?php
	} ?>
</table>
</div>
<div class="home-rankings-category">
<table class="home-rankings">
	<tr><th class="home-rankings-header" colspan="4"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/rankings?category=competitive">COMPETITIVE</a></th></tr>
	<tr>
		<th class="home-rankings-rank-header">Rank</th>
		<th class="home-rankings-character-header" colspan="2">Character</th>
		<th class="home-rankings-rating-header">Rating</th>
	</tr>
	<?php while ($row = mysqli_fetch_array($result_competitive)) {
		// Replace hyphens with spaces and capitalize first letter of each word
		$character = strtoupper(str_replace('-', ' ', $row['name']));

		if ($row['name'] == 'dvorah') { $character = "D'VORAH"; }
		else if ($row['name'] == 'sub-zero') { $character = 'SUB-ZERO'; } ?>
	<tr><td class="home-rankings-rank"><?php echo $row['ranking'] ?></td><td class="home-rankings-character-image-container"><img class="home-rankings-character-image" src="<?php echo $dir . $row['name'] ?>.<?php echo $ext ?>"></td><td class="home-rankings-character-name"><?php echo $character ?></td><td class="home-rankings-rating"><?php echo $row['rating'] ?></td></tr>
	<?php
	} ?>
</table>
</div>
</div>

<?php
// Close Database
mysqli_close($db_community);
mysqli_close($db_competitive);
?>