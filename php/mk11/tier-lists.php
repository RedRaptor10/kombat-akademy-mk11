<?php
$category = '';
if(isset($_GET['category'])) { $category = $_GET['category']; }

if (!$category) { ?>

<div class="box-container">
	<div class="box"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-list?category=community">Community<br>Tier List</a></div>
	<div class="box"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-list?category=competitive">Competitive<br>Tier List</a></div>
	<div class="box"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=community">Community<br>Player Tier Lists</a></div>
	<div class="box"><a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=competitive">Competitive<br>Player Tier Lists</a></div>
</div>

<?php
}

if ($category == 'community' || $category == 'competitive') {
	$url = 'https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists/tier-list';
	$page = 1;
	$num_results = 10;
	if(isset($_GET['pg'])) { $page = $_GET['pg']; }
	$index = $page * $num_results - $num_results;

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
		$query = "SELECT * FROM community ORDER BY id DESC LIMIT $index, $num_results";
	} else if ($category == 'competitive') {
		$query = "SELECT * FROM competitive ORDER BY id DESC LIMIT $index, $num_results";
	}

	// Get Result
	$result = mysqli_query($db, $query) or die("Error querying database.");

	// Fetch Data
	$tier_lists = mysqli_fetch_all($result, MYSQLI_ASSOC); // Use MYSQLI_ASSOC to include column names
?>
<h2 id="tier-lists-results-title">
	<?php if ($category == 'community') {
		echo 'Community Tier Lists';
	} else if ($category == 'competitive') {
		echo 'Competitive Tier Lists';
	} ?>
</h2>

<div id="tier-lists-results-info">
	To view the average of all tier lists, see the
	<a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-list?category=<?php echo $category ?>">
		<?php if ($category == 'community') { ?> Community <?php }
		else if ($category == 'competitive') { ?> Competitive <?php } ?>Tier List</a>.
</div>

<table id="tier-lists-results">
<tr><th>Name</th><th>Type</th><th>Version</th><th>Date</th></tr>
<?php
	foreach ($tier_lists as $tier_list) {
		// Check if Last Page
		if ($tier_list['id'] == '1') { $page_last = true; }

		// Convert Date from YYYY-MM-DD to MM-DD-YYYY
		$date = DateTime::createFromFormat('Y-m-d', $tier_list['date'])->format('m-d-Y');
		$date = str_replace('-', '/', $date); ?>

		<tr>
			<td id="tier-lists-results-name">
				<a href="<?php echo $url . '?category=' . $category . '&id=' . $tier_list['id'] ?>">
					<?php echo $tier_list['name'] ?>
				</a>
			</td>
			<td id="tier-lists-results-order"><?php echo ucfirst($tier_list['tier_order']) ?></td>
			<td id="tier-lists-results-version"><?php echo $tier_list['version'] ?></td>
			<td id="tier-lists-results-date"><?php echo $date ?></td>
		</tr>
	<?php
	} ?>
</table>

<div id="tier-lists-results-pagination">
	<?php if ($page != 1) { ?>
		<a id="tier-lists-results-prev" href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=<?php echo $category . '&pg=' . ($page - 1) ?>">Prev Page</a>
	<?php
	}
	if (!$page_last) { ?>
		<a id="tier-lists-results-next" href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=<?php echo $category . '&pg=' . ($page + 1) ?>">Next Page</a>
	<?php
	} ?>
</div>
<?php
}
?>