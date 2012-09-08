<?php $this->load->view('includes/members_header'); ?>
	<div id="cpanelwrapper" class="cpanel">
		<div class="cpanel-left">
			<div class="cpanel-left-box">
				<div class="cpanel-left-box-header">
					<span class="header-text mycollection">My Collection</span></div>
				<div class="cpanel-left-box-content" id="catalog_container">
				<?php $this->load->view('modules/dashboard_item'); ?>
				</div>
				<div class="cpanel-left-box-footer"></div>
			</div>
		</div>
		<div class="cpanel-right">
			<div class="cpanel-right-box-header"><span class="header-text actions">Actions</span><?=$this->load->view('includes/min_max.php');?></div>
			<div class="cpanel-right-box-content"><br/>			
			<span class="edit-span">
			<a href="<?=base_url()?>marketplace/dashboard/"><img src="/img/marketplace.gif" alt="marketplace" /></a>
			</span><br/><br/>
				<a href="<?=base_url()?>members_area/browse_catalog/"><img src="/img/browsecatalog.gif" alt="browsecatalog" /></a>
			<br/><br/>
			<span class="actions-span">
				<a href="<?=base_url()?>members_area/add_to_collection"><img src="/img/add-to-collection.gif" alt="addtocollection" /></a>
			</span><br/><br/>
			<?if(count($collection_items) > 0) { ?>
			<span class="edit-span">
				<a href="<?=base_url()?>members_area/edit_collection"><img src="/img/edit-collection.gif" alt="editcollection" /></a>
			</span><br/><br/>
			<? } ?>
			<span class="edit-span">
				<a href="#"><img src="/img/edit_profile.gif" alt="editprofile"  id="editprofile"/></a>
			</span><br/><br/>
			<span class="edit-span">
				<a href="<?=base_url()?>members_area/wish_list"><img src="/img/wishlist.gif" alt="wishlist" /></a>
			</span><br/><br/>
			<? if ($this->phpsession->get('personVO')->getAdmin() == 1) { ?>
			<span class="edit-span">
				<a href="<?=base_url()?>admin_area/dashboard"><img src="/img/admin_dashboard.gif" alt="admin" /></a>
			</span><br/><br/>
			<? }?>
			KLECT's Est. Value: $<?=$collection_value?><br/><br/>
			Number of <?=constant($this->phpsession->get('current_domain')->getTag().'_ITEMS')?>: <?=$this->pagination->total_rows?>
			</div>
			<div class="cpanel-right-box-footer"></div>
			<div class="cpanel-right-box-header">
				<span class="header-text actions">Filter</span><?=$this->load->view('includes/max_min.php');?></div>
				<div class="cpanel-right-box-content filter_catalog" id="filter_div"><br/>
		    	<?=form_open('', 'onsubmit="return false;" id="filterform" name="filterform"');?>
				<?=form_hidden('source', 'dashboard')?>
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
			<div class="cpanel-right-box-header"><span class="header-text actions">Favorite Links</span><?=$this->load->view('includes/min_max.php');?></div>
			<div class="cpanel-right-box-content" style="height:240px">
				<?=constant($this->phpsession->get('current_domain')->getTag().'_SPONSOR')?>
			</div>
			<div class="cpanel-right-box-footer"></div>
		</div>
	</div>
<?php $this->load->view('includes/members_footer'); ?>