<?php

require_once ('functions.php');

$db = [
	'host' => 'localhost',
	'user' => 'root',
	'password' => '',
	'database' => 'doingsdone'
	
];

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

$categories = [];
$task_list = [];
$show_complete_tasks = 0;
$page_content = null;
$cat = null;
$user = null;
$show_layout = false;
$modal_task = null;
$modal_login = null;
$modal_cat = null;

// Проверка связи с БД
if (!$link) {
    $error = mysqli_connect_error();
    show_error($page_content, $error);
}