<div class="cpanel-left-box-content" id="mp_dashboard" style="text-align:center"><br/><br/>
<? if (($this->phpsession->get('personVO')->getAddr1() != '') && ($this->phpsession->get('personVO')->getZip() != '')){ ?>
<a href="<?=base_url();?>marketplace/buy"><img src="/img/<?=$this->phpsession->get('current_domain')->getTag()?>/buy_a.jpg"/></a><br/>
<?php 
}
else
{
?>
<img src="/img/<?=$this->phpsession->get('current_domain')->getTag()?>/buy_a_disabled.jpg" title="You have not entered shipping information, please do so from the edit profile screen."/><p style="margin-bottom:16px">You have not entered shipping information, please do so from the edit profile screen.</p>
<? } ?>
<? if (($this->phpsession->get('personVO')->getAddr1() != '') && ($this->phpsession->get('personVO')->getZip() != '')) { ?>
	<a href="<?=base_url();?>marketplace/sell"><img src="/img/<?=$this->phpsession->get('current_domain')->getTag()?>/sell_a.jpg"/></a><br/>
<?php 
}
else
{
?>
<img src="/img/<?=$this->phpsession->get('current_domain')->getTag()?>/sell_a_disabled.jpg" title="You must be a premium member to sell items in the marketplace!"/><p></p></br>
<? } ?>
<br/><br/>Need some help navigating the buying and selling in the KLECT marketplace? <a href="https://klect.com/site/faq">Check out our FAQ page for some videos!</a>
	<div style="margin:10px auto; width:90px">
		<!-- (c) 2005, 2011. Authorize.Net is a registered trademark of CyberSource Corporation -->
		<div class="AuthorizeNetSeal">
		<script type="text/javascript" language="javascript">var ANS_customer_id="1b95ba1b-b0aa-4243-86eb-2b97a65ebe48";</script>
		<script type="text/javascript" language="javascript" src="//verify.authorize.net/anetseal/seal.js" ></script>
		<a href="http://www.authorize.net/" id="AuthorizeNetText" target="_blank">Accept Credit Cards Online</a></div>
	</div>
</div>