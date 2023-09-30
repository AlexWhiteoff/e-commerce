<main id="main">
	<div class="account-registration-background"></div>
	<section class="account-registration" id="account-registration">
		<form action="" method="post">
			<h2 class="account-registration__title">
				Create account
			</h2>

			<? if (!empty($messageClass)) : ?>
				<div class="error-alert-block alert-<?= $messageClass ?>" role="alert">
					<div class="error-alert-block__text">
						<?= $messageText ?>
					</div>
				</div>
			<? endif; ?>

			<input type="email" name="email" class="account-registration-input__email" placeholder="Enter your Email" required>
			<input type="password" name="password" class="account-registration-input__password" id="input-password" placeholder="Enter your Password" required autocomplete="new-password">
			<i class="fas fa-eye see-password"></i>
			<input type="password" name="repeat-password" class="account-registration-input__password" id="input-repeat-password" placeholder="Repeat your Password" required autocomplete="new-password">
			<i class="fas fa-eye see-password"></i>
			<div id="password-error"></div>
			<input type="submit" value="Submit" class="account-registration__submit" id="submit-button">
			<span class="account-registration__submit-span"></span>
		</form>
		<fieldset class="account-registration__block">
			<legend class="account-registration__legendText">Already have an account?</legend>
			<a class="account-registration__sign-button" href="/account/login">Sign-In Your Account</a>
			<span class="account-registration__sign-span"></span>
		</fieldset>
	</section>
</main>