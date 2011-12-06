<div id="dialog-modal" title="<?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Details" style="font-size:12px;">
	<div id="sale-message" style="display:none"></div>
	<div class="catalog_image" id="catalog_image_div">
		<img class="drop-shadow lifted" src="" id="stock_catalog_image" style="display:none" width="200" />
		<img class="drop-shadow lifted" src="" id="cat_custom" width="200" />
		<img class="drop-shadow lifted" src="" id="cust_catalog_image" style="display:none" width="200" />
		<div style="display:none" id="progress_image"><br/><br/><br/><br/><img width="200"src="/img/ajax-loader.gif"><br/><br/>Uploading...<br/><br/><br/><br/><br/></div></div>
		<div style="margin:10px;text-align:center" id="image_toggle">
			| <span onclick="goStock()" id="go_stock" style="text-align:center; cursor:pointer; color: blue; text-decoration: underline;text-align:center">KLECT Stock</span> | 
			<? if ($this->phpsession->get('personVO')->getPremium() == 1) { ?>
			<span onclick="goCatCustom()" id="go_cat_custom" style="display:none; text-align:center; cursor:pointer; color: blue; text-decoration: underline;text-align:center">My Catalog</span> <span id="extra_pipe">|</span>
			<? } ?>
		</div>
	<div id="accordion">
	    <h3><a href="#">Catalog Details</a></h3>
	    <div>
		    <br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Name: <div id="catalog_name" class="catalog_div" style="text-transform:capitalize"></div>
			<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Description: <div id="catalog_description" class="catalog_div"></div>
			<br/>Manufacturer: <div id="catalog_manufacturer" class="catalog_div" style="text-transform:capitalize"></div>
			<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Attributes: <br/><div id="catalog_attributes" class="catalog_div"></div>
			<div id="catalog_item_attributes" class="" style=""></div>
	    </div>
	    <h3><a href="#">Personal Details</a></h3>
	    <div>
	    	<br/>Purchase Price: <div id="owned_purchaseprice" class="catalog_div"></div>
			<br/>Date Acquired: <div id="owned_dateacquired" class="catalog_div"></div>
			<br/>Condition: <div id="owned_condition" class="catalog_div"></div>
			<br/>KLECT's Estimated Value: <div id="owned_value" class="catalog_div"></div>
		</div>
		<h3><a href="#">Listing Details</a></h3>
	    <div>
	    	<form id="sale-form" action="" onsubmit="return false;">
				<fieldset>
					<input type='hidden' name='x1' value='' id='x1' />
					<input type='hidden' name='y1' value='' id='y1' />
					<input type='hidden' name='w' value='' id='w' />
					<input type='hidden' name='h' value='' id='h' />
					<input type="hidden" name="sale_item_name" id="sale_item_name"/>
					<input type="hidden" name="oi_id" id="oi_id"/>
					<input type="hidden" name="saleId" id="saleId"/>
					<input type="hidden" name="filename" id="filename" value="stock"/>
					<label for="price" class="jui-label" >Price (ex. 4.00)</label>
					<input type="text" name="price" id="price" AUTOCOMPLETE=OFF class="text ui-widget-content ui-corner-all" maxlength="7" onkeypress="return restrictCharacters(this, event, integerOnly);"/>
					<label for="desc" class="jui-label">Listing Description</label>
					<textarea style="display: block; width: 290px; height: 60px;" name="desc" id="desc" AUTOCOMPLETE=OFF class="text ui-widget-content ui-corner-all" ></textarea>
					Accepted Methods<br/><input type="checkbox" id="paypal" name="paypal" value="1" style="display:inline">Paypal&nbsp;<input type="checkbox" id="moneyorder" name="moneyorder" value="1" style="display:inline">Money Order
					<br/>Image<br/>
					<div id="file-uploader" style="height:30px;overflow:hidden">       
				    <noscript>          
				        <p>Please enable JavaScript to use file uploader.</p>
				        <!-- or put a simple form for upload here -->
				    </noscript>         
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
</div>