<div id="pending_purchase_modal" title="Pending Purchase Details" style="font-size:12px;">
	<div class="catalog_image" id="pending_purchase_image_div"><img class="drop-shadow lifted" src="" id="pending_purchase_image" width="200" /></div><br/>
	<div id="purchase_accordion">
	    <h3><a href="#">Catalog Details</a></h3>
	    <div>
		    <br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Name: <div id="pending_purchase_name" class="catalog_div" style="text-transform:capitalize"></div>
			<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Description: <div id="pending_purchase_description" class="catalog_div"></div>
			<br/>Manufacturer: <div id="pending_purchase_manufacturer" class="catalog_div" style="text-transform:capitalize"></div>
			<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Attributes: <br/><div id="pending_purchase_attributes" class="catalog_div"></div>
			<div id="pending_purchase_item_attributes" class="" style=""></div>
	    </div>
		<h3><a href="#">Listing Details</a></h3>
	    <div>
	    	<br/>KLECT Sale Id: <div id="pending_purchase_id" class="catalog_div"></div>
	    	<br/>KLECT's Estimated Value: <div id="pending_purchase_owned_value" class="catalog_div"></div>
	    	<br/>Seller's Username: <div id="pending_purchase_seller_username" class="catalog_div"></div>
	    	<br/>Seller's Email: <div id="pending_purchase_seller_email" class="catalog_div"></div>
	    	<br/>Buyer's Username: <div id="pending_purchase_buyer_username" class="catalog_div"></div>
	    	<br/>Buyer's Email: <div id="pending_purchase_buyer_email" class="catalog_div"></div>
	    	<br/>Price: <div id="pending_purchase_price" class="catalog_div"></div>
	    	<br/>List Date: <div id="pending_purchase_listdate" class="catalog_div"></div>
	    	<br/>Accepted Methods: <div id="pending_purchase_methods" class="catalog_div"></div>
	    	<br/>Listing Description: <br/><br/><div id="pending_purchase_list_desc" class="catalog_div"></div>
		</div>
		<div style="font-size:14px; color:red"><strong>Status:</strong> <div id="pending_purchase_status" class="catalog_div">This item has been marked as shipped by the seller. Once you recieve the item, click 'Recieved' and the item will be transfered to your collection.</div></div>
</div>
</div>