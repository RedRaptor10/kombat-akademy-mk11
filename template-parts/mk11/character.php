<?php
/**
 * Template part for displaying page content in character.php
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package customify
 */

?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( customify_is_post_title_display() ) { ?>
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title h3">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	<?php } ?>

	<div class="entry-content">

<?php
// Categories
$cats = array(
	'baraka' => 6,
	'cassie-cage' => 7,
	'cetrion' => 8,
	'dvorah' => 9,
	'erron-black' => 10,
	'frost' => 11,
	'fujin' => 142,
	'geras' => 12,
	'jacqui-briggs' => 13,
	'jade' => 14,
	'jax-briggs' => 15,
	'johnny-cage' => 16,
	'the-joker' => 138,
	'kabal' => 17,
	'kano' => 18,
	'kitana' => 19,
	'kollector' => 20,
	'kotal-kahn' => 21,
	'kung-lao' => 22,
	'liu-kang' => 23,
	'mileena' => 154,
	'nightwolf' => 95,
	'noob-saibot' => 24,
	'raiden' => 25,
	'rain' => 158,
	'rambo' => 162,
	'robocop' => 144,
	'scorpion' => 5,
	'shang-tsung' => 39,
	'shao-kahn' => 26,
	'sheeva' => 143,
	'sindel' => 98,
	'skarlet' => 27,
	'sonya' => 28,
	'spawn' => 101,
	'sub-zero' => 29,
	'the-terminator' => 134
);

// Slug & Snake
$slug = get_post_field('post_name');
$snake = str_replace('-', '_', $slug);

// Category ID
$cat_id = $cats[$slug];

// Character
$character = the_title('', '', false);

// Set $character equal to $slug for characters with single quotes
if ($slug == 'dvorah') { $character = $slug; }

// Category
$category = 'basic-attacks'; // Default
if(isset($_GET['category'])){ $category = $_GET['category']; }
$category_slug = $category;
$category = str_replace('-', ' ', $category);
$category = ucwords($category);

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
$query1 = "SELECT * FROM $snake WHERE category='Basic Attacks'";
$query2 = "SELECT * FROM $snake WHERE category='Kombo Attacks'";
$query3 = "SELECT * FROM $snake WHERE category='Special Moves'";
$query4 = "SELECT * FROM $snake WHERE category='Finishers'";
$query5 = "SELECT * FROM $snake WHERE category='Abilities'";

// Get Results
$result1 = mysqli_query($db, $query1) or die("Error querying database.");
$result2 = mysqli_query($db, $query2) or die("Error querying database.");
$result3 = mysqli_query($db, $query3) or die("Error querying database.");
$result4 = mysqli_query($db, $query4) or die("Error querying database.");
$result5 = mysqli_query($db, $query5) or die("Error querying database.");

// Fetch Data
$basic_attacks = mysqli_fetch_all($result1, MYSQLI_ASSOC);
$kombo_attacks = mysqli_fetch_all($result2, MYSQLI_ASSOC);
$special_moves = mysqli_fetch_all($result3, MYSQLI_ASSOC);
$finishers = mysqli_fetch_all($result4, MYSQLI_ASSOC);
$abilities = mysqli_fetch_all($result5, MYSQLI_ASSOC);

// Replace With Notations
foreach ($basic_attacks as $row => $value) {
	$basic_attacks[$row]['notation'] = do_shortcode('[notation]' . $value['notation'] . '[/notation]');
}
foreach ($kombo_attacks as $row => $value) {
	$kombo_attacks[$row]['notation'] = do_shortcode('[notation]' . $value['notation'] . '[/notation]');
}
foreach ($special_moves as $row => $value) {
	$special_moves[$row]['notation'] = do_shortcode('[notation]' . $value['notation'] . '[/notation]');
}
foreach ($finishers as $row => $value) {
	$finishers[$row]['notation'] = do_shortcode('[notation]' . $value['notation'] . '[/notation]');
}
foreach ($abilities as $row => $value) {
	$abilities[$row]['notation'] = do_shortcode('[notation]' . $value['notation'] . '[/notation]');
}

// Set JavaScript Moves Arrays
echo '<script>let basicAttacks = ' . json_encode($basic_attacks) .';</script>';
echo '<script>let komboAttacks = ' . json_encode($kombo_attacks) .';</script>';
echo '<script>let specialMoves = ' . json_encode($special_moves) .';</script>';
echo '<script>let finishers = ' . json_encode($finishers) .';</script>';
echo '<script>let abilities = ' . json_encode($abilities) .';</script>';
?>

<div>
<?php // Table of Kontents ?>
<div id="toc_char_container">
<p class="toc_char_title">Table of Kontents</p>

<ul class="toc_char_list">
	<li><a href="#move-list">1 Move List</a>
		<ul>
			<li><a href="#move-list" onclick="changeCategory('Basic Attacks')">1.1 Basic Attacks</a></li>
			<li><a href="#move-list" onclick="changeCategory('Kombo Attacks')">1.2 Kombo Attacks</a></li>
			<li><a href="#move-list" onclick="changeCategory('Special Moves')">1.3 Special Moves</a></li>
			<li><a href="#move-list" onclick="changeCategory('Finishers')">1.4 Finishers</a></li>
			<li><a href="#move-list" onclick="changeCategory('Abilities')">1.5 Abilities</a></li>
		</ul>
	</li>
	<li><a href="#strategy">2 Strategy</a></li>
	<li><a href="#abilities-list">3 Abilities</a></li>
	<li><a href="#variations">4 Variations</a></li>
	<li><a href="#extra-guides">5 Extra Guides</a></li>
</ul>
</div>

<?php // Character ?>
<img id="character" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/characters/<?php echo $slug ?>.png">
</div>

<?php // Move List ?>
<h1 id="move-list">Move List</h1>
<hr class="hr_title" />

<div id="move-list-container">
	<div id="move-list-category-container">
		<div class="move-list-category" id="basic-attacks">BASIC ATTACKS</div>
		<div class="move-list-category" id="kombo-attacks">KOMBO ATTACKS</div>
		<div class="move-list-category" id="special-moves">SPECIAL MOVES</div>
		<div class="move-list-category" id="finishers">FINISHERS</div>
		<div class="move-list-category" id="abilities">ABILITIES</div>
	</div>

	<table id="move-list-moves-container"></table>
</div>

<br>

<?php // Last Updated ?>
<div id="move_list_last_updated">
	Version 1.28
	<br>
	Last Updated: May 14, 2021
</div>

<br>

<?php // Strategy ?>
<h1 id="strategy">Strategy</h1>
<hr class="hr_title">

<div class="entry-content single-post-content">
	<?php the_content(); // Page Content ?>
</div>

<?php // Variations ?>
<h1 id="variations">Variations</h1>
<hr class="hr_title">
<?php include dirname(__DIR__) . '../../php/mk11/variations.php'; ?>

<?php // Extra Guides ?>
<h1 id="extra-guides">Extra Guides</h1>
<hr class="hr_title">

<?php echo do_shortcode('
[catlist template=list orderby=title order=asc thumbnail=yes thumbnail_size=full date_modified=yes dateformat=m/d/y comments=yes tags=beginner excerpt=yes excerpt_size=25 id='.$cat_id.']
[catlist template=list orderby=title order=asc thumbnail=yes thumbnail_size=full date_modified=yes dateformat=m/d/y comments=yes tags=advanced excerpt=yes excerpt_size=25 id='.$cat_id.']
'); ?>

<?php
// Close Database
mysqli_close($db);
?>

		<?php
		// the_content();

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'customify' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->