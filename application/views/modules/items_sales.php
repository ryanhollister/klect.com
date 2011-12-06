<div class="cpanel-left-box-content" id="catalog_container">
<?php 
if (isset($sale_items) && is_array($sale_items) && count($sale_items) > 0)
{
	$img_size = constant($this->phpsession->get('personVO')->getImg_size());
	foreach($sale_items as $key => $item)
	{
		if (isset($cust_imgs[$key]))
		{
			$img = $cust_imgs[$key];
		}
		else
		{
			$img = $item->getPictureURL(true, $img_size);
		}
	?>
	<div class="catalog_item_div catalog_item_div_<?=$img_size?>" title="<?=$item->getName()?>" id="<?=$key?>" >
		<span style="float:right;width:100%;position:relative" >
			<img class="drop-shadow lifted" src="<?=$img?>" alt="<?=$item->getName()?>" style="border:0" width="100%"/>
			<img class="zoom" title="<?=$item->getItemId()?>" style="position:absolute; bottom:0px; right:0px;cursor:pointer" src="/img/zoom.png"/>
		</span>
			<?=$item->getItem_label()?>
	</div>
	<?php 
	}
}
else
{
	?>
	<br/><br/><br/><br/><br/>&nbsp;&nbsp;Sorry, no sales were found for this item. Press your back button and try a different item.<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<?	
}
?>
</div>