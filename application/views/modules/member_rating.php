<ul style="margin: 10px 0; text-align: center;display:inline">
	<?php 
	$i=1;
	while ($i < 6) {
	if ($member_rating > $i) $img = "/img/star_gold.png";
	elseif (substr($member_rating, -2) == ".5") { $img = "/img/star_half_grey.png"; $member_rating -= 0.5; }
	else $img = "/img/star_grey.png";
	
	$i++;
	
	?>
	<li style="display:inline"><img src="<?=$img?>" title="2" /></li>
	<?php } ?>
</ul>