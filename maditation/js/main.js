const $merits = document.querySelectorAll('.adv__content__box__content__list__item');
const $newsContentHeader = document.querySelector('#newsHeader');
const $newsContent = document.querySelector('.news__content__list');
const $newsHeader = document.querySelectorAll('.news__list__item');

for (let i = 0, l = $merits.length; i < l; i++) {
	$merits[i].onclick = function() {
		for (let a = 0, l = $merits.length; a < l; a++) {
			$merits[a].classList.remove('active');
		}
		$merits[i].classList.add('active');
	}	
}

setInterval(function() {
	for (let i = 0, l = $merits.length; i < l; i++) {
		if ($merits[i].classList.contains('active')) {
			$merits[i].classList.remove('active');
			i++;

			if (i === l) {
				i = 0;
			}

			$merits[i].classList.add('active');
		}

	}
}, 5000);

let newsContentArr = [
	`<li class="news__content__list__item">
		Процедуры аппаратной косметологии на оборудовании экспертного класса от ведущих мировых производителей могут проводиться в любом возрасте и решать широкий спектр проблем: возрастные изменения, покраснения, акне и купероз, потеря тонуса и упругости кожи, отечность, целлюлит и т. п.
	</li>
	<li class="news__content__list__item">
		С помощью инъекционных методик мы можем разгладить морщины, провести объёмное моделирование, увлажнить кожу, ввести активные вещества в поверхностные и средние слои кожи, запустить процессы омоложения.
	</li>
	<li class="news__content__list__item">
		Лазерное и фотоомоложение помогут запустить процесс синтеза собственного коллагена, улучшить светооптические свойства кожи, а также получить максимальный эффект подтяжки лица без уколов и длительного восстановительного периода.
	</li>
	<li class="news__content__list__item">
		Курс процедур лазерной эпиляции поможет навсегда избавиться от проблемы нежелательных волос.
	</li>`,
	`Стандартизация деятельности клиник в соответствии с ISO 9001:2015`,
	`<li class="news__content__list__item">Индивидуальный подход к каждому пациенту</li> <li class="news__content__list__item">Подбор оптимальных косметологических методик.</li>`
];


for (let i = 0, l = $newsHeader.length; i < l; i++) {
	$newsHeader[i].onclick = function() {
		for (let a = 0, l = $newsHeader.length; a < l; a++) {
			$newsHeader[a].classList.remove('active');
		}
		$newsHeader[i].classList.add('active');
		$newsContentHeader.innerText = $newsHeader[i].innerText;
		$newsContent.innerHTML = newsContentArr[i];
	}
}