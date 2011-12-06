<div style="width: 94%; border-top: thin dashed gray;border-bottom: thin dashed gray;">
<br/>Recent Purchases<br/>
<ol class="ol-list" id="sale-list">
	<?php 
	if (is_array($pending_purchases) && count($pending_purchases) > 0) { 
	
		foreach($pending_purchases as $saleId => $name)
		{ 
	?>
		<li class="pending-purchase-li"><a class="pending_purchase_item" href="#" title="Sale #<?=$saleId?>"><?=$name?></a></li>
	<?php 
		}
	} 
	else
	{ 
	?>
	You have no pending purchases
	<?php 
	}
	?>
</ol>
</div>