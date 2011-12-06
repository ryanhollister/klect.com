<div id="dialog-modal" title="<?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Details" style="font-size:12px;">
	<div id="buy_main" style="height: 315px;">
		<div class="catalog_image" id="catalog_image_div"><img class="drop-shadow lifted" src="" id="catalog_image" width="200" /></div><br/>
		<div id="accordion">
		    <h3><a href="#">Catalog Details</a></h3>
		    <div>
			    <br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Name: <div id="catalog_name" class="catalog_div" style="text-transform:capitalize"></div>
				<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Description: <div id="catalog_description" class="catalog_div"></div>
				<br/>Manufacturer: <div id="catalog_manufacturer" class="catalog_div" style="text-transform:capitalize"></div>
				<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Attributes: <br/><div id="catalog_attributes" class="catalog_div"></div>
				<div id="catalog_item_attributes" class="" style=""></div>
		    </div>
			<h3><a href="#">Listing Details</a></h3>
		    <div>
		    	<br/>Seller Rating: <span id="member_rating_span"></span>
		    	<br/>KLECT Sale Id: <div id="klect_sale_id" class="catalog_div"></div>
		    	<br/>KLECT's Estimated Value: <div id="owned_value" class="catalog_div"></div>
		    	<br/>Seller's Username: <div id="seller" class="catalog_div"></div>
		    	<br/>Price: <div id="price" class="catalog_div"></div>
		    	<br/>List Date: <div id="listdate" class="catalog_div"></div>
		    	<br/>Accepted Methods: <div id="methods" class="catalog_div"></div>
		    	<br/>Listing Description: <br/><br/><div id="list_desc" class="catalog_div"></div>
		    	
			</div>
		</div>
	</div>
	<div id="buy_confirm" style="display:none">
		<div id="sale-message" style="display:none"></div>
		<div id="confirm_text">Are you sure you want to purchase this item?  By confirming below, you are agreeing to the intent to purchase the sellers item and to the terms and conditions agreed upon previously on this site. Your shipping and contact information will be shared with the seller. If not, please click on cancel to return to the Marketplace.<br><br>
		Thank you for using KLECT!</div>
		<div style="height: 27px; margin-top: 45px;">
			<a href="#" id="cancel_button" class="ui-state-default ui-corner-all" style="padding: 0.5em 1em; text-decoration: none; float: left; margin: auto 0px auto 0px">Cancel Purchase</a>
			<a href="#" id="confirm_button" class="ui-state-default ui-corner-all" style="padding: .5em 1em; text-decoration: none; float:right">Confirm Purchase</a>
		</div>
	</div>
</div>