$(function() {
			$("#sort_ord").buttonset();
			$("#img_size").buttonset();
		});
$(function() {
		var uname = $("#uname"),
			fname = $("#fname"),
			lname = $("#lname"),
			email = $("#email"),
			opassword = $("#opassword"),
			npassword = $("#npassword"),
			sort_ord = $("#sort_ord"),
			img_size = $("#img_size"),
			
			allFields = $([]).add(uname).add(email).add(fname).add(lname).add(opassword).add(npassword).add(img_size).add(sort_ord),
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
		
		$("#editprofile-div").dialog({
			autoOpen: false,
			height: 610,
			width: 350,
			modal: true,
			resizable: false,
			buttons: {
				'Save': function(event) {
					var bValid = true;
					allFields.removeClass('ui-state-error');

					bValid = bValid && checkLength(fname,"First Name",3,16);
					bValid = bValid && checkLength(lname,"Last Name",3,16);
					bValid = bValid && checkLength(email,"email",6,80);

					bValid = bValid && checkRegexp(fname,/^[a-z]([0-9a-z_ ])+$/i,"First name must consist of only letters.");
					bValid = bValid && checkRegexp(lname,/^[a-z]([0-9a-z_ .])+$/i,"Last name must consist of only letters.");
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");
					
					if (opassword.val() != "")
					{
						bValid = bValid && checkRegexp(opassword,/^([0-9a-zA-Z])+$/,"Password field only allow : a-z 0-9");
						bValid = bValid && checkRegexp(npassword,/^([0-9a-zA-Z])+$/,"New Password field only allow : a-z 0-9");
						
						bValid = bValid && checkLength(opassword,"password",5,16);
						bValid = bValid && checkLength(npassword,"cpassword",5,16);
					}
					
					if (bValid) {
						$.tempThis = this;
						$.post(getBaseURL()+"/login/edit_profile", $("#editprofile-form").serialize() + "&" + $("#shipping-form").serialize(),
								function (data)
								{
									if(data === "1")
									{
										$('#editprofile-message').html('Profile updated!<br><span style="font-size: 12px; line-height: 19px;">If you changed the image size or sort order, it will be applied on next page load.</span>').show().css('color', 'red').css('text-align', 'center').css('font-size','20px').css('margin-top', '100px');
										$('#main_edit_profile').hide();
										$('#shipping_edit_profile').hide();
										var test = $(".ui-dialog-buttonpane button:contains('Save')");
										test.hide();
									}
									else
									{
										$('#editprofile-message').html(data).show();
									}	
								});
					}
				},
				Close: function() {
					$('#editprofile-message').hide()
					$('#editprofile-form').show();
					$('#editprofile-btn').show();
					$('#editprofile-message').html("");
					$(this).dialog('close');
					return false;
				}
			},
			close: function() {
				allFields.val('').removeClass('ui-state-error');
			}
		});

		$('#editprofile')
			.click(function() {
				$.post(getBaseURL()+"/login/get_profile", $("#editprofile-form").serialize(),
						function (data)
						{
							if(data)
							{
								var test = $(".ui-dialog-buttonpane button:contains('Save')");
								test.show();
								var jObj = $.parseJSON(data);
								$("#premium_edit_profile").hide();
								$("#shipping_edit_profile").hide();
								$("#main_edit_profile").show();
								$("#fname").val(jObj.first_name);
								$("#lname").val(jObj.last_name);
								$("#email").val(jObj.email);
								if (jObj.premium == '1')
								{
									$("#stat_label_act").show();
									$("#stat_label_inact").hide();
									$("#prem_button").text("Edit Info");
									$("#purchase_button").hide();
									$("#agree").attr("checked", true).attr("disabled", true);
									$("#bill_subtype").val(jObj.type);
									$('.bill_sub_div .ui-autocomplete-input').val( $("#bill_subtype option:selected").text());
								}
								else
								{
									$("#stat_label_inact").show();
									$("#stat_label_act").hide();
									$("#cancel_button").hide();
									$("#prem_button").text("Upgrade");
									$("#purchase_button").hide();
									$("#agree").attr("checked", false);
								}
								$("#"+jObj.img_size).attr("checked", "checked");
								$("#"+jObj.sort_ord).attr("checked", "checked");
								
								$("#bill_fname").val(jObj.bill_first);
								$("#bill_lname").val(jObj.bill_last);
								$("#bill_addr1").val(jObj.bill_addr1);
								$("#bill_addr2").val(jObj.bill_addr2);
								$("#bill_city").val(jObj.bill_city);
								$("#bill_state").val(jObj.bill_state);
								$("#bill_zip").val(jObj.bill_zip);
								$( ".bill_country_div .ui-autocomplete-input" ).val(jObj.bill_country);
								$( "#bill_country" ).val(jObj.bill_country);
								if (jObj.last_4)
								{
									$("#bill_num").val("XXXXXXXXXX"+jObj.last_4);
								}
								else
								{
									$("#bill_num").val('');
								}
								$("#bill_mo").val(jObj.bill_mo);
								$("#bill_yr").val(jObj.bill_yr);
								
								$("#ship_addr1").val(jObj.ship_addr1);
								$("#ship_addr2").val(jObj.ship_addr2);
								$("#ship_city").val(jObj.ship_city);
								$("#ship_state").val(jObj.ship_state);
								$("#ship_zip").val(jObj.ship_zip);
								$( ".ship_country_div .ui-autocomplete-input" ).val(jObj.ship_country);
								$( "#ship_country" ).val(jObj.ship_country);
								
								$("#sort_ord").buttonset("refresh");
								$("#img_size").buttonset("refresh");
								$('#editprofile-div').dialog('open');
							}
						});
				return false;
			});
		
		
		
		$("#editprofile-form").keyup(function(event){
			  if(event.keyCode == 13){
				var buttons = $( "#editprofile-div" ).dialog( "option", "buttons" );
				buttons['Save']();
			  }
			});
		
		$("#premium-form").keyup(function(event){
			  if(event.keyCode == 13){
				premiumSubmit();
			  }
			});

	});

$(function() {
	//run the currently selected effect
	function runEffect(){
		//run the effect
		$("#main_edit_profile").toggle('slide',{direction : "left"},500, function () { $("#premium_edit_profile").toggle('slide',{ direction : "right" },500); });
		$(".ui-dialog-buttonpane button:contains('Save')").hide();
	};
	function runPremium(){
		$("#premium_edit_profile").toggle('slide',{ direction : "right"},500, function () { $("#main_edit_profile").toggle('slide',{direction : "left"},500); });
		$(".ui-dialog-buttonpane button:contains('Save')").show();
	};
	
	//run the currently selected effect
	function runBilling(){
		//run the effect
		$("#main_edit_profile").toggle('slide',{direction : "right"},500, function () { $("#shipping_edit_profile").toggle('slide',{ direction : "left" },500); });
	};
	function runMain(){
		$("#shipping_edit_profile").toggle('slide',{ direction : "left"},500, function () { $("#main_edit_profile").toggle('slide',{direction : "right"},500); });
	};
	
	//slide to premium information
	$("#prem_button").click(function() {
		runEffect();
		return false;
	});
	
	//slide back to edit profile
	$("#back_button").click(function() {
		runPremium();
		return false;
	});
	
	//slide to premium information
	$("#shipping_button").click(function() {
		runBilling();
		return false;
	});
	
	//slide back to edit profile
	$("#main_button").click(function() {
		runMain();
		return false;
	});
	
	$("#purchase_button").click(function() {
		premiumSubmit();
		return false;
	});
	
	$("#cancel_button").click(function() {
		cancelPremium();
		return false;
	});
	
	$("#agree").change(function() {
		if ($("#agree").attr("checked"))
		{
			$("#purchase_button").show();
		}
		else
		{
			$("#purchase_button").hide();
		}
			
	});

});

function premiumSubmit() {
	$("#prem_msg").html('<img src="/img/ajax-loader.gif" /><br/>Processing...');
	$.post(getBaseURL()+"membership/subscribe", $("#premium-form").serialize() ,
			function (data)
			{
				if(data)
				{
					$("#stat_label_act").show();
					$("#stat_label_inact").hide();
					$("#prem_button").html("Edit Info");
					$("#prem_msg").html("Successfully processed membership, welcome to the KLECT marketplace!");
					$("#purchase_button").hide();
					$("#cancel_button").show();
				}
				else
				{
					$("#prem_msg").html("There was an error, please check your information and try again. If you are still having problems please contact KLECT");
				}
				return false;
			});
}

function cancelPremium() {
	$("#prem_msg").html('<img src="/img/ajax-loader.gif" /><br/>Processing...');
	$.post(getBaseURL()+"membership/cancel", { cancel : true } ,
			function (data)
			{
				if(data)
				{
					$("#stat_label_inact").show();
					$("#stat_label_act").hide();
					$("#prem_button").html("Upgrade");
					$("#prem_msg").html("Successfully canceled automatic membership renewel. All your active sales have been deleted.");
					$("#cancel_button").hide();
				}
				else
				{
					$("#prem_msg").html("There was an error. Please contact KLECT");
				}
				return false;
			});
}

function clearfilters()
{
	$('#filterform').clearForm();
	filter_submit();
	scroll(0,0);
}

function filter_submit()
{
	content_left_processing('catalog_container');
	$.post(getBaseURL()+"item_filtering/filter_collection", $("#filterform").serialize(),
			function (data)
			{
				$("#catalog_container").html(data);
			});
}