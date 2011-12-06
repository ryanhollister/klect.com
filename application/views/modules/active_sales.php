<div style="width: 94%; border-top: thin dashed gray;">
<br/>Active Sales<br/>
<ol class="ol-list" id="sale-list">
	<?php 
	if (is_array($active_sales) && count($active_sales) > 0) { 
	
		foreach($active_sales as $oiId => $item)
		{ 
	?>
		<li class="active-sale-li"><a class="edit_sale active-sale-item" href="#" title="Sale #<?=$oi_to_sale[$oiId]?>"><?=$item->getItem_label()?></a></li>
	<?php 
		}
	} 
	else
	{ 
	?>
	You have no active sales
	<?php 
	}
	?>
</ol>
</div>