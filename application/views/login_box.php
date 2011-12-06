<div id="loginbox" class="loginbox">
	<?=form_open('login/validate_credentials')?>
	<?$usernameval = (isset($invalid)) ? $invalid : ""?>
	<?$autocomplete = (isset($invalid)) ? "  " : ""?>
	<?$passwordval = (isset($invalid)) ? '' : ""?>
	<div class="loginbox-name"><?=form_input('username',$usernameval, 'class="hintUTextbox" '.$autocomplete)?></div>
	<div class="loginbox-pw"><?=form_password('password', '', 'class="hintPTextbox" '.$autocomplete)?></div>
	<div class="loginbox-signup">
		<input name="loginbox-submit" type="image" src="/img/login-btn.gif" alt="Submit Stamp Pony" style="display:inline"/>
		<a title="Sign Up" href="#" id="signup" style="color:white; text-decoration: none"><img src="/img/sign_up_btn.gif" alt="Stamp Pony Sign Up Here" /></a>
		<a title="Forgot Password" href="#" id="forgotpw" style="color:gold; text-decoration: none"><img src="/img/forgot_pw_btn.gif" alt="Forgot Stamp Pony Password" /></a>
	</div>
	<?=form_close()?>
</div>