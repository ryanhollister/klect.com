<?php
$first = true;
foreach ($entries as $date => $entry)
{
?>
<h1><?=$entry['title']?></h1>
<h3 style="font-weight:normal">on <?=date('M j, Y', strtotime($date))?> by <?=$entry['author']?></h3>
<div style="text-align:justify; margin:10px; overflow:hidden; <?php if (!$first) { ?> height:300px;<?php } ?>">
<?=$entry['content']?>
</div>
<?php
if (!$first) { ?> <div class="expand_post" title="<?=$entry['height']?>">Expand Post...</div> <?php }
$first = false;
}
?>
<script type="text/javascript">
function expand_post()
{
	$(this).prev().animate({
	    height:$(this).attr('title')
	  }, 1500, function() { $(this).next().fadeOut(); } );
}

$('.expand_post').click(expand_post)
</script>
