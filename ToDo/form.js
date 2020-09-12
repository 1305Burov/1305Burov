

const $ul = document.querySelector('.form__list');	

$ul.addEventListener('click', function(event){
	let element = event.target;
	element.classList.toggle('complete');
	check(element);
});


function check(el) {
	if (el.classList.contains('complete')) {
		$ul.append(el);
	}else { 
		$ul.prepend(el);
	}
}


