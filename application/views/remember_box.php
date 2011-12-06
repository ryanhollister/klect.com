<div id="loginbox" class="loginbox rememberbox">
	<div class="remember_message">Welcome back <?=$this->phpsession->get('personVO')->getFname() ?>!<br/><br/>Click below to go to your dashboard or click logout to close your session.</div>
	<a href="<?=base_url()?>members_area/dashboard" style="position: absolute; bottom: 24px; left: 24px;"><img src="/img/lb_dashboard.gif" /></a>
	<a href="<?=base_url()?>login/logout" style="position: absolute; bottom: 24px; right: 24px;" ><img src="/img/lb_logout.gif" /></a>
</div>