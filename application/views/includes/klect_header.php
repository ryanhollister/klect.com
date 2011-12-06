<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="keywords" content="stamp collecting software, stamp recognition software, stamp database software, stamp images, collection, free, collectors, catalog, my little pony, stamp, mac, windows, pc, osx, linux, klect, klect corp, trade, buy, sell, index, stamps, us, philatelic, Philately" />
<meta name="description" content="KLECT is the solution for millions of collectors who want to inventory stamps, value and trade their collectible stamps online. Basic membership is free!" />
<meta name="copyright" content="February 2011" />
<meta name="author" content="Ryan Hollister" />
<link href="/css/reset.css" rel="stylesheet" type="text/css" />
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
<meta name="google-site-verification" content="WAFTmWF42GEjQkNG1A7NRfpC-uFbSXAqbxXHEbQjpb4" />
</head>
<body>
<div>
	<div class="header" style="background:transparent url('/css/images/banner.gif') no-repeat;">
	<a href="http://www.facebook.com/pages/Stamp_Collecting_KLECT/190454150982573" target="_blank" class="KLECT facebook"></a>
	<a href="http://www.twitter.com/KLECT_Stamps" target="_blank" class="twitter"></a>
	</div>
	</div>
	<div class="banner-nav-wrapper">
		<div class="button-nav <?=(!strstr($_SERVER["REQUEST_URI"], 'news') && !strstr($_SERVER["REQUEST_URI"], 'contact_us') && !strstr($_SERVER["REQUEST_URI"], 'blog') && !strstr($_SERVER["REQUEST_URI"], 'about_us') && !strstr($_SERVER["REQUEST_URI"], '/faq')) || strstr($_SERVER["REQUEST_URI"], '/members_area') ? 'selected-nav' : ''?>">
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
		<div style="display:none" class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'services') ? 'selected-nav' : ''?>">
			<span class="text-nav">Services</span>
		</div>
		<div class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'contact_us') ? 'selected-nav' : ''?>">
			<span class="text-nav"><a href="<?=base_url()?>site/contact_us">Contact Us</a></span>
		</div>
		<div class="button-nav <?=strstr($_SERVER["REQUEST_URI"], 'blog') ? 'selected-nav' : ''?>" style="left:291px;position:relative; margin-right: 7px;">
			<span class="text-nav"><a  href="<?=base_url()?>site/blog">Blog</a></span>
		</div>
	</div>
	<div class="banner">
	<div class="nav-subnav-clear"></div>
		<div class="subnav-wrapper">
			<div class="button-subnav selected-subnav" ref="stamp-subnav">
				<span class="text-subnav" id="stamp_tab">Stamps</span>
			</div>
			<div class="button-subnav notselected-subnav" ref="mylittleponies-subnav">
				<span class="text-subnav" id="mlp_tab">My Little Pony</span>
			</div>
		</div>
		<script>$(".button-subnav").click(subnav_change);</script>
		<div id="mylittleponies-subnav" class="subbanner notselected-subbanner">
			<div class="subbanner-image" id="mlp_banner"></div>
			<div class="subbanner-text">
				<h2>My Little Pony</h2> 
				<p>is a line of colorful toy ponies produced by the toy manufacturer Hasbro. These ponies can be identified by their colorful bodies and manes, and typically a unique symbol or series of symbols on one or both sides of their back hip. My Little Pony was launched in 1982.</p>
			</div>
		</div>
		<div id="stamp-subnav" class="subbanner selected-subnav">
			<div class="subbanner-image" id="stamp_banner"></div>
			<div class="subbanner-text">
				<h2>Stamps</h2> 
				<p style="margin-top:4px">Domestic U.S. Air Mail was established as a new class of mail service by the United States Post Office Department  on May 15, 1918, with the inauguration of the Washington-Philadelphia-New York route. Special postage stamps were issued for use with this service.Domestic air mail became obsolete in 1975, and international air mail in 1995, when the USPS began transporting First Class mail by air on a routine basis</p>
			</div>
		</div>
	</div>