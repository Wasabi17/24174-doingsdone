<?php
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
		'date' => '25.05.2018',
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
		'date' => 'Нет',
		'category' => 'Домашние дела',
        'done' => false
	],
    [
		'task' => 'Заказать пиццу',
		'date' => 'Нет',
		'category' => 'Домашние дела',
        'done' => false
	]
    
];

require_once('functions.php');

$page_content = include_template('index.php', [
	'task_list' => $task_list,
	'show_complete_tasks' => $show_complete_tasks
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