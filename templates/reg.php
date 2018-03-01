<h2 class="content__main-heading">Регистрация аккаунта</h2>

<form class="form" action="index.php?reg" method="post">
	<div class="form__row">
		<label class="form__label" for="email">E-mail <sup>*</sup></label>
		<?php $errorclass = isset($errors['email']) ? "form__input--error" : "";
				$inputvalue = isset($form['email']) ? $form['email'] : ""; ?>
		<input class="form__input <?=$errorclass;?>" type="text" name="email" id="email" value="<?=$inputvalue;?>" placeholder="Введите e-mail">
		<?php if (isset($errors['email'])): ?>
		<p class="form__message">
			<?=$errors['email']?>
		</p>
		<?php endif; ?>
	</div>

	<div class="form__row">
		<label class="form__label" for="password">Пароль <sup>*</sup></label>
		<?php $errorclass = isset($errors['password']) ? "form__input--error" : "";
				$inputvalue = isset($form['password']) ? $form['password'] : ""; ?>
		<input class="form__input <?=$errorclass;?>" type="password" name="password" id="password" value="<?=$inputvalue;?>" placeholder="Введите пароль">
		<?php if (isset($errors['password'])): ?>
		<p class="form__message">
			<?=$errors['password']?>
		</p>
		<?php endif; ?>
	</div>

	<div class="form__row">
		<label class="form__label" for="name">Имя <sup>*</sup></label>
		<?php $errorclass = isset($errors['name']) ? "form__input--error" : "";
				$inputvalue = isset($form['name']) ? $form['name'] : ""; ?>
		<input class="form__input <?=$errorclass;?>" type="text" name="name" id="name" value="<?=$inputvalue;?>" placeholder="Введите имя">
		<?php if (isset($errors['name'])): ?>
		<p class="form__message">
			<?=$errors['name']?>
		</p>
		<?php endif; ?>
	</div>

	<div class="form__row form__row--controls">
		<input class="button" type="submit" name="reg" value="Зарегистрироваться">
	</div>
</form>
