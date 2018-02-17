<div class="modal">
	<button class="modal__close" type="button" name="button">Закрыть</button>

	<h2 class="modal__heading">Добавление задачи</h2>

	<form class="form" action="index.php" method="post" enctype="multipart/form-data">
		<div class="form__row">
			<label class="form__label" for="task">Название <sup>*</sup></label>
			<input class="form__input <? if (isset($errors['task'])) {
				print 'form__input--error';
			}
			?>" type="text" name="task" id="task" value="" placeholder="Введите название">
			<?php if (isset($errors['task'])) : ?> 
				<p class="form__message"><?=$errors['task'];?></p>
			<? endif; ?>
		
		</div>

		<div class="form__row">
			<label class="form__label" for="category">Проект <sup>*</sup></label>

			<select class="form__input form__input--select 
			<? if (isset($errors['category'])) {
				print 'form__input--error';
			}
			?>" name="category" id="category">
        		<option value="Входящие">Входящие</option>
        		<option value="Авто">Авто</option>
      		</select>
      		<?php if (isset($errors['category'])) : ?> 
				<p class="form__message"><?=$errors['category'];?></p>
			<? endif; ?>
		</div>

		<div class="form__row">
			<label class="form__label" for="date">Дата выполнения</label>

			<input class="form__input form__input--date" type="date" name="date" id="date" value="" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
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
			<input class="button" type="submit" name="" value="Добавить">
		</div>
	</form>
</div>

