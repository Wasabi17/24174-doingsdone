<?php

date_default_timezone_set("Europe/Moscow");

require_once ('init.php');

// Работа с БД
if (!$link) {
    $error = mysqli_connect_error();
    show_error($page_content, $error);
}
else {
	// Забираем из БД юзеров
	$sql = 'SELECT * FROM users';
	$result = mysqli_query($link, $sql);
	
	if ($result) {
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
	 else {
        show_error($page_content, mysqli_error($link));
    }
	
}

session_start();

if (isset($_SESSION['user'])) {
	
	$user = $_SESSION['user'];
	
	$user_id = intval($user['id']);
	
	// Забираем из БД категории юзера
	$sql = 'SELECT `id`, `name` FROM category WHERE user_id =' .$user_id;
	$result = mysqli_query($link, $sql);
    if ($result) {
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
	
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
	
    // Забираем задачи юзера для главной страницы и категории Все
	if ($show_complete_tasks == 1) {
		$sql = 'SELECT * FROM tasks WHERE user_id =' .$user_id ;
	} else {
		$sql = 'SELECT * FROM tasks WHERE done_date IS NULL AND user_id =' .$user_id;
	}
	$result = mysqli_query($link, $sql);
	if ($result) {
        $task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
	
	$all_tasks = $task_list; // Чтобы посчитать кол-во задач для менюшки
	
	//Ищем id категории в адресной строке и определяем задачи для показа на странице
	if (isset($_GET['cat'])) {
		$cat_id = intval($_GET['cat']);
		if ($cat_id == 0) {
			$cat = 0;
		} else {
			// Проверяем существование категории
			$sql = 'SELECT `id` FROM category WHERE id =' .$cat_id. ' AND user_id = '.$user_id;
			$result = mysqli_query($link, $sql);
			$cat = $cat_id;
    		if ($result) {
        		// Забираем задачи юзера для выбранной категории
				if ($show_complete_tasks == 1) {
					$sql = 'SELECT * FROM tasks WHERE category_id = '.$cat_id.' AND user_id = '.$user_id;
				} else {
					$sql = 'SELECT * FROM tasks WHERE done_date IS NULL AND category_id = '.$cat_id.' AND user_id =' .$user_id;
				}
				$result = mysqli_query($link, $sql);
    			if ($result) {
        			$task_list = mysqli_fetch_all($result, MYSQLI_ASSOC);
    			}
    		} else {
				http_response_code(404);
				die();
			}
		}
	}
	
	$page_content = include_template('index.php', [
		'task_list' => $task_list,
		'show_complete_tasks' => $show_complete_tasks,
		]);
				
	// Обработка кнопки Добавить проект

	if (isset($_GET['add_cat'])) {
		$show_layout = true;
		$modal_cat = include_template('add_cat.php', []);	

		// Обработка формы проекта
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_cat'])) {
			$form = $_POST;
			$show_layout = true;
			$required = ['name'];
			$errors = [];
			foreach ($required as $key) {
				if (empty($_POST[$key])) {
					$errors[$key] = 'Заполните это поле';
				}
			}

			if (count($errors)) {
				$modal_cat = include_template('add_cat.php', [
					'errors' => $errors,
					'form' => $form
				]);
			} else {
				$sql = 'INSERT INTO category (name, user_id) VALUES (?, ?)';
				$stmt = db_get_prepare_stmt($link, $sql, [$form['name'], $user_id]);
				$res = mysqli_stmt_execute($stmt);
				header("Location: /index.php");
				die();
			}

		}

	}
	
	// Обработка кнопки Добавить задачу
	
	if (isset($_GET['add_task'])) {
		$show_layout = true;
		$modal_task = include_template('add_task.php', [
			'categories' => $categories
		]);	

		// Обработка формы задачи
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_task'])) {
			$task_new = $_POST;
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
				$task_new['date'] = date('Y.m.d',strtotime($_POST['date']));
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
				if ($_POST['date'] != "") { 
					$sql = 'INSERT INTO tasks (name, category_id, creation_date, deadline_date, file, user_id) VALUES (?, ?, CURDATE(), ?, ?, ?)';
					$stmt = db_get_prepare_stmt($link, $sql, [$task_new['task'], $task_new['category'], $task_new['date'], $task_new['file'], $user_id]);
				} else {
					$sql = 'INSERT INTO tasks (name, category_id, creation_date, file, user_id) VALUES (?, ?, CURDATE(), ?, ?)';
					$stmt = db_get_prepare_stmt($link, $sql, [$task_new['task'], $task_new['category'], $task_new['file'], $user_id]);
				}
				$res = mysqli_stmt_execute($stmt);
				header("Location: /index.php");
				die();
			}

		}
	}

} else {
	// Авторизация
	if (isset($_GET['login'])) {
		$show_layout = true;
		$modal_login = include_template('auth_form.php', []);	
		$page_content = include_template('guest.php', []);
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
			$form = $_POST;

			$required = ['email', 'password'];
			$errors = [];
			foreach ($required as $field) {
				if (empty($form[$field])) {
					$errors[$field] = 'Это поле надо заполнить';
				}
			}
				
			if (!count($errors) and $user = searchUserByEmail($form['email'], $users)) {
				if (password_verify($form['password'], $user['password'])) {
					$_SESSION['user'] = $user;
				}
				else {
					$errors['password'] = 'Неверный пароль';
				}
			}
			else {
				$errors['email'] = 'Такой пользователь не найден';
			}

			if (count($errors)) {
				$modal_login = include_template('auth_form.php', [
					'form' => $form, 
					'errors' => $errors
					]);
			}
			else {
				header("Location: /index.php");
				die();
			}
		}	
	} 
	else {
		$page_content = include_template('guest.php', []);
	}
}


// Разлогин
if (isset($_GET['logout'])) {
	session_unset();
	$page_content = include_template('guest.php', []);
}

// Регистрация пользователя
if (isset($_GET['reg'])) {
	$page_content = include_template('reg.php', []);
		
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reg'])) {
		$form = $_POST;

		$required = ['email', 'password', 'name'];
		$errors = [];
		foreach ($required as $field) {
			if (empty($form[$field])) {
				$errors[$field] = 'Это поле надо заполнить';
			}
		}
		if (!count($errors) && $user = searchUserByEmail($form['email'], $users)) {
			$errors['email'] = 'Пользователь с таким email уже зарегестрирован';
		}
		
		if (!count($errors) && !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
			$errors['email'] = 'Введите корректный email';
		}
		
		if (count($errors)) {
			$page_content = include_template('reg.php', [
				'form' => $form, 
				'errors' => $errors
				]);
		}
		else {
			$sql = 'INSERT INTO users (email, name, password, registration_date, contacts) VALUES (?, ?, ?, CURDATE(), ?)';
        	$stmt = db_get_prepare_stmt($link, $sql, [$form['email'], $form['name'], password_hash($form['password'], PASSWORD_DEFAULT), $form['contacts']]);
        	$res = mysqli_stmt_execute($stmt);
			header("Location: /index.php?login");
			die();
		}
	}	
} 

//Выводим контент
$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'task_list' => $task_list,
	'all_tasks' => $all_tasks,
	'categories' => $categories, 
	'title' => 'Дела в порядке - главная',
	'cat' => $cat,
	'user' => $user,
	'show_layout' => $show_layout,
	'modal_task' => $modal_task,
	'modal_login' => $modal_login,
	'modal_cat' => $modal_cat
]);

print($layout_content);
	
?>