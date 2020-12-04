<?php
	$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
	$nowDate = date("m/d/Y");
	$start = strtotime($nowDate);
	$finish = strtotime('12/31/2024');
	$dataMas = [];

	$timeNow = date('h');	

	$arrayOfDates = array();
	for($i=$start; $i<=$finish; $i+=86400) {
	    if (date('D', $i) != 'Sun') {

	        list($year, $month, $day) = explode("|", date("Y|m|d", $i));
	        $arrayOfDates[$year][$month][$day] = $day;
	        $a = 0;
	        $dayName = date('D', $i);

	        if (date('D', $i) === 'Fri') {
	            $dayName =' Пятница_';
	        }else if (date('D', $i) === 'Sat') {
	            $dayName =' Суббота_';
	        }else if (date('D', $i) === 'Mon') {
	            $dayName =' Понедельник_';
	        }else if (date('D', $i) === 'Tue') {
	            $dayName =' Вторник_';
	        }else if (date('D', $i) === 'Wed') {
	            $dayName =' Среда_';
	        }else if (date('D', $i) === 'Thu') {
	            $dayName =' Четверг_';
	        }

	        if ($month === '05') {
	            $month = 'Май ';
	        } else if ($month === '06') {
	            $month = 'Июнь ';
	        } else if ($month === '07') {
	            $month = 'Июль ';
	        }else if ($month === '08') {
	            $month = 'Август ';
	        }else if ($month === '09') {
	            $month = 'Сентябрь ';
	        }else if ($month === '10') {
	            $month = 'Октябрь ';
	        }else if ($month === '11') {
	            $month = 'Ноябрь ';
	        }else if ($month === '12') {
	            $month = 'Декабрь ';
	        }else if ($month === '01') {
	            $month = 'Январь ';
	        }else if ($month === '02') {
	            $month = 'Февраль ';
	        }else if ($month === '03') {
	            $month = 'Март ';
	        }else if ($month === '04') {
	            $month = 'Апрель ';
	        }

	        array_push( $dataMas,$month, $day, $dayName );

	    }
	}
	
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/main.min.css">
	<title>Document</title>
</head>
<body>
	<section class="addPatientDate hidden">
		
	</section>

	<!-- <section class="newPatient hidden">

		<form class="flex">

			<label>
				Имя <br>
				<input type="text">
			</label>

			<label>Фамилия <br>
				<input type="text">
			</label>

			<label>Отчество <br>
				<input type="text">
			</label>

			<button class="send">Добавить пациента</button>
		</form>
		
	</section> -->
	<header class="header">
		<div class="container">
			<div>
				<img class="addPatient" draggable="false" src="img/addPatientBtn.png" alt="addPatien">
				<img class="addPatient hidden" id="closeBtnPatient" draggable="false" src="img/closePatientBtn.png" alt="closePatien">
				<img class="input__img focusFalse" draggable="false" src="img/search.png" alt="search">
				<img class="input__img hidden" draggable="false" src="img/searchFocus.png" alt="search">
				<input class="search" placeholder="Найти пациента..." type="text">
			</div>
		</div>
	</header>	

	<div class="container flex">


		<main class="main">
			<div class="accSwitch">
				<!-- activeAcc -->
				<?php 
					
					foreach($connection->query('SELECT * FROM doctors') as $row) {	
						
						if ($row['doctor_id'] == 1) {
							echo "<div class='accSwitchBtn activeAcc'>". $row['doctor_name']."</div>";	
						}else {
							echo "<div class='accSwitchBtn'>". $row['doctor_name'] ."</div>";
						}
						
					}

					
				?>
			</div>
				
				<div class="box__nav_calendar" >
					<img  draggable="false" class="nav prew" src="img/prew.png" alt="prew">
					<img  draggable="false" class="nav next" src="img/next.png" alt="next">
				</div>
				
			<div class="calendar__box">
				
				<!-- <div class="calendar__box__text">
					Ноябрь 07 Суббота
				</div>
				<div class="calendar">
					<div class="calendar__block active">9:00<div class="patient_name"></div></div>
					<div class="calendar__block">10 <div class="patient_name"></div></div>
					<div class="calendar__block">11 <div class="patient_name"></div></div>
					<div class="calendar__block">12 <div class="patient_name"></div></div>
					<div class="calendar__block">13 <div class="patient_name"></div></div>
					<div class="calendar__block">14 <div class="patient_name"></div></div>
					<div class="calendar__block">15 <div class="patient_name"></div></div>
					<div class="calendar__block">16 <div class="patient_name"></div></div>
					<div class="calendar__block">17 <div class="patient_name"></div></div>
					<div class="calendar__block">18<div class="patient_name"></div></div>
				</div> -->
			</div>


		</main>

		<section class="newPatient hidden">

			<form class="flex">

				<label>
					Фамилия  <br>
					<input type="text">
				</label>

				<label>Имя<br>
					<input type="text">
				</label>

				<label>Отчество <br>
					<input type="text">
				</label>

				<label>Возраст <br>
					<input type="number">
				</label>

				<label>Адрес <br>
					<input type="text">
				</label>

				<label>Номер телефона <br>
					<input type="tel">
				</label>

				<button class="send">Добавить пациента</button>
			</form>
			
		</section>


		<section class="sidebar" id="hide">

			

			<script>

				const $accBtn = document.querySelectorAll('.accSwitchBtn');
				const $sidebar = document.querySelector('.sidebar');
				const $sidehide = document.querySelector('#hide');
				const addPatient = document.querySelector('.addPatient');
				const closePatient = document.querySelector('#closeBtnPatient');
				const newPatient = document.querySelector('.newPatient');
				const send = document.querySelector('.send');
				
				for ( let i = 0; i < $accBtn.length; i++ ) {
								//doctor default
								$sidebar.innerHTML = '';
								let content = `<?php getDoc();?>`;
								$sidebar.insertAdjacentHTML('beforeEnd',content);
					
					$accBtn[i].onclick = function() {
						if ($accBtn[i].classList.contains( 'activeAcc' )) {
							
						}else {
							for ( let i = 0; i < $accBtn.length; i++ ) {
								if (newPatient.classList.contains('hidden')) {
									$accBtn[i].classList.remove('activeAcc');
									this.classList.add('activeAcc');
								}else {
									swal("Добавьте пациента", "", "error");
								}
								
							}
							if ($accBtn[i].classList.contains( 'activeAcc' )) {
								let activeDoctor;
								activeDoctor = i + 1;
								//show doctor 1
								if (activeDoctor == 1) {
									$sidebar.innerHTML = '';
									let content = `<?php getDoc();?>`;
									$sidebar.insertAdjacentHTML('beforeEnd',content);
									dragAndDrop();	
									cardAnimate();
								}
								//show doctor 2
								if (activeDoctor == 2) {
									$sidebar.innerHTML = '';
									let content = `<?php getDoc(2);?>`;
									$sidebar.insertAdjacentHTML('beforeEnd',content);
									dragAndDrop();
									cardAnimate();
								}
								//show doctor 3
								if (activeDoctor == 3) {
									$sidebar.innerHTML = '';
									let content = `<?php getDoc(3);?>`;
									$sidebar.insertAdjacentHTML('beforeEnd',content);
									dragAndDrop();
									cardAnimate();
								}
								
							}
						}
					}
				}

			</script>

			<?php 

				function getDoc($activeDoctor = 1) {
					$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
					foreach($connection->query('SELECT * FROM doctors') as $row) {
						foreach($connection->query('SELECT * FROM patients') as $patient) {		
							if ($activeDoctor == $row['doctor_id']) {
								if ($row['doctor_id'] === $patient['doctor_id']) {	
									echo '<div draggable="true" class="sidebar__patient_card" id="'.$patient['patient_id'].'">'. $patient['patient_name'] .'</div>';
								}
							}	
						 	
						}	
					}
				}
				
				
			?>


			
		</section>
	</div>



	<script src="js/main.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<script>


		
		const dayContent = document.querySelector('.calendar__box');
		const next = document.querySelector('.next');
		const prew = document.querySelector('.prew');

		let numDays = 5; //10
		let week = 0; //5

		getWeek();

	    function getWeek(numDays = 5, week = 0) {
		    	let day = [`<?php
		    for($i=0; $i<=200; $i++) {
		        echo $dataMas[$i];
		    }
		    ?>`];

		    let arr = [];
		    for ( let i = 0; i <= day.length-1; i++ ) {
		        arr = day[i].split('_');
		    }
		       
		    let dataSet = '';
		    let timeSet = 0;

		    for ( let i = week; i <= numDays; i++ ) {
		        let content = `<div class="wrapper"><div class="calendar__box__text">

		            ${arr[i]}

					</div>
		            <div class="calendar"></div></div>`;
		        dayContent.insertAdjacentHTML( 'beforeEnd', content );
		        
		        const timeContent = document.querySelectorAll('.calendar');
		        for ( let j = 9; j <= 18; j++ ) {
		        	if (arr[i] === dataSet && j === timeSet) {
		        		let con = `<div class="calendar__block active"> ${j}:00 <div class="patient_name"></div></div>`;
		        		timeContent[i - week].insertAdjacentHTML('beforeEnd', con);
		        	}else {
		        		let con = `<div class="calendar__block"><div class="time hidden">${j}:00</div> ${j}:00<div class="patient_name"></div></div>`;
		        		timeContent[i - week].insertAdjacentHTML('beforeEnd', con);
		        	}
		            
		        }
		    }
	    }


	    next.onclick = function() {
	    	dayContent.innerHTML = '';
	    	numDays += 5;
	    	week += 5;
	    	getWeek(numDays,week);
	    	dragAndDrop();
	    }

	    prew.onclick = function() {
	    	if (week != 0) {
	    		dayContent.innerHTML = '';
	    		numDays -= 5;
	    		week -= 5;
	    		getWeek(numDays,week);
	    		dragAndDrop();	
	    	}	
	    }

		dragAndDrop();

		function dragAndDrop() {

			const $patienCard = document.querySelectorAll('.sidebar__patient_card');
			const $calendarBlock = document.querySelectorAll('.calendar__block');

			for (let i = 0; i < $calendarBlock.length; i++) {
				$calendarBlock[i].ondragover = allowDrop;
				$calendarBlock[i].ondrop = Drop;	
			}


			for (let i = 0; i < $patienCard.length; i++) {
				$patienCard[i].ondragstart = drag;

			}
		}

		function allowDrop(event) {
			event.preventDefault();
		}

		function drag(event) {
			event.dataTransfer.setData('id', event.target.id);
		}

		function Drop(event) {
			let itemId = event.dataTransfer.getData('id');
			if (event.target.classList.contains('active')) {
				swal("Время назначенно", "", "error");
			}else {
				event.target.append(document.getElementById(itemId).innerHTML);
				event.target.classList.add('active');
				let wrapper = event.target.parentNode.parentNode;
				let time = event.target;
				let name = document.getElementById(itemId).innerHTML;
				addPatientDate(wrapper, time, name);
				const $patienCard = document.querySelectorAll('.sidebar__patient_card');
				for ( let i = 0; i < $patienCard.length; i++ ) {
					$patienCard[i].classList.remove('hidden');
				}
			}
		}


		function cardAnimate() {
			const $patienCard = document.querySelectorAll('.sidebar__patient_card');

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
		}

		function addPatientDate(element, t, name) {
			const $patientDate = document.querySelector('.addPatientDate');
			const $date = element.querySelector('.calendar__box__text');
			const $timeDate = t.querySelector('.time');
			
			$patientDate.classList.remove('hidden');
			$patientDate.innerHTML = $date.innerHTML + $timeDate.innerHTML + name;
		}

		addPatient.onclick = function() {
			addPatient.classList.toggle('hidden');
			closePatient.classList.toggle('hidden');
			newPatient.classList.toggle('hidden');
			newPatient.classList.toggle('sidebar');
			$sidehide.classList.toggle('hidden');
			send.onclick = function() {
				newPatient.classList.add('hidden');
			}
		}

		closePatient.onclick = function() {
			closePatient.classList.toggle('hidden');
			addPatient.classList.toggle('hidden');
			newPatient.classList.toggle('hidden');
			newPatient.classList.toggle('sidebar');
			$sidehide.classList.toggle('hidden');
		}

		const searchInput = document.querySelector('.search');
		const error = document.querySelector('.error');

		searchInput.onclick = function() {
			const patientCard = document.querySelectorAll('.sidebar__patient_card');

			searchInput.oninput = function() {
				for (let i = 0; i < patientCard.length; i++) {
					let searchObj = patientCard[i].innerHTML;
					let nav = '';
					for (let j = 0; j < this.value.length; j++) {
						nav += searchObj[j];
						if (nav.toLowerCase() == this.value.toLowerCase()) {
							patientCard[i].classList.remove('hidden');
						}else {
							patientCard[i].classList.add('hidden');
						}
					}
					if (this.value == '') {
						patientCard[i].classList.remove('hidden');
					}
				}


			}	
		}
		
		
	</script>
</body>
</html>