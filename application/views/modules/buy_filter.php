<div class="cpanel-right-box-content filter_catalog" id="filter_div">
		<?=form_open('', 'onsubmit="return false;" id="filterform" name="filterform"');?>
		<?=form_hidden('source', 'addtocollection')?>
	    <?php echo validation_errors(); $filter_values = $this->phpsession->get('filter_values'); ?>	
	    <div class="edit_input"><label for="name_core">Item Name :</label> <?=form_input('name_core', '', 'id="name_core" style="padding:0" class="ac_input ui-autocomplete-input" autocomplete="off"');?></p></div>
	    <?php foreach($collection_attributes as $attributeId => $attributeText): ?>
	    <div class="edit_input"><p><label for="<?=$attributeId?>"> <?=$attributeText?> :</label> <?=form_input($attributeId.'_input', '' , 'id='.$attributeId.'_input')?></p></div>
	    <?php endforeach; ?>
	    <div style="text-align:center">
	    <img src="/img/filter_catalog.gif" alt="filter_catalog" onClick="filter_submit()" />
	    <img id="clear" src="/img/clear_filters.gif" alt="clear_filters" onclick="clearfilters()" />
		<img src="/img/filter_in_wishlist.gif" alt="filter_in_wishlist" onClick="filter_submit('wishlist')" />
		<img src="/img/filter_i_dont_have.gif" alt="filter_i_dont_have" onClick="filter_submit('unowned')" />
		<?=form_close()?>
		</br></div>
	</div>