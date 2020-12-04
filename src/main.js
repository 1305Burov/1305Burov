
window.onload = function () {

	const $focusIcon = document.querySelectorAll('.input__img');
	const $searchInput = document.querySelector('.search');
	const $accBtn = document.querySelectorAll('.accSwitchBtn');
	const $patienCard = document.querySelectorAll('.sidebar__patient_card');
	const $calendarBlock = document.querySelectorAll('.calendar__block');
	const $closeBlock = document.querySelectorAll('.close');

	//inputFocus script start

	$searchInput.onfocus = function() {

		for ( let i = 0; i < $focusIcon.length; i++ ) {
			$focusIcon[i].classList.toggle('hidden');
			$focusIcon[i].classList.toggle('focusFalse');
		}	
	}

	$searchInput.addEventListener("focusout", function() {
		for ( let i = 0; i < $focusIcon.length; i++ ) {
			$focusIcon[i].classList.toggle('hidden');
			$focusIcon[i].classList.toggle('focusFalse');
			$searchInput.value = '';	
		}
	});



	//inputFocus script end

	//accBtn script start

	// for ( let i = 0; i < $accBtn.length; i++ ) {
		
	// 	$accBtn[i].onclick = function() {
	// 		if ($accBtn[i].classList.contains( 'activeAcc' )) {
				
	// 		}else {
	// 			for ( let i = 0; i < $accBtn.length; i++ ) {
	// 				$accBtn[i].classList.remove('activeAcc');
	// 				this.classList.add('activeAcc');
	// 			}
	// 			if ($accBtn[i].classList.contains( 'activeAcc' )) {
	// 				let activeDoctor;
	// 				activeDoctor = i + 1;

	// 			}
	// 		}
	// 	}
	// }

	//accBtn script end


	//patien card animation script start

	for (let i = 0; i < $patienCard.length; i++) {
		
		$patienCard[i].onmouseover = function() {
			
			this.classList.add('m-0');
		}

		$patienCard[i].onmouseout = function() {
		
			this.classList.remove('m-0');		
		}

		$patienCard[i].ondblclick = function() {
					
			console.log('double');		
		}
	}

	//patien card animation script end 

}




