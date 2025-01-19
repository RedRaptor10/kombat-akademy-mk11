<?php

// Submit Tier List MK11
add_action('wp_ajax_submit_tier_list_mk11', 'submit_tier_list_mk11');
add_action('wp_ajax_nopriv_submit_tier_list_mk11', 'submit_tier_list_mk11');
function submit_tier_list_mk11() {
	global $wpdb;

	$category = wp_unslash($_GET['category']);
	$name = wp_unslash($_GET['player']);
	$date = wp_unslash($_GET['date']);
	$ver = wp_unslash($_GET['ver']);
	$tier_list = wp_unslash($_GET['tier-list']);
	$tier_order = wp_unslash($_GET['order']);

	// Get Server, Database, Username, and Password
	$servername = "";
	$database = "";
	$username = "";
	$password = "";

	// Create Connection
	$db = mysqli_connect($servername, $username, $password, $database);

	// Check Connection
	if (!$db) { die("Connection failed: " . mysqli_connect_error()); }

	// Insert Name, Date, Version, Tier List and Order Into Database
	if ($category == 'community') {
		$query = "INSERT INTO community (name, date, version, tier_list, tier_order) VALUES ('$name', '$date', '$ver', '$tier_list', '$tier_order')";
	} else if ($category == 'competitive') {
		$query = "INSERT INTO competitive (name, date, version, tier_list, tier_order) VALUES ('$name', '$date', '$ver', '$tier_list', '$tier_order')";
	}
	mysqli_query($db, $query) or die("Error querying database.");

	// Close Database
	mysqli_close($db);

	wp_die();
}

// Submit Rankings MK11
add_action('wp_ajax_submit_rankings_mk11', 'submit_rankings_mk11');
add_action('wp_ajax_nopriv_submit_rankings_mk11', 'submit_rankings_mk11');
function submit_rankings_mk11() {
	global $wpdb;

	$category = 'community';
	if(isset($_GET['category'])) { $category = $_GET['category']; }

	/* Get Data and Decode JSON Object to Array
	 * NOTE: WordPress automatically adds slashes
	 * to all global input variables using wp_slash().
	 * Must use wp_unslash() to remove slashes. */
	$ratings = json_decode(wp_unslash($_GET['ratings']));
	$ver = ($_GET['ver']);

	// Get Server, Database, Username, and Password
	$servername = "";
	if ($category == 'community') {
		$database = "";
	}
	else if ($category == 'competitive') {
		$database = "";
	}
	$username = "";
	$password = "";

	// Create Connection
	$db = mysqli_connect($servername, $username, $password, $database);

	// Check Connection
	if (!$db) { die("Connection failed: " . mysqli_connect_error()); }

	// Add & Update Character Ratings
	foreach ($ratings as $character => $rating) {
		// Replace hyphens with underscores
		$character = str_replace('-', '_', $character);
		// Insert Character Rating Into Database
		$query = "INSERT INTO $character (rating, version) VALUES ('$rating', '$ver')";
		mysqli_query($db, $query) or die("Error querying database.");

		// Get Average Character Rating
		$query = "SELECT AVG(rating) FROM $character WHERE version=$ver";
		$result = mysqli_query($db, $query) or die("Error querying database.");
		$row = mysqli_fetch_assoc($result);
		$avg_rating = $row['AVG(rating)'];

		// Replace underscores with hyphens
		$character = str_replace('_', '-', $character);
		// Update Average Character Rating
		$query = "UPDATE avg SET rating='$avg_rating' WHERE name='$character' AND version='$ver'";
		mysqli_query($db, $query) or die("Error querying database.");
	}

	// Update Character Rankings
	$query = "SELECT * FROM avg WHERE version='$ver' ORDER BY rating DESC";
	$result = mysqli_query($db, $query) or die("Error querying database.");

	$index = 1;
	$prev_rating = -1;
	$tie = false;
	$tie_rank = 1;

	while ($row = mysqli_fetch_array($result)) {
		$character = $row['name'];

		// If Rating is Equal to Previous Rating
		if ($row['rating'] == $prev_rating) {
			// If Not Already a Tie, Set Tie to true
			if (!$tie) {
				$tie = true;
				$tie_rank = $index - 1; // Set Tie Rank to Previous Rank
			}

			$rank = $tie_rank; // Set Rank to Tie Rank
		} else {
			$tie = false; // Reset Tie to false
			$rank = $index; // Set Rank to Current Index
		}

		// Update Character Ranking
		$query_ranking = "UPDATE avg SET ranking='$rank' WHERE name='$character' AND version='$ver'";
		mysqli_query($db, $query_ranking) or die("Error querying database.");

		// Set Previous Rating to Current Rating
		$prev_rating = $row['rating'];

		$index++;
	}

	// Close Database
	mysqli_close($db);

	wp_die();
}