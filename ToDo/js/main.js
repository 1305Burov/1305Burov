



// let form = document.forms.form;
// 	let formText = form.elements.text;
// 	const formBtn = document.querySelector('.form__btn');
	
	
// 	formBtn.addEventListener('click', function() {
// 		let div = document.createElement('div');
// 			div.className = 'task';
// 			div.innerHTML = formText.value;
		
// 		form.after(div);
// 	})

const $ul = document.querySelector('.task__list');
const $input = document.querySelector('.input');
const $btn = document.querySelector('.form__btn');
const $refresh = document.querySelector('.refresh');
const $date = document.querySelector('.date');
console.log( $btn );


const uncheck = 'fa-circle';
const check = 'fa-check-circle';
const line = 'line';
let taskList = [];
let id = 0;

$ul.addEventListener('click', function(event) {
	let element = event.target; //вернет иконку по клику
	const elementJob = event.target.attributes.job.value; //delete or complete att
	if (elementJob == 'complete') {
		completeTask(element);
	}else if (elementJob == 'delete') {
		removeTask(element);
	}
});

$btn.addEventListener( 'click', function () {
	const task = $input.value;

	if ( task ) {
		addTask(task, id, false, false);

		taskList.push(
				{
					name: task,
					id: id,
					done: false,
					trash: false
				}
			);
	} else {
		inputError('Пустое поле');
	}

	$input.value = '';
	id++;
	localStorage.setItem("TODO", JSON.stringify(taskList));
});

$refresh.addEventListener('click', function(){
	localStorage.clear();
	location.reload();
})

document.addEventListener("keydown", function(event) {
	if (event.keyCode == 13) {
		const task = $input.value;

		if ( task ) {
			addTask( task );
		} else {
			inputError('Пустое поле');
		}
		localStorage.setItem("TODO", JSON.stringify(taskList));
		$input.value = '';
	}

});



function addTask( task, id, done, trash) {

	if (trash) {return;}

	const DONE = done ? check : uncheck;
	const LINE = done ? line : "";

	const contant = `<li>
					<p class="task__list-text ${ LINE }">${ task }</p>
					<i class="far ${ DONE } fa-lg" id="${id}" job="complete"></i>
					<i class="far fa-trash-alt fa-lg" id="${id}" job="delete"></i>	
				</li>`;

	const position = 'afterbegin';

	$ul.insertAdjacentHTML( position, contant );
}

function inputError(textError) {
	$input.classList.add('input__error');
	let error = document.createElement('error');
 		error.className = 'error';
		error.innerHTML = textError;

		form.after(error);
	setTimeout(del, 2000);

	function del() {
		error.remove()
		$input.classList.remove('input__error');
	}
}

function completeTask(element) {
	element.classList.toggle(check);
	element.classList.toggle(uncheck);
	element.parentNode.querySelector('.task__list-text').classList.toggle(line);
	taskList[element.id].done = taskList[element.id].done ? false : true;
}

function removeTask(element) {
	element.parentNode.parentNode.removeChild(element.parentNode);
	taskList[element.id].trash = true;
}

function loadToDo( array ) {
	array.forEach(function(item) {
		addTask(item.name, item.id, item.done, item.trash);
	});
}

let localData = localStorage.getItem("TODO");
if (localData) {
	taskList = JSON.parse(localData);
	loadToDo(taskList);
	id = taskList.length;
} else {
	taskList = [];
	id = 0;
}



