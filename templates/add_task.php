<div class="modal">
	<button class="modal__close" type="button" name="button">Закрыть</button>

	<h2 class="modal__heading">Добавление задачи</h2>

	<form class="form" action="index.php?add_task" method="post" enctype="multipart/form-data">
		<div class="form__row">
		
			<?php $errorclass = isset($errors['task']) ? "form__input--error" : ""; 
			$inputvalue = isset($task_new['task']) ? $task_new['task'] : ""; ?>
			
			<label class="form__label" for="task">Название <sup>*</sup></label>
			<input class="form__input <?=$errorclass;?>" type="text" name="task" id="task" value="<?=$inputvalue;?>" placeholder="Введите название">
		    <?php if (isset($errors['task'])): ?>
			<p class="form__message"><?=$errors['task']?></p>
			<?php endif; ?>
		</div>

		<div class="form__row">
		
			<?php $errorclass = isset($errors['category']) ? "form__input--error" : ""; 
			$inputvalue = isset($task_new['category']) ? $task_new['category'] : ""; ?>
			
			<label class="form__label" for="category">Проект <sup>*</sup></label>
			<select class="form__input form__input--select <?=$errorclass;?>" name="category" id="category">
      			<option value="Выберите проект">Выберите проект</option>
       			<?php foreach ($categories as $key => $item): ?>      
        			<option 
        			<?php if (isset($errors) && $item['name'] == $inputvalue) {
						print 'selected';
					}
        			?>
        			value="<?=$item['id']?>"><?=$item['name']?></option>
        		<?php endforeach; ?>
      		</select>
      		<?php if (isset($errors['category'])): ?>
			<p class="form__message"><?=$errors['category']?></p>
			<?php endif; ?>
		</div>

		<div class="form__row">
		
			<?php $errorclass = isset($errors['date']) ? "form__input--error" : "";
			if (isset($task_new['date']) && $task_new['date'] != "") {
				$inputvalue = date('Y-m-d',strtotime($task_new['date']));
			}
			?>
		
			<label class="form__label" for="date">Дата выполнения</label>
			<input class="form__input form__input--date <?=$errorclass;?>" type="date" name="date" id="date" value="<?=$inputvalue;?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
			<?php if (isset($errors['date'])): ?>
			<p class="form__message"><?=$errors['date']?></p>
			<?php endif; ?>
		</div>

		<div class="form__row">
			
			<label class="form__label" for="file">Файл</label>
			<div class="form__input-file">
				<input class="visually-hidden" type="file" name="file" id="file" value="">
			
				<label class="button button--transparent" for="file">
            <span>Выберите файл</span>
        </label>
			</div>
		</div>

		<div class="form__row form__row--controls">
			<input class="button" type="submit" name="add_task" value="Добавить">
		</div>
	</form>
</div>

