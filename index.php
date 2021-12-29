<?php

	$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
	$nowDate = date("m/d/Y");
	$start = strtotime($nowDate);
	$finish = strtotime('12/31/2055');
	$dataMas = [];

	
	$path = 'patient_images/';
	


	if (isset($_POST['name'])) {
		$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
		$query = "INSERT INTO `patients` (`doctor_id`, `patient_name`,`patient_firstName`, `patient_surname`, `patient_middlename`, `patient_birthday`, `patient_adress`, `patient_phone`, `patient_notes`) VALUES (:doctor_id, :fullname, :name, :surname, :middlename, :birthday, :adress, :phone, :notes)";
		$msg = $connection->prepare($query);
		$msg->execute(['doctor_id' => $_POST['activeDoctor'], 'fullname' => $_POST['surname'].' '.mb_substr($_POST['name'], 0,1).'.'.mb_substr($_POST['middlename'], 0,1),'name' => $_POST['name'], 'surname' => $_POST['surname'], 'middlename' => $_POST['middlename'], 'birthday' => $_POST['birthday'], 'adress' => $_POST['adress'], 'phone' => $_POST['phone'], 'notes' => $_POST['notes']]);
		// header('Location: http://dental/');
		// exit;			
	}else if (isset($_POST['app_name'])) {
			$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
			$query = "INSERT INTO `patient appointment` (`doctor_id`, `patient_id`, `date`, `time`, `name`, `diagnosis`, `healing`, `teethNumber`) VALUES(:doctor_id, :patient_id, :app_date, :app_time, :app_name, :diagnosis, :healing, :teethNumber)";
			$msg = $connection->prepare($query);
			$msg->execute(['doctor_id' => $_POST['app_doctor'], 'patient_id' => $_POST['app_id'], 'app_date' => $_POST['app_date'], 'app_time' => $_POST['app_time'], 'app_name' => $_POST['app_name'], 'diagnosis' => $_POST['diagnosis'], 'healing' => $_POST['healing'], 'teethNumber' => $_POST['teethNumber']]);
			header('Location: http://dental/');
			exit;				
		}else if (isset($_POST['date_delete'])) {
			$date = $_POST['date_delete'];
			$time = $_POST['time_delete'];
			$name = $_POST['name_delete'];
			$doctor = $_POST['doctor_delete'];
			$id = $_POST['id_delete'];

			$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
			$query = "DELETE FROM `patient appointment` WHERE (`date` = '$date' AND `time` = '$time' AND `name` = '$name' AND `patient_id` = '$id' AND `doctor_id` = '$doctor')";
			$msg = $connection->prepare($query);
			$msg->execute();
			header('Location: http://dental/');
			exit;
		}else if ($_GET['id']) {
			$id = $_GET['id'];
			$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
			$query = "DELETE FROM `patients` WHERE (`patient_id` = '$id')";
			$msg = $connection->prepare($query);
			$msg->execute();
			header('Location: http://dental/');
			exit;
		}else if ($_GET['fname']) {
			$id = $_GET['p_id'];
			$surname = $_GET['fsurname'];
			$fname = $_GET['fname'];
			$fmiddlename = $_GET['fmiddlename'];
			$fdate = $_GET['fdate'];
			$fadress = $_GET['fadress'];
			$fphone = $_GET['fphone'];
			$fnotes = $_GET['fnotes'];
			$fullname = $surname.' '.mb_substr($fname, 0,1).'.'.mb_substr($fmiddlename, 0,1);

			$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
			$query = "UPDATE `patients` SET  `patient_name`='$fullname', `patient_firstname`='$fname', `patient_surname`='$surname', `patient_middlename`='$fmiddlename', `patient_birthday`='$fdate', `patient_adress`='$fadress', `patient_phone`='$fphone', `patient_notes`='$fnotes'  WHERE (`patient_id` = '$id')";
			$msg = $connection->prepare($query);
			$msg->execute();
			header('Location: http://dental/');
			exit;
		}else if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		 	if (!@copy($_FILES['file']['tmp_name'], $path . $_FILES['file']['name'])){
		 		echo 'Что-то пошло не так';
		 	}else {
		 		$picture = $path.$_FILES['file']['name'];
		 		$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
				$query = "INSERT INTO `picture_data` (`patient_id`, `picture_name`) VALUES (:patient_id, :picture_name)";
				$msg = $connection->prepare($query);
				$msg->execute(['patient_id' => $_POST['pat_id'], 'picture_name' => $picture]);
				// echo $_POST['pat_id'];
				header('Location: http://dental/');
				exit;
		 	}
		 	
		}

	// include 'image.php';

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
	<link rel="shortcut icon" href="img/лого.png" type="image/png">
	<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/main.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/jquery.maskedinput.min.js"></script>
	<script src="js/phonemask.js"></script>
	<title>Document</title>
</head>
<body>
	<input type="hidden" class="ActiveDoc" value="">
	<div class="shadow hidden"></div>
	<section class="addPatientDate hidden">



		<div class="data__text" id="dataPatient">
			
		</div>
		<div class="flex">
			<img src="img/clock.svg" class="i" alt="clock">
			<div class="data_date">
			
			</div>
		</div>
		
		<div class="flex">
			<img src="img/profile-user.svg" class="i" alt="user">
			<div class="data_name">
			
			</div>
		</div>

		<div class="diagnosisList">
			<div><span>Диагноз:</span></div>
			
		</div>

		<form method="post">
			<input type="hidden" name="app_date"  class="app_date">
			<input type="hidden" name="app_time"  class="app_time">
			<input type="hidden" name="app_name"  class="app_name">
			<input type="hidden" name="app_doctor" class="app_doctor">
			<input type="hidden" name="app_id" class="app_id">
			<input type="hidden" name="teethNumber" class="teethNumber">

			<div class="Raw flex-end">
				<div class="teeth__box">
					
						
					<select name="diagnosis" class="teethSelect o0" num="18" disabled>
  						<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				
					
					<img class="teeth" src="img/teeth/18.svg" alt="18">
					<div class="num__teeth">18</div>
				</div>	
				
				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0"num="17" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>

					<img class="teeth" src="img/teeth/17.svg" alt="17">
					<div class="num__teeth">17</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" num="16" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/16.svg" alt="16">
					<div class="num__teeth">16</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" num="15" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/15.svg" alt="15">
					<div class="num__teeth">15</div>
				</div>


				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" num="14" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/14.svg" alt="14">
					<div class="num__teeth">14</div>
				</div>


				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/13.svg" alt="13">
					<div class="num__teeth">13</div>
				</div>


				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/12.svg" alt="12">
					<div class="num__teeth">12</div>
				</div>


				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/11.svg" alt="11">
					<div class="num__teeth">11</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
						<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/21.svg" alt="21">
					<div class="num__teeth">21</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/22.svg" alt="22">
					<div class="num__teeth">22</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/23.svg" alt="23">
					<div class="num__teeth">23</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/24.svg" alt="24">
					<div class="num__teeth">24</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/25.svg" alt="25">
					<div class="num__teeth">25</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/26.svg" alt="26">
					<div class="num__teeth">26</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/27.svg" alt="27">
					<div class="num__teeth">27</div>
				</div>

				<div class="teeth__box">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
					<img class="teeth" src="img/teeth/28.svg" alt="28">
					<div class="num__teeth">28</div>
				</div>
			</div>
			
			<div class="Raw flex-start">
				<div class="teeth__box">
					<div class="num__teeth">48</div>
					<img class="teeth" src="img/teeth/48.svg" alt="48">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">47</div>
					<img class="teeth" src="img/teeth/47.svg" alt="47">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">46</div>
					<img class="teeth" src="img/teeth/46.svg" alt="46">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">45</div>
					<img class="teeth" src="img/teeth/45.svg" alt="45">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">44</div>
					<img class="teeth" src="img/teeth/44.svg" alt="44">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">43</div>
					<img class="teeth" src="img/teeth/43.svg" alt="43">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">42</div>
					<img class="teeth" src="img/teeth/42.svg" alt="42">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">41</div>
					<img class="teeth" src="img/teeth/41.svg" alt="41">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">31</div>
					<img class="teeth" src="img/teeth/31.svg" alt="31">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">32</div>
					<img class="teeth" src="img/teeth/32.svg" alt="32">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">33</div>
					<img class="teeth" src="img/teeth/33.svg" alt="33">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">34</div>
					<img class="teeth" src="img/teeth/34.svg" alt="34">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">35</div>
					<img class="teeth" src="img/teeth/35.svg" alt="35">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">36</div>
					<img class="teeth" src="img/teeth/36.svg" alt="36">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">37</div>
					<img class="teeth" src="img/teeth/37.svg" alt="37">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>

				<div class="teeth__box">
					<div class="num__teeth">38</div>
					<img class="teeth" src="img/teeth/38.svg" alt="38">
					<select name="diagnosis" class="teethSelect o0" disabled>
	  					<option>C</option>
  						<option>P</option>
  						<option>Pt</option>
  						<option>Lp</option>
  						<option>Gp</option>
					</select>
				</div>
			</div>

			<div class="diagnosisList">
				<span>C</span> - кариес, <span>P</span> - пульпит, <span>Pt</span> - периодонтит, <span>Lp</span> - локализованный пародонтит, <span>Gp</span> - генерализованный пародонтит
			</div>

			<div class="diagnosisList">
				<div><span>Лечение:</span></div>
				
				<div class="healing_box">
					
				</div>
				<span>R</span> - корень, <span>A</span> - отсутствует, <span>Cd</span> - коронка, <span>Pl</span> - пломба, <span>F</span> - искусственный зуб, <span>Ar</span> - искусственный зуб, <span>R</span> - реставрация, <span>H</span> - гемисекция <br><span>Am</span> - ампутация, <span>Res</span> - резекция, <span>Pin</span> - штифт, <span>I</span> - имплантация, <span>Rp</span> - реплантация, <span>Dc</span> - зубной камень.
			</div>

			<button class="appointment">Записать</button>
			
		</form>

		<form method="post">
			<input type="hidden" name="date_delete"  class="app_date_delete" value="">
			<input type="hidden" name="time_delete"  class="app_time_delete" value="">
			<input type="hidden" name="name_delete"  class="app_name_delete" value="">
			<input type="hidden" name="doctor_delete" class="app_doctor_delete" value="">
			<input type="hidden" name="id_delete" class="app_id_delete" value="">
			<button class="confirmDelete" hidden></button>
			
		</form>
		<div class="deleteBtnBox">
				
		</div>
		<img class="closeWritePatient"  draggable="false" src="img/closePatientBtn.png" alt="closePatien">
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

			<div class="patient_card hidden">
				<div class="open_img hidden">
							
				</div>

				<img class="closeCard" draggable="false" src="img/closePatientBtn.png" alt="closePatien" >
				<form class="fix_form">
				<div class="d-flex">
					<div class="patient_card__box d-flex">
						<input type="hidden" name="p_id" class="p_id" value="">
						<label>
							Фамилия  <br>
							<input type="text" name="fsurname"  class="patient_card__Input" disabled value="">
							<div class="error_text hidden"></div>
						</label>

						<label>
							Имя<br>
							<input type="text" name="fname" class="patient_card__Input" disabled value="">
							<div class="error_text hidden"></div>
						</label>

						<label>
							Отчество <br>
							<input type="text" name="fmiddlename" class="patient_card__Input" disabled value="">
							<div class="error_text hidden"></div>
						</label>
			    </form>

			    		

						<!-- image send start! -->

						<form enctype="multipart/form-data" method="post"> 
							<div class="input__wrapper">
						   <input name="file" type="file" name="file" id="input__file" class="input input__file" multiple>
						   <label for="input__file" class="input__file-button">
						      <span class="input__file-icon-wrapper"><img class="input__file-icon" src="img/iconDown.svg" alt="Выбрать файл" width="25"></span>
						      <span class="input__file-button-text">Выберите файл</span>
						   </label>
						</div>
							<input class="imageSend" type="submit" value="Загрузить" />
							<input type="hidden" name="pat_id" class="pat_id" value="">
						</form>

						<!-- image send end! -->
					</div>

						
						
					<div class="img__box">
						
						<?php 
							
							$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
							$query = "SELECT * FROM picture_data";
							$msg = $connection->prepare($query);
							$msg->execute();
							$imageData = $msg->fetchAll();								

						?>

					</div>

					<div class="patient_card__box d-flex">

						<label>
							Дата рождения <br>
							<input type="text" name="fdate" id="date2" class="patient_card__Input" disabled value="">
							<div class="error_text hidden"></div>
						</label>

						<label>
							Адрес <br>
							<input type="text" name="fadress" class="patient_card__Input" disabled value="">
							<div class="error_text hidden"></div>
						</label>

						<label>
							Номер телефона <br>
							<input type="text" name="fphone" id="phone2"  class="patient_card__Input" disabled value="">
							<div class="error_text hidden"></div>
						</label>

					</div>
					<label>
						Заметки <br>
						<textarea class="patient_card__Input" name="fnotes" disabled="disabled">очень длинное предложение, прям пиздец какое длинное предлежение, оно не вместиться никогда в маленький инпут, я серьезно, оно огромное!</textarea> 
						<div class="error_text hidden"></div>

					</label>

					<div class="teethImgBox">
		    			
		    			<div class="teethWrapper">
		    				<div class="raw">	    					
				    			<div class="teethHistory"><img src="img/teeth/18.svg"><p>18</p></div>
				    			<div class="teethHistory"><img src="img/teeth/17.svg"><p>17</p></div>
				    			<div class="teethHistory"><img src="img/teeth/16.svg"><p>16</p></div>
				    			<div class="teethHistory"><img src="img/teeth/15.svg"><p>15</p></div>
				    			<div class="teethHistory"><img src="img/teeth/14.svg"><p>14</p></div>
				    			<div class="teethHistory"><img src="img/teeth/13.svg"><p>13</p></div>
				    			<div class="teethHistory"><img src="img/teeth/12.svg"><p>12</p></div>
				    			<div class="teethHistory"><img src="img/teeth/11.svg"><p>11</p></div>
				    			<div class="teethHistory"><img src="img/teeth/21.svg"><p>21</p></div>
				    			<div class="teethHistory"><img src="img/teeth/22.svg"><p>22</p></div>
				    			<div class="teethHistory"><img src="img/teeth/23.svg"><p>23</p></div>
				    			<div class="teethHistory"><img src="img/teeth/24.svg"><p>24</p></div>
				    			<div class="teethHistory"><img src="img/teeth/25.svg"><p>25</p></div>
				    			<div class="teethHistory"><img src="img/teeth/26.svg"><p>26</p></div>
				    			<div class="teethHistory"><img src="img/teeth/27.svg"><p>27</p></div>
				    			<div class="teethHistory"><img src="img/teeth/28.svg"><p>28</p></div>
		    				</div>
		    				
		    				<div class="raw">
			    				<div class="teethHistory"><p>48</p><img src="img/teeth/48.svg"></div>
				    			<div class="teethHistory"><p>47</p><img src="img/teeth/47.svg"></div>
				    			<div class="teethHistory"><p>46</p><img src="img/teeth/46.svg"></div>
				    			<div class="teethHistory"><p>45</p><img src="img/teeth/45.svg"></div>
				    			<div class="teethHistory"><p>44</p><img src="img/teeth/44.svg"></div>
				    			<div class="teethHistory"><p>43</p><img src="img/teeth/43.svg"></div>
				    			<div class="teethHistory"><p>42</p><img src="img/teeth/42.svg"></div>
				    			<div class="teethHistory"><p>41</p><img src="img/teeth/41.svg"></div>
				    			<div class="teethHistory"><p>31</p><img src="img/teeth/31.svg"></div>
				    			<div class="teethHistory"><p>32</p><img src="img/teeth/32.svg"></div>
				    			<div class="teethHistory"><p>33</p><img src="img/teeth/33.svg"></div>
				    			<div class="teethHistory"><p>34</p><img src="img/teeth/34.svg"></div>
				    			<div class="teethHistory"><p>35</p><img src="img/teeth/35.svg"></div>
				    			<div class="teethHistory"><p>36</p><img src="img/teeth/36.svg"></div>
				    			<div class="teethHistory"><p>37</p><img src="img/teeth/37.svg"></div>
				    			<div class="teethHistory"><p>38</p><img src="img/teeth/38.svg"></div>
		    				</div>
		    				
		    			</div>
		    			
		    		</div>

					<div class="btn_box">
						<input type="button" value="Редактировать" class="btn_fix">
						<button class="btn_fix_send hidden">Сохранить</button>
						<a  class="btn_delete">Удалить</a>
						
					</div>

					
					<div class="visitList_header">
						История посещений
					</div>
					<div class="visitList">
						
						
		
					</div>
				</div>
				
				
			</div>	

			<script>
			    let inputs = document.querySelectorAll('.input__file');
			    let file_btn = document.querySelector('.imageSend');
				let countFiles = '';

				file_btn.onclick = function() {
					if (countFiles == '') {
						event.preventDefault();
					}
				}
			    Array.prototype.forEach.call(inputs, function (input) {
			      let label = input.nextElementSibling,
			        labelVal = label.querySelector('.input__file-button-text').innerText;
			  
			      input.addEventListener('change', function (e) {
			        
			        if (this.files && this.files.length >= 1)
			          countFiles = this.files.length;
			  
			        if (countFiles)
			          label.querySelector('.input__file-button-text').innerText = 'Выбрано файлов: ' + countFiles;
			        else
			          label.querySelector('.input__file-button-text').innerText = labelVal;
			        
			      });
			    });
			</script>

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

			<form class="flex" method="post" name="patient_form" action="index.php">

				<label>
					Фамилия  <br>
					<input type="text" name="surname" class="patient_form" placeholder="Иванов">
					<div class="error_text_add hidden"></div>
				</label>

				<label>Имя<br>
					<input type="text" name="name" class="patient_form" placeholder="Иван">
					<div class="error_text_add hidden"></div>
				</label>

				<label>Отчество <br>
					<input type="text" name="middlename" class="patient_form" placeholder="Иванович">
					<div class="error_text_add hidden"></div>
				</label>

				<label>Дата рождения <br>
					<input type="text" name="birthday" id="date" class="patient_form" placeholder="22/05/1870">
					<div class="error_text_add hidden"></div>
				</label>

				<label>Адрес <br>
					<input type="text" name="adress" class="patient_form" placeholder="Бутырина 8-б">
					<div class="error_text_add hidden"></div>
				</label>

				<label>Номер телефона <br>
					<input type="tel" name="phone" id="phone" class="patient_form" placeholder="+38(099)999-99-99">
					<div class="error_text_add hidden"></div>
				</label>

				<label>Заметки <br>
					<textarea class="notes patient_form" name="notes"></textarea>
					<div class="error_text_add hidden"></div>	
				</label>

				<input type="hidden" name="activeDoctor" class="activeDoctorInput">

				<button class="send">Добавить пациента</button>
				<!-- <div class="send">Добавить пациента</div> -->
			</form>
			
		</section>	

		<?php 

			$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
			$query = "SELECT * FROM patients";
			$msg = $connection->prepare($query);
			$msg->execute();
			$result = $msg->fetchAll();	


			$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
				$q = "SELECT * FROM `patient appointment`";
				$m = $connection->prepare($q);
				$m->execute();
				$dataSet = $m->fetchAll();	
			

		?>


		<section class="sidebar" id="hide">			

			


			<script>

				const $accBtn = document.querySelectorAll('.accSwitchBtn');
				const $sidebar = document.querySelector('.sidebar');
				const $sidehide = document.querySelector('#hide');
				const addPatient = document.querySelector('.addPatient');
				const closePatient = document.querySelector('#closeBtnPatient');
				const newPatient = document.querySelector('.newPatient');
				const send = document.querySelector('.send');
				const imageSend = document.querySelector('.imageSend');
				const aPD = document.querySelector('.addPatientDate');
				const $AD = document.querySelector('.ActiveDoc');
				$AD.value = 1;

			
				for ( let i = 0; i < $accBtn.length; i++ ) {
					//doctor default
					$sidebar.innerHTML = '';
					let content = `<?php getDoc();?>`;
					$sidebar.insertAdjacentHTML('beforeEnd',content);
					$accBtn[i].onclick = function() {
						if ($accBtn[i].classList.contains( 'activeAcc' )) {
							
						}else {
							for ( let i = 0; i < $accBtn.length; i++ ) {
								if (newPatient.classList.contains('hidden') && aPD.classList.contains('hidden')) {
									$accBtn[i].classList.remove('activeAcc');
									this.classList.add('activeAcc');
								}else {
									swal("Добавьте пациента!", "", "error");
								}
								
							}
							if ($accBtn[i].classList.contains( 'activeAcc' )) {
								let activeDoctor;
								activeDoctor = i + 1;
								//show doctor 1
								if (activeDoctor == 1) {
									$sidebar.innerHTML = '';
									let content = `<?php getDoc(1);?>`;
									$sidebar.insertAdjacentHTML('beforeEnd',content);
									dragAndDrop();	
									cardAnimate();
									validation(1);
									newVisit(1);
									openAppointment(1);
									$AD.value = 1;
									// getPatientData();
								}
								//show doctor 2
								if (activeDoctor == 2) {
									$sidebar.innerHTML = '';
									let content = `<?php getDoc(2);?>`;
									$sidebar.insertAdjacentHTML('beforeEnd',content);
									dragAndDrop();
									cardAnimate();
									validation(2);
									newVisit(2);
									openAppointment(2);
									$AD.value = 2;
									// getPatientData();
								}
								//show doctor 3
								if (activeDoctor == 3) {
									$sidebar.innerHTML = '';
									let content = `<?php getDoc(3);?>`;
									$sidebar.insertAdjacentHTML('beforeEnd',content);
									dragAndDrop();
									cardAnimate();
									validation(3);
									newVisit(3);
									openAppointment(3);
									$AD.value = 3;
									// getPatientData();
								}
								
							}
						}
					}
				}
			
				



				const $patienCard = document.querySelectorAll('.sidebar__patient_card');
				const $openCard = document.querySelector('.patient_card');
				const $closeCard = document.querySelector('.closeCard');
				const $openCardInput = document.querySelectorAll('.patient_card__Input');
				
				
				
				

				var number =  <? echo json_encode($result); ?>;	
				var imgData =  <? echo json_encode($imageData); ?>;	
				
				
			

				// вывод в карту пациента
				getPatientData();
				function getPatientData() {
					const $pat_id = document.querySelector('.pat_id');
					const $Patient_image = document.querySelectorAll('.Patient_image');



					for(let i = 0; i < $patienCard.length; i++) {
						$patienCard[i].ondblclick = function() {

							const $img__box = document.querySelector('.img__box');
							const $deleteBtn = document.querySelector('.btn_delete');
							const $pat_id = document.querySelector('.pat_id');
							const $id = document.querySelector('.p_id');
							const $fix = document.querySelector('.btn_fix');
							const $fixSend = document.querySelector('.btn_fix_send');
							const $fixForm = document.querySelector('.fix_form');
							const $visitList = document.querySelector('.visitList');
							const $teethHistory = document.querySelectorAll('.teethHistory');


							$visitList.innerHTML = '';
							$img__box.innerHTML = '';
							$pat_id.value = this.id;
							$id.value = this.id;


	    					var teethDataSet = <? echo json_encode($dataSet); ?>;

	    					

	    				// 	for (let t = 0, l = $teethHistory.length; t < l; t++) {
	    				// 		$teethHistory[t].classList.remove('hasHistory');
	    					
	    				// 		if ($id.value.replace(/^0+/, '') == teethDataSet[t]['patient_id'] && teethDataSet[t]['teethNumber'] == $teethHistory[t].childNodes.innerText) {
	    				// 			$teethHistory[t].classList.add('hasHistory');
	    				// 			if ($teethHistory[t].classList.contains('hasHistory')) {
									// 	console.log($teethHistory[t]);
									// 	$teethHistory[t].onclick = function() {
									// 		console.log(teethDataSet[t]);
									// 	}
									// }
	    				// 		}
	    				// 	}

	    				for (let t = 0, l = $teethHistory.length; t < l; t++) {
	    					$teethHistory[t].classList.remove('hasHistory');
	    				}

	    				for (let i = 0, l = teethDataSet.length; i < l; i++) {
	    					if (teethDataSet[i]['patient_id'] === $id.value.replace(/^0+/, '')) {
	    						for (let t = 0, l = $teethHistory.length; t < l; t++) {
	    							if (teethDataSet[i]['teethNumber'] === $teethHistory[t].innerText) {
	    								$teethHistory[t].classList.add('hasHistory');
	    								if ($teethHistory[t].classList.contains('hasHistory')) {
	    									$teethHistory[t].onclick = function() {
	    										
	    										let content = `<div class="teethHistoryInfo">
													<img src="img/smallClose.png" class="smallClose">
													<p> Зуб: ${teethDataSet[i]['teethNumber']} </p>
													<p> Диагноз: ${teethDataSet[i]['diagnosis']} </p> 
													<p> Лечение: ${teethDataSet[i]['healing']} </p> 
													<p> Дата: ${teethDataSet[i]['date']} </p>
												</div>`;
;

	    									

	    										if (document.querySelector('.teethHistoryInfo') != null) {
													document.querySelector('.teethHistoryInfo').remove();
														
	    										}else {
	    												$teethHistory[t].insertAdjacentHTML('beforeEnd', content);
	    												const close = document.querySelector('.smallClose');
	    										}

	    										close.onclick = function() {
													document.querySelector('.teethHistoryInfo').remove();
												}
	    									}
	    								}
	    							}
	    						}
	    					}
	    				}

	    					



							
							
							$deleteBtn.onclick = function() {
								swal({
									  title: "Вы уверены, что хотите удалить карту пациента?",
									  text: "Удалив карту пациента, вы не сможете ее восстановить!",
									  icon: "warning",
									  buttons: true,
									  dangerMode: true,
									})
									.then((willDelete) => {
									  if (willDelete) {
									    swal("Карта успешно удалена!", {
									      icon: "success",
									    });
									    $deleteBtn.href = `http://dental?id=${$pat_id.value.replace(/^0+/, '')}`;
									    setTimeout(function() { // таймер-планировщик
		  								  document.querySelector('.btn_delete').click(); // вызвать клик на кнопку
		  								}, 1000);
									  } else {
									    swal("Удаление отмененно!");
									  }
									});
							}

							$fixSend.onclick = function() {

								const $inputUpdate = document.querySelectorAll('.patient_card__Input');
								const errorText = document.querySelectorAll('.error_text');

								for (let i = 0; i < $inputUpdate.length; i++ ) {
									for (let j = 0; j < 255; j++ ) {

										if ($inputUpdate[i].value[j] == '!' || $inputUpdate[i].value[j] == '"' || $inputUpdate[i].value[j] == ':' ||  $inputUpdate[i].value[j] == '}' || $inputUpdate[i].value[j] == '\\' || $inputUpdate[i].value[j] == '<' || $inputUpdate[i].value[j] == '.' || $inputUpdate[i].value[j] == '='|| $inputUpdate[i].value[j] == '['|| $inputUpdate[i].value[j] == ']') 
										{
											event.preventDefault();
											$inputUpdate[i].classList.add('form_error');
											errorText[i].classList.remove('hidden');
											errorText[i].innerHTML = "Недопустимые символы '!.=<\\:};['";	
										}else if (i < 3) {
											if ($inputUpdate[i].value === '' || $inputUpdate[i].value[j] == ' ') {
												event.preventDefault();
												$inputUpdate[i].classList.add('form_error');
												errorText[i].classList.remove('hidden');
												errorText[i].innerHTML = "Пустое поле";
											}
										}
										$inputUpdate[i].onfocus = function() {
											$inputUpdate[i].classList.remove('form_error');
											errorText[i].classList.add('hidden');
											errorText[i].innerHTML = "";
										}
									}
								}
							}


							if (!$fix.classList.contains('hidden')) {
								$fix.onclick = function() {
								for (let a = 0; a < $openCardInput.length; a++) {
										$openCardInput[a].disabled = false;
										$openCardInput[a].classList.add('fixing');
									}
									$fix.classList.add('hidden');
									$closeCard.classList.add('hidden');
									$fixSend.classList.remove('hidden');
								}
								
								$openCard.classList.remove('hidden');
								$closeCard.onclick = function() {
									$openCard.classList.add('hidden');
								}

								}else {
									swal("Закончите редактирование пациента", "", "error");
								}

								

								for (var j = 0; j < number.length; j++) {
								
									if (this.id == number[j][['patient_id']]) {
										$openCardInput[0].value = number[j][['patient_surname']];
										$openCardInput[1].value = number[j][['patient_firstname']];
										$openCardInput[2].value = number[j][['patient_middlename']];
										$openCardInput[3].value = number[j][['patient_birthday']];
										$openCardInput[4].value = number[j][['patient_adress']];
										$openCardInput[5].value = number[j][['patient_phone']];
										$openCardInput[6].value = number[j][['patient_notes']];	
										
										getPatientVisit( number[j][['patient_id']].replace(/^0+/, '') );
									}
									
								}

								for (var j = 0; j < imgData.length; j++) {
									if (this.id.replace(/^0+/, '') == imgData[j][['patient_id']]) {
										$img__box.innerHTML += `<img class="Patient_image" src="${imgData[j]['picture_name']}" alt="img">`;
									}
								}

								const $open_img = document.querySelector('.open_img');
								const $shadow = document.querySelector('.shadow');
								const $Patient_image = document.querySelectorAll('.Patient_image');


								for (let i = 0; i < $Patient_image.length; i++) {
									$Patient_image[i].ondblclick = function() {
										let content = $Patient_image[i];
										let clone = content.cloneNode(content, false);
										$open_img.append(clone);
										$open_img.classList.remove('hidden');
										$shadow.classList.remove('hidden');
									}
								}

						}
					}
				}

				
				
			</script>

			<?php 

				
				// if (isset($_POST['name'])) {
					
				// 	$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
				// 	$query = "INSERT INTO `patients` (`patient_name`,`patient_firstName`, `patient_surname`, `patient_middlename`, `patient_birthday`, `patient_adress`, `patient_phone`, `patient_notes`) VALUES (:fullname, :name, :surname, :middlename, :birthday, :adress, :phone, :notes)";
				// 	$msg = $connection->prepare($query);
				// 	$msg->execute(['fullname' => $_POST['surname'].' '.mb_substr($_POST['name'], 0,1).'.'.mb_substr($_POST['middlename'], 0,1),'name' => $_POST['name'], 'surname' => $_POST['surname'], 'middlename' => $_POST['middlename'], 'birthday' => $_POST['birthday'], 'adress' => $_POST['adress'], 'phone' => $_POST['phone'], 'notes' => $_POST['notes']]);

				// }

				// function insert($doctor_id = 1) {
					// if (isset($_POST['name'])) {

					// 	$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');	
					// 	$query = "INSERT INTO `patients` (`doctor_id`, `patient_name`,`patient_firstName`, `patient_surname`, `patient_middlename`, `patient_birthday`, `patient_adress`, `patient_phone`, `patient_notes`) VALUES (:doctor_id, :fullname, :name, :surname, :middlename, :birthday, :adress, :phone, :notes)";
					// 	$msg = $connection->prepare($query);
					// 	$msg->execute(['doctor_id' => $doctor_id, 'fullname' => $_POST['surname'].' '.mb_substr($_POST['name'], 0,1).'.'.mb_substr($_POST['middlename'], 0,1),'name' => $_POST['name'], 'surname' => $_POST['surname'], 'middlename' => $_POST['middlename'], 'birthday' => $_POST['birthday'], 'adress' => $_POST['adress'], 'phone' => $_POST['phone'], 'notes' => $_POST['notes']]);

					// }	
					
				// }

				function getDoc($activeDoctor = 01) {
					$alpha = array(
					    'А', 'а', 'Б', 'б', 'В', 'в', 'Г', 'г', 'Д', 'д', 'Е', 'е', 'Ё', 'ё', 'Ж', 'ж', 'З', 'з',
					    'И', 'и', 'Й', 'й', 'К', 'к', 'Л', 'л', 'М', 'м', 'Н', 'н', 'О', 'о', 'П', 'п', 'Р', 'р',
					    'С', 'с', 'Т', 'т', 'У', 'у', 'Ф', 'ф', 'Х', 'х', 'Ц', 'ц', 'Ч', 'ч', 'Ш', 'ш', 'Щ', 'щ',
					    'Ъ', 'ъ', 'Ы', 'ы', 'Ь', 'ь', 'Э', 'э', 'Ю', 'ю', 'Я', 'я'
					);
					$connection = new PDO('mysql:host=127.0.0.1;port=3306;dbname=dentalsitedata;charset=utf8', 'root', '');
					foreach ($alpha as $sort) {
						foreach($connection->query('SELECT `doctor_id` FROM doctors') as $row) {
							foreach($connection->query('SELECT * FROM patients') as $patient) {
								if ($activeDoctor == $row['doctor_id']) {
									if ($row['doctor_id'] == $patient['doctor_id']) {
										 if (mb_substr($patient['patient_name'],0,1,'UTF-8') == $sort) {
										 	echo '<div draggable="true" class="sidebar__patient_card" id="'.$patient['patient_id'].'">'. $patient['patient_name'] .'</div>';
										 }
									}
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

		    
		    for ( let i = week; i <= numDays; i++ ) {

		        let content = `<div class="wrapper"><div class="calendar__box__text">

		            ${arr[i]}

					</div>
		            <div class="calendar"></div></div>`;
		        dayContent.insertAdjacentHTML( 'beforeEnd', content );
		        
		        const timeContent = document.querySelectorAll('.calendar');

		        for ( let j = 9; j <= 18; j++ ) {
		        	
		        	let con = `<div class="calendar__block"><div class="time hidden">${j}:00</div> ${j}:00<div class="patient_name"></div></div>`;
		        	timeContent[i - week].insertAdjacentHTML('beforeEnd', con);
		       
		        }
		    }
	    }


	   
	    
// $visitTime[t].parentNode.classList.add('active');

	    function newVisit(active = '1') {
			const $visitDate = document.querySelectorAll('.calendar__box__text');
			const $visitTime = document.querySelectorAll('.calendar');
			const $block = document.querySelectorAll('.calendar__block');
			const $visitName = document.querySelectorAll('.patient_name');
			

			var arrayDataSet = <? echo json_encode($dataSet); ?>;	

			for (let b = 0; b < $block.length; b++) {
   				$block[b].classList.remove('active');
   				$visitName[b].innerText = '';
   			}

	   		for (let i = 0; i < arrayDataSet.length; i++) {
	   			if (active == arrayDataSet[i]['doctor_id']) {
	   				for (let j = 0; j < $visitDate.length; j++) {
	   					if (arrayDataSet[i]['date'] === $visitDate[j].innerText) {
	   						for (let t = 0; t < 10; t++) {
	   							if (arrayDataSet[i]['time'] === $visitTime[j].childNodes[t].innerText) {
	   								$visitTime[j].childNodes[t].classList.add('active');
	   								$visitTime[j].childNodes[t].childNodes[2].innerText = arrayDataSet[i]['name'];
	   							}
	   						}
	   					}
	   				}
	   				
	   			}
	   		}

	    }


	    


	    newVisit();
	    getPatientVisit();
	    openAppointment();



	    function openAppointment(active = 1) {
	    	const $calendarBlockActive = document.querySelectorAll('.calendar__block.active');
	    	const $teethSelect = document.querySelectorAll('.teethSelect');
	    	const $teeth = document.querySelectorAll('.teeth');
	    	const $addPatientDate = document.querySelector('.addPatientDate');
	    	const $data_date = document.querySelector('.data_date');
	    	const $data_name = document.querySelector('.data_name');
	    	
	    	const $closeWritePatient = document.querySelector('.closeWritePatient');

	    	var arrayDataSet = <? echo json_encode($dataSet); ?>;

	    	

		    for (let i = 0; i < $calendarBlockActive.length; i++) {
				$calendarBlockActive[i].ondblclick = function() {
					const $appointmentBtn = document.querySelector('.appointment');
					const $healBox = document.querySelector('.healing_box');
					const $deleteBtnBox = document.querySelector('.deleteBtnBox');
					const $dateDelete = document.querySelector('.app_date_delete');
					const $timeDelete = document.querySelector('.app_time_delete');
					const $nameDelete = document.querySelector('.app_name_delete');
					const $doctorDelete = document.querySelector('.app_doctor_delete');
					const $idDelete = document.querySelector('.app_id_delete');

					
					$appointmentBtn.classList.add('hidden');

					$addPatientDate.classList.remove('hidden');
					
					$addPatientDate.childNodes[1].innerText = $calendarBlockActive[i].parentNode.parentNode.childNodes[0].innerText;
					$data_date.innerText = $calendarBlockActive[i].childNodes[0].innerText;
					$data_name.innerText = $calendarBlockActive[i].childNodes[2].innerText;
					
					for (let j = 0; j < arrayDataSet.length; j++) {
						if (arrayDataSet[j]['date'] == $addPatientDate.childNodes[1].innerText && arrayDataSet[j]['time'] == $data_date.innerText && arrayDataSet[j]['name'] == $data_name.innerText) {

							$healBox.innerHTML = `<div class="healingViev">${arrayDataSet[j]['healing']}</div>`;
							$deleteBtnBox.innerHTML = `<button class="deleteApp">Удалить</button>`;

							const $deleteBtn = document.querySelector('.deleteApp');


							$deleteBtn.onclick = function() {
								swal({
									  title: "Вы уверены, что хотите удалить запись?",
									  text: "Удалив запись, вы не сможете ее восстановить!",
									  icon: "warning",
									  buttons: true,
									  dangerMode: true,
									})
									.then((willDelete) => {
									  if (willDelete) {
									    swal("Запись успешно удалена!", {
									      icon: "success",
									    });
									    $dateDelete.value = arrayDataSet[j]['date'];
										$timeDelete.value = arrayDataSet[j]['time'];
										$nameDelete.value = arrayDataSet[j]['name'];
										$doctorDelete.value = arrayDataSet[j]['doctor_id'];
										$idDelete.value = arrayDataSet[j]['patient_id'];

									    setTimeout(function() { // таймер-планировщик
		  								  document.querySelector('.confirmDelete').click(); // вызвать клик на кнопку
		  								}, 1000);
									    
									  } else {
									    swal("Удаление отмененно!");
									  }
									});
							}

							
							
							for (t = 0; t < $teeth.length; t++) {

								$teeth[t].style.pointerEvents = "none";
								$teeth[t].classList.remove(`active_${$teeth[t].alt}`);
								$teethSelect[t].classList.add(`o0`);
								

								if ($teeth[t].alt == arrayDataSet[j]['teethNumber']) {
									let active_teeth = $teeth[t];

									$teeth[t].classList.add(`active_${$teeth[t].alt}`);



									if ($teeth[t].alt >= 11 && $teeth[t].alt <= 28) {
										let select = `<div class="diagnosisView">${arrayDataSet[j]['diagnosis']} </div>`
										$teeth[t].parentNode.insertAdjacentHTML('afterbegin', select);
									}

									if ($teeth[t].alt >= 31 && $teeth[t].alt <= 48) {
										let select = `<div class="diagnosisView">${arrayDataSet[j]['diagnosis']} </div>`
										$teeth[t].parentNode.insertAdjacentHTML('beforeend', select);
									}


									$closeWritePatient.onclick = function() {
										const patientCard = document.querySelectorAll('.sidebar__patient_card');
										const $diagnosisView = document.querySelectorAll('.diagnosisView');

										$appointmentBtn.classList.remove('hidden');

									    $data_date.innerHTML = '';
										$addPatientDate.classList.add('hidden');

										for (let i = 0; i < patientCard.length; i++) {
											patientCard[i].classList.remove('hidden');
										}

										active_teeth.classList.remove(`active_${active_teeth.alt}`);
										
										for (t = 0; t < $teeth.length; t++) {
											$teeth[t].style.pointerEvents = '';
											if ($diagnosisView[t]) {
												$diagnosisView[t].remove();
											}
											
										}	
										
									}


								}

							}


						}
					}








					$data_name.onclick = function() {
						search($data_name.innerText);
					}

					
				}
				
			}
	    }

	    


	    function getPatientVisit(patient) {
	    	const $visitList = document.querySelector('.visitList');

	    	var Data = <? echo json_encode($dataSet); ?>;
	    	
	    	for (let i = 0; i < Data.length; i++) {
	    		if (patient == Data[i]['patient_id']) {
	    			let content = `<div class="visit">${Data[i]['date']}</div>`;
	    			const position = 'afterbegin';

					$visitList.insertAdjacentHTML( position, content );
	    		}
	    	}

	    }

	 

	    next.onclick = function() {
	    	if (week != 5*12) {
	    		dayContent.innerHTML = '';
		    	numDays += 5;
		    	week += 5;
		    	getWeek(numDays,week);
		    	dragAndDrop();
		    	newVisit($AD.value);
		    	openAppointment($AD.value);
		    	prew.classList.remove('block');
		    	
	    	}else {
	    		next.classList.add('block');
	    	}
	    }

	    prew.onclick = function() {
	    	if (week != 0) {
	    		dayContent.innerHTML = '';
	    		numDays -= 5;
	    		week -= 5;
	    		getWeek(numDays,week);
	    		dragAndDrop();
	    		newVisit($AD.value);
	    		openAppointment($AD.value);
	    		next.classList.remove('block');	
	    			
	    	}else {
	    		prew.classList.add('block');
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
				const healBox = document.querySelector('.healing_box');
				// event.target.childNodes[2].innerText = document.getElementById(itemId).innerHTML;
				// event.target.classList.add('active');
				let wrapper = event.target.parentNode.parentNode;
				let time = event.target;
				let name = document.getElementById(itemId).innerHTML;
				addPatientDate(wrapper, time, name, itemId);
				const $patienCard = document.querySelectorAll('.sidebar__patient_card');
				for ( let i = 0; i < $patienCard.length; i++ ) {
					$patienCard[i].classList.remove('hidden');
				}

				
				let content = `<select name="healing" class="teethSelect">
	  					<option>R</option>
  						<option>A</option>
  						<option>Cd</option>
  						<option>Pl</option>
  						<option>F</option>
  						<option>Ar</option>
  						<option>R</option>
  						<option>H</option>
  						<option>Am</option>
  						<option>Res</option>
  						<option>Pin</option>
  						<option>I</option>
  						<option>Rp</option>
  						<option>Dc</option>
					</select>`;

				healBox.innerHTML = content;
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

					const $pat_id = document.querySelector('.pat_id');
					const $id = document.querySelector('.p_id');
					const $img__box = document.querySelector('.img__box');
					const $fix = document.querySelector('.btn_fix');
					const $fixSend = document.querySelector('.btn_fix_send');
					const $fixForm = document.querySelector('.fix_form');
					const $deleteBtn = document.querySelector('.btn_delete');
					const $visitList = document.querySelector('.visitList');
					const $teethHistory = document.querySelectorAll('.teethHistory');

					$visitList.innerHTML = '';
					$img__box.innerHTML = '';
					$pat_id.value = this.id;
					$id.value = this.id;

					var teethDataSet = <? echo json_encode($dataSet); ?>;

	    					

					for (let t = 0, l = $teethHistory.length; t < l; t++) {
	    					$teethHistory[t].classList.remove('hasHistory');
	    			}

    				for (let i = 0, l = teethDataSet.length; i < l; i++) {
						if (teethDataSet[i]['patient_id'] === $id.value.replace(/^0+/, '')) {
							for (let t = 0, l = $teethHistory.length; t < l; t++) {
								if (teethDataSet[i]['teethNumber'] === $teethHistory[t].innerText) {
									$teethHistory[t].classList.add('hasHistory');
									if ($teethHistory[t].classList.contains('hasHistory')) {
											$teethHistory[t].onclick = function() {
										
											let content = `<div class="teethHistoryInfo">
											<img src="img/smallClose.png" class="smallClose">
											<p> Зуб: ${teethDataSet[i]['teethNumber']} </p>
											<p> Диагноз: ${teethDataSet[i]['diagnosis']} </p> 
											<p> Лечение: ${teethDataSet[i]['healing']} </p> 
											<p> Дата: ${teethDataSet[i]['date']} </p>
											</div>`;

									

											if (document.querySelector('.teethHistoryInfo') != null) {
											
												document.querySelector('.teethHistoryInfo').remove();	
											}else {
												$teethHistory[t].insertAdjacentHTML('beforeEnd', content);
												const close = document.querySelector('.smallClose');
											}

											close.onclick = function() {
												document.querySelector('.teethHistoryInfo').remove();
											}
    									}	
    								}
    							}
    						}
    					}
    				}


					$deleteBtn.onclick = function() {
						swal({
							  title: "Вы уверены, что хотите удалить карту пациента?",
							  text: "Удалив карту пациента, вы не сможете ее восстановить!",
							  icon: "warning",
							  buttons: true,
							  dangerMode: true,
							})
							.then((willDelete) => {
							  if (willDelete) {
							    swal("Карта успешно удалена!", {
							      icon: "success",
							    });
							    $deleteBtn.href = `http://dental?id=${$pat_id.value.replace(/^0+/, '')}`;
							    setTimeout(function() { // таймер-планировщик
  								  document.querySelector('.btn_delete').click(); // вызвать клик на кнопку
  								}, 1000);
							  } else {
							    swal("Удаление отмененно!");
							  }
							});
					}


					$fixSend.onclick = function() {

						const $inputUpdate = document.querySelectorAll('.patient_card__Input');
						const errorText = document.querySelectorAll('.error_text');

						for (let i = 0; i < $inputUpdate.length; i++ ) {
							for (let j = 0; j < 255; j++ ) {
								if ($inputUpdate[i].value[j] == '!' || $inputUpdate[i].value[j] == '"' || $inputUpdate[i].value[j] == ':' ||  $inputUpdate[i].value[j] == '}' || $inputUpdate[i].value[j] == '\\' || $inputUpdate[i].value[j] == '<' || $inputUpdate[i].value[j] == '.' || $inputUpdate[i].value[j] == '='|| $inputUpdate[i].value[j] == '['|| $inputUpdate[i].value[j] == ']') 
								{
									event.preventDefault();
									$inputUpdate[i].classList.add('form_error');
									$inputUpdate[i].classList.add('form_error');
									errorText[i].classList.remove('hidden');
									errorText[i].innerHTML = "Недопустимые символы '!.=<\\:};['";	
								}else if (i < 3) {
									if ($inputUpdate[i].value === '' || $inputUpdate[i].value[j] == ' ') {
										event.preventDefault();
										$inputUpdate[i].classList.add('form_error');
										$inputUpdate[i].classList.add('form_error');
										errorText[i].classList.remove('hidden');
										errorText[i].innerHTML = "Пустое поле";												
									}
								}
								$inputUpdate[i].onfocus = function() {
									$inputUpdate[i].classList.remove('form_error');
									errorText[i].classList.add('hidden');
									errorText[i].innerHTML = "";
								}
							}
						}
					}


					if (!$fix.classList.contains('hidden')) {
						$fix.onclick = function() {
						for (let a = 0; a < $openCardInput.length; a++) {
								$openCardInput[a].disabled = false;
								$openCardInput[a].classList.add('fixing');
							}
							$fix.classList.add('hidden');
							$closeCard.classList.add('hidden');
							$fixSend.classList.remove('hidden');
						}
						$openCard.classList.remove('hidden');
						$closeCard.onclick = function() {
							$openCard.classList.add('hidden');
						}

						


						for (var j = 0; j < number.length; j++) {
							
							if (this.id == number[j][['patient_id']]) {
								$openCardInput[0].value = number[j][['patient_surname']];
								$openCardInput[1].value = number[j][['patient_firstname']];
								$openCardInput[2].value = number[j][['patient_middlename']];
								$openCardInput[3].value = number[j][['patient_birthday']];
								$openCardInput[4].value = number[j][['patient_adress']];
								$openCardInput[5].value = number[j][['patient_phone']];
								$openCardInput[6].value = number[j][['patient_notes']];

								getPatientVisit( number[j][['patient_id']].replace(/^0+/, '') );
							}
							
						}
						
						for (var j = 0; j < imgData.length; j++) {
						
							if (this.id.replace(/^0+/, '') == imgData[j][['patient_id']]) {
								$img__box.innerHTML += `<img class="Patient_image" src="${imgData[j]['picture_name']}" alt="img">`;
							}
						}

						const $open_img = document.querySelector('.open_img');
						const $shadow = document.querySelector('.shadow');
						const $Patient_image = document.querySelectorAll('.Patient_image');
							
						for (let i = 0; i < $Patient_image.length; i++) {
							$Patient_image[i].ondblclick = function() {
								let content = $Patient_image[i];
								let clone = content.cloneNode(content, false);
								$open_img.append(clone);
								$open_img.classList.remove('hidden');
								$shadow.classList.remove('hidden');
							}
						}
					}else {
						swal("Закончите редактирование пациента", "", "error");
					}

					
				}
			}
		}

		document.onclick = function() {
			const $shadow = document.querySelector('.shadow');
			const $open_img = document.querySelector('.open_img');
			
				$open_img.innerHTML = '';
				$open_img.classList.add('hidden');
				$shadow.classList.add('hidden');
				
		}



		function addPatientDate(element, t, name, itemId) {
			const $patientDate = document.querySelector('.addPatientDate');
			const $date = element.querySelector('.calendar__box__text');
			const $timeDate = t.querySelector('.time');
			const $dataPatient = document.querySelector('#dataPatient');
			const $dataDate = document.querySelector('.data_date');
			const $dataName = document.querySelector('.data_name');
			const $search = document.querySelector('.search');
			const $closeWritePatient = document.querySelector('.closeWritePatient');
			const $app_date = document.querySelector('.app_date');
			const $app_time = document.querySelector('.app_time');
			const $app_name = document.querySelector('.app_name');
			const $app_id = document.querySelector('.app_id');
			
			$patientDate.classList.remove('hidden');
			$dataPatient.innerHTML = $date.innerHTML;
			$dataDate.innerHTML = $timeDate.innerHTML;
			$dataName.innerHTML = name;
			$date.innerHTML = $date.innerHTML.trim();
			$app_date.value = $date.innerHTML;
			$app_time.value = $timeDate.innerHTML;
			$app_name.value = name;
			$app_id.value = itemId;


			// $patientDate.innerHTML = $date.innerHTML + $timeDate.innerHTML + name;

			$dataName.onclick = function() {
				search($dataName.innerText);
			}



			$closeWritePatient.onclick = function() {
				swal({
					  title: "Вы уверены, что хотите отменить запись?",
					  text: "",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then((willDelete) => {
					  if (willDelete) {
					  	const patientCard = document.querySelectorAll('.sidebar__patient_card');

					    $dataPatient.innerHTML = '';
						$patientDate.classList.add('hidden');

						for (let i = 0; i < patientCard.length; i++) {
							patientCard[i].classList.remove('hidden');
						}
					  } 
					});
				
			}
		}

		addPatient.onclick = function() {
			addPatient.classList.toggle('hidden');
			closePatient.classList.toggle('hidden');
			newPatient.classList.toggle('hidden');
			newPatient.classList.toggle('sidebar');
			$sidehide.classList.toggle('hidden');
		}

		closePatient.onclick = function() {
			closePatient.classList.toggle('hidden');
			addPatient.classList.toggle('hidden');
			newPatient.classList.toggle('hidden');
			newPatient.classList.toggle('sidebar');
			$sidehide.classList.toggle('hidden');
			const form = document.querySelectorAll('.patient_form');
			for (let i = 0; i < form.length; i++) {
				form[i].value = '';
			}
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
		

		function search(searchName) {
			const patientCard = document.querySelectorAll('.sidebar__patient_card');
			searchName.trim();

			for (let i = 0; i < patientCard.length; i++) {
				let searchObj = patientCard[i].innerHTML;
				let nav = '';
				for (let j = 0; j < searchName.length; j++) {
					nav += searchObj[j];
					if (nav.toLowerCase() == searchName.toLowerCase()) {
						patientCard[i].classList.remove('hidden');
					}else {
						patientCard[i].classList.add('hidden');
					}
				}
			}
		}


		var input = document.querySelectorAll(".patient_form");
		for (let l = 0; l < input.length; l++) {
			input[l].addEventListener("input", function() {
		  		this.value = this.value[0].toUpperCase() + this.value.slice(1);
			})
		}

		var input = document.querySelectorAll(".patient_card__Input");
		for (let l = 0; l < input.length; l++) {
			input[l].addEventListener("input", function() {
		  		this.value = this.value[0].toUpperCase() + this.value.slice(1);
			})
		}
		

		validation(1);

		function validation(active) {
			const $send = document.querySelector('.send');
			const $active = document.querySelector('.activeDoctorInput');
			const $app_doctor = document.querySelector('.app_doctor');
			$active.value = active;
			$app_doctor.value = active;

			console.log(`id = ${active}`);

			console.log(name);

			send.addEventListener('click', function(event) {
				const form = document.querySelectorAll('.patient_form');
				const errorText = document.querySelectorAll('.error_text_add');
				const sidebar = document.querySelector('.sidebar__patient_card');
				event.preventDefault();
				console.log(1);

				let name = form[1].value,
					surname = form[0].value,
					middlename = form[2].value,
					birthday = form[3].value,
					adress = form[4].value,
					phone = form[5].value,
					notes = form[6].value;

				let isError = false;

				for (let i = 0; i < form.length; i++) {
					for (let j = 0; j < 255; j++) {
						this.value.trim();
						if (form[i].value[j] == '!' || form[i].value[j] == '"' || form[i].value[j] == ':' ||  form[i].value[j] == '}' || form[i].value[j] == '\\' || form[i].value[j] == '<' || form[i].value[j] == '' || form[i].value[j] == '='|| form[i].value[j] == '['|| form[i].value[j] == ']') {
							form[i].classList.add('form_error');
							errorText[i].classList.remove('hidden');
							errorText[i].innerHTML = "Недопустимые символы '!.=<\\:};['";
							isError = true;
						}
						if (i < 3) {
							if (form[i].value === '' || form[i].length < 1) {
								form[i].classList.add('form_error');
								errorText[i].classList.remove('hidden');
								errorText[i].innerHTML = "Пустое поле";
								isError = true;
							}
						}
						
						form[i].onfocus = function() {
							form[i].classList.remove('form_error');
							errorText[i].classList.add('hidden');
							errorText[i].innerHTML = "";
							isError = false;
						}
					}
				}


				if (isError === false) {
					
					let newName = new Promise((resolve, reject) => {
				        fetch('index.php', {
				            method: 'POST',
				            headers: {
				                'Content-Type': 'application/x-www-form-urlencoded'
				            },
				            body: `name=${name}&surname=${surname}&middlename=${middlename}&birthday=${birthday}&adress=${adress}&phone=${phone}&notes=${notes}&activeDoctor=${$active.value}`
				        })
				        .then(data => {
				            resolve(data.text());
				        })
				    });

					closePatient.classList.toggle('hidden');
					addPatient.classList.toggle('hidden');
					newPatient.classList.toggle('hidden');
					newPatient.classList.toggle('sidebar');
					$sidehide.classList.toggle('hidden');
					form.forEach( function(element, index) {
						element.value = '';
					});
				}		
			});
		}
	</script>
	<script src="js/teeth.js"></script>
</body>
</html>