<section class="welcome">
	<h2 class="welcome__heading">«Дела не в порядке»</h2>

	<div class="welcome__text">
		<p>Упс... что-то не так.</p>
		
		<? if (isset($error)) {
			print $error;
		}
		?>
	</div>
</section>
