// Mobile
let mobile = false;
// Element to add before
let input = document.querySelector('.cb-row--mobile div.col-v2.col-v2-right');
if( /Android|webOS|iPhone|iPad|Mac|Macintosh|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
	mobile = true;
}

// Notation Platform Selector
let currentPlatform = 'universal';
// Load Platform from Session Storage
if (sessionStorage.getItem('platform')) {
	currentPlatform = sessionStorage.getItem('platform');
	togglePlatform(currentPlatform);
}

// If Move List or Combo List, Toggle Platform on Change
if (document.getElementById('move-list-moves-container')) {
	basicAttacksButton.addEventListener('click', () => { togglePlatform(currentPlatform); });
	komboAttacksButton.addEventListener('click', () => { togglePlatform(currentPlatform); });
	specialMovesButton.addEventListener('click', () => { togglePlatform(currentPlatform); });
	finishersButton.addEventListener('click', () => { togglePlatform(currentPlatform); });
	abilitiesButton.addEventListener('click', () => { togglePlatform(currentPlatform); });
} else if (document.getElementById('combo-list')) {
	midscreen.addEventListener('click', () => { togglePlatform(currentPlatform); });
	corner.addEventListener('click', () => { togglePlatform(currentPlatform); });
}

// Create Platform Selector
let headerHtmlContainer = document.getElementById('header-html-container');
let notationForm = document.createElement('form');
notationForm.id = 'selectPlatform';

let platformSelector = document.createElement('select');
platformSelector.id = 'platform';

	let optionDefault = document.createElement('option');
	optionDefault.value = '';
	optionDefault.innerHTML = 'Select Platform';
	let option1 = document.createElement('option');
	option1.value = 'universal';
	option1.innerHTML = 'Universal';
	let option2 = document.createElement('option');
	option2.value = 'ps4';
	option2.innerHTML = 'PlayStation 4';
	let option3 = document.createElement('option');
	option3.value = 'xb1';
	option3.innerHTML = 'Xbox One';
	let option4 = document.createElement('option');
	option4.value = 'plain-text';
	option4.innerHTML = 'Plain-Text';

	platformSelector.addEventListener('change', () => { togglePlatform(platformSelector.value); });

platformSelector.append(optionDefault, option1, option2, option3, option4);
notationForm.append(platformSelector);

// If mobile, add form before element
if (mobile) { input.parentNode.insertBefore(notationForm, input); }
else { headerHtmlContainer.append(notationForm); }

function togglePlatform(platform) {
	// Exit if no platform or default platform
	if ((platform == '') || (currentPlatform == 'universal' && platform == 'universal')) { return; }

	let url = 'https://www.mk11.kombatakademy.com/wp-content/uploads/mortal-kombat-11/notation/';
	let slug = '';
	let ext = '.png';
	let inputs = document.querySelectorAll('.input');
	let classList = '';
	let nodeName = '';
	currentPlatform = platform;

	// Save Platform to Session Storage
	if (platform == 'universal') { sessionStorage.removeItem('platform'); }
	else { sessionStorage.setItem('platform', platform); }

	inputs.forEach((input) => {
		classList = input.classList;

		// Directionals
		if (platform != 'plain-text') {
			nodeName = 'img';
			if (input.classList.contains('input-left')) { slug = 'left'; }
			else if (input.classList.contains('input-up')) { slug = 'up'; }
			else if (input.classList.contains('input-down')) { slug = 'down'; }
			else if (input.classList.contains('input-right')) { slug = 'right'; }
			else if (input.classList.contains('input-up-left')) { slug = 'up-left'; }
			else if (input.classList.contains('input-up-right')) { slug = 'up-right'; }
			else if (input.classList.contains('input-down-left')) { slug = 'down-left'; }
			else if (input.classList.contains('input-down-right')) { slug = 'down-right'; }
		} else {
			nodeName = 'span';
			if (input.classList.contains('input-left')) { slug = 'B'; }
			else if (input.classList.contains('input-up')) { slug = 'U'; }
			else if (input.classList.contains('input-down')) { slug = 'D'; }
			else if (input.classList.contains('input-right')) { slug = 'F'; }
			else if (input.classList.contains('input-up-left')) { slug = 'U+B'; }
			else if (input.classList.contains('input-up-right')) { slug = 'U+F'; }
			else if (input.classList.contains('input-down-left')) { slug = 'D+B'; }
			else if (input.classList.contains('input-down-right')) { slug = 'D+F'; }
		}

		switch(platform) {
			case 'universal':
				nodeName = 'img'; 
				if (input.classList.contains('input-fb')) { slug = 'FB'; nodeName = 'span'; }
				else if (input.classList.contains('input-throw')) { slug = 'Throw'; nodeName = 'span'; }
				else if (input.classList.contains('input-amp')) { slug = 'AMP'; nodeName = 'span'; }
				else if (input.classList.contains('input-stance')) { slug = 'SS'; nodeName = 'span'; }
				else if (input.classList.contains('input-block')) { slug = 'Block'; nodeName = 'span'; }
				else if (input.classList.contains('input-one')) { slug = 'one'; }
				else if (input.classList.contains('input-two')) { slug = 'two'; }
				else if (input.classList.contains('input-three')) { slug = 'three'; }
				else if (input.classList.contains('input-four')) { slug = 'four'; }
				break;
			case 'ps4':
				nodeName = 'img'; 
				if (input.classList.contains('input-fb')) { slug = 'fb'; }
				else if (input.classList.contains('input-throw')) { slug = 'l1'; }
				else if (input.classList.contains('input-amp')) { slug = 'r1'; }
				else if (input.classList.contains('input-stance')) { slug = 'l2'; }
				else if (input.classList.contains('input-block')) { slug = 'r2'; }
				else if (input.classList.contains('input-one')) { slug = 'square'; }
				else if (input.classList.contains('input-two')) { slug = 'triangle'; }
				else if (input.classList.contains('input-three')) { slug = 'cross'; }
				else if (input.classList.contains('input-four')) { slug = 'circle'; }
				break;
			case 'xb1':
				nodeName = 'img'; 
				if (input.classList.contains('input-fb')) { slug = 'fb'; }
				else if (input.classList.contains('input-throw')) { slug = 'lb'; }
				else if (input.classList.contains('input-amp')) { slug = 'rb'; }
				else if (input.classList.contains('input-stance')) { slug = 'lt'; }
				else if (input.classList.contains('input-block')) { slug = 'rt'; }
				else if (input.classList.contains('input-one')) { slug = 'x'; }
				else if (input.classList.contains('input-two')) { slug = 'y'; }
				else if (input.classList.contains('input-three')) { slug = 'a'; }
				else if (input.classList.contains('input-four')) { slug = 'b'; }
				break;
			case 'plain-text':
				nodeName = 'span'; 
				if (input.classList.contains('input-fb')) { slug = 'FB'; }
				else if (input.classList.contains('input-throw')) { slug = 'Throw'; }
				else if (input.classList.contains('input-amp')) { slug = 'AMP'; }
				else if (input.classList.contains('input-stance')) { slug = 'SS'; }
				else if (input.classList.contains('input-block')) { slug = 'Block'; }
				else if (input.classList.contains('input-one')) { slug = '1'; }
				else if (input.classList.contains('input-two')) { slug = '2'; }
				else if (input.classList.contains('input-three')) { slug = '3'; }
				else if (input.classList.contains('input-four')) { slug = '4'; }
				break;
		}

		// Fatal Blow
		if (slug == 'fb') {
			let newInputs = document.createElement('span');
			let newInput1 = document.createElement('img');
			let newInput2 = document.createElement('img');
			newInputs.classList.add('input', 'input-fb', 'shoulder');

			if (platform == 'ps4') {
				newInput1.classList.add('input', 'input-l2', 'shoulder');
				newInput2.classList.add('input', 'input-r2', 'shoulder');
				newInput1.src = url + platform + '/' + 'l2' + ext;
				newInput2.src = url + platform + '/' + 'r2' + ext;
			} else if (platform == 'xb1') {
				newInput1.classList.add('input', 'input-lt', 'shoulder');
				newInput2.classList.add('input', 'input-rt', 'shoulder');
				newInput1.src = url + platform + '/' + 'lt' + ext;
				newInput2.src = url + platform + '/' + 'rt' + ext;
			}

			newInputs.append(newInput1,'+',newInput2);
			input.parentNode.replaceChild(newInputs, input);
		}
		else if (nodeName == 'img') {
			let newInput = document.createElement('img');
			classList.forEach((className) => { newInput.classList.add(className); });
			if (newInput.classList.contains('directional')) { newInput.src = url + '/' + slug + ext; }
			else { newInput.src = url + platform + '/' + slug + ext; }
			input.parentNode.replaceChild(newInput, input);
		} else if (nodeName == 'span') {
			let newInput = document.createElement('span');
			classList.forEach((className) => { newInput.classList.add(className); });
			newInput.innerHTML = slug;
			input.parentNode.replaceChild(newInput, input);
		}
	});
}