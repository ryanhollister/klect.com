$(function() {
		$( "#accordion" ).accordion({
			collapsible: true,
			active: 2
		});
		$("#filterform").keyup(function(event){
			  if(event.keyCode == 13){
				  filter_submit();
			  }
			});
		
		$('.edit_sale')
		.live('click',function() {
			$.post(getBaseURL()+"mp_management/get_sale_info", { saleid : this.title },
					function (jObj)
					{
						if(jObj)
						{
							$("#stock_catalog_image").hide();
							$("#cat_custom").hide();
							
							if (jObj.filename != undefined)
							{
								$("#stock_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename).show();
								$("#filename").val('stock');
							}
							else
							{
								$("#stock_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg").show();
								$("#filename").val('stock');
							}
							
							if (jObj.custImg != 'stock')
							{
								$("#cat_custom").attr("src","/img/" + DOMAIN_TAG + "/customs/" + jObj.custImg).attr("title", jObj.custImg).show();
								$("#go_cat_custom").show();
								$("#stock_catalog_image").hide();
								$("#filename").val(jObj.custImg);
							}
							else
							{
								$("#stock_catalog_image").show();
								$("#extra_pipe").hide();
								$("#cat_custom").hide();
							}
							$('#dialog-modal').dialog('open');
							$("#catalog_name").html(jObj.name);
							$("#sale_item_name").val(jObj.name);
							$("#catalog_description").html(jObj.catalog_description);
							$("#catalog_manufacturer").html(jObj.manufacturer);
							$("#catalog_attributes").html(jObj.general_attributes);
							$("#catalog_item_attributes").html(jObj.item_attributes);
							$("#owned_purchaseprice").html(jObj.purchase_price);
							$("#owned_dateacquired").html(jObj.date_acquired);
							$("#owned_condition").html(jObj.label);
							$("#oi_id").val(jObj.owned_item_id);
							$("#price").val(jObj.price);
							$("#desc").val(jObj.list_description);
							$("#saleId").val(jObj.saleId);
							var methods = jObj.methods;
							if (methods.indexOf("Money") == -1)
							{
								$('input[name=moneyorder]').attr('checked', false);
							}
							else
							{
								$('input[name=moneyorder]').attr('checked', true);
							}
							
							if (methods.indexOf("Paypal") == -1)
							{
								$('input[name=paypal]').attr('checked', false);
							}
							else
							{
								$('input[name=paypal]').attr('checked', true);
							}
							
							if (jObj.value == "Unknown Value")
							{
								$("#owned_value").html(jObj.value);
							}
							else
							{
								$("#owned_value").html("$"+jObj.value);
							}
							$("#owned_description").html(jObj.description);
							$('#accordion').show();
							$('#submit-btn').show();
							$('#catalog_image_div').show();
						}
					}, "json");
		});
		
		$('.delete_sale')
		.live('click',function() {
			delete_sale(this);
		});
	});

function filter_submit(workingset)
{
	workingset = workingset || ""
	$("#catalog_container").html("<div id=\"add_proc\" style=\"text-align: center;\"><br/><br/><br/><br/><img src=\"/img/ajax-loader.gif\" height=\"15px\" width=\"128px\" /><br/><br/>Processing...<br/><br/><br/></div>");
	$.post(getBaseURL()+"mp_filtering/filter/" + workingset, $("#filterform").serialize(),
			function (data)
			{
				$("#catalog_container").html(data);
			});
}

function clearfilters()
{
	$('#filterform').clearForm();
	filter_submit();
}

$(function() {
			var price = $("#price"),
			desc = $("#desc"),
			paypal = $("#paypal"),
			moneyoder = $("#moneyorder")
			allFields = $([]).add(price).add(desc),
			tips = $(".validateTips");
		
		function updateTips(t) {
			tips
				.text(t)
				.addClass('ui-state-highlight');
			setTimeout(function() {
				tips.removeClass('ui-state-highlight', 1500);
			}, 500);
		}
		
		function checkLength(o,n,min,max) {
		
			if ( o.val().length > max || o.val().length < min ) {
				o.addClass('ui-state-error');
				updateTips("Length of " + n + " must be between "+min+" and "+max+".");
				return false;
			} else {
				return true;
			}
		
		}
		
		function checkRegexp(o,regexp,n) {
		
			if ( !( regexp.test( o.val() ) ) ) {
				o.addClass('ui-state-error');
				updateTips(n);
				return false;
			} else {
				return true;
			}
		}
			$("#dialog-modal").dialog({
				height: 650,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false,
				buttons: {
					'Submit Sale': function(event) {
						btnObj = event.currentTarget;
						$(btnObj).attr('id', 'submit-btn');
						var bValid = true;
						allFields.removeClass('ui-state-error');
						
						var x1 = $('#x1').val();
			            var y1 = $('#y1').val();
			            var x2 = $('#x2').val();
			            var y2 = $('#y2').val();
			            var w = $('#w').val();
			            var h = $('#h').val();

						bValid = bValid && checkLength(price,"Price",1,7);
						bValid = bValid && checkLength(desc,"Description",5,1000);

						bValid = bValid && checkRegexp(price,/^[0-9]([0-9.])+$/i,"Price must be entered and have a length of 1-7 characters.");
						// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
						
						if (bValid) {
							$.tempThis = this;
							$.post(getBaseURL()+"mp_management/submit_sale", $("#sale-form").serialize(),
									function (data)
									{
										if (data == "over")
										{
											$('#sale-message').html('We are sorry, each user is limited to 20 active sales at this point. We appreciate your support and hope to offer more active sales in the near future!').show().css('color', 'red').css('text-align', 'center').css('font-size','20px').css('margin-top', '100px');
											$('#accordion').hide();
											$('#submit-btn').hide();
											$('#catalog_image_div').hide();
											
											var ias = $('#cust_catalog_image').imgAreaSelect({ instance: true });

											ias.setOptions({ hide: true });
											goStock();
										}
										else if(data !== "-1")
										{
											$('#sale-message').html('Your item is now listed in the KLECT marketplace!').show().css('color', 'red').css('text-align', 'center').css('font-size','20px').css('margin-top', '100px');
											$('#accordion').hide();
											$('#submit-btn').hide();
											$('#catalog_image_div').hide();
											$('#'+$('#oi_id').val()).remove();
											$("#image_toggle").hide();
											if ($('#sale-list').children().length == 0)
											{
												$('#sale-list').html('<li class="pending-item"><a class="edit_sale" href="#" title="'+data+'">'+$("#catalog_name").html()+'</a> (<a href="#" class="delete_sale" title="'+data+'">delete</a>)</li>');
											}
											else if ($('#saleId').val() == '')
											{
												$('#sale-list').append('<li class="pending-item"><a class="edit_sale" href="#" title="'+data+'">'+$("#catalog_name").html()+'</a> (<a href="#" class="delete_sale" title="'+data+'">delete</a>)</li>');
											}
											var ias = $('#cust_catalog_image').imgAreaSelect({ instance: true });

											ias.setOptions({ hide: true });
											goStock();
											$(".ui-dialog-buttonpane button:contains('Submit Sale')").hide();
										}
										else
										{
											$('#sale-message').html("Listing Failed, please check your fields and try again").show();
										}
										return false;
									});
						}
						return false;
					},
					Close: function() {
						$('#sale-message').hide()
						$('#sale-form').show();
						$('#submit-btn').show();
						$('#sale-message').html("");
						$("#image_toggle").show();
						$(this).dialog('close');
					}
				},
				close: function() {
					allFields.val('').removeClass('ui-state-error');
					var ias = $('#cust_catalog_image').imgAreaSelect({ instance: true });
					
					ias.setOptions({ hide: true });
				}
			});
			$("#dialog-modal").keyup(function(event){
				  if(event.keyCode == 13){
					var buttons = $( "#dialog-modal" ).dialog( "option", "buttons" );
					buttons['Submit'](false);
				  }
				});
			
			$('.collection_item_div')
			.click(function() {
					$.post(getBaseURL()+"index.php/item_management/get_owned_catalog_details", { owned_item_id : this.id },
							function (data)
							{
								if(data)
								{
									var jObj = $.parseJSON(data);
									if (jObj.filename != undefined)
									{
										$("#stock_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename);
										$("#filename").val('stock');
									}
									else
									{
										$("#stock_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg");
										$("#filename").val('stock');
									}
									
									if (jObj.custImg != 'stock')
									{
										$("#cat_custom").attr("src","/img/" + DOMAIN_TAG + "/customs/" + jObj.custImg);
										$("#go_cat_custom").show();
										$("#filename").val("custom");
									}
									else
									{
										$("#stock_catalog_image").show();
										$("#extra_pipe").hide();
										$("#cat_custom").hide();
									}
									
									
									$('#dialog-modal').dialog('open');
									$("#catalog_name").html(jObj.name);
									$("#sale_item_name").val(jObj.name);
									$("#catalog_description").html(jObj.catalog_description);
									$("#catalog_manufacturer").html(jObj.manufacturer);
									$("#catalog_attributes").html(jObj.general_attributes);
									$("#catalog_item_attributes").html(jObj.item_attributes);
									$("#owned_purchaseprice").html(jObj.purchase_price);
									$("#owned_dateacquired").html(jObj.date_acquired);
									$("#owned_condition").html(jObj.label);
									$("#saleId").val("");
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
									$('#accordion').show();
									$('#submit-btn').show();
									$('#catalog_image_div').show();
								}
							});
				});
		});

function handleSuccess(id, fileName, responseJSON)
{
	if (responseJSON.success)
	{
		$("#cust_catalog_image").attr("src","/img/" + DOMAIN_TAG + "/uploads/"+responseJSON.filename).show();
		$("#catalog_image_div").css("cursor", "crosshair");
		$("#filename").val(responseJSON.filename);
		$("#stock_catalog_image").hide();
		$("#cat_custom").hide();
		$("#progress_image").hide();
	}
}

function showProgress()
{
	$("#stock_catalog_image").hide();
	$("#cust_catalog_image").hide();
	$("#progress_image").show();
}

function goStock()
{
	$("#stock_catalog_image").show();
	$("#cust_catalog_image").hide();
	$("#cat_custom").hide();
	$("#filename").val("stock");
	$("#catalog_image_div").css("cursor", "default");
	var ias = $('#cust_catalog_image').imgAreaSelect({ instance: true });
	
	ias.setOptions({ hide: true });
}

function goCatCustom()
{
	$("#stock_catalog_image").hide();
	$("#cat_custom").show();
	$("#cust_catalog_image").hide();
	$("#filename").val($("#cat_custom").attr("title"));
	$("#catalog_image_div").css("cursor", "default");
	var ias = $('#cust_catalog_image').imgAreaSelect({ instance: true });
	
	ias.setOptions({ hide: true });
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

function delete_sale(ol_item)
{
	var answer = confirm("Are you sure you want to delete this listing?");
	if (answer){
		$.post(getBaseURL()+"mp_management/delete_sale", { saleId: ol_item.title  },
				   function(data){
						$(ol_item).parent().remove();
						if($("#sale-list").children().length == 0)
						{
							$("#sale-list").html("You have no active sales");	
						}
				   });
	}
	
}