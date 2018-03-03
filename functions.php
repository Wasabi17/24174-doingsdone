<?php
// Шаблонизатор
function include_template($template,$data = []) {
		if(file_exists('templates/'.$template)) {
			ob_start();
			extract($data);
			require 'templates/'.$template;
			return ob_get_clean();
		}
	}

// Считаем все задачи пользователя
function count_tasks($categories) {
	$count = 0;
	foreach ($categories as $key => $item) {
		$count = $count + $item['COUNT(tasks.id)'];
	}
	return $count;
}

//Подсчет времени задачи и проверка на срочность
function is_important($date) {
	if ($date != "") { 
		$isimportant = false;
		$curdate = strtotime(date('d.m.Y'));
		$deadline = strtotime($date);
		$daysleft = floor($deadline-$curdate);
		if ($daysleft <= 1) {
			$isimportant = true;
		}
		return $isimportant;
	}
}

// Дата задачи должна быть будущая
function is_future($date) {
	if ($date != "") {
		$isfuture = false;
		$curdate = strtotime(date('d.m.Y'));
		$deadline = strtotime($date);
		$daysleft = floor($deadline-$curdate);
		if ($daysleft >= 0) {
			$isfuture = true;
		}
		return $isfuture;
	}
}

// Поиск пользователя по мылу
function searchUserByEmail($email,$link) {
	$user = null;
	$sql = "SELECT * FROM users WHERE email = '$email'";
	$result = mysqli_query($link, $sql);
    if ($result) {
    	$user = mysqli_fetch_assoc($result);
    }
	return $user;
}

// Поиск категорий пользователя и подсчет задач в категориях
function searchCategoriesByUser($user_id,$show_complete_tasks,$link) {
	$categories = [];
	$sql = 'SELECT category.id, category.name, COUNT(tasks.id) FROM category LEFT JOIN tasks ON category.id = tasks.category_id WHERE category.user_id = '.$user_id.' GROUP BY category.id';
	$result = mysqli_query($link, $sql);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
	
	return $categories;
}

// Проверка существования категории пользователя
function checkCategoryByUser($cat_id, $user_id, $link) {
	$rows = 0;
	$cat_id = intval($cat_id);
	$sql= 'SELECT id FROM category WHERE id = '.$cat_id.' AND user_id = '.$user_id;
	$result = mysqli_query($link, $sql);
	if ($result) {
		$rows = mysqli_num_rows($result);
    }
	return $rows;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}

function show_error($page_content, $error) {
    $page_content = include_template('error.php', ['error' => $error]);
	$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'title' => 'Дела не в порядке',
	'show_layout' => '',
	'modal_task' => '',
	'modal_login' => '',
	'modal_cat' => ''
	]);
	print($layout_content);
	die();
}