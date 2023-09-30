<main id="main">
	<div class="account-login-background"></div>
	<section class="account-login" id="account-login">
		<form method="post">
			<h2 class="account-login__title">
				Sign-In Your Account
			</h2>

			<? if (!empty($messageClass)) : ?>
				<div class="error-alert-block alert-<?= $messageClass ?>" role="alert">
					<div class="error-alert-block__text">
						<?= $messageText ?>
					</div>
				</div>
			<? endif; ?>

			<input type="email" name="email" class="account-login__input-email" placeholder="Enter your Email" required>
			<input type="password" name="password" class="account-login__input-password" placeholder="Enter your Password" required autocomplete="current-password">
			<i class="fas fa-eye see-password"></i>
			<input type="submit" value="Submit" class="account-login__submit">
			<span class="account-login__submit-span"></span>
		</form>
		<fieldset class="account-login__block">
			<legend class="account-login__legendText">New to Grovemade?</legend>
			<a class="account-login__sign-button" href="/account/registration">Create your Account</a>
			<span class="account-login__sign-span"></span>
		</fieldset>
	</section>
</main>