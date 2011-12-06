<div class="cpanel-left-box-content" id="catalog_container">
<?php 
if (isset($sale_items) && is_array($sale_items) && count($sale_items) > 0)
{
	$img_size = constant($this->phpsession->get('personVO')->getImg_size());
	foreach($sale_items as $item)
	{
	?>
	<div class="catalog_item_div catalog_item_div_<?=$img_size?>" title="<?=$item->getName()?>" id="<?=$item->getItemId()?>" style="cursor:pointer" >
		<span style="float:right;width:100%;position:relative" >
			<span class="wish_list_num" style="position: absolute; z-index: 999; color: white; font-size:30px"><?=$counts[$item->getItemId()]?></span>
			<img class="drop-shadow lifted" src="<?=$item->getPictureURL(true, $img_size, true)?>" alt="<?=$item->getName()?>" style="border:0" width="100%" onClick=""/>
		</span>
			<?=$item->getItem_label()?>
	</div>
	<?php 
	}
}
else
{
	?>
	<br/><br/><br/><br/><br/>&nbsp;&nbsp;Sorry, no items were found in the marketplace. Try a different filter.<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<?	
}
?>
</div>