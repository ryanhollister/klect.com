<p>We have upgraded our security at KLECT. In doing so it is necessary for everyone to change their password. We appologize for any inconvienece, you will only have to do this once.</p>
<?=form_open('login/change_password')?><br/>
<?$usernameval = (isset($invalid)) ? $invalid : ""?>
<?$autocomplete = (isset($invalid)) ? "  " : ""?>
<?$passwordval = (isset($invalid)) ? '' : ""?>
<div class="">Username: <?=form_input('username',$usernameval, 'class="" '.$autocomplete)?></div>
<div class="">Old Password: <?=form_password('old_password', '', 'class="" '.$autocomplete)?></div>
<div class="">New Password: <?=form_password('new_password', '', 'class="" '.$autocomplete)?></div>
<?=form_submit('submit', 'Submit')?>
<?=form_close()?>