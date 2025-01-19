let category = 'Midscreen';
let midscreen = document.getElementById('midscreen');
let corner = document.getElementById('corner');
let tagsContainer = document.getElementById('tag-list');
let enableTags = false;
let combosContainer = document.getElementById('combo-list');

// Tags
let tags = {
	'Buff' : false,
	'Restand' : false,
	'Setup' : false,
	'Sideswitch' : false,
	'Krushing Blow' : false,
	'Fatal Blow' : false
};

displayTags();
initializeCombos();

midscreen.addEventListener('click', () => {
	if (category != 'Midscreen') {
		category = 'Midscreen';
		combosContainer.innerHTML = '';
		initializeCombos();
	}
});
corner.addEventListener('click', () => {
	if (category != 'Corner') {
		category = 'Corner';
		combosContainer.innerHTML = '';
		initializeCombos();
	}
});

// Display tags list
function displayTags() {
	for (t in tags) {
		let tag = document.createElement('div');
		tag.classList.add('combo-tag');

		tag.innerHTML = t;
		if (tags[t]) { setTagColor(tag); }
		else {
			tag.style.background = 'rgb(16,16,16)';
			tag.style.color = 'rgb(128,128,128)';

			tag.addEventListener('mouseover', () => {
				setTagColor(tag);
				tag.style.color = 'rgb(255,255,255)';
			});
			tag.addEventListener('mouseout', () => {
				tag.style.background = 'rgb(16,16,16)';
				tag.style.color = 'rgb(128,128,128)';
			});
		}

		tag.addEventListener('click', () => { setTags(tag); togglePlatform(currentPlatform); });

		tagsContainer.append(tag);
	}
}

// Set tag and re-initialize combos
function setTags(tag) {
	tags[tag.innerHTML] = !tags[tag.innerHTML];
	checkAllTags();
	tagsContainer.innerHTML = '';
	displayTags();

	combosContainer.innerHTML = '';
	initializeCombos();
}

// Enable tags if any tag is true
function checkAllTags() {
	enableTags = false;

	for (t in tags) {
		if (tags[t]) { enableTags = true; }
	}
}

// Set Tag Color
function setTagColor(tag) {
	if (tag.innerHTML == 'Buff') { tag.style.background = 'rgb(0,128,0)'; } // Green
	else if (tag.innerHTML == 'Restand') { tag.style.background = 'rgb(0,0,128)'; } // Blue
	else if (tag.innerHTML == 'Setup') { tag.style.background = 'rgb(75,0,130)'; } // Indigo
	else if (tag.innerHTML == 'Sideswitch') { tag.style.background = 'rgb(112,15,112)'; } // Violet
	else if (tag.innerHTML == 'Unbreakable') { tag.style.background = 'rgb(128,128,0)'; } // Yellow
	else if (tag.innerHTML == 'Krushing Blow') { tag.style.background = 'rgb(128,83,0)'; } // Orange
	else if (tag.innerHTML == 'Fatal Blow') { tag.style.background = 'rgb(128,0,0)'; } // Red
}

// Initialize
function initializeCombos() {
	let prevSubcategory = '';
	let combos = new Array();

	// Check Category
	if (category == 'Midscreen') {
		midscreen.classList.add('active');
		corner.classList.remove('active');

		combos = combosMidscreen;
	}
	else if (category == 'Corner') {
		corner.classList.add('active');
		midscreen.classList.remove('active');

		combos = combosCorner;
	}

	// Combos
	combos.forEach(c => {
		// Split tags by comma
		let tagsList = c['tags'].split(', ');
		let hasTag = false;

		// Check if tag is on
		tagsList.forEach(t => { if (tags[t]) { hasTag = true; } });

		// If tags are disabled or tag is on, output combo
		if (!enableTags || hasTag) {

			if (prevSubcategory != c['subcategory']) {
				let rowStarter = document.createElement('tr');
				let dataStarter = document.createElement('td');
				dataStarter.classList.add('subcategory');

				let starter = document.createElement('div');
				starter.innerHTML = c['subcategory'];
				dataStarter.append(starter);
				rowStarter.append(dataStarter);
				combosContainer.append(rowStarter);
			}

			let row = document.createElement('tr');
			let data = document.createElement('td');

			let left = document.createElement('div');
			left.classList.add('left');

				// Combo
				let combo = document.createElement('div');
				combo.classList.add('combo');
				combo.innerHTML = c['combo'];
				left.append(combo);

				// Description
				if (c['description'] != '') {
					let description = document.createElement('div');
					description.classList.add('description');
					description.innerHTML = c['description'];
					left.append(description);
				}
				data.append(left);

			let right = document.createElement('div');
			right.classList.add('right');

				// Tags
				if (c['tags'] != '') {
					let tags = document.createElement('div');
					tags.classList.add('combo-tags');

					tagsList.forEach(t => {
						let tag = document.createElement('div');
						tag.classList.add('combo-tag');

						tag.innerHTML = t;
						setTagColor(tag); // Set tag color
						tag.addEventListener('click', () => { setTags(tag); togglePlatform(currentPlatform); });
						tags.append(tag);
					});
					right.append(tags);
				}

				// Damage
				let damage = document.createElement('div');
				damage.classList.add('damage');

				damage.innerHTML = c['damage'];
				right.append(damage);
				data.append(right);

			row.append(data);
			combosContainer.append(row);

			// Set Previous Subcategory
			prevSubcategory = c['subcategory'];

		}
	});
}