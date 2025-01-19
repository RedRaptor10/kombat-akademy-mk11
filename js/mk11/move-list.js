let category = 'Basic Attacks';
let basicAttacksButton = document.getElementById('basic-attacks');
let komboAttacksButton = document.getElementById('kombo-attacks');
let specialMovesButton = document.getElementById('special-moves');
let finishersButton = document.getElementById('finishers');
let abilitiesButton = document.getElementById('abilities');
let movesContainer = document.getElementById('move-list-moves-container');

initializeMoveList();

basicAttacksButton.addEventListener('click', () => { changeCategory('Basic Attacks'); });
komboAttacksButton.addEventListener('click', () => { changeCategory('Kombo Attacks'); });
specialMovesButton.addEventListener('click', () => { changeCategory('Special Moves'); });
finishersButton.addEventListener('click', () => { changeCategory('Finishers'); });
abilitiesButton.addEventListener('click', () => { changeCategory('Abilities'); });

function changeCategory(c) {
	if (category != c) {
		category = c;
		movesContainer.innerHTML = '';
		initializeMoveList();
	}
}

function initializeMoveList() {
	let moves = new Array();

	// Check Category
	basicAttacksButton.classList.remove('active');
	komboAttacksButton.classList.remove('active');
	specialMovesButton.classList.remove('active');
	finishersButton.classList.remove('active');
	abilitiesButton.classList.remove('active');

	if (category == 'Basic Attacks') {
		basicAttacksButton.classList.add('active');
		moves = basicAttacks;
	} else if (category == 'Kombo Attacks') {
		komboAttacksButton.classList.add('active');
		moves = komboAttacks;
	} else if (category == 'Special Moves') {
		specialMovesButton.classList.add('active');
		moves = specialMoves;
	} else if (category == 'Finishers') {
		finishersButton.classList.add('active');
		moves = finishers;
	} else if (category == 'Abilities') {
		abilitiesButton.classList.add('active');
		moves = abilities;
	}

	// Move List Left
	let moveListLeft = document.createElement('div');
	moveListLeft.id = 'move-list-left';

		// Input Commands
		let inputCommandsTitleContainer = document.createElement('div');
		inputCommandsTitleContainer.classList.add('move-list-title-container');

			let inputCommandsTitle = document.createElement('div');
			inputCommandsTitle.classList.add('move-list-title');
			inputCommandsTitle.innerHTML = 'INPUT COMMANDS';

		inputCommandsTitleContainer.append(inputCommandsTitle);

		let moveListScroll = document.createElement('div');
		moveListScroll.id = 'move-list-scroll';

			let inputCommands = document.createElement('table');
			inputCommands.id = 'input-commands';

		moveListScroll.append(inputCommands);
		moveListLeft.append(inputCommandsTitleContainer, moveListScroll);

	// Move List Right
	let moveListRight = document.createElement('div');
	moveListRight.id = 'move-list-right';

		// Move Data
		let moveDataTitleContainer = document.createElement('div');
		moveDataTitleContainer.classList.add('move-list-title-container');

			let moveDataTitle = document.createElement('div');
			moveDataTitle.classList.add('move-list-title');
			moveDataTitle.innerHTML = 'MOVE DATA';

		moveDataTitleContainer.append(moveDataTitle);

		let moveData = document.createElement('table');
		moveData.id = 'move-data';

		// Frame Data
		let frameDataTitleContainer = document.createElement('div');
		frameDataTitleContainer.classList.add('move-list-title-container');

			let frameDataTitle = document.createElement('div');
			frameDataTitle.classList.add('move-list-title');
			frameDataTitle.innerHTML = 'FRAME DATA';
		
		frameDataTitleContainer.append(frameDataTitle);

		let frameData = document.createElement('table');
		frameData.id = 'frame-data';

		moveListRight.append(moveDataTitleContainer, moveData, frameDataTitleContainer, frameData);

	movesContainer.append(moveListLeft, moveListRight);

	initializeInputCommands(moves);
	initializeMoveData();
	initializeFrameData();
}

function initializeInputCommands(moves) {
	let inputCommands = document.getElementById('input-commands');
	let prevSubcategory = '';

	// Moves
	moves.forEach(m => {
		// Handle line breaks in description
		m['description'] = m['description'].replace(/\r?\n/g, '<br>');

		/* Subcategory
		Check if current row's subcategory is not empty AND not 'Submove'
		Then check if previous row's subcategory is equal to current row's subcategory*/
		if (m['subcategory'] != '' && m['subcategory'] != 'Submove') {
			if (prevSubcategory != m['subcategory']) {
				let rowSubcategory = document.createElement('tr');
				let dataSubcategory = document.createElement('td');
				dataSubcategory.classList.add('subcategory');

				dataSubcategory.innerHTML = m['subcategory'].toUpperCase();
				rowSubcategory.append(dataSubcategory);
				inputCommands.append(rowSubcategory);
			}
		}

		// Move
		let row = document.createElement('tr');
		let data = document.createElement('td');

		data.addEventListener('mouseover', () => { displayData(m); });
		data.addEventListener('mouseout', () => { resetData(); });

		// Submove
		if (m['subcategory'] == 'Submove') { row.id = 'submove'; }

		let moveName = document.createElement('div');
		moveName.classList.add('move-name');

		// Equipped Icon
		if (m['category'] == 'Abilities') {
			let equippedIcon = document.createElement('img');
			equippedIcon.id = 'equipped';
			equippedIcon.src = 'https://www.mk11.kombatakademy.com/wp-content/uploads/images/Equipped.png';
			moveName.append(equippedIcon);
		}

		moveName.innerHTML += m['move_name'];

		// Input
		let input = document.createElement('div');
		// If Subcategory is equal to Submove then add to left, else add to right
		if (m['subcategory'] == 'Submove') {
			input.classList.add('move-input-left');
			input.innerHTML = '&nbsp&nbsp&nbsp' + m['notation'];
		} else {
			input.classList.add('move-input-right');
			input.innerHTML = m['notation'];
		}

		data.append(moveName, input);
		row.append(data);
		inputCommands.append(row);

		// Set Previous Subcategory
		prevSubcategory = m['subcategory'];
	});
}

function initializeMoveData() {
	let moveData = document.getElementById('move-data');

	// Damage, Block Damage, F/Block Damage
	let rowTitle1 = document.createElement('tr');
		let damageTitle = document.createElement('td');
		let blockDamageTitle = document.createElement('td');
		let fblockDamageTitle = document.createElement('td');

		damageTitle.classList.add('subcategory');
		blockDamageTitle.classList.add('subcategory');
		fblockDamageTitle.classList.add('subcategory');

		damageTitle.innerHTML = 'DAMAGE';
		blockDamageTitle.innerHTML = 'BLOCK DAMAGE';
		fblockDamageTitle.innerHTML = 'F/BLOCK DAMAGE';
	rowTitle1.append(damageTitle, blockDamageTitle, fblockDamageTitle);

	let rowData1 = document.createElement('tr');
		let damage = document.createElement('td');
		let blockDamage = document.createElement('td');
		let fblockDamage = document.createElement('td');

		damage.id = 'damage';
		blockDamage.id = 'block-damage';
		fblockDamage.id = 'flawless-block-damage';

		damage.innerHTML = 'N/A';
		blockDamage.innerHTML = 'N/A';
		fblockDamage.innerHTML = 'N/A';
	rowData1.append(damage, blockDamage, fblockDamage);

	// Move Type
	let rowTitle2 = document.createElement('tr');
		let moveTypeTitle = document.createElement('td');
		moveTypeTitle.classList.add('subcategory');
		moveTypeTitle.colSpan = '3';
		moveTypeTitle.innerHTML = 'MOVE TYPE';
	rowTitle2.append(moveTypeTitle);

	let rowData2 = document.createElement('tr');
		let moveType = document.createElement('td');
		moveType.id = 'move-type';
		moveType.colSpan = '3';
		moveType.innerHTML = 'N/A';
	rowData2.append(moveType);

	// Properties
	let rowTitle3 = document.createElement('tr');
		let propertiesTitle = document.createElement('td');
		propertiesTitle.classList.add('subcategory');
		propertiesTitle.colSpan = '3';
		propertiesTitle.innerHTML = 'PROPERTIES';
	rowTitle3.append(propertiesTitle);

	let rowData3 = document.createElement('tr');
		let moveDataHalfContainer = document.createElement('td');
		moveDataHalfContainer.id = 'move-data-half-container';
		moveDataHalfContainer.colSpan = '3';
			let moveDataHalf = document.createElement('table');
			moveDataHalf.classList.add('move-data-half');
				let moveDataHalfRow = document.createElement('tr');
					let property1 = document.createElement('td');
					let property2 = document.createElement('td');

					property1.id = 'property-1';
					property2.id = 'property-2';

					property1.innerHTML = 'N/A';
					property2.innerHTML = 'N/A';
				moveDataHalfRow.append(property1, property2);
			moveDataHalf.append(moveDataHalfRow);
		moveDataHalfContainer.append(moveDataHalf);
	rowData3.append(moveDataHalfContainer);

	// Description
	let rowTitle4 = document.createElement('tr');
		let descriptionTitle = document.createElement('td');
		descriptionTitle.classList.add('subcategory');
		descriptionTitle.colSpan = '3';
		descriptionTitle.innerHTML = 'DESCRIPTION';
	rowTitle4.append(descriptionTitle);

	let rowData4 = document.createElement('tr');
		let description = document.createElement('td');
		description.id = 'description';
		description.colSpan = '3';
		description.innerHTML = 'N/A';
	rowData4.append(description);

	moveData.append(rowTitle1, rowData1, rowTitle2, rowData2, rowTitle3, rowData3, rowTitle4, rowData4);
}

function initializeFrameData() {
	let frameData = document.getElementById('frame-data');

	// Start-up, Active, Recovery
	let rowTitle5 = document.createElement('tr');
		let startupTitle = document.createElement('td');
		let activeTitle = document.createElement('td');
		let recoveryTitle = document.createElement('td');

		startupTitle.classList.add('subcategory');
		activeTitle.classList.add('subcategory');
		recoveryTitle.classList.add('subcategory');

		startupTitle.innerHTML = 'START-UP';
		activeTitle.innerHTML = 'ACTIVE';
		recoveryTitle.innerHTML = 'RECOVERY';
	rowTitle5.append(startupTitle, activeTitle, recoveryTitle);

	rowData5 = document.createElement('tr');
		let startup = document.createElement('td');
		let active = document.createElement('td');
		let recovery = document.createElement('td');

		startup.id = 'start-up';
		active.id = 'active';
		recovery.id = 'recovery';

		startup.innerHTML = 'N/A';
		active.innerHTML = 'N/A';
		recovery.innerHTML = 'N/A';
	rowData5.append(startup, active, recovery);

	// Cancel
	let rowTitle6 = document.createElement('tr');
		let cancelAdvantageTitle = document.createElement('td');
		cancelAdvantageTitle.classList.add('subcategory');
		cancelAdvantageTitle.id = 'cancel-advantage-title';
		cancelAdvantageTitle.colSpan = '3';
		cancelAdvantageTitle.innerHTML = 'CANCEL';
	rowTitle6.append(cancelAdvantageTitle);

	rowData6 = document.createElement('tr');
		let cancelAdvantage = document.createElement('td');
		cancelAdvantage.id = 'cancel-advantage';
		cancelAdvantage.colSpan = '3';
		cancelAdvantage.innerHTML = 'N/A';
	rowData6.append(cancelAdvantage);

	// Hit Advantage, Block Advantage, F/Block Advantage
	rowTitle7 = document.createElement('tr');
		let hitAdvantageTitle = document.createElement('td');
		let blockAdvantageTitle = document.createElement('td');
		let fblockAdvantageTitle = document.createElement('td');

		hitAdvantageTitle.classList.add('subcategory');
		blockAdvantageTitle.classList.add('subcategory');
		fblockAdvantageTitle.classList.add('subcategory');

		hitAdvantageTitle.innerHTML = 'HIT ADVANTAGE';
		blockAdvantageTitle.innerHTML = 'BLOCK ADVANTAGE';
		fblockAdvantageTitle.innerHTML = ' F/BLOCK ADVANTAGE';
	rowTitle7.append(hitAdvantageTitle, blockAdvantageTitle, fblockAdvantageTitle);

	rowData7 = document.createElement('tr');
		let hitAdvantage = document.createElement('td');
		let blockAdvantage = document.createElement('td');
		let fblockAdvantage = document.createElement('td');

		hitAdvantage.id = 'hit-advantage';
		blockAdvantage.id = 'block-advantage';
		fblockAdvantage.id = 'flawless-block-advantage';

		hitAdvantage.innerHTML = 'N/A';
		blockAdvantage.innerHTML = 'N/A';
		fblockAdvantage.innerHTML = 'N/A';
	rowData7.append(hitAdvantage, blockAdvantage, fblockAdvantage);

	frameData.append(rowTitle5, rowData5, rowTitle6, rowData6, rowTitle7, rowData7);
}

function displayData(move) {
	if (move['damage'] != '') { document.getElementById('damage').innerHTML = move['damage']; }
	else { document.getElementById('damage').innerHTML = 'N/A'; }

	if (move['block_damage'] != '') { document.getElementById('block-damage').innerHTML = move['block_damage']; }
	else { document.getElementById('block-damage').innerHTML = 'N/A'; }

	if (move['fblock_damage'] != '') { document.getElementById('flawless-block-damage').innerHTML = move['fblock_damage']; }
	else { document.getElementById('flawless-block-damage').innerHTML = 'N/A'; }

	if (move['move_type'] != '') { document.getElementById('move-type').innerHTML = move['move_type']; }
	else { document.getElementById('move-type').innerHTML = 'N/A'; }

	if (move['property_1'] != '') { document.getElementById('property-1').innerHTML = move['property_1']; }
	else { document.getElementById('property-1').innerHTML = 'N/A'; }

	if (move['property_2'] != '') { document.getElementById('property-2').innerHTML = move['property_2']; }
	else { document.getElementById('property-2').innerHTML = 'N/A'; }

	if (move['description'] != '') { document.getElementById('description').innerHTML = move['description']; }
	else { document.getElementById('description').innerHTML = 'N/A'; }

	if (move['startup'] != '') { document.getElementById('start-up').innerHTML = move['startup']; }
	else { document.getElementById('start-up').innerHTML = 'N/A'; }

	if (move['active'] != '') { document.getElementById('active').innerHTML = move['active']; }
	else { document.getElementById('active').innerHTML = 'N/A'; }

	if (move['recovery'] != '') { document.getElementById('recovery').innerHTML = move['recovery']; }
	else { document.getElementById('recovery').innerHTML = 'N/A'; }

	if (move['cancel_adv'] != '') { document.getElementById('cancel-advantage').innerHTML = move['cancel_adv']; }
	else { document.getElementById('cancel-advantage').innerHTML = 'N/A'; }

	if (move['hit_adv'] != '') { document.getElementById('hit-advantage').innerHTML = move['hit_adv']; }
	else { document.getElementById('hit-advantage').innerHTML = 'N/A'; }

	if (move['block_adv'] != '') { document.getElementById('block-advantage').innerHTML = move['block_adv']; }
	else { document.getElementById('block-advantage').innerHTML = 'N/A'; }

	if (move['fblock_adv'] != '') { document.getElementById('flawless-block-advantage').innerHTML = move['fblock_adv']; }
	else { document.getElementById('flawless-block-advantage').innerHTML = 'N/A'; }
}

function resetData() {
	document.getElementById('damage').innerHTML = 'N/A';
	document.getElementById('block-damage').innerHTML = 'N/A';
	document.getElementById('flawless-block-damage').innerHTML = 'N/A';
	document.getElementById('move-type').innerHTML = 'N/A';
	document.getElementById('property-1').innerHTML = 'N/A';
	document.getElementById('property-2').innerHTML = 'N/A';
	document.getElementById('description').innerHTML = 'N/A';
	document.getElementById('start-up').innerHTML = 'N/A';
	document.getElementById('active').innerHTML = 'N/A';
	document.getElementById('recovery').innerHTML = 'N/A';
	document.getElementById('cancel-advantage').innerHTML = 'N/A';
	document.getElementById('hit-advantage').innerHTML = 'N/A';
	document.getElementById('block-advantage').innerHTML = 'N/A';
	document.getElementById('flawless-block-advantage').innerHTML = 'N/A';
}