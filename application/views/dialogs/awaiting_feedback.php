<div id="awaiting_feedback_modal" title="Awaiting Feedback" style="font-size:12px;">
	<div class="catalog_image" id="awaiting_feedback_image_div"><img class="drop-shadow lifted" src="" id="awaiting_feedback_image" width="200" /></div><br/>
	<div style="font-size:12px; text-align:center; cursor:pointer" id="feedback_message"></div>
	<div style="font-size:12px; text-align:center; cursor:pointer" id="feedback_area">Please leave feedback for this transaction<br/><span style="font-size:10px">(1 being horrible and 5 being seamless)</span><br/>
	<div id="rating_div">
		<ul class="rating_list">
			<li><img src="/img/star_grey.png" title="1" class="rating_star" /></li>
			<li><img src="/img/star_grey.png" title="2" class="rating_star" /></li>
			<li><img src="/img/star_grey.png" title="3" class="rating_star" /></li>
			<li><img src="/img/star_grey.png" title="4" class="rating_star" /></li>
			<li><img src="/img/star_grey.png" title="5" class="rating_star" /></li>
		</ul>
	</div>
	<form id="feedback_form" action="" >
	<input type="hidden" name="rating_val" id="rating_val" value="2" />
	<input type="hidden" name="rating_id" id="rating_id" />
	
	</form>
	</div>
	<div id="awaiting_feedback_accordion">
	    <h3><a href="#">Catalog Details</a></h3>
	    <div>
		    <br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Name: <div id="awaiting_feedback_name" class="catalog_div" style="text-transform:capitalize"></div>
			<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Description: <div id="awaiting_feedback_description" class="catalog_div"></div>
			<br/>Manufacturer: <div id="awaiting_feedback_manufacturer" class="catalog_div" style="text-transform:capitalize"></div>
			<br/><?=constant($this->phpsession->get('current_domain')->getTag().'_ITEM')?> Attributes: <br/><div id="awaiting_feedback_attributes" class="catalog_div"></div>
			<div id="awaiting_feedback_item_attributes" class="" style=""></div>
	    </div>
		<h3><a href="#">Listing Details</a></h3>
	    <div>
	    	<br/>KLECT Sale Id: <div id="awaiting_feedback_id" class="catalog_div"></div>
	    	<br/>KLECT's Estimated Value: <div id="awaiting_feedback_owned_value" class="catalog_div"></div>
	    	<br/>Seller's Username: <div id="awaiting_feedback_seller_username" class="catalog_div"></div>
	    	<br/>Seller's Email: <div id="awaiting_feedback_seller_email" class="catalog_div"></div>
	    	<br/>Buyer's Username: <div id="awaiting_feedback_buyer_username" class="catalog_div"></div>
	    	<br/>Buyer's Email: <div id="awaiting_feedback_buyer_email" class="catalog_div"></div>
	    	<br/>Price: <div id="awaiting_feedback_price" class="catalog_div"></div>
	    	<br/>List Date: <div id="awaiting_feedback_listdate" class="catalog_div"></div>
	    	<br/>Accepted Methods: <div id="awaiting_feedback_methods" class="catalog_div"></div>
	    	<br/>Listing Description: <br/><br/><div id="awaiting_feedback_list_desc" class="catalog_div"></div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(function() {
	$(".rating_star").click(function(){
		$("#rating_val").val($(this).attr("title"));
		$(".rating_star").attr("src", "/img/star_grey.png");
		$(".rating_star").slice(0, $(this).attr("title")).attr("src", "/img/star_gold.png");
	});
	$("#awaiting_feedback_modal").dialog({
		height: 650,
		width:375,
		modal: true,
		autoOpen: false,
		resizable: false,
		buttons: {
			'Leave Feedback': function(event) {
				$.post(getBaseURL()+"mp_management/give_feedback", { saleId : $('#rating_id').val(), rating_val : $('#rating_val').val() },
				function (data)
				{
					if(data.success)
					{
						$("#feedback_message").html("Thank you for providing feedback about your transaction.<br/>&nbsp;");
						$("#feedback_area").hide();
						$(".ui-dialog-buttonpane button:contains('Leave Feedback')").hide();
						$(".rating_star").attr("src", "/img/star_grey.png");
					}
					else if(!data.success)
					{
						$("#feedback_message").html("Saving of your feedback failed, please contact KLECT.com with the sale Id: " + $('#rating_id').val() + " for help.");
					}
				}, "json");
			},
			Close: function() {
				$(this).dialog('close');
				$(".ui-dialog-buttonpane button:contains('Leave Feedback')").show();
				$("#feedback_message").hide();
				$("#feedback_area").show();
			}
		}
	});
	$('.feedback_item')
	.live('click', function() {
			$("#feedback_area").show();
			$.post(getBaseURL()+"mp_management/get_awaiting_feedback_info", { saleid : this.title.substring(6) },
					function (data)
					{
						if(data)
						{
							var jObj = $.parseJSON(data);
							
							if (jObj.custImg != undefined && jObj.custImg == 'stock' && jObj.filename != undefined)
							{
								$("#awaiting_feedback_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename);
							}
							else if (jObj.custImg != 'stock')
							{
								$("#awaiting_feedback_image").attr("src","/img/" + DOMAIN_TAG + "/customs/" + jObj.custImg);
							}
							else
							{
								$("#awaiting_feedback_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg");
							}
							$('#awaiting_feedback_modal').dialog('open');
							$("#awaiting_feedback_name").html(jObj.name);
							$("#awaiting_feedback_description").html(jObj.catalog_description);
							$("#awaiting_feedback_manufacturer").html(jObj.manufacturer);
							$("#awaiting_feedback_attributes").html(jObj.general_attributes);
							$("#awaiting_feedback_item_attributes").html(jObj.item_attributes);
							$("#awaiting_feedback_id").html(jObj.saleId);
							$("#rating_id").val(jObj.saleId);
							$("#awaiting_feedback_list_desc").html(jObj.list_description);
							$("#awaiting_feedback_price").html("$"+jObj.price);
							$("#awaiting_feedback_seller_username").html(jObj.sellerUsername);
							$("#awaiting_feedback_seller_email").html(jObj.sellerEmail);
							$("#awaiting_feedback_buyer_username").html(jObj.buyerUsername);
							
							if(jObj.shipped == '1')
							{
								$("#awaiting_feedback_status").html("Thank you for shipping this item, the buyer will mark it as recieved once delivery is made");
								var test = $(".ui-dialog-buttonpane button:contains('Mark As Shipped')");
								test.hide();
							}
							
							$("#awaiting_feedback_buyer_email").html(jObj.buyerEmail);
							$("#awaiting_feedback_methods").html(jObj.methods);
							$('#awaiting_feedback_listdate').html(jObj.list_date);
							
							$('#awaiting_feedback_accordion').show();
							$('#awaiting_feedback_image_div').show();
						}
					});
		});
});
</script>