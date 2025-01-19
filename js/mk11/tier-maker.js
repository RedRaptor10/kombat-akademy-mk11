let title = 'MORTAL KOMBAT 11<br>TIER LIST';
let description = '';
let background = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/ultimate-background.jpg';
let tiers = [];
let version = '1.28';

let tierLetters = ['S', 'A', 'B', 'C', 'D', 'F'];
let tierColors = [
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
	'rgba(255,0,125,.25)', // Raspberry
	'rgba(255,255,255,.25)', // White
	'rgba(125,125,125,.25)', // Gray
	'rgba(0,0,0,.25)' // Black
];
let backgrounds = {
	'Default' : 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/default-background.jpg',
	'Mortal Kombat 11' : 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/mk11-cover-background.jpg',
	'Aftermath' : 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/aftermath-background.jpg',
	'Aftermath 2' : 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/aftermath-background-alt.jpg',
	'Ultimate' : 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/ultimate-background.jpg',
	'Empty' : 'rgb(16,16,16)'
};
let dir = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/tier-maker/';
let ext = 'jpg';
let characters = [
	'baraka', 'cassie-cage', 'cetrion', 'dvorah', 'erron-black', 'frost', 'fujin', 'geras', 'jacqui-briggs', 'jade',
	'jax-briggs', 'johnny-cage', 'the-joker', 'kabal', 'kano', 'kitana', 'kollector', 'kotal-kahn', 'kung-lao', 'liu-kang',
	'mileena', 'nightwolf', 'noob-saibot', 'raiden', 'rain', 'rambo', 'robocop', 'scorpion', 'shang-tsung', 'shao-kahn',
	'sheeva', 'sindel', 'skarlet', 'sonya', 'spawn', 'sub-zero', 'the-terminator', 'kronika'];

// Mobile
let isMobile = false;
if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) { isMobile = true; }

// Tier List Object
const tierList = {
	title: title,
	description: description,
	background: background,
	tiers: tiers,
	version: version
}

// Tier Object
function tier(title, description, color, list) {
	this.title = title;
	this.description = description;
	this.color = color;
	this.list = list;
}

initialize();
loadAdmin();

function loadAdmin() {
	let displayName = document.querySelector('.display-name');
	if (displayName && displayName.innerHTML == 'Raptor') {
		// Container
		let buttonsContainer = document.getElementById('buttons-container');

		let adminSubmitButton = document.createElement('div');
		adminSubmitButton.classList.add('tier-list-button');
		adminSubmitButton.innerHTML = '(Admin) Submit Competitive Tier List';
		adminSubmitButton.addEventListener('click', () => {
			loadCover();
			addCharacters();

			// Create Form
			let formContainer = document.createElement('div');
			formContainer.classList.add('submit-form-container');
			document.body.append(formContainer);

			// Fade in
			formContainer.classList.add('form-fade');

			// Create Form Fields
			let submitForm = document.createElement('div');
			submitForm.id = 'submit-form';

			// Name Field
			let nameLabel = document.createElement('span');
			nameLabel.classList.add('form-label');
			nameLabel.innerHTML = 'Name';
			let nameInput = document.createElement('input');
			nameInput.id = 'name-input';
			nameInput.setAttribute('maxlength', '70');

			// Date Field
			let dateLabel = document.createElement('span');
			dateLabel.classList.add('form-label');
			dateLabel.innerHTML = 'Date (YYYY-MM-DD)';
			let dateInput = document.createElement('input');
			dateInput.id = 'name-input';

			// Order
			let orderLabel = document.createElement('span');
			orderLabel.classList.add('form-label');
			orderLabel.id = 'order-label';
			orderLabel.innerHTML = 'Order';
			let orderSelect = document.createElement('select');
			orderSelect.id = 'order-select';

				// Unordered
				let optionUnordered = document.createElement('option');
				optionUnordered.value = 'unordered';
				optionUnordered.innerHTML = 'Unordered';
				orderSelect.append(optionUnordered);

				// Ordered
				let optionOrdered = document.createElement('option');
				optionOrdered.value = 'ordered';
				optionOrdered.innerHTML = 'Ordered';
				orderSelect.append(optionOrdered);

			// Submit Confirm Button
			let submitButtonConfirm = document.createElement('div');
			submitButtonConfirm.id = 'submit-button-confirm';
			submitButtonConfirm.innerHTML = 'Submit';
			submitButtonConfirm.addEventListener('click', () => {
				submitCompetitiveData(nameInput.value, dateInput.value, JSON.stringify(tierList), orderSelect.value);
				alert('Submitted');
				formContainer.remove();
			});

			// Append
			submitForm.append(nameLabel, nameInput, dateLabel, dateInput, orderLabel, orderSelect, submitButtonConfirm);
			formContainer.append(submitForm);
		});

		buttonsContainer.append(adminSubmitButton);
	}
}

// Reset Tier List
function resetTierList() {
	let container = document.querySelector('.entry-content');

	container.innerHTML = '';
	tierList.title = title;
	tierList.description = description;
	tierList.background = background;
	tierList.tiers = tiers;
	tierList.version = version;

	initialize();
}

// Load Tier List
function loadTierList() {
	const loadedTierList = JSON.parse(localStorage.getItem('localTierList'));
	for (let property in loadedTierList) { tierList[property] = loadedTierList[property]; }
}

// Save Tier List
function saveTierList() {
	// Add Characters to Tier List
	addCharacters();

	// Save Tier List to Local Storage
	localStorage.setItem('localTierList', JSON.stringify(tierList));

	let savedText = document.getElementById('saved-text');
	if (savedText) { savedText.remove(); }
	setTimeout(() => {
		let tierListContainer = document.getElementById('tier-list-container');
		savedText = document.createElement('div');
		savedText.id = 'saved-text';
		savedText.innerHTML = 'Progress saved.';

		let deleteText = document.createElement('div');
		deleteText.id = 'delete-text';
		deleteText.innerHTML = 'Click to Delete';
		deleteText.addEventListener('click', () => {
			localStorage.removeItem('localTierList');
			savedText.innerHTML = 'Progress deleted.';
		});
		savedText.append(deleteText);

		tierListContainer.parentNode.insertBefore(savedText, tierListContainer);
	}, 100);
}

function initialize() {
	// Load Tier List
	if (localStorage.getItem('localTierList')) { loadTierList(); }

	// Container
	let container = document.querySelector('.entry-content');

	// Buttons
	let buttonsContainer = document.createElement('div');
	buttonsContainer.id = ('buttons-container');

	// Save Tier List Button
	let saveTierListButton = document.createElement('div');
	saveTierListButton.classList.add('tier-list-button');
	saveTierListButton.innerHTML = 'Save Progress';
	saveTierListButton.addEventListener('click', () => { saveTierList(); });
	buttonsContainer.append(saveTierListButton);

	// Generate Button
	let generateButton = document.createElement('div');
	generateButton.classList.add('tier-list-button');
	generateButton.innerHTML = 'Generate Image';
	generateButton.addEventListener('click', () => { downloadTierList(); });
	buttonsContainer.append(generateButton);

	// Submit Button
	let submitButton = document.createElement('div');
	submitButton.classList.add('submit-button-hover');
	submitButton.id = 'submit-button';
	submitButton.innerHTML = 'Submit Tier List';
	submitButton.addEventListener('click', submitTierList);
	buttonsContainer.append(submitButton);
	container.append(buttonsContainer);

	// Disable Submit if Already Submitted for 1 Day
	let d = new Date();
	if (d.getDate() == localStorage.getItem('local')) { disableSubmit(); }
	else { localStorage.removeItem('local'); }

	let tierListContainer = document.createElement('div');
	tierListContainer.id = 'tier-list-container';
	tierListContainer.style.backgroundImage = 'linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url(' + tierList.background + ')';
	let tierListHeader = document.createElement('div');
	tierListHeader.id = 'tier-list-header';
	let tierListElement = document.createElement('div');
	tierListElement.id = 'tier-list';

	// Create Sortable Tier List Element
	Sortable.create(tierListElement, { handle: ".handle", animation: 150 });

	// Create Title Options
	let titleOptions = document.createElement('div');
	titleOptions.id = 'title-options';
	let titleButton = document.createElement('div');
	titleButton.classList.add('html2canvas-ignore'); // Ignore During Image Generation
	titleButton.id = 'title-button';
	titleButton.innerHTML = '&#x270e';
	titleButton.addEventListener('click', () => { editTierList(); });
	titleOptions.append(titleButton);

	// Create Title
	let tierListTitle = document.createElement('div');
	tierListTitle.id = 'tier-list-title';
	tierListTitle.innerHTML = tierList.title;

	// Create Description
	let tierListDescription = document.createElement('div');
	tierListDescription.id = 'tier-list-description';
	tierListDescription.innerHTML = tierList.description;

	// Append
	tierListHeader.append(titleOptions, tierListTitle, tierListDescription);
	tierListContainer.append(tierListHeader, tierListElement);
	container.append(tierListContainer);

	// Create Tiers
	// If no saved Tier List, create default tiers
	if (!localStorage.getItem('localTierList')) {
		for (let i = 0; i < 5; i++) { tierList.tiers[i] = new tier(tierLetters[i], '', tierColors[i], []); }
	}
	tierList.tiers.forEach (t => { addTier(t); });

	// Create Pool
	let pool = document.createElement('div');
	pool.id = 'pool';
	characters.forEach(c => {
		// Check if Tier List already has Character
		let hasCharacter = false;
		tierList.tiers.forEach(t => {
			if (t.list.includes(c)) { hasCharacter = true; }
		});

		// Add Character to Pool
		if (!hasCharacter) {
			let character = document.createElement('img');
			character.classList.add('character');
			character.id = c;
			character.src = dir + c + '.' + ext;
			pool.append(character);
		}
	});

	// Create Sortable Pool Element
	Sortable.create(pool, { group: "tiers", animation: 150 });

	// Append
	container.append(pool);
}

// Add Tier (targetTier == Tier to Add Under)
function addTier(loadedTier, targetTier = null) {
	let tierListElement = document.getElementById('tier-list');

	// Create Tier
	let newTier;
	let targetTierIndex;
	let targetColorIndex;

	if (!targetTier) { // Default Tier
		newTier = loadedTier;
	} else { // Set newTier Properties and Position Based on targetTier
		targetTierIndex = tierList.tiers.indexOf(targetTier);
		targetColorIndex = tierColors.indexOf(targetTier.color);
		let color = tierColors[targetColorIndex + 1];

		newTier = new tier('', '', color, []);

		tierList.tiers.splice(targetTierIndex + 1, 0, newTier); // Add newTier Under targetTier
	}

	// Create Tier Element
	let tierElement = document.createElement('div');
	tierElement.classList.add('tier');

	// Rearrange Tiers Array if Tier is Drag and Dropped
	tierElement.addEventListener('drop', () => { rearrangeArray(newTier, tierElement); });

	// Create Tier Header Container
	let tierHeaderContainer = document.createElement('div');
	tierHeaderContainer.classList.add('tier-header-container', 'handle');
	tierHeaderContainer.style.background = newTier.color;

		// Create Tier Header
		let tierHeader = document.createElement('div');
		tierHeader.classList.add('tier-header');

			// Create Tier Title
			let tierTitle = document.createElement('div');
			tierTitle.classList.add('tier-title');
			tierTitle.innerHTML = newTier.title;
			tierHeader.append(tierTitle);

			// Create Tier Description
			let tierDescription = document.createElement('div');
			tierDescription.classList.add('tier-description');
			tierDescription.innerHTML = newTier.description;
			tierHeader.append(tierDescription);
			tierHeaderContainer.append(tierHeader);

		// Create Tier Options
		let tierOptions = document.createElement('div');
		tierOptions.classList.add('tier-options', 'html2canvas-ignore'); // Ignore During Image Generation

			// Edit Button
			let editTierButton = document.createElement('div');
			editTierButton.classList.add('tier-button');
			editTierButton.id = 'edit-tier-button';
			editTierButton.innerHTML = '&#x270e';
			editTierButton.addEventListener('click', () => { editTier(newTier); });

			// Add Button
			let addTierButton = document.createElement('div');
			addTierButton.classList.add('tier-button');
			addTierButton.id = 'add-tier-button';
			addTierButton.innerHTML = '&#43';
			addTierButton.addEventListener('click', () => { addTier(null, newTier); });

			// Remove Button
			let removeTierButton = document.createElement('div');
			removeTierButton.classList.add('tier-button');
			removeTierButton.id = 'remove-tier-button';
			removeTierButton.innerHTML = '&#x1f5d1&#xfe0e'; // Add &#xfe0e to prevent replacing unicode with emoji
			removeTierButton.addEventListener('click', () => { removeTier(newTier, tierElement); });

	// Append
	tierOptions.append(editTierButton, addTierButton, removeTierButton);
	tierHeaderContainer.append(tierOptions);
	tierElement.append(tierHeaderContainer);

	// Create List
	let list = document.createElement('div');
	list.classList.add('list');
	newTier.list.forEach(c => {
		let character = document.createElement('img');
		character.classList.add('character');
		character.id = c;
		character.src = dir + c + '.' + ext;
		list.append(character);
	});
	tierElement.append(list);

	// Create Sortable List Element
	Sortable.create(list, { group: "tiers", animation: 150 });

	// Add Tier to Tier List after targetTier position
	tierListElement.insertBefore(tierElement, tierListElement.children[targetTierIndex + 1]);
}

// Remove Tier
function removeTier(targetTier, tierElement) {
	if (tierList.tiers.length > 1) {
		let list = tierElement.querySelector('.list');
		let listItems = list.children;
		let pool = document.getElementById('pool');
		let frag = document.createDocumentFragment();

		// Add all elements in tier to pool
		while (listItems.length) { frag.append(listItems[0]); }
		pool.append(frag);

		// Remove Tier
		let targetTierIndex = tierList.tiers.indexOf(targetTier);
		tierList.tiers.splice(targetTierIndex, 1);
		tierElement.parentNode.removeChild(tierElement);
	}
}

// Edit Tier List
function editTierList() {
	loadCover();

	let tierListTitle = document.getElementById('tier-list-title');
	let tierListDescription = document.getElementById('tier-list-description');
	// Handle newline, replace <br> with \n
	let titleText = tierListTitle.innerHTML.replace(/<br\s*\/?>/mg, "\n");

	// Create Form
	let formContainer = document.createElement('div');
	formContainer.classList.add('tier-list-form-container');
	formContainer.id = 'tier-list-form-container';
	document.body.append(formContainer);

	// Fade in
	setTimeout(() => {
		formContainer.classList.add('form-fade');
	}, 100);

	// Create Form Fields
	let tierListForm = document.createElement('div');
	tierListForm.id = 'tier-list-form';

	// Title Field
	let titleLabel = document.createElement('span');
	titleLabel.classList.add('form-label');
	titleLabel.innerHTML = 'Name';
	let titleInput = document.createElement('textarea');
	titleInput.id = 'title-input';
	titleInput.value = titleText;
	tierListForm.append(titleLabel, titleInput);

	// Description Field
	let descriptionLabel = document.createElement('span');
	descriptionLabel.classList.add('form-label');
	descriptionLabel.innerHTML = 'Description';
	let descriptionInput = document.createElement('input');
	descriptionInput.id = 'description-input';
	descriptionInput.value = tierListDescription.innerHTML;
	tierListForm.append(descriptionLabel, descriptionInput);

	// Background Image
	let backgroundLabel = document.createElement('span');
	backgroundLabel.classList.add('form-label');
	backgroundLabel.innerHTML = 'Background';
	let backgroundsContainer = document.createElement('div');
	backgroundsContainer.id = 'backgrounds-container';

	// Create Background Thumbnails
	for (b in backgrounds) {
		let background = document.createElement('div');
		background.classList.add('background-thumb');
		if (b != 'Empty') { background.style.backgroundImage = 'url(' + backgrounds[b] + ')'; }
		else { background.style.background = backgrounds[b]; }
		background.innerHTML = b;
		background.addEventListener('click', () => {
			// Remove active background
			let backgroundElements = document.querySelectorAll('.background-thumb');
			backgroundElements.forEach(c => { c.classList.remove('background-thumb-active'); });

			// Add active background
			background.classList.add('background-thumb-active');
		});

		backgroundsContainer.append(background);
	}
	tierListForm.append(backgroundLabel, backgroundsContainer);

	// Reset Button
	let resetButton = document.createElement('div');
	resetButton.id = 'reset-button';
	resetButton.innerHTML = 'Reset';
	resetButton.addEventListener('click', () => {
		resetTierList();
		removeForm();
	});
	tierListForm.append(resetButton);

	// Cancel Button
	let cancelButton = document.createElement('div');
	cancelButton.id = 'cancel-form-button';
	cancelButton.innerHTML = 'Cancel';
	cancelButton.addEventListener('click', () => { removeForm(); });

	// Save Button
	let saveButton = document.createElement('div');
	saveButton.id = 'save-form-button';
	saveButton.innerHTML = 'Save';
	saveButton.addEventListener('click', () => {
		// Handle newline, replace \n with <br>
		newTitle = titleInput.value.replace(/(?:\r\n|\r|\n)/g, "<br>");
		tierListTitle.innerHTML = newTitle;
		tierListDescription.innerHTML = descriptionInput.value;

		tierList.title = newTitle;
		tierList.description = descriptionInput.value;

		// Hide Description if Empty
		if (descriptionInput.value == '') { tierListDescription.style.display = 'none'; }
		else { tierListDescription.style.display = 'unset'; }

		let tierListContainer = document.getElementById('tier-list-container');
		let backgroundElements = document.querySelectorAll('.background-thumb');
		backgroundElements.forEach(b => {
			console.log(b.style.backgroundImage);
			if (b.classList.contains('background-thumb-active')) {
				if (b.style.backgroundImage != 'none' && b.style.backgroundImage != 'initial') {
					tierListContainer.style.backgroundImage = 'linear-gradient(rgba(0,0,0,.25), rgba(0,0,0,.25)), url(' + backgrounds[b.innerHTML] + ')';
					tierListContainer.style.backgroundSize = 'cover';
					tierListContainer.style.backgroundRepeat = 'no-repeat';
					tierList.background = backgrounds[b.innerHTML];
				} else {
					tierListContainer.style.background = backgrounds[b.innerHTML];
					tierList.background = backgrounds[b.innerHTML];
				}
			}
		});

		removeForm();
	});

	tierListForm.append(saveButton, cancelButton);
	formContainer.append(tierListForm);
}

// Edit Tier
function editTier(targetTier) {
	loadCover();

	// Create Form
	let formContainer = document.createElement('div');
	formContainer.classList.add('tier-form-container');
	formContainer.id = 'tier-form-container';
	document.body.append(formContainer);

	// Fade in
	setTimeout(() => {
		formContainer.classList.add('form-fade');
	}, 100);

	// Create Form Fields
	let tierForm = document.createElement('div');
	tierForm.id = 'tier-form';

		// Title Field
		let titleLabel = document.createElement('span');
		titleLabel.classList.add('form-label');
		titleLabel.innerHTML = 'Name';
		let titleInput = document.createElement('input');
		titleInput.id = 'title-input';
		titleInput.value = targetTier.title;
		tierForm.append(titleLabel, titleInput);

		// Description Field
		let descriptionLabel = document.createElement('span');
		descriptionLabel.classList.add('form-label');
		descriptionLabel.innerHTML = 'Description';
		let descriptionInput = document.createElement('input');
		descriptionInput.id = 'description-input';
		descriptionInput.value = targetTier.description;
		tierForm.append(descriptionLabel, descriptionInput);

		// Color
		let colorLabel = document.createElement('span');
		colorLabel.classList.add('form-label');
		colorLabel.id = 'color-label';
		colorLabel.innerHTML = 'Color';
		tierForm.append(colorLabel);
		let colorsContainer = document.createElement('div');
		colorsContainer.id = 'colors-container';
		for (let c = 0; c < tierColors.length; c++) {
			let color = document.createElement('div');
			color.classList.add('color');
			color.style.background = tierColors[c];
			color.addEventListener('click', () => {
				// Remove active color
				let colors = document.querySelectorAll('.color');
				colors.forEach(d => { d.classList.remove('color-active'); });

				// Add active color
				color.classList.add('color-active');
			});
			colorsContainer.append(color);
		}
		tierForm.append(colorsContainer);

	// Cancel Button
	let cancelButton = document.createElement('div');
	cancelButton.id = 'cancel-form-button';
	cancelButton.innerHTML = 'Cancel';
	cancelButton.addEventListener('click', () => { removeForm(); });

	// Save Button
	let saveButton = document.createElement('div');
	saveButton.id = 'save-form-button';
	saveButton.innerHTML = 'Save';
	saveButton.addEventListener('click', () => {
		let tierListElement = document.getElementById('tier-list');
		let targetTierIndex = tierList.tiers.indexOf(targetTier);

		// Change targetTier Element Title & Description
		tierListElement.children[targetTierIndex].querySelector('.tier-title').innerHTML = titleInput.value;
		tierListElement.children[targetTierIndex].querySelector('.tier-description').innerHTML = descriptionInput.value;

		// Change targetTier Title & Description
		targetTier.title = titleInput.value;
		targetTier.description = descriptionInput.value;

		// Change targetTier Color
		let colors = document.querySelectorAll('.color');
		colors.forEach(c => {
			if (c.classList.contains('color-active')) {
				tierListElement.children[targetTierIndex].querySelector('.tier-header-container').style.background = c.style.background;
				targetTier.color = c.style.background;
			}
		});

		removeForm();
	});

	tierForm.append(saveButton, cancelButton);
	formContainer.append(tierForm);
}

// Load Cover
function loadCover() {
	let cover = document.createElement('div');
	cover.classList.add('cover');
	cover.id = 'cover';
	cover.addEventListener('click', () => { removeForm(); });
	document.body.append(cover);

	// Fade in
	setTimeout(() => {
		cover.classList.add('cover-fade');
	}, 100);
}

// Remove Form
function removeForm() {
	let tierListFormContainer = document.getElementById('tier-list-form-container');
	let tierFormContainer = document.getElementById('tier-form-container');
	let generatedContainer = document.getElementById('generated-container');
	let submitFormContainer = document.getElementById('submit-form-container');

	// Fade out
	setTimeout(() => {
		cover.classList.remove('cover-fade');
		if (tierListFormContainer) { tierListFormContainer.classList.remove('form-fade'); }
		if (tierFormContainer) { tierFormContainer.classList.remove('form-fade'); }
		if (generatedContainer) { generatedContainer.classList.remove('generated-fade'); }
		if (submitFormContainer) { submitFormContainer.classList.remove('form-fade'); }
		setTimeout(() => {
			cover.remove();
			if (tierListFormContainer) { tierListFormContainer.remove(); };
			if (tierFormContainer) { tierFormContainer.remove(); };
			if (generatedContainer) { generatedContainer.remove(); };
			if (submitFormContainer) { submitFormContainer.remove(); };
		}, 500);
	}, 100);
}

// Add Characters to tierList Object
function addCharacters() {
	let tierElements = document.querySelectorAll('.tier');

	for (let i = 0; i < tierElements.length; i++) {
		tierList.tiers[i].list = []; // Empty Tier List

		// Add Characters to Tier List
		let charElements = tierElements[i].querySelectorAll('.character');
		charElements.forEach(c => { tierList.tiers[i].list.push(c.id); });
	}
}

// Rearrange Tiers Array if Tier is Drag and Dropped
function rearrangeArray(targetTier, tierElement) {
	let tierListElement = document.getElementById('tier-list');
	let oldIndex = tierList.tiers.indexOf(targetTier);
	let newIndex = Array.prototype.indexOf.call(tierListElement.children, tierElement);

	if (oldIndex != newIndex) {
		tierList.tiers.splice(oldIndex, 1); // Remove tier from Tiers array at old index
		tierList.tiers.splice(newIndex, 0, targetTier); // Re-add tier to Tiers array at new index
	}
}

// Save Image
function downloadTierList() {
	loadCover();

	// Create Generated Container
	let generatedContainer = document.createElement('div');
	generatedContainer.classList.add('generated-container');
	generatedContainer.id = 'generated-container';

	// Create Generated Image Container
	let generatedImageContainer = document.createElement('div');
	generatedImageContainer.id = 'generated-image-container';
	generatedContainer.append(generatedImageContainer);
	document.body.append(generatedContainer);

	// Fade in
	setTimeout(() => {
		generatedContainer.classList.add('generated-fade');
	}, 100);

	// Hide Scrollbar
	document.documentElement.classList.add('hide-scrollbar');

	let e = document.getElementById('tier-list-container');
	let e_scale = 1.5;
	let e_width = e.offsetWidth * 2; // Set Width greater than Element to crop later
	let e_height = e.offsetHeight * 2; // Set Height greater than Element to crop later
	let e_PosX = window.scrollX + e.getBoundingClientRect().left;
	let e_PosY = window.scrollY + e.getBoundingClientRect().top;

	// Mobile
	if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		e.style.width = '728px'; // Set Tier List Width to 728px on Mobile
		e_width = e.offsetWidth * 2;
		e_height = e.offsetHeight * 2;
		e_PosX = window.scrollX + e.getBoundingClientRect().left;
		e_PosY = window.scrollY + e.getBoundingClientRect().top;
	}

	// HTML2Canvas
	html2canvas(e, {
		scale: e_scale,
		width: e_width,
		height: e_height,
		x: e_PosX,
		y: e_PosY,
		backgroundColor: null,
		// Ignore Elements
		ignoreElements: function(e) {
			return e.className === 'html2canvas-ignore';
		}
		}).then(canvas => {
		// Crop Image
		let ctx = canvas.getContext('2d');
		canvas = cropImageFromCanvas(ctx, canvas);
		canvas.id = 'generated-image';

		// Create Image URL
		let base64image = canvas.toDataURL('image/png');
		/* let win = window.open('', '_blank');
		win.document.write('<img src="' + base64image + '"/>');
		win.document.close(); */

		// Re-add Scrollbar
		document.documentElement.classList.remove('hide-scrollbar');

		if (isMobile) {
			e.style.width = '100%'; // Reset Tier List Width on Mobile
			generatedImageContainer.style.height = '25%';
		}

		// Create File Name
		let title = document.getElementById('tier-list-title');
		let fileName = title.innerHTML.replace(/<br\s*\/?>/mg, " - "); // Handle Newline

		// Create Download Container
		let downloadContainer = document.createElement('div');
		downloadContainer.id = 'download-container';
		// Create Download Button
		let downloadButton = document.createElement('div');
		downloadButton.id = 'download-button';
		// Create Download Link
		let link = document.createElement('a');
		link.id = 'download-link';
		link.href = base64image;
		link.download = fileName + '.png';
		link.innerHTML = 'Download';

		// Append
		downloadButton.append(link);
		downloadContainer.append(downloadButton);
		generatedImageContainer.append(canvas);
		generatedContainer.append(downloadContainer, generatedImageContainer);
	});
}

// Crop Image
function cropImageFromCanvas(ctx, canvas) {
	let w = canvas.width,
	h = canvas.height,
	pix = {x:[], y:[]},
	imageData = ctx.getImageData(0,0,canvas.width,canvas.height), x, y, index;

	for (y = 0; y < h; y++) {
		for (x = 0; x < w; x++) {
		index = (y * w + x) * 4;
		if (imageData.data[index+3] > 0) {
			pix.x.push(x);
			pix.y.push(y);
		}
		}
	}

	pix.x.sort(function(a,b){return a-b});
	pix.y.sort(function(a,b){return a-b});
	let n = pix.x.length-1;
	w = pix.x[n] - pix.x[0];
	h = pix.y[n] - pix.y[0];
	let cut = ctx.getImageData(pix.x[0], pix.y[0], w + 1, h + 1);
	canvas.width = w + 1;
	canvas.height = h + 1;
	ctx.putImageData(cut, 0, 0);

	return canvas;
}

// Submit Tier List
function submitTierList() {
	loadCover();

	// Create Form
	let formContainer = document.createElement('div');
	formContainer.classList.add('submit-form-container');
	formContainer.id = 'submit-form-container';
	document.body.append(formContainer);

	// Fade in
	setTimeout(() => {
		formContainer.classList.add('form-fade');
	}, 100);

	// Create Form Fields
	let submitForm = document.createElement('div');
	submitForm.id = 'submit-form';

	let submitDescription = document.createElement('div');
	submitDescription.id = 'submit-description';
	submitDescription.innerHTML =
	"You can add your tier list to the site by clicking on the submit button below. " +
	"Your tier list's character rankings will also be added to the overall community rankings.<br><br>" +
	"Notes:<br>" +
	"1. Your tier list must contain all characters in order for your submission to be valid.<br>" +
	"2. Unplayable characters will not be counted.<br>" +
	"3. Character rankings will depend on the tier list order.<br>" +
	"4. You are only allowed to submit one tier list per day.<br><br>";

	// Name Container
	let nameContainer = document.createElement('div');
	nameContainer.id = 'name-container';

		// Name Field
		let nameLabel = document.createElement('span');
		nameLabel.classList.add('form-label');
		nameLabel.id = 'name-label';
		nameLabel.innerHTML = 'Name';
		let nameInput = document.createElement('input');
		nameInput.id = 'name-input';
		nameInput.setAttribute('maxlength', '70');
		nameInput.value = 'Anonymous';
		nameContainer.append(nameLabel, nameInput);

	// Date (YYYY-MM-DD)
	let dateValue = new Date().toISOString().replace(/T.*/,'');

	// Order Container
	let orderContainer = document.createElement('div');
	orderContainer.id = 'order-container';

		// Order
		let orderLabel = document.createElement('span');
		orderLabel.classList.add('form-label');
		orderLabel.id = 'order-label';
		orderLabel.innerHTML = 'Order';
		let orderSelect = document.createElement('select');
		orderSelect.id = 'order-select';

			// Unordered
			let optionUnordered = document.createElement('option');
			optionUnordered.value = 'unordered';
			optionUnordered.innerHTML = 'Unordered';
			orderSelect.append(optionUnordered);

			// Ordered
			let optionOrdered = document.createElement('option');
			optionOrdered.value = 'ordered';
			optionOrdered.innerHTML = 'Ordered';
			orderSelect.append(optionOrdered);
			orderContainer.append(orderLabel, orderSelect);

	// Cancel Button
	let cancelButton = document.createElement('div');
	cancelButton.id = 'cancel-form-button';
	cancelButton.innerHTML = 'Cancel';
	cancelButton.addEventListener('click', () => { removeForm(); });

	// Submit Confirm Button
	let submitButtonConfirm = document.createElement('div');
	submitButtonConfirm.id = 'submit-button-confirm';
	submitButtonConfirm.innerHTML = 'Submit';
	submitButtonConfirm.addEventListener('click', () => {
		if (nameInput.value != '' && nameInput.value.trim() != '') {
			// Escape Special Characters
			nameValue = mysql_real_escape_string(nameInput.value);

			addCharacters();
			submitCommunityData(nameValue, dateValue, JSON.stringify(tierList), orderSelect.value);
		} else { showError('* Name required.'); }
	});

	// Append
	submitForm.append(submitDescription, nameContainer, orderContainer, submitButtonConfirm, cancelButton);
	formContainer.append(submitForm);
}

// Success Submit
function showSuccess() {
	// Save Date to Local Storage to Prevent Resubmission
	let d = new Date();
	localStorage.setItem('local', d.getDate());

	let submitDescription = document.getElementById('submit-description');
	submitDescription.style.textAlign = 'center';
	submitDescription.innerHTML =
	'Successfully submitted!<br>' +
	'You can view your tier list on the ' +
	'<a href="https://www.mk11.kombatakademy.com/mortal-kombat-11/tier-lists?category=community">Tier Lists</a> page.';

	let cancelButton = document.getElementById('cancel-form-button');
	cancelButton.innerHTML = 'Close';

	// Remove
	let nameContainer = document.getElementById('name-container');
	let orderContainer = document.getElementById('order-container');
	let submitButtonConfirm = document.getElementById('submit-button-confirm');
	nameContainer.remove();
	orderContainer.remove();
	submitButtonConfirm.remove();

	disableSubmit(); // Disable Resubmission
}

// Disable Resubmission
function disableSubmit() {
	let submitButton = document.getElementById('submit-button');

	submitButton.removeEventListener('click', submitTierList);
	submitButton.classList.remove('submit-button-hover');
	submitButton.style.background = 'rgb(24,24,24)';
	submitButton.style.color = 'rgb(96,96,96)';
	submitButton.style.cursor = 'default';
}

// Error Submit
function showError(e) {
	let submitForm = document.getElementById('submit-form');
	let submitButtonConfirm = document.getElementById('submitButtonConfirm');
	let errorMessage = document.getElementById('error-message');
	if (errorMessage) { errorMessage.innerHTML = e; }
	else {
		let errorMessage = document.createElement('div');
		errorMessage.id = 'error-message';
		errorMessage.innerHTML = e;
		submitForm.insertBefore(errorMessage, submitButtonConfirm);
	}
}

// Escape Special Characters
function mysql_real_escape_string(str) {
	return str.replace(/[\0\x08\x09\x1a\n\r"'\\\%]/g, function(char) {
		switch (char) {
			case "\0":
				return "\\0";
			case "\x08":
				return "\\b";
			case "\x09":
				return "\\t";
			case "\x1a":
				return "\\z";
			case "\n":
				return "\\n";
			case "\r":
				return "\\r";
			case "\"":
			case "'":
			case "\\":
			case "%":
				return "\\" + char; // Prepend Backslash to Backslash, Percent and Quotes
			default:
				return char;
		}
	});
}