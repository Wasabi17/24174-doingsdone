<?php

date_default_timezone_set("Europe/Moscow");
	
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$categories = ["Все", "Входящие", "Учеба", "Работа", "Домашние дела", "Авто"];

$task_list = [
	[
		'task' => 'Собеседование в IT-компании',
		'date' => '01.06.2018',
		'category' => 'Работа',
        'done' => false
	],
	[
		'task' => 'Выполнить тестовое задание',
		'date' => '11.02.2018',
		'category' => 'Работа',
        'done' => false
	],
    [
		'task' => 'Сделать задание первого раздела',
		'date' => '21.04.2018',
		'category' => 'Учеба',
        'done' => true
	],
    [
		'task' => 'Встреча с другом',
		'date' => '22.04.2018',
		'category' => 'Входящие',
        'done' => false
	],
    [
		'task' => 'Купить корм для кота',
		'date' => '',
		'category' => 'Домашние дела',
        'done' => false
	],
    [
		'task' => 'Заказать пиццу',
		'date' => '',
		'category' => 'Домашние дела',
        'done' => false
	]
    
];

require_once('functions.php');

//Ищем id категории в адресной строке
$cat = null;

if (isset($_GET['cat'])) {
	$cat_id = $_GET['cat'];

	foreach ($categories as $key => $value) {
		if ($key == $cat_id)  {
			$cat = $key;
			break;
		}
	}
}

if (!$cat) {
	http_response_code(404);
}
			
$page_content = include_template('index.php', [
	'task_list' => $task_list,
	'show_complete_tasks' => $show_complete_tasks,
	'cat' => $cat,
	'categories' => $categories
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'task_list' => $task_list, 
	'categories' => $categories, 
	'title' => 'Дела в порядке - главная',
	'user' => 'Андрей'
]);

print($layout_content);
	
?>