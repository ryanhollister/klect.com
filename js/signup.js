$(function() {
		var uname = $("#uname"),
			fname = $("#fname"),
			lname = $("#lname"),
			email = $("#email"),
			password = $("#password"),
			cpassword = $("#cpassword"),
			
			allFields = $([]).add(uname).add(email).add(password).add(fname).add(lname).add(cpassword),
			tips = $(".validateTips");

		function updateTips(t) {
			tips
				.text(t)
				.addClass('ui-state-highlight')
				.show();
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
		
		$("#dialog-form").dialog({
			autoOpen: false,
			height: 475,
			width: 350,
			modal: true,
			resizable: false,
			buttons: {
				'Signup For KLECT': function(event) {
					if (event)
					{
						btnObj = event.currentTarget;
						$(btnObj).attr('id', 'signup-btn');
					}
					var bValid = true;
					allFields.removeClass('ui-state-error');

					bValid = bValid && checkLength(uname,"username",3,20);
					bValid = bValid && checkLength(fname,"First Name",2,16);
					bValid = bValid && checkLength(lname,"Last Name",2,16);
					bValid = bValid && checkLength(email,"email",6,80);
					bValid = bValid && checkLength(password,"password",5,16);
					bValid = bValid && checkLength(cpassword,"cpassword",5,16);

					bValid = bValid && (password.val() == cpassword.val());
					bValid = bValid && checkRegexp(uname,/^[a-z]([0-9a-z_-])+$/i,"Username may consist of a-z, 0-9, underscores, dashes and begin with a letter.");
					bValid = bValid && checkRegexp(fname,/^[a-z]([0-9a-z_])+$/i,"First name must consist of only letters.");
					bValid = bValid && checkRegexp(lname,/^[a-z]([0-9a-z_])+$/i,"Last name must consist of only letters.");
					// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
					bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");
					bValid = bValid && checkRegexp(password,/^([0-9a-zA-Z])+$/,"Password field only allow : a-z 0-9");
					bValid = bValid && checkRegexp(cpassword,/^([0-9a-zA-Z])+$/,"Confirm Password field only allow : a-z 0-9");
					
					if (bValid) {
						$.tempThis = this;
						$.post(getBaseURL()+"login/create_member", $("#signup-form").serialize(),
								function (data)
								{
									if(data=="email")
									{
										$('#signup-message').html('Email address is already in use! Try logging in!').show().css('color', 'red').css('text-align', 'center');
										email.addClass('ui-state-error');
									}
									else if(data=="username")
									{
										$('#signup-message').html('User name is already taken, sorry!').show().css('color', 'red').css('text-align', 'center');
										uname.addClass('ui-state-error');
									}
									else if(data)
									{
										$('#signup-message').html('User created!').show().css('color', 'red').css('text-align', 'center').css('font-size','20px').css('margin-top', '100px');
										$('#signup-form').hide();
										$('#signup-btn').hide();
										$("#uname").val('');
										$("#fname").val('');
										$("#lname").val('');
										$("#email").val('');
										$("#password").val('');
										$("#cpassword").val('');
										tips.hide();
										$(".ui-dialog-buttonpane button:contains('Signup For KLECT')").hide();
									}
								});
					}
				},
				Close: function() {
					$(this).dialog('close');
				}
			},
			close: function() {
				allFields.val('').removeClass('ui-state-error');
			}
		});
		
		
		
		$('#signup')
			.click(function() {
				$('#dialog-form').dialog('open');
			});
		
		$("#dialog-form").keyup(function(event){
			  if(event.keyCode == 13){
				var buttons = $( "#dialog-form" ).dialog( "option", "buttons" );
				buttons['Signup For KLECT'](false);
			  }
			});

	});

$(function() {
	var email = $("#forgotpwemail"),
		
		allFields = $([]).add(email),
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
	
	$("#forgotpw-div").dialog({
		autoOpen: false,
		height: 200,
		width: 274,
		modal: true,
		resizable: false,
		buttons: {
			'Email Password': function(event) {
				if (event)
				{
					btnObj = event.currentTarget;
					$(btnObj).attr('id', 'forgotpw-btn');
				}
				var bValid = true;
				allFields.removeClass('ui-state-error');
				
				bValid = bValid && checkLength(email,"email",6,80);

				// From jquery.validate.js (by joern), contributed by Scott Gonzalez: http://projects.scottsplayground.com/email_address_validation/
				bValid = bValid && checkRegexp(email,/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i,"eg. ui@jquery.com");
				if (bValid) {
					$.tempThis = this;
					$.post(getBaseURL()+"login/forgot_password", $("#forgotpw-form").serialize(),
							function (data)
							{
								if(data)
								{
									$('#forgotpw-message').html('Email has been sent').show().css('color', 'red').css('text-align', 'center').css('font-size','20px').css('margin-top', '43px');
									$('#forgotpw-form').hide();
									$(".ui-dialog-buttonpane button:contains('Email Password')").hide();
								}
							});
				}
			},
			Close: function() {
				$('#forgotpw-message').hide()
				$('#forgotpw-form').show();
				$('#forgotpw-btn').show();
				$(this).dialog('close');
			}
		},
		close: function() {
			allFields.val('').removeClass('ui-state-error');
		}
	});
	
	
	
	$('#forgotpw')
		.click(function() {
			$('#forgotpw-div').dialog('open');
		});
	$("#forgotpwemail").keyup(function(event){
		  if(event.keyCode == 13){
			var buttons = $( "#forgotpw-div" ).dialog( "option", "buttons" );
			buttons['Email Password'](true);
		  }
		});

});



