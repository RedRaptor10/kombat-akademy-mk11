<?php
$url = 'https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists/tier-list';

// Get Server, Database, Username, and Password
$servername = "";
$database = "";
$username = '';
$password = '';

// Create Connection
$db = mysqli_connect($servername, $username, $password, $database);

// Check Connection
if (!$db) { die("Connection failed: " . mysqli_connect_error()); }

// Select Query
$query = '';
$query_community = "SELECT * FROM community ORDER BY id DESC LIMIT 5";
$query_competitive = "SELECT * FROM competitive ORDER BY id DESC LIMIT 5";

// Get Result
$result_community = mysqli_query($db, $query_community) or die("Error querying database.");
$result_competitive = mysqli_query($db, $query_competitive) or die("Error querying database.");
?>

<div id="home-tier-lists">
<div class="home-tier-lists-category">
<table class="home-tier-lists">
	<tr><th class="home-tier-lists-header" colspan="2"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=community">COMMUNITY</a></th></tr>
	<tr>
		<th class="home-tier-lists-name-header">Name</th>
		<th class="home-tier-lists-date-header">Date</th>
	</tr>
	<?php while ($row = mysqli_fetch_array($result_community)) {
		// Convert Date from YYYY-MM-DD to MM-DD-YYYY
		$date = DateTime::createFromFormat('Y-m-d', $row['date'])->format('m-d-Y');
		$date = str_replace('-', '/', $date); ?>

		<tr>
			<td class="home-tier-lists-name">
				<a href="<?php echo $url . '?category=community' . '&id=' . $row['id'] ?>">
					<?php echo $row['name'] ?>
				</a>
			</td>
			<td class="home-tier-lists-date"><?php echo $date ?></td>
		</tr>
	<?php
	} ?>
</table>
</div>
<div class="home-tier-lists-category">
<table class="home-tier-lists">
	<tr><th class="home-tier-lists-header" colspan="2"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=competitive">COMPETITIVE</a></th></tr>
	<tr>
		<th class="home-tier-lists-name-header">Name</th>
		<th class="home-tier-lists-date-header">Date</th>
	</tr>
	<?php while ($row = mysqli_fetch_array($result_competitive)) {
		// Convert Date from YYYY-MM-DD to MM-DD-YYYY
		$date = DateTime::createFromFormat('Y-m-d', $row['date'])->format('m-d-Y');
		$date = str_replace('-', '/', $date); ?>

		<tr>
			<td class="home-tier-lists-name">
				<a href="<?php echo $url . '?category=competitive' . '&id=' . $row['id'] ?>">
					<?php echo $row['name'] ?>
				</a>
			</td>
			<td class="home-tier-lists-date"><?php echo $date ?></td>
		</tr>
	<?php
	} ?>
</table>
</div>
</div>

<?php
// Close Database
mysqli_close($db);
?>