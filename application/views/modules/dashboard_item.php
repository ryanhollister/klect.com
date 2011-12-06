<?php 
if (is_array($collection_items) && count($collection_items) > 0) { 
	$img_size = constant($this->phpsession->get('personVO')->getImg_size());
	?>
<div class="pagination_links"><?=$this->pagination->create_links()?></div>
	<?php
	foreach($collection_items as $item)
	{
		$saleImg = '';
		$oi_id = $item->getOwned_item_id();
		if (isset($active_sales[$oi_id]))
		{
			$saleImg = '<img style="z-index: 999; position: absolute; left: 5px; top: 5px; border: thin solid white;" src="/img/forsale.jpg">';
		}
		elseif (isset($pending_sales[$oi_id]))
		{
			$saleImg = '<img style="z-index: 999; position: absolute; left: 5px; top: 5px; border: thin solid white;" src="/img/sold.gif">';
		}
?>
<div class="collection_item_div collection_item_div_<?=$img_size?>" id="<?=$oi_id?>">
	<div style="width: <?=$img_size?>px; position:relative" >
		<?=$saleImg?>
		<div style="position: absolute; color: white; font-size: 21px; right: 5px; top: 5px;"><?=constant($this->phpsession->get('current_domain')->getTag().'_CONDITION_'.$item->getCondition())?></div>
		<a href="#" style="color: black; font-family: helvetica;">
			<img class="drop-shadow lifted" src="<?=$item->getPictureURL(true, $img_size)?>" alt="<?=$item->getName()?>"  width="100%" />
			<?=$item->getItem_label()?>
		</a>
	</div>
</div>
<?php 
	}
	?>
	<div class="pagination_links"><?=$this->pagination->create_links()?></div>
	<?php
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