<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.html" method="post">
	<input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

	<input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
	<nav class="tasks-switch">
		<a href="<?=isset($_GET['cat'])? '?cat='.$_GET['cat']: '/';?>" class="tasks-switch__item <?=(!isset($_GET['filter'])) ? 'tasks-switch__item--active' : '';?>">Все задачи</a>
		<a href="<?=isset($_GET['cat'])? '?cat='.$_GET['cat'] .'&filter=today' : '?filter=today';?>" class="tasks-switch__item <?=(isset($_GET['filter']) && $_GET['filter'] == 'today') ? 'tasks-switch__item--active' : '';?>">Повестка дня</a>
		<a href="<?=isset($_GET['cat'])? '?cat='.$_GET['cat'] .'&filter=tomorrow' : '?filter=tomorrow';?>" class="tasks-switch__item <?=(isset($_GET['filter']) && $_GET['filter'] == 'tomorrow') ? 'tasks-switch__item--active' : '';?>">Завтра</a>
		<a href="<?=isset($_GET['cat'])? '?cat='.$_GET['cat'] .'&filter=expired' : '?filter=expired';?>" class="tasks-switch__item <?=(isset($_GET['filter']) && $_GET['filter'] == 'expired') ? 'tasks-switch__item--active' : '';?>">Просроченные</a>
	</nav>
	
	<label class="checkbox">
    	<a href="<?=isset($_GET['cat'])? '?cat='.$_GET['cat'] .'&show_completed' : '?show_completed';?>">
      		<input class="checkbox__input visually-hidden" type="checkbox" 
      		<?php if ($show_complete_tasks == 1) { 
				print ("checked"); 
			} 
		    ?>>
      		<span class="checkbox__text">Показывать выполненные</span>
    	</a>
 	</label>
</div>

<table class="tasks">
	<!-- Вывод массива задач -->
	<?php foreach ($task_list as $key => $item): ?>
	<tr class="tasks__item task 
	<?php 
		if ($item['done_date'] !="") {
			print ('task--completed'); 
		} else {
			if (is_important($item['deadline_date'])) {
				print ('task--important'); 
			}
		}
	?>">
		<td class="task__select">
			<label class="checkbox task__checkbox">
        		<input class="checkbox__input visually-hidden" type="checkbox" checked>
        		<a href="?done=<?=$item['id'];?>"><span class="checkbox__text"><?=htmlspecialchars($item['name']);?></span></a>
      		</label>
		</td>

		<td class="task__file">
		<?php if (($item['file'] != "")) {
			print '<a class="download-link href="#">'.$item['file'].'</a>';
		}
		?>	
		</td>
		<td class="task__date">
			<?php !is_null($item['deadline_date']) ? print date('d.m.Y',strtotime($item['deadline_date'])) : "";?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>