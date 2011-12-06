$(function() {
		$( "#accordion" ).accordion({
			collapsible: true,
			active: 1,
			fillSpace: true
		});
	});

function showLearnMore()
{
	newwindow=window.open('/site/faq#picture_format','name','height=250,width=900');
	if (window.focus) {newwindow.focus()}
	return false;
}

$(function() {
			$("#dialog-modal").dialog({
				height: 575,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false,
				buttons: {
					'Buy Item': function(event) {
						showConfirm();
						return false;			
					},
					Close: function() {
						$('#sale-message').hide()
						$('#sale-form').show();
						$('#submit-btn').show();
						$('#sale-message').html("");
						$(this).dialog('close');
					}
				}
			});
			$('.catalog_item_div')
			.click(function() {
					$("#catalog_image").unbind('click');
					$.post(getBaseURL()+"mp_management/get_sale_info", { saleid : this.id },
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
										$("#catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/nopic.jpg").click(showLearnMore);
									}
									$('#dialog-modal').dialog('open');
									$("#catalog_name").html(jObj.name);
									$("#catalog_description").html(jObj.catalog_description);
									$("#catalog_manufacturer").html(jObj.manufacturer);
									$("#catalog_attributes").html(jObj.general_attributes);
									$("#catalog_item_attributes").html(jObj.item_attributes);
									$("#owned_condition").html(jObj.label);
									$("#member_rating_span").html(jObj.member_rating);
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
									$('#submit-btn').show();
									$('#catalog_image_div').show();
								}
							});
				});
		});

//run the currently selected effect
function showConfirm(){
	//run the effect
	$("#buy_main").toggle('slide',{direction : "left"},500, function () { $("#buy_confirm").toggle('slide',{ direction : "right" },500); });
	$(".ui-dialog-buttonpane button:contains('Buy Item')").hide();
};
function showMain(){
	$("#buy_confirm").toggle('slide',{ direction : "right"},500, function () { $("#buy_main").toggle('slide',{direction : "left"},500); });
	$(".ui-dialog-buttonpane button:contains('Buy Item')").show();
};

$(document).ready(function() {
	$("#confirm_button").click(function() {
		submit_buy();
		return false;
	});
	
	$("#cancel_button").click(function() {
		showMain();
		return false;
	});
});
		
function submit_buy()
{
	$('#confirm_button').hide();
	$('#cancel_button').hide();
	$("#confirm_text").hide();
	$('#sale-message').html('<img src="/img/ajax-loader.gif"/><br/><br/>Processing...').show().css('text-align', 'center').css('font-size','20px').css('margin-top', '100px');
	$.post(getBaseURL()+"mp_management/submit_buy/", { saleId : $("#klect_sale_id").html() } ,
			function (data)
			{
				if(data.indexOf("success") > 0)
				{
					$('#accordion').hide();
					$('#submit-btn').hide();
					$('#catalog_image_div').hide();
					$('#'+$("#klect_sale_id").html()).remove();
					$("#klect_sale_id").html('');
					$("#confirm_button").hide();
					$("#cancel_button").hide();
					$("#confirm_text").hide();
					$('#sale-message').html(data).css('color', 'red');
				}
				else
				{
					$('#sale-message').html(data).show();
					$(".ui-dialog-buttonpane button:contains('Buy Item')").show();
					$('#confirm_button').show();
					$('#cancel_button').show();
				}});
}