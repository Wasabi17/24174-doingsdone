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

// Считаем задачи в проекте
function count_tasks ($task_list, $category) {
	$tasks = 0;
  	if ($category == "Все") {
    	$tasks = count($task_list); 
  	} else {
    	foreach ($task_list as $key => $item) {
      		if ($item['category_id'] == $category) {
				$tasks++;
			}
    	}
	}
  	return $tasks;
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

function searchUserByEmail($email, $users) {
	$result = null;
	foreach ($users as $user) {
		if ($user['email'] == $email) {
			$result = $user;
			break;
		}
	}

	return $result;
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
	$show_layout = false;
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