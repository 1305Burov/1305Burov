


var DATA;

function getFile (fileName) {

    var request = new XMLHttpRequest();

    request.open('GET', fileName);

    request.onloadend = function() {

        parse(request.responseText);
    }

    request.send();
}

getFile('list.json'); //путь к файлу

function parse(obj) {

    DATA = JSON.parse(obj);

    select(DATA);
}


function select(data) {
	const $select = document.querySelector('.select');
	const $matches = document.querySelector('.matches');

	let letters = getLetters();


	for (let i = 0; i <  letters.length; i++ ) {
		$select.innerHTML += `<option value="${letters[i]}">${letters[i]}</option>`;
		
	}


	if ($select) {
		$matches.innerHTML = '';
		for (let j = 0; j < data.length; j++) {
			if ($select.children[0].value == data[j]['name'][0].toLowerCase()) {
				$matches.innerHTML += `<div class="matches__item">${data[j]['name']}</div>`;
			}
		}

		if ($matches.innerHTML == '') {
			$matches.innerHTML = "no matches";
		}
	}
		

	$select.addEventListener('change', function (e) {
		$matches.innerHTML = '';
		for (let j = 0; j < data.length; j++) {
			if (e.target.value == data[j]['name'][0].toLowerCase()) {
				$matches.innerHTML += `<div class="matches__item">${data[j]['name']}</div>`;
			}
		}

		if ($matches.innerHTML == '') {
			$matches.innerHTML = "no matches";
		}
	  		
	})

	
}












//random unique letters

function getLetters() {

	let alphabet = "abcdefghijklmnopqrstuvwxyz";
	let array = [];
	

	while (array.length != 5) {
		let randomIndex = Math.floor(Math.random() * alphabet.length);
		let randomLetter = alphabet[randomIndex];

		array.push(randomLetter);
		alphabet = alphabet.replace(randomLetter, '');
	}

	return array;
}




