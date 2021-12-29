$(document).ready( () => {

	const API = '293a0484459e838672669b928c199456';// - API key;  293a0484459e838672669b928c199456
	const locationWarning = $('.main__box_location');
	const search = $('#citySearch');
	const searchButton = $('#searchBtn');
	//данные погоды
	const city = $('.main__box_city span');
	const weather = $('.main__box_weather span');
	const degrees = $('.main__box_degrees span');
	const weatherIcon = $('.main__box_img');
	const time = $('.main__box_time span');
	const feels = $('.main__box_feels');
	const pressure = $('.main__box_pressure');
	const humidity = $('.main__box_humidity');
	const wind = $('.main__box_wind');
	
	if (navigator.geolocation) {

		// Получение геолокации пользователя
		navigator.geolocation.getCurrentPosition(success, error);

		// Если пользователь включил геолокацию

		function success(pos) {
			let crd = pos.coords;
			let lat = crd.latitude;
			let lon = crd.longitude;

			fetch(`http://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&lang=ru&units=metric&appid=${API}`).then( (resp) => { return resp.json() }).then( (data) => {
				locationWarning.text(getDate(data.dt));
				city.text(`${data.name}`);
				weather.text(`${data.weather[0].description}`);
				degrees.html(`${Math.round(data.main.temp)} &deg;`);
				weatherIcon.html(`<img src="https://openweathermap.org/img/wn/${data.weather[0]['icon']}@2x.png">`);
				time.text('сейчас');
				feels.html(`По ощущению: <span>${Math.round(data.main.feels_like)} &deg;</span>`);
				pressure.html(`Давление: <span>${data.main.pressure * 0.75} мм рт. ст.</span>`);
				humidity.html(`Влажность:  <span>${data.main.humidity} %</span>`);
				wind.html(`Ветер: <span>${data.wind.speed} м/с</span>`);	
			})
		};

		// Если пользователь отклонил геолокацию

		function error(err) {
			locationWarning.text('геолокация выключенна');
		};

	}else {
		locationWarning.text('Ваш браузер не поддерживает геолокацию');
	}

	search.val('Киев');

	search.on('input', () => {
        search.val(search.val().substr(0, 30));
	});

	//отправка запроса для поиска города
	searchButton.on('click', () => {
		let cityName = search.val().trim(); //Название города для локации
		// let countryCode = 'UA'; //Код страны

		for (let i = 0, l = cityName.length; i < l; i++) {
			if (cityName[i] == ';' || cityName[i] == '@' || cityName[i] == '!' || cityName[i] == '.' || cityName[i] == '/' || cityName[i] == '(' || cityName[i] == '}' || cityName[i] == '[' || cityName[i] == '?') {
				$('#inputWrapper').addClass('error_symbols');
				search.addClass('error');
				setTimeout( () => search.removeClass('error'), 3000);
				search.on('click', () => {
					search.removeClass('error');
				});
				return;
			}
		}
				
		fetch(`http://api.openweathermap.org/geo/1.0/direct?q=${cityName}&limit=2&appid=${API}`).then( (resp) => { return resp.json() }).then( (data) => {
			if (data.length > 0) {
				$('#inputWrapper').removeClass('error_text');
				$('#inputWrapper').removeClass('error_symbols');
				let lat = data[0].lat;
				let lon = data[0].lon;
				let local = data[0].local_names.ru;

				fetch(`https://api.openweathermap.org/data/2.5/onecall?lat=${lat}&lon=${lon}&lang=ru&units=metric&exclude=daily&appid=${API}`).then( (resp) => { return resp.json() }).then( (data) => {
					locationWarning.text(getDate(data.current.dt));
					city.text(`${local}`);
					weather.text(`${data.current.weather[0].description}`);
					degrees.html(`${Math.round(data.current.temp)} &deg;`);
					weatherIcon.html(`<img src="https://openweathermap.org/img/wn/${data.current.weather[0]['icon']}@2x.png">`);
					time.text('сейчас');
					feels.html(`По ощущению: <span>${Math.round(data.current.feels_like)} &deg;</span>`);
					pressure.html(`Давление: <span>${data.current.pressure * 0.75} мм рт. ст.</span>`);
					humidity.html(`Влажность:  <span>${data.current.humidity} %</span>`);
					wind.html(`Ветер: <span>${data.current.wind_speed} м/с</span>`);

					locationWarning.on('click', () => {
						search.val(local);
						searchButton.click();
					});

					for (let i = 0, l = data.hourly.length; i < l; i++) {
						$(".slider").slick("slickRemove", false);
					}

					for (let i = 0, l = data.hourly.length; i < l; i++) {
						let bor = '';
						let weatherDescr = data.hourly[i].weather[0].description;
						let weatherIcon = data.hourly[i].weather[0].icon;
						let weatherDegrees = Math.round(data.hourly[i].temp);
						let weatherTime = getTime(data.hourly[i].dt);

						if (getTime(data.hourly[i].dt) == '0:00') {
							bor = 'bor-l'
	  						weatherTime = getDate(data.hourly[i].dt);
	  					}
	  					$('.slider').slick('slickAdd', ` <div><div class="main__box_weather"><span>${weatherDescr}</span></div>
							<div class="${bor}">
								<div class="d-flex jc-c">
								<div class="main__box_img"><img src="https://openweathermap.org/img/wn/${weatherIcon}@2x.png"></div>
								<div class="main__box_degrees"><span>${weatherDegrees} &deg;</span></div>
							</div>
							<div class="main__box_time"><span>${weatherTime}</span></div></div>
							<input id="feels" type="hidden" value="${data.hourly[i].feels_like} ">
							<input id="humidity" type="hidden" value="${data.hourly[i].humidity}%">
							<input id="pressure" type="hidden" value="${data.hourly[i].pressure * 0.75} мм рт. ст.">
							<input id="wind" type="hidden" value="${data.hourly[i].wind_speed} м/с">`);
					}	
					$('.slick-track').on('click','.slick-slide', (e) => {
						if (event.path[4].classList.contains('slick-slide')) {
							feels.html(`По ощущению: <span>${Math.round(event.path[4].childNodes[4].value)} &deg;</span>`); //feels like
							humidity.html(`Влажность:  <span>${event.path[4].childNodes[6].value} </span>`); //humidity 
							pressure.html(`Давление: <span>${event.path[4].childNodes[8].value} </span>`); //pressure 
							wind.html(`Ветер: <span>${event.path[4].childNodes[10].value} </span>`); //wind 
							degrees.html(`${event.path[4].childNodes[2].childNodes[1].childNodes[3].textContent}`); //degrees
							weatherIcon.html(`<img src="${event.path[4].childNodes[2].childNodes[1].childNodes[1].childNodes[0].src}">`); //weather Image src
							weather.text(`${event.path[4].childNodes[0].textContent}`); //weather descr
							time.text(event.path[4].childNodes[2].childNodes[3].textContent); //time
						}
					});
				});
				search.val('');
			}else {
				//ошибка город не найден
				$('#inputWrapper').removeClass('error_symbols');
				search.addClass('error');
				$('#inputWrapper').addClass('error_text');
				setTimeout( () => search.removeClass('error'), 3000);
				search.on('click', () => {
					search.removeClass('error');
				});
			}
		});
	});

	searchButton.click();
	

	//отправка запроса при нажатии enter
	search.on('keypress', (e) => {
	    if(e.which == 13) {
	        searchButton.click();
	    }
	});
	//Возвращает дату в формате 31.12.2021, 12:21
	function getDate(d) {
		let date = new Date(d * 1000);
		currentDate = date.getDate().toLocaleString('en-US', { minimumIntegerDigits: 2, useGroupping: false }) + '.' + (`${(date.getMonth() + 1).toLocaleString('en-US', { minimumIntegerDigits: 2, useGroupping: false })}`) + '.' + date.getFullYear() + ", " + date.getHours() + ':' + date.getMinutes().toLocaleString('en-US', { minimumIntegerDigits: 2, useGroupping: false });
		return currentDate;
	}
	//Возвращает время в формате 12:00
	function getTime(t) {
		let date = new Date(t * 1000);
		currentDate = date.getHours() + ':' + `00`;
		return currentDate;
	}

});
