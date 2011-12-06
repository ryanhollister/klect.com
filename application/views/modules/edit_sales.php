<div class="cpanel-right-box-content">
	<ol class="ol-list orange_links" id="sale-list">
	<?php 
	if (is_array($active_sales) && count($active_sales) > 0) { 
	
		foreach($active_sales as $oiId => $item)
		{ 
	?>
		<li class="pending-item"><a class="edit_sale" href="#" title="<?=$oi_to_sale[$oiId]?>"><?=$item->getName()?></a> (<a href="#" class="delete_sale" title="<?=$oi_to_sale[$oiId]?>">delete</a>)</li>
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