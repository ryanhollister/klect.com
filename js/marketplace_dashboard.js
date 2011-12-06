$(function() {
		$( "#accordion" ).accordion({
			collapsible: true,
			active: 1,
			fillSpace: true
		});
		$( "#sale_accordion" ).accordion({
			collapsible: true,
			active: 1,
			fillSpace: true
		});
		$( "#purchase_accordion" ).accordion({
			collapsible: true,
			active: 1,
			fillSpace: true
		});
		$( "#awaiting_feedback_accordion" ).accordion({
			collapsible: true,
			active: 1,
			fillSpace: true
		});
	});

$(function() {
			$("#dialog-modal").dialog({
				height: 650,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false,
				buttons: {
					Close: function() {
						$(this).dialog('close');
					}
				}
			});
			$('.active-sale-item')
			.live('click', function() {
					$.post(getBaseURL()+"mp_management/get_sale_info", { saleid : this.title.substring(6) },
							function (data)
							{
								if(data)
								{
									var jObj = $.parseJSON(data);
									
									if (jObj.custImg != undefined && jObj.custImg == 'stock' && jObj.filename != undefined)
									{
										$("#catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename);
									}
									else if (jObj.custImg != 'stock')
									{
										$("#catalog_image").attr("src","/img/" + DOMAIN_TAG + "/customs/" + jObj.custImg);
									}
									else
									{
										$("#catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg");
									}
									$('#dialog-modal').dialog('open');
									$("#catalog_name").html(jObj.name);
									$("#catalog_description").html(jObj.catalog_description);
									$("#catalog_manufacturer").html(jObj.manufacturer);
									$("#catalog_attributes").html(jObj.general_attributes);
									$("#catalog_item_attributes").html(jObj.item_attributes);
									$("#owned_condition").html(jObj.label);
									if (jObj.value == "Unknown Value")
									{
										$("#owned_value").html(jObj.value);
									}
									else
									{
										$("#owned_value").html("$"+jObj.value);
									}
									$("#klect_sale_id").html(jObj.saleId);
									$("#list_desc").html(jObj.list_description);
									$("#price").html("$"+jObj.price);
									$("#seller").html(jObj.username);
									$("#methods").html(jObj.methods);
									$('#listdate').html(jObj.list_date);
									
									$('#accordion').show();
									$('#catalog_image_div').show();
								}
							});
				});
		});

$(function() {
	$("#pending_sale_modal").dialog({
		height: 650,
		width:375,
		modal: true,
		autoOpen: false,
		resizable: false,
		buttons: {
			'Mark As Shipped': function(event) {
				$.post(getBaseURL()+"mp_management/mark_as_shipped", { saleId : $('#pending_sale_id').html() },
				function (data)
				{
					if(data)
					{
						$("#pending_sale_status").html("Thank you for shipping this item, the buyer will mark it as recieved once delivery is made");
						var test = $(".ui-dialog-buttonpane button:contains('Mark As Shipped')");
						test.hide();
					}
				});
			},
			Close: function() {
				$(this).dialog('close');
				var test = $(".ui-dialog-buttonpane button:contains('Mark As Shipped')");
				$("#pending_sale_status").html("Once the buyer has paid, please mark this item as shipped.");
				test.show();
			}
		}
	});
	$('.pending-sale-item')
	.live('click', function() {
			$.post(getBaseURL()+"mp_management/get_pending_sale_info", { saleid : this.title.substring(6) },
					function (data)
					{
						if(data)
						{
							var jObj = $.parseJSON(data);
							
							if (jObj.custImg != undefined && jObj.custImg == 'stock' && jObj.filename != undefined)
							{
								$("#pending_sale_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename);
							}
							else if (jObj.custImg != 'stock')
							{
								$("#pending_sale_image").attr("src","/img/" + DOMAIN_TAG + "/customs/" + jObj.custImg);
							}
							else
							{
								$("#pending_sale_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg");
							}
							$('#pending_sale_modal').dialog('open');
							$("#pending_sale_name").html(jObj.name);
							$("#pending_sale_description").html(jObj.catalog_description);
							$("#pending_sale_manufacturer").html(jObj.manufacturer);
							$("#pending_sale_attributes").html(jObj.general_attributes);
							$("#pending_sale_item_attributes").html(jObj.item_attributes);
							$("#pending_sale_id").html(jObj.saleId);
							$("#pending_sale_list_desc").html(jObj.list_description);
							$("#pending_sale_price").html("$"+jObj.price);
							$("#pending_sale_seller_username").html(jObj.sellerUsername);
							$("#pending_sale_seller_email").html(jObj.sellerEmail);
							$("#pending_sale_buyer_username").html(jObj.buyerUsername);
							
							if(jObj.shipped == '1')
							{
								$("#pending_sale_status").html("Thank you for shipping this item, the buyer will mark it as recieved once delivery is made");
								var test = $(".ui-dialog-buttonpane button:contains('Mark As Shipped')");
								test.hide();
							}
							
							$("#pending_sale_buyer_email").html(jObj.buyerEmail);
							$("#pending_sale_methods").html(jObj.methods);
							$('#pending_sale_listdate').html(jObj.list_date);
							
							$('#sale_accordion').show();
							$('#pending_sale_image_div').show();
						}
					});
		});
});

$(function() {
	$("#pending_purchase_modal").dialog({
		height: 650,
		width:375,
		modal: true,
		autoOpen: false,
		resizable: false,
		buttons: {
			'Mark As Recieved': function(event) {
			$.post(getBaseURL()+"mp_management/mark_as_recieved", { saleId : $('#pending_purchase_id').html() },
			function (data)
			{
				if(data)
				{
					$("#pending_purchase_status").html("Great! The item has been transfered to your collection. Thank you for using KLECT Marketplace");
					$(".ui-dialog-buttonpane button:contains('Mark As Recieved')").hide();
					$(".pending-purchase-li > a:[title='"+$('#pending_purchase_id').html()+"']").parent().remove()
				}
			});
	},
			Close: function() {
				$(".ui-dialog-buttonpane button:contains('Mark As Recieved')").show();
				$(this).dialog('close');
				$("#pending_purchase_status").html("This item has been marked as shipped by the seller. Once you recieve the item, click 'Recieved' and the item will be transfered to your collection.");
			}
		}
	});
	$('.pending_purchase_item')
	.live('click', function() {
			$.post(getBaseURL()+"mp_management/get_pending_sale_info", { saleid : this.title.substring(6) },
					function (data)
					{
						if(data)
						{
							var jObj = $.parseJSON(data);
							
							if (jObj.custImg != undefined && jObj.custImg == 'stock' && jObj.filename != undefined)
							{
								$("#pending_purchase_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename);
							}
							else if (jObj.custImg != 'stock')
							{
								$("#pending_purchase_image").attr("src","/img/" + DOMAIN_TAG + "/customs/" + jObj.custImg);
							}
							else
							{
								$("#pending_purchase_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg");
							}
							$('#pending_purchase_modal').dialog('open');
							$("#pending_purchase_name").html(jObj.name);
							$("#pending_purchase_description").html(jObj.catalog_description);
							$("#pending_purchase_manufacturer").html(jObj.manufacturer);
							$("#pending_purchase_attributes").html(jObj.general_attributes);
							$("#pending_purchase_item_attributes").html(jObj.item_attributes);
							$("#pending_purchase_id").html(jObj.saleId);
							$("#pending_purchase_list_desc").html(jObj.list_description);
							$("#pending_purchase_price").html("$"+jObj.price);
							$("#pending_purchase_seller").html(jObj.username);
							$("#pending_purchase_methods").html(jObj.methods);
							$('#pending_purchase_listdate').html(jObj.list_date);
							
							$("#pending_purchase_seller_username").html(jObj.sellerUsername);
							$("#pending_purchase_seller_email").html(jObj.sellerEmail);
							$("#pending_purchase_buyer_username").html(jObj.buyerUsername);
							
							if(jObj.shipped == '0')
							{
								$("#pending_purchase_status").html("This item has not been shipped yet. Once it is shipped you will be able to mark it as recieved here. Marking it as recieved will move it to your collection and complete the sale.");
								var test = $(".ui-dialog-buttonpane button:contains('Mark As Recieved')");
								test.hide();
							}
							
							if(jObj.resolved == '1')
							{
								$("#pending_purchase_status").html("This item has been marked as 'Recieved' by the buyer. Thank you for using KLECT Marketplace.");
							}
							
							$("#pending_purchase_buyer_email").html(jObj.buyerEmail);
							
							$('#purchase_accordion').show();
							$('#pending_purchase_image_div').show();
						}
					});
		});
});