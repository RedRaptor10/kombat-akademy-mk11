let ratingsData;
let ratings = {};
let tempTierList = {};
let totalTiers = 0;
let totalChars = 0;
let NPCs = 1;
let minChars = (document.querySelectorAll('.character')).length - NPCs;

function submitCommunityData(player, tierListDate, playerTierList, order) {
	resetData();
	fillTiers();
	if (order == 'unordered') { addRatingsUnordered(); }
	else if (order == 'ordered') { addRatingsOrdered(); }

	// Check if Tier List is Valid
	if (totalChars == minChars) {
		// Send Tier List
		$.ajax({
		type: 'GET',
		url: tier_submit_ajax.ajax_url,
		data: {
			'action' : 'submit_tier_list_mk11',
			'category' : 'community',
			'player' : player,
			'date' : tierListDate,
			'ver' : version,
			'tier-list' : playerTierList,
			'order' : order }
		});

		// Send Rankings
		$.ajax({
		type: 'GET',
		url: tier_submit_ajax.ajax_url,
		data: {
			'action' : 'submit_rankings_mk11',
			'ratings' : ratingsData,
			'ver' : version },
		success: function (response) { showSuccess(); }
		});
	} else {
		showError('* Tier list must contain all characters.');
	}
}

function submitCompetitiveData(player, tierListDate, playerTierList, order) {
	resetData();
	fillTiers();
	if (order == 'unordered') { addRatingsUnordered(); }
	else if (order == 'ordered') { addRatingsOrdered(); }

	// Send Tier List
	$.ajax({
		type: 'GET',
		url: tier_submit_ajax.ajax_url,
		data: {
			'action' : 'submit_tier_list_mk11',
			'category' : 'competitive',
			'player' : player,
			'date' : tierListDate,
			'ver' : version,
			'tier-list' : playerTierList,
			'order' : order }
	});

	// Send Rankings
	$.ajax({
		type: 'GET',
		url: tier_submit_ajax.ajax_url,
		data: {
			'action' : 'submit_rankings_mk11',
			'ratings' : ratingsData,
			'ver' : version,
			'category' : 'competitive' }
	});
}

// Reset Data
function resetData() {
	ratingsData = '';
	ratings = {};
	tempTierList = {};
	totalTiers = 0;
	totalChars = 0;
}

// Add to Tiers Object
function fillTiers() {
	for (let i = 0; i < tierList.tiers.length; i++) {
		// If Tier is Not Empty, Add Tier Number and Characters to Tiers Object
		if (tierList.tiers[i].list.length != 0) {
			// Create tierCharacters Array
			let tierCharacters = [];
			tierList.tiers[i].list.forEach(c => {
				// Add Character if Not NPC
				if (c != 'kronika') {
					tierCharacters.push(c);
					totalChars++;
				}
			});

			// Add Characters if tierCharacters is Not Empty
			if (tierCharacters.length > 0) {
				tempTierList[totalTiers] = tierCharacters;
				totalTiers++;
			}
		}
	}
}

// Add to Ratings Object Unordered
function addRatingsUnordered() {
	let tierRating = 1; // Set Top Tier Rating
	let baseRating = 1 / totalTiers; // Base Tier Rating == Total Tiers Evenly Divided

	for (userTier in tempTierList) {
		tempTierList[userTier].forEach(character => {
			ratings[character] = tierRating;
		});

		tierRating -= baseRating;
	}

	ratingsData = JSON.stringify(ratings); // Convert Ratings to be Sent to PHP
}

// Add to Ratings Object Ordered
function addRatingsOrdered() {
	let charRating = 1; // Set Top Rating
	let baseRating = 1 / totalChars; // Base Rating == Total Characters Evenly Divided

	for (userTier in tempTierList) {
		tempTierList[userTier].forEach(character => {
			ratings[character] = charRating;
			charRating -= baseRating;
		});
	}

	ratingsData = JSON.stringify(ratings); // Convert Ratings to be Sent to PHP
}