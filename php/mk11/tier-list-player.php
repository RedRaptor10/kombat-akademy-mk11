<?php
$category = '';
$id = '';
$dir = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/';
$ext = 'jpg';

if(isset($_GET['category'])) { $category = $_GET['category']; }
if(isset($_GET['id'])) { $id = $_GET['id']; }

// Get Server, Database, Username, and Password
$servername = "";
$database = "";
$username = "";
$password = "";

// Create Connection
$db = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$db) { die("Connection failed: " . mysqli_connect_error()); }

// Select Query
$query = '';
if ($category == 'community') {
	$query = "SELECT * FROM community WHERE id='$id'";
} else if ($category == 'competitive') {
	$query = "SELECT * FROM competitive WHERE id='$id'";
} else { exit(); }

// Get Result
$result = mysqli_query($db, $query) or die("Error querying database.");

// Fetch Data
$row = mysqli_fetch_assoc($result);

// Exit on Error
if (!$row) { exit(); }

// Decode JSON Object to Array
$tier_list = json_decode($row['tier_list'], true);

// Convert Date from YYYY-MM-DD to MM-DD-YYYY
$date = DateTime::createFromFormat('Y-m-d', $row['date'])->format('m-d-Y');

?>

<div id="tier-lists-player-container" style="background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)), url('<?php echo $tier_list['background'] ?>'); background-size: cover; background-repeat: no-repeat;">
	<div id="tier-list-header">
		<div id="tier-list-title"><?php echo $tier_list['title'] ?></div>
		<div id="tier-list-description"><?php echo $tier_list['description'] ?></div>
	</div>
	<div id="tier-list">
	<?php
	foreach ($tier_list['tiers'] as $tier) { ?>
		<div class="tier">
			<div class="tier-header-container" style="background: <?php echo $tier['color'] ?>">
				<div class="tier-header">
					<div class="tier-title"><?php if ($tier['title']) { echo $tier['title']; } ?></div>
					<div class="tier-description"><?php if ($tier['description']) { echo $tier['description']; } ?></div>
				</div>
			</div>
			<div class="list">
				<?php foreach ($tier['list'] as $character) { ?><img id="<?php echo $character ?>" class="character lazyloaded" src="<?php echo $dir . $character ?>.<?php echo $ext ?>"><?php } ?>
			</div>
		</div>
	<?php
	} ?>
	</div>
</div>
<div id="tier-lists-player-info">
	<div id="tier-lists-player"><?php echo $row['name'] ?></div>
	<div id="tier-lists-player-date"><?php echo str_replace('-', '/', $date) ?></div>
	<div id="tier-lists-player-version">Version <?php echo $row['version'] ?></div>
</div>

<?php
// Close Database
mysqli_close($db);
?>