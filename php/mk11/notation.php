<?php
function notation_shortcode($atts, $content = null) {
	// Capitalize String
	$str = strtoupper($content);

// Mechanics
$separator = '<span class="notation-separator"></span>';
$fb = '<span class="input input-fb shoulder">FB</span>';
$throw = '<span class="input input-throw shoulder">Throw</span>';
$amp = '<span class="input input-amp shoulder">AMP</span>';
$stance = '<span class="input input-stance shoulder">SS</span>';
$block = '<span class="input input-block shoulder">Block</span>';

// PS4 / XB1 Buttons
$ps4_l1 = '<img class="input input-l1 shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/ps4/l1.png" alt="L1" />';
$ps4_r1 = '<img class="input input-r1 shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/ps4/r1.png" alt="R1" />';
$ps4_l2 = '<img class="input input-l2 shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/ps4/l2.png" alt="L2" />';
$ps4_r2 = '<img class="input input-r2 shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/ps4/r2.png" alt="R2" />';
$xb1_lb = '<img class="input input-lb shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/xb1/lb.png" alt="LB" />';
$xb1_rb = '<img class="input input-rb shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/xb1/rb.png" alt="RB" />';
$xb1_lt = '<img class="input input-lt shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/xb1/lt.png" alt="LT" />';
$xb1_rt = '<img class="input input-rt shoulder" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/xb1/rt.png" alt="RT" />';

// Directionals
$left = '<img class="input input-left directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/left.png" alt="Back" />';
$up = '<img class="input input-up directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/up.png" alt="Up" />';
$down = '<img class="input input-down directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/down.png" alt="Down" />';
$right = '<img class="input input-right directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/right.png" alt="Forward" />';
$up_left = '<img class="input input-up-left directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/up-left.png" alt="Up + Back" />';
$up_right = '<img class="input input-up-right directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/up-right.png" alt="Up + Forward" />';
$down_left = '<img class="input input-down-left directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/down-left.png" alt="Down + Back" />';
$down_right = '<img class="input input-down-right directional" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/down-right.png" alt="Down + Forward" />';

// Face Buttons
$one = '<img class="input input-one" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/universal/one.png" alt="1" />';
$two = '<img class="input input-two" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/universal/two.png" alt="2" />';
$three = '<img class="input input-three" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/universal/three.png" alt="3" />';
$four = '<img class="input input-four" src="https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/universal/four.png" alt="4" />';

	$inputs = array(
		// Separator
		' ' => $separator,

		// Mechanics
		'DASH' => $right . $right,
		'BACKDASH' => $left . $left,
		'PRESS' => 'Press',
		'KB' => 'KB',
		'FATAL BLOW' => $fb,
		'THROW' => $throw,
		'AMP' => $amp,
		'SS' => $stance,
		'BLOCK' => $block,
		'HOLD' => 'Hold',
		'DELAY' => 'Delay',
		'RELEASE' => 'Release',
		'D+BLOCK' => $down . '+' . 'Block',
		'OR' => 'or',
		'RAPIDLY' => 'Rapidly',
		'REPEATEDLY' => 'Repeatedly',
		'AFTER ATTACK' => 'After Attack',

		// Directions
		'U+B' => $up_left,
		'U+F' => $up_right,
		'D+B' => $down_left,
		'D+F' => $down_right,
		'B' => $left,
		'U' => $up,
		'D' => $down,
		'F' => $right,

		// Face
		'1' => $one,
		'2' => $two,
		'3' => $three,
		'4' => $four
	);

	$str = strtr($str, $inputs);

	return $str;
}
add_shortcode('notation', 'notation_shortcode');
?>