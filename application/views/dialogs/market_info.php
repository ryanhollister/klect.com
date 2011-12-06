<div id="dialog-modal" title="Market Details" style="font-size:12px;">
	<div id="sale-message" style="display:none"></div>
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
		<h3><a href="#">Market Details</a></h3>
	    <div>
	    	<input type="text" id="market_item_id" style="display:none"/>
	    	<br/>Number for Sale: <div id="market_count" class="catalog_div"></div>
			<br/>Min Price: <div id="market_minprice" class="catalog_div"></div>
			<br/>Max Price: <div id="market_maxprice" class="catalog_div"></div>
			<br/>Average: <div id="market_avgprice" class="catalog_div"></div>
		</div>
	</div>
</div>