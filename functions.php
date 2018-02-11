<?php
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
      		if ($item['category'] == $category) $tasks++;
    	}
	}
  	return $tasks;
}
?>