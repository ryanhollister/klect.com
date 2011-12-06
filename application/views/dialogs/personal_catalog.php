<div id="dialog-modal" title="<?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Details" style="font-size:14px;">
<div class="catalog_image" id="catalog_image_div">
		<img class="drop-shadow lifted" src="" id="stock_catalog_image" width="200" />
		<? if ($this->phpsession->get('personVO')->getPremium() == 1) { ?>
		<img class="drop-shadow lifted" src="" id="cust_catalog_image" style="display:none" width="200" />
		<div style="display:none" id="progress_image"><br/><br/><br/><br/><img width="200"src="/img/ajax-loader.gif"><br/><br/>Uploading...<br/><br/><br/><br/><br/></div>
		<? } ?>
</div>
	<? if ($this->phpsession->get('personVO')->getPremium() == 1) { ?><div onclick="cancelCustom()" id="cancel_custom" style="text-align:center; cursor:pointer; color: blue; text-decoration: underline;text-align:center">Clear</div><? } ?>
	<form id="custom-form" action="" onsubmit="return false;">
				<fieldset>
					<input type='hidden' name='x1' value='' id='x1' />
					<input type='hidden' name='y1' value='' id='y1' />
					<input type='hidden' name='w' value='' id='w' />
					<input type='hidden' name='h' value='' id='h' />
					<input type="hidden" name="oi_id" id="oi_id"/>
					<input type="hidden" name="filename" id="filename" value="stock"/>
				</fieldset>
	</form>
	<? if ($this->phpsession->get('personVO')->getPremium() == 1) { ?>
	<div id="file-uploader" style="display:none;height:30px;overflow:hidden;margin:auto">       
				    <noscript>          
				        <p>Please enable JavaScript to use file uploader.</p>
				        <!-- or put a simple form for upload here -->
				    </noscript>         
	</div>
	<?php } ?>
	<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Name: <div id="catalog_name" class="catalog_div" style="text-transform:capitalize"></div>
	<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Description: <div id="catalog_description" class="catalog_div"></div>
	<br/>Manufacturer: <div id="catalog_manufacturer" class="catalog_div" style="text-transform:capitalize"></div>
	<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Attributes: <br/><div id="catalog_attributes" class="catalog_div"></div>
	<div id="catalog_item_attributes" class="" style=""></div>

	<br/>
	<br/>Personal Description: <div id="owned_description" class="catalog_div"></div>
	<br/>Purchase Price: <div id="owned_purchaseprice" class="catalog_div"></div>
	<br/>Date Acquired: <div id="owned_dateacquired" class="catalog_div"></div>
	<br/>Condition: <div id="owned_condition_catalog" class="catalog_div"></div>
	<br/>KLECT's Est. Value: <div id="owned_value" class="catalog_div"></div>
</div>
<script>
$("#dialog-modal").dialog({
	height: 600,
	width:375,
	modal: true,
	autoOpen: false,
	resizable: false
});

function showLearnMore()
{
	newwindow=window.open('/site/faq#picture_format','name','height=250,width=900');
	if (window.focus) {newwindow.focus()}
	return false;
}

$('.<?=$catalog_info_button?>')
.live('click', function() {
		$.post(getBaseURL()+"/item_management/get_owned_catalog_details", { owned_item_id : $(this).closest('.collection_item_div').attr('id') },
				function (data)
				{
					if(data)
					{
						$("#stock_catalog_image").unbind('click');
						var jObj = $.parseJSON(data);
						if (jObj.custImg != undefined && jObj.custImg == 'stock'  && jObj.filename != undefined)
						{
							$("#stock_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename).show();
							$("#cust_catalog_image").hide();
							$("#filename").val('stock');
							$("#cust_catalog_image").hide();
							$("#file-uploader").show();
							$("#cancel_custom").hide();
							
						}
						else if (jObj.custImg != 'stock')
						{
							$("#cust_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/customs/" + jObj.custImg).show();
							$("#stock_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename).hide();
							$("#filename").val(jObj.custImg);
							$("#file-uploader").hide();
							$("#cancel_custom").css('display', 'block');
						}
						else
						{
							$("#stock_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg").click(showLearnMore);
							$("#filename").val('stock');
							$("#cust_catalog_image").hide();
							$("#file-uploader").show();
							$("#cancel_custom").hide();
						}
						$('#dialog-modal').dialog('open');
						$("#catalog_name").html(jObj.name);
						$("#catalog_description").html(jObj.catalog_description);
						$("#catalog_manufacturer").html(jObj.manufacturer);
						$("#catalog_attributes").html(jObj.general_attributes);
						$("#catalog_item_attributes").html(jObj.item_attributes);
						$("#owned_purchaseprice").html(jObj.purchase_price);
						$("#owned_dateacquired").html(jObj.date_acquired);
						$("#owned_condition_catalog").html(jObj.label);
						$("#oi_id").val(jObj.owned_item_id);
						if (jObj.value == "Unknown Value")
						{
							$("#owned_value").html(jObj.value);
						}
						else
						{
							$("#owned_value").html("$"+jObj.value);
						}
						$("#owned_description").html(jObj.description);
					}
				});
		return false;
	});

function handleSuccess(id, fileName, responseJSON)
{
	if (responseJSON.success)
	{
		$("#cust_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/customs/"+responseJSON.filename).show();
		$("#"+$("#oi_id").val() +" > div > a > img").attr("src","/img/" + DOMAIN_TAG + "/customs/"+responseJSON.filename );
		$("#"+$("#oi_id").val() +" > span > img:first").attr("src","/img/" + DOMAIN_TAG + "/customs/"+responseJSON.filename );
		$("#filename").val(responseJSON.filename);
		$("#stock_catalog_image").hide();
		$("#progress_image").hide();
		$("#cancel_custom").css('display', 'block');
		$("#file-uploader").hide();
	}
}

function showProgress()
{
	$("#stock_catalog_image").hide();
	$("#cust_catalog_image").hide();
	$("#progress_image").show();
}

function cancelCustom()
{
	$.post('/item_management/clearcustomimage/', {'owned_item_id' : $('#oi_id').val() }, function(data){
			if(data.success)
			{

				$("#"+$("#oi_id").val() +" > div > a > img").attr("src",$("#stock_catalog_image").attr("src"));
				$("#"+$("#oi_id").val() +" > span > img:first").attr("src", $("#stock_catalog_image").attr("src"));
				$("#cancel_custom").hide();
				$("#stock_catalog_image").show();
				$("#cust_catalog_image").hide();
				$("#filename").val("stock");
				$("#catalog_image_div").css("cursor", "default");
				var ias = $('#cust_catalog_image').imgAreaSelect({ instance: true });
				$("#file-uploader").show();
				ias.setOptions({ hide: true });
			}
		}, "json");
}

function update_crop(img, selection)
{
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}
</script>