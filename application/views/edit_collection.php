<?php $this->load->view('includes/members_header'); ?>
	<div id="cpanelwrapper" class="cpanel">
		<div class="cpanel-left">
			<div id="message_div" class="message" style="display:none"></div>
			<div class="cpanel-left-box">
				<div class="cpanel-left-box-header">
				<span class="header-text mycollection">Edit Collection</span><span class="backtodash"><a href="<?=current($back_loc)?>"  style="color:orange"><img src="/img/<?=key($back_loc)?>" /></a></span></div>
				<div class="cpanel-left-box-content" id="catalog_container">
				<?php $this->load->view('modules/my_collection_item'); ?>
				</div>
			<div class="cpanel-left-box-footer"></div>
			</div>
		</div>
		<div class="cpanel-right" id="cpanel-right">
		<div class="cpanel-right-box-header">
				<span class="header-text actions">Edit Details</span></div>
				<div class="cpanel-right-box-content edit_item" id="edit_div" style="display:none"><br/>
			    	<h4>Editing <span id="owned_item_name"></span></h4>
			    	<p>Enter in your details for your <?=constant($this->phpsession->get('current_domain')->getTag()."_NAME")?></p>
			    	<?=form_open('item_management/update_owned_item', 'id="item_update_form"');?>
					<div class="edit_hidden"><?=form_hidden('owned_item_id', '', FALSE, 'id="owned_item_id" AUTOCOMPLETE=OFF')?></div>
			        <div class="edit_input">Personal Description:<br/><?=form_input('description', '', 'AUTOCOMPLETE=OFF id="owned_description"')?></div>
					<div class="edit_input">Date Aquired:<br/><?=form_input('datepicker', '', 'class="ui-autocomplete-input" id="datepicker" AUTOCOMPLETE=OFF')?></div>
					<div class="edit_input">Condition:<br/><?=form_dropdown('owned_condition', $value_options, 3, 'id="owned_condition"')?><?=constant($this->phpsession->get('current_domain')->getTag().'_CONDITION')?></div>
					<div class="edit_input">Purchase Price:<br/><?=form_input('price', '', 'AUTOCOMPLETE=OFF id="owned_price"')?></div>
					<div class="edit_input">Hide from Marketplace Views: <?=form_checkbox('mp_visible', '1', FALSE, 'style="display:inline" id="owned_mp_visible"');?></div>
					<div class="edit_btn"><img src="/img/save_changes.gif" alt="Save Changes" onClick="submit_item_update()"/></div>
					<div class="edit_btn"><img src="/img/delete_pony.gif" alt="Save Changes" onClick="remove_owned_item()"/></div>
					<?=form_close()?>
				</div>
				
				<div class="cpanel-right-box-content edit_item" id="clickleft"><br/><br/><br/><br/>&nbsp;&nbsp;&nbsp;Click a <?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> to the left to edit its details.<br/><br/><br/><br/><br/></div>
				<div class="cpanel-right-box-footer"></div>
		<div class="cpanel-right-box-header">
		<span class="header-text actions">Filter</span><?=$this->load->view('includes/min_max.php');?></div>
				<div class="cpanel-right-box-content filter_catalog" id="filter_div"><br/>
				<?=form_open('', 'onsubmit="return false;" id="filterform" name="filterform"');?>
				<?=form_hidden('source', 'editcollection')?>
			    <?php echo validation_errors(); $filter_values = $this->phpsession->get('filter_values'); ?>	
			    <div class="edit_input"><label for="name_core">Item Name :</label> <?=form_input('name_core', '', 'id="name_core" style="padding:0" class="ac_input ui-autocomplete-input" autocomplete="off"');?></p></div>
			    <?php foreach($collection_attributes as $attributeId => $attributeText): ?>
			    <div class="edit_input"><p><label for="<?=$attributeId?>"> <?=$attributeText?> :</label> <?=form_input($attributeId.'_input', '' , 'id='.$attributeId.'_input')?></p></div>
			    <?php endforeach; ?>
			    <div style="text-align:center"><img src="/img/filter_catalog.gif" alt="filter_catalog" onClick="filter_submit()" />
			    <img id="clear" src="/img/clear_filters.gif" alt="clear_filters" onclick="clearfilters()" /></br></div>
			    <?=form_close()?>
				</div>
				<div class="cpanel-right-box-footer"></div>
			
		</div>
	</div>
<?php $this->load->view('includes/members_footer'); ?>