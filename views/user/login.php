<?php include ROOT . '/views/layouts/header.php';

/**
 * @var UserController $password
 * @var UserController $email
 */
?>
<main class="content">
	<section class="form-block">
		<div class="container">

			<h1 class="form-block__title">Войти</h1>
            <?php if (isset($errors) && is_array($errors)): ?>
				<ul class="form-block__errors errors">
                    <?php foreach ($errors as $error): ?>
						<li class="errors__item">-<?php echo $error; ?></li>
                    <?php endforeach; ?>
				</ul>
            <?php endif; ?>
			<form class="form" method="POST" action="#">
				<label class="form__label" for="email">
					<input class="form__input-elem" type="email" name="email" required="required" placeholder="E-mail"
						   value="<?php echo $email; ?>" id="email" />
				</label>
				<label class="form__label" for="password">
					<input class="form__input-elem" type="password" name="password" required="required"
						   placeholder="Пароль" value="<?php echo $password; ?>" id="password" />
				</label>
				<label class="form__label" for="submit">
					<input class="btn btn__form" type="submit" name="submit" value="Войти" id="submit" />
				</label>
			</form>
		</div>
	</section>
</main>

<?php include ROOT . '/views/layouts/footer.php'; ?>

