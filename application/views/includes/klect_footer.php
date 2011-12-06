	<div style="margin:auto; width:749px; margin-top:10px; font-size:10px;height:15px; color:grey">My Little Pony and all of the names and characters associated therewith are the property of Hasbro. Klect.com claims neither any affiliation with Hasbro nor any ownership of any of the names or characters associated with My Little Pony. </div>
	<div id="footer" class="footer">
		<div class="footer-nav"><a href="http://www.klect.com/" style="color:white">Home</a>  |  <a href="<?=base_url()?>site/about_us" style="color:white">About Us</a>  |  <a href="<?=base_url()?>site/contact_us" style="color:white">Contact Us</a></div>
		<div class="footer-copyright">(c) 2010 KLECT.com</div>
	</div>
</div>
<? if (isProd())
{
	?>
 
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-3065050-14']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<?php } ?>
</body>
</html>