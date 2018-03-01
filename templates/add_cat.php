<div class="modal">
	<button class="modal__close" type="button" name="button">Закрыть</button>

	<h2 class="modal__heading">Добавление проекта</h2>

	<form class="form" action="index.php?add_cat" method="post">
		<div class="form__row">
			<?php $errorclass = isset($errors['name']) ? "form__input--error" : "";?>
			<label class="form__label" for="project_name">Название <sup>*</sup></label>
			<input class="form__input" type="text" name="name" id="project_name" value="" placeholder="Введите название проекта">
			<?php if (isset($errors['name'])): ?>
			<p class="form__message">
				<?=$errors['name']?>
			</p>
			<?php endif; ?>
		</div>

		<div class="form__row form__row--controls">
			<input class="button" type="submit" name="add_cat" value="Добавить">
		</div>
	</form>
</div>