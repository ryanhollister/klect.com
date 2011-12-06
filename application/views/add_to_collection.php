<?php $this->load->view('includes/members_header'); ?>
	<div id="cpanelwrapper" class="cpanel">
		<div class="cpanel-left">
			<div id="message_div" class="message" style="display:none"></div>
			<div class="cpanel-left-box">
			<div class="cpanel-left-box-header">
				<span class="header-text mycollection">Select a <?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> to Add</span>
				<span class="backtodash">
					<a href="<?=current($back_loc)?>"  style="color:orange">
						<img src="/img/<?=key($back_loc)?>" />
					</a>
				</span>
			</div>
			<div class="cpanel-left-box-content" id="catalog_container">
				<?php $this->load->view('modules/catalog_item'); ?>
			</div>
			<div class="cpanel-left-box-footer"></div>
			</div>
		</div>
		<div class="cpanel-right" id="cpanel-right">
		<div class="cpanel-right-box-header">
				<span class="header-text actions"><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Details</span></div>
				<div class="cpanel-right-box-content edit_item" id="add_div" style="display:none"><br/>
			    	<h4>Adding <span id="owned_item_name"></span></h4>
			    	<p>Enter in your details for your <?=constant($this->phpsession->get('current_domain')->getTag()."_NAME")?></p>
			    	<?=form_open('item_management/update_owned_item', 'id="item_add_form"');?>
					<div class="edit_input"><?=form_hidden('owned_item_id', '', FALSE, 'id="owned_item_id" AUTOCOMPLETE=OFF')?></div>
					<?php 
						$per_data = array(  'name' => 'description',
											'value' => '',
											'AUTOCOMPLETE' => 'OFF', 
											'id' => 'owned_description', 
											'rows' => '3',
											'cols' => '25');?>
			        <div class="edit_input">Personal Description:<?=form_textarea($per_data)?></div>
					<div class="edit_input">Date Aquired:<?=form_input('datepicker', '', 'class="ui-autocomplete-input" id="datepicker" AUTOCOMPLETE=OFF')?></div>
					<div class="edit_input">Condition:<br/><?=form_dropdown('condition', $value_options, 0)?><?=constant($this->phpsession->get('current_domain')->getTag().'_CONDITION')?></div>
					<div class="edit_input">Purchase Price:<?=form_input('price', '', 'AUTOCOMPLETE=OFF id="owned_price"')?></div>
					<div class="edit_input">Hide from Marketplace Views: <?=form_checkbox('mp_visible', '1', FALSE, 'style="display:inline"');?></div>
					<div class="edit_btn"><img src="/img/add-to-collection.gif" onClick="submit_item_add()"/></div>
					<?=form_close()?>
				</div>
				
				<div id="clickleft" class="cpanel-right-box-content edit_item">
					<div style="text-align: center; margin: 36px 5px;">Click a <?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> to the left to add a <?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> to your collection.</div>
				</div>
				<div class="cpanel-right-box-content edit_item" id="add_proc" style="display:none; text-align: center;"><br/><br/><br/><br/><img src="/img/ajax-loader.gif" height="15px" width="128px" /><br/><br/>Processing...<br/><br/><br/></div>
				<div class="cpanel-right-box-footer"></div>
			
			<div class="cpanel-right-box-header">
				<span class="header-text actions">Filter</span><?=$this->load->view('includes/min_max.php');?></div>
				<div class="cpanel-right-box-content filter_catalog" id="filter_div"><br/>
		    	<?=form_open('', 'onsubmit="return false;" id="filterform" name="filterform"');?>
				<?=form_hidden('source', 'addtocollection')?>
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
<div id="dialog-modal" title="<?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Details" style="font-size:14px;">
	<div class="catalog_image"><img class="drop-shadow lifted" src="" id="catalog_image" /></div>
	<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Name: <div id="catalog_name" class="catalog_div" style="text-transform:capitalize"></div>
	<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Description: <div id="catalog_description" class="catalog_div"></div>
	<br/>Manufacturer: <div id="catalog_manufacturer" class="catalog_div" style="text-transform:capitalize"></div>
	<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Attributes: <br/><div id="catalog_attributes" class="catalog_div"></div>
	<div id="catalog_item_attributes" class="" style=""></div>
</div>
<?php $this->load->view('includes/members_footer'); ?>
