<?php

date_default_timezone_set("Europe/Moscow");
	
// показывать или нет выполненные задачи
$show_complete_tasks = 0;
$show_complete_tasks_cookie = "showcompl";
$showcompl_value = 0;
$expire = strtotime("+30 days");
$path = "/";

if (isset($_GET['show_completed'])) {
	if (isset($_COOKIE['showcompl'])) {
		$showcompl_value = $_COOKIE['showcompl'] == 0 ? 1 : 0;
		$show_complete_tasks = $showcompl_value; 
	} else {
		$showcompl_value = 1;	
		$show_complete_tasks = $showcompl_value;
	}
	setcookie($show_complete_tasks_cookie, $showcompl_value, $expire, $path);
} else {
	if (isset($_COOKIE['showcompl'])) {
	 $show_complete_tasks = $_COOKIE['showcompl'];
}
}

$categories = ["Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

$task_list = [
	[
		'task' => 'Собеседование в IT-компании',
		'date' => '01.06.2018',
		'category' => 'Работа',
        'done' => false,
		'file' => 'Home.psd'
	],
	[
		'task' => 'Выполнить тестовое задание',
		'date' => '11.02.2018',
		'category' => 'Работа',
        'done' => false,
		'file' => ''
	],
    [
		'task' => 'Сделать задание первого раздела',
		'date' => '21.04.2018',
		'category' => 'Учеба',
        'done' => true,
		'file' => ''
	],
    [
		'task' => 'Встреча с другом',
		'date' => '22.04.2018',
		'category' => 'Входящие',
        'done' => false,
		'file' => ''
	],
    [
		'task' => 'Купить корм для кота',
		'date' => '',
		'category' => 'Домашние дела',
        'done' => false,
		'file' => ''
	],
    [
		'task' => 'Заказать пиццу',
		'date' => '',
		'category' => 'Домашние дела',
        'done' => false,
		'file' => 'Home.psd'
	]
    
];

require_once('functions.php');

//Ищем id категории в адресной строке
$cat = null;

if (isset($_GET['cat'])) {
	$cat_id = $_GET['cat'];
	if (isset($categories[$cat_id])) {
		$cat = $cat_id;
	} else {
		http_response_code(404);
		die();
	}
	
}

// Обработка кнопки Добавить задачу
$show_layout = false;
$modal_task = null;

if (isset($_GET['add_task'])) {
	$show_layout = true;
	$modal_task = include_template('add_task.php', [
		'categories' => $categories
	]);	
}

// Обработка формы задачи
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$task_new = $_POST;
	$task_new['done'] = false;
	$show_layout = true;
	$required = ['task'];
	$errors = [];
	foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = 'Заполните это поле';
		}
	}
	
	if ($_POST['category'] == 'Выберите проект') {
			$errors['category'] = 'Нужно выбрать проект';
	}
	
	
	if ($_POST['date'] != "") {
		$task_new['date'] = date('d.m.Y',strtotime($_POST['date']));
		if (!is_future($task_new['date'])) {
			$errors['date'] = 'Дата окончания задачи должна быть в будущем';
		} 
	}
		
	if (isset($_FILES['file']['name'])) {
		$file_path = $_FILES['file']['name'];
		$res = move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/' . $file_path);
	}
	
	if (isset($file_path)) {
		$task_new['file'] = $file_path;
	}
	
	if (count($errors)) {
		$modal_task = include_template('add_task.php', [
			'errors' => $errors,
			'categories' => $categories,
			'task_new' => $task_new
		]);
	} else {
		array_unshift($task_list, $task_new);
		$show_layout = false;
	}

}


//Определяем задачи для показа на странице
$task_list_show=[];

if ($cat == 0) {
	if ($show_complete_tasks == 1) {
		$task_list_show = $task_list;
	} else {
		foreach ($task_list as $key => $item) {
			if (!$item['done'])  {
				array_push($task_list_show, $task_list[$key]);
			}
		}
	} 
} else {
	foreach ($task_list as $key => $item) {
		if (($item['category'] == $categories[$cat] && !$item['done'] && $show_complete_tasks == 0) || ($item['category'] == $categories[$cat] && $show_complete_tasks == 1))  {
			array_push($task_list_show, $task_list[$key]);
		}
	}
}


//Выводим контент
$page_content = include_template('index.php', [
	'task_list_show' => $task_list_show,
	'show_complete_tasks' => $show_complete_tasks
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'task_list' => $task_list, 
	'categories' => $categories, 
	'title' => 'Дела в порядке - главная',
	'user' => 'Андрей',
	'cat' => $cat,
	'show_layout' => $show_layout,
	'modal_task' => $modal_task
]);

print($layout_content);
	
?>