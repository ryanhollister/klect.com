<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="collection, collectors, catalog, my little pony, klect, klect corp, trade, buy, sell, index, stamps, baseball cards, pez dispensers, coins" />
<meta name="description" content="KLECT is the solution for millions of collectors who want to inventory, value and trade their collectibles online. Basic membership is free!" />
<meta name="copyright" content="August 2010" />
<meta name="author" content="Ryan Hollister" />
<link href="/css/reset.css" rel="stylesheet" type="text/css" />
<link href="/css/dropshadow.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
var DOMAIN_TAG = '<?=constant($this->phpsession->get('current_domain')->getTag().'_DOMAIN_TAG')?>';
var DOMAIN_NAME = '<?=constant($this->phpsession->get('current_domain')->getTag().'_NAME')?>';
var DOMAIN_ID = '<?=constant($this->phpsession->get('current_domain')->getTag().'_DOMAIN_ID')?>';
var DOMAIN_ITEM = '<?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?>';
var DOMAIN_ITEMS = '<?=constant($this->phpsession->get('current_domain')->getTag().'_ITEMS')?>';
</script>
<script type="text/javascript" src="<?=base_url()?>js/<?=JQUERY_JS?>.js"></script>
<script type="text/javascript" src="<?=base_url()?>js/klect.js"></script>


 <?php 
 if (isset($js_includes))
 {
 ?>
	<?php foreach($js_includes as $js_include): ?>
	<script type="text/javascript" src="<?php echo base_url();?>js/<?=$js_include?>.js"></script>
	<?php endforeach; ?>
 <?php 	
 }
 ?>          
 	 <?php if (isset($jquery_scripts)) {?>
 	 <script type="text/javascript">   
 		  $(document).ready(function(){ 
  	<?php foreach($jquery_scripts as $jquery_script): ?>                                     
	<?php echo $jquery_script;?>
	<?php endforeach; ?>     
 		  });                      
 	 </script>  
 	 
 	 <?php } ?>
 <?php 
 if (isset($css_includes))
 {
 ?>
	<?php foreach($css_includes as $css_include): ?>
	<link rel="stylesheet" href="<?php echo base_url();?>css/<?=$css_include?>.css" type="text/css" media="screen" />
	<?php endforeach; ?>
 <?php 	
 }
 ?>
 <link href="/css/klect.css" rel="stylesheet" type="text/css" />
<title><?= (isset($page_title)) ? $page_title : 'Welcome to Klect.com'?></title>
</head>
<body>
<div>
	<div class="header">
	<a href="<?=constant($this->phpsession->get('current_domain')->getTag().'_FACEBOOK')?>" target="_blank" class="KLECT facebook"></a>
	<a href="<?=constant($this->phpsession->get('current_domain')->getTag().'_TWITTER')?>" target="_blank" class="twitter"></a>
	<a href="#" target="_blank" style="color:white" class="invite_a_friend" id="inviteafriend_btn"></a>
	</div>
	<div class="banner-nav-wrapper">
		<div class="button-nav <?=(!strstr($_SERVER["REQUEST_URI"], 'contact_us') && !strstr($_SERVER["REQUEST_URI"], 'about_us') && !strstr($_SERVER["REQUEST_URI"], '/faq')) || strstr($_SERVER["REQUEST_URI"], '/members_area') ? 'selected-nav' : ''?>">
			<span class="text-nav"><a href="<?=base_url()?>">Home</a></span>
		</div>
		<div class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'news') ? 'selected-nav' : ''?>">
			<span class="text-nav"><a  href="<?=base_url()?>site/news">News</a></span>
		</div>
		<div class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'about_us') ? 'selected-nav' : ''?>">
			<span class="text-nav"><a  href="<?=base_url()?>site/about_us">About Us</a></span>
		</div>
		<div class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'faq') ? 'selected-nav' : ''?>">
			<span class="text-nav"><a  href="<?=base_url()?>site/faq">FAQ</a></span>
		</div>
		<div class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'contact_us') ? 'selected-nav' : ''?>">
			<span class="text-nav"><a href="<?=base_url()?>site/contact_us">Contact Us</a></span>
		</div>
		<div class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'blog') ? 'selected-nav' : ''?>" style="z-index:9;position:relative">
			<span class="text-nav"><a  href="<?=base_url()?>site/blog">Blog</a></span>
		</div>
		<div style="margin: auto; position: relative; bottom: 8px; width: 400px; height: 30px; left: 186px; z-index:1"><a href="<?=base_url()?>login/logout" style="float: right;">
			<img src="/img/log_out_btn.png" alt="Logout"></a>
			<span style="position: relative; bottom: 12px; float: right;">Welcome <?=$this->phpsession->get('personVO')->getFname() ?>!</span>
		</div>
	</div>
	<div class="banner members-banner">
	<div class="nav-subnav-clear"></div>
		<div class="subnav-wrapper">
			<?php if (isset($users_collections) && count($users_collections) > 0) { ?>
			<?php foreach ($users_collections as $users_collection) {
				$selected = ($users_collection->getName() == $this->phpsession->get('current_domain')->getName()) ? 'selected-subnav' : 'notselected-subnav';
				?>
			<div class="button-subnav <?=$selected?>" id="collection_<?=$users_collection->getId()?>">
				<span class="text-subnav"><?=$users_collection->getName()?></span>
			</div>
			<?php } }?>
			<? if (isset($additional_collections) && count($additional_collections) > 0)
				{
					?>
			<div class="button-subnav" id="addcollection_btn">
				<span class="text-subnav">+ Add Collection</span>
			</div>
			<?php } ?>
		</div>
	</div>
<script>
$('.notselected-subnav').click(function(){
	$.post(getBaseURL()+"/collection_management/change_collection", "collection_id="+ $(this).attr("id").replace("collection_", ""),
			function (data)
			{
				if(data)
				{
					window.location.reload( true );
				}
			});
});
</script>