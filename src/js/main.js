$(document).ready(function () {
	const counterUp = $('.counter_up');
	const counterDown = $('.counter_down');
	let currentFloor = 2;
	

	$('.home-image path').on('mouseover', function () {
		$('.home-image path').removeClass('current-floor');
		currentFloor = $(this).attr('data-floor');
		$('.counter_num').text(currentFloor);
	});

	counterUp.on('click', function() {
		if (currentFloor < 18) {
			currentFloor++;
			let formedCurrentFloor = currentFloor.toLocaleString('en-US', { minimumIntegerDigits: 2, useGroupping: false });
			$('.counter_num').text(formedCurrentFloor);
			$('.home-image path').removeClass('current-floor');
			$(`[data-floor=${formedCurrentFloor}]`).toggleClass('current-floor');
		}
	});

	counterDown.on('click', function() {
		if (currentFloor > 2) {
			currentFloor--;
			let formedCurrentFloor = currentFloor.toLocaleString('en-US', { minimumIntegerDigits: 2, useGroupping: false });
			$('.counter_num').text(formedCurrentFloor);
			$('.home-image path').removeClass('current-floor');
			$(`[data-floor=${formedCurrentFloor}]`).toggleClass('current-floor');
		}	
	});
});