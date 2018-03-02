<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.html" method="post">
	<input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

	<input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
	<nav class="tasks-switch">
		<a href="<?=getUrl('');?>" class="tasks-switch__item <?php (!isset($_GET['today']) && !isset($_GET['tomorrow']) && !isset($_GET['expired'])) ? print 'tasks-switch__item--active' : '';?>">Все задачи</a>
		<a href="<?=getUrl('today');?>" class="tasks-switch__item <?php (isset($_GET['today'])) ? print 'tasks-switch__item--active' : '';?>">Повестка дня</a>
		<a href="<?=getUrl('tomorrow');?>" class="tasks-switch__item <?php (isset($_GET['tomorrow'])) ? print 'tasks-switch__item--active' : '';?>">Завтра</a>
		<a href="<?=getUrl('expired');?>" class="tasks-switch__item <?php (isset($_GET['expired'])) ? print 'tasks-switch__item--active' : '';?>">Просроченные</a>
	</nav>
	
	<label class="checkbox">
    	<a href="<?=getUrl('show_completed');?>">
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
        		<a href="?done=<?=$item['id'];?>"><span class="checkbox__text"><?=$item['name'];?></span></a>
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