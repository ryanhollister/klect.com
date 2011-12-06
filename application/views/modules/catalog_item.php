	<div class="pagination_links">
		<?=$this->pagination->create_links()?>
	</div>
<?php 
if (is_array($catalog_items))
{
	$img_size = constant($this->phpsession->get('personVO')->getImg_size());
	foreach($catalog_items as $item)
	{
		if (isset($onClick))
		{
			$click = "onClick=\"prepare4add(".$item->getItemId().", '".addslashes($item->getName())."')\"";
		}
		else
		{
			$click = "";
		}
	?>
	<div class="catalog_item_div catalog_item_div_<?=$img_size?>" title="<?=$item->getName()?>" id="<?=$item->getItemId()?>" >
		<img style="position:absolute;display:none;z-index:999" src=""/>
		<span style="float:right;width:100%;position:relative" >
			<img class="drop-shadow lifted" src="<?=$item->getPictureURL(true, $img_size,true)?>" alt="<?=$item->getName()?>" width="100%" <?=$click?>/>
			<img class="zoom" title="<?=$item->getItemId()?>" style="position:absolute; bottom:0px; right:0px;cursor:pointer" src="/img/zoom.png"/>
		</span>
			<?=$item->getItem_label()?>
	</div>
	<?php 
	}
	?>
	<div class="pagination_links">
		<?=$this->pagination->create_links()?>
	</div>
	<?php
}
else
{
	?>
	<br/><br/><br/><br/><br/>&nbsp;&nbsp;No items found with given attributes, please try expanding your filter.<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<?	
}
?>