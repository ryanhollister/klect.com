<div class="pagination_links"><?=$this->pagination->create_links()?></div>
<?php 
	if (is_array($catalog_items))
	{
		$img_size = constant($this->phpsession->get('personVO')->getImg_size());
		foreach($catalog_items as $item)
		{
			$click = "onClick=\"prepare4add(".$item->getItemId().", '".addslashes($item->getItem_label())."')\"";
		?>
		<div class="catalog_item_div catalog_item_div_<?=$img_size?>" title="<?=$item->getName()?>" id="<?=$item->getItemId()?>" >
			<span style="float:right;width:100%;position:relative" >
				<span class="wish_list_num"></span>
				<img style="drop-shadow lifted" src="<?=$item->getPictureURL(true, $img_size,true)?>" alt="<?=$item->getName()?>" style="border:0" width="100%" <?=$click?>/>
				<img class="zoom" title="<?=$item->getItemId()?>" style="position:absolute; bottom:0px; right:0px;cursor:pointer" src="/img/zoom.png"/>
			</span>
			<?=$item->getItem_label()?>
		</div>
		<?php 
		}
?>
<div class="pagination_links"><?=$this->pagination->create_links()?></div>
<?php
	}
?>