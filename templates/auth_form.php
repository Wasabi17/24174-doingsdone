<div class="modal">
	<button class="modal__close" type="button" name="button">Закрыть</button>

	<h2 class="modal__heading">Вход на сайт</h2>

	<form class="form" action="index.php?login" method="post">
		<div class="form__row">
			<label class="form__label" for="email">E-mail <sup>*</sup></label>
			<?php $errorclass = isset($errors['email']) ? "form__input--error" : "";
				$inputvalue = isset($form['email']) ? $form['email'] : ""; ?>	
			<input class="form__input <?=$errorclass;?>" type="text" name="email" id="email" value="<?=$inputvalue;?>" placeholder="Введите e-mail">
			<?php if (isset($errors['email'])): ?>
			<p class="form__message"><?=$errors['email']?></p>
			<?php endif; ?>
		</div>

		<div class="form__row">
			<label class="form__label" for="password">Пароль <sup>*</sup></label>
			<?php $errorclass = isset($errors['password']) ? "form__input--error" : "";
				$inputvalue = isset($form['password']) ? $form['password'] : ""; ?>
			<input class="form__input <?=$errorclass;?>" type="password" name="password" id="password" value="<?=$inputvalue;?>" placeholder="Введите пароль">
			<?php if (isset($errors['password'])): ?>
			<p class="form__message"><?=$errors['password']?></p>
			<?php endif; ?>
		</div>

		<div class="form__row form__row--controls">
			<input class="button" type="submit" name="login" value="Войти">
		</div>
	</form>
</div>
