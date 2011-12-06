<?php 
if (count($collection) > 0)
{
?>
<div class="pagination_links"><?=$this->pagination->create_links()?></div>
<?php foreach($collection as $item) { ?>
<?php $img_size = constant($this->phpsession->get('personVO')->getImg_size());?>
<div class="collection_item_div collection_item_div_<?=$img_size?>" id="<?=$item->getOwned_item_id()?>" >
<span style="float:right; width:100%;position:relative" >
	<img class="drop-shadow lifted" src="<?=$item->getPictureURL(true, $img_size)?>" alt="<?=$item->getName()?>" style="border:0" width="100%" onClick="prepare4edit(<?=$item->getOwned_item_id()?>)" />
		<img class="zoom" title="<?=$item->getOwned_item_id()?>" style="position:absolute; bottom:0px; right:0px;cursor:pointer" src="/img/zoom.png"/>
	</span>
	<?=$item->getItem_label()?>
</div>
<?php }
?>
<div class="pagination_links"><?=$this->pagination->create_links()?></div>
<?php 
}
else
{
	?>
	<br/><br/><br/><br/><br/>&nbsp;&nbsp;No items found with given attributes, please try expanding your filter.<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	<?	
}
?>
