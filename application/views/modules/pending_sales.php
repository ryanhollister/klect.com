<div>
<br/>Pending Sales<br/>
<ol class="ol-list" id="sale-list">
	<?php 
	if (is_array($pending_sales) && count($pending_sales) > 0) { 
	
		foreach($pending_sales as $oiId => $item)
		{ 
			
	?>
		<li class="pending-sale-li"><a class="pending-sale-item" href="#" title="Sale #<?=$oi_to_sale[$oiId]?>"><?=$item->getItem_label()?></a></li>
	<?php 
			 }
	} 
	else
	{ 
	?>
	You have no pending sales
	<?php 
	}
	?>
</ol>
</div>