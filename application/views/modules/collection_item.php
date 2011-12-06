<?php 
if (is_array($collection_items) && count($collection_items) > 0) { 
	$img_size = constant($this->phpsession->get('personVO')->getImg_size());

	foreach($collection_items as $item)
	{
?>
<div class="collection_item_div collection_item_div_<?=$img_size?>" id="<?=$item->getOwned_item_id()?>">
	<span style="width: <?=$img_size?>px" >
		<a href="#"><img class="drop-shadow lifted" src="<?=$item->getPictureURL(true, $img_size)?>" alt="<?=$item->getName()?>" style="border:0" width="100%" />
		<?=$item->getItem_label()?></a>
	</span>
</div>
<?php 
	}
} 
else
{ 
?>
<br/><br/><br/><br/>
<div style="text-align:center">Use the menu to the right to start adding to your collection!</div>
<br/><br/><br/><br/>&nbsp;
<?php 
}
?>