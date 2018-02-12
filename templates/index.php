<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.html" method="post">
	<input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

	<input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
	<nav class="tasks-switch">
		<a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
		<a href="/" class="tasks-switch__item">Повестка дня</a>
		<a href="/" class="tasks-switch__item">Завтра</a>
		<a href="/" class="tasks-switch__item">Просроченные</a>
	</nav>

	<label class="checkbox">
    	<a href="/">
      		<input class="checkbox__input visually-hidden" type="checkbox" <?php if ($show_complete_tasks == 1) print ("checked"); ?>>
      		<span class="checkbox__text">Показывать выполненные</span>
    	</a>
 	</label>
</div>

<table class="tasks">
	<!-- Вывод массива задач -->
	<?php foreach ($task_list as $key => $item): ?>
	<?php if ($show_complete_tasks == 1 || ($show_complete_tasks == 0 && !$item['done'])): ?>
	<tr class="tasks__item task <?php if ($item['done']) print ('task--completed'); if (is_important($item['date'])) print ('task--important'); ?>">
		<td class="task__select">
			<label class="checkbox task__checkbox">
        		<input class="checkbox__input visually-hidden" type="checkbox" checked>
        		<a href="/"><span class="checkbox__text"><?=$item['task'];?></span></a>
      		</label>
		</td>

		<td class="task__file">
			<a class="download-link" href="#">Home.psd</a>
		</td>

		<td class="task__date">
			<?=$item['date'];?>
		</td>
	</tr>
	<?php endif; ?>
	<?php endforeach; ?>
</table>