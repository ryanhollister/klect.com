	<div id="contentwrapper" class="content">
		<div class="content-right">
		<div class="index-right-box">
				<div class="index-right-box-header">
					<span class="header-text mycollection"><?=key($content_right)?></span>
				</div>
				<div class="index-right-box-content">
				<?=current($content_right)?>
				</div>
				<div class="index-right-box-footer"></div>
			</div>
		</div>
		<div class="content-left">
			<?php $logged_in ? $this->load->view('remember_box') : $this->load->view('login_box') ?>
			<div class="index-left-box-header">
				<span class="header-text actions"><?=key($content_left)?></span>
			</div>
			<div class="index-left-box-content">
				<?=current($content_left)?>
			</div>
			<div class="cpanel-right-box-footer"></div>
		</div>
	</div>
<div id="forgotpw-div" title="Forgot Password">
	<div id="forgotpw-message" style="color:red; text-align:center;">Have your password sent to your email.</div>
	<form id="forgotpw-form" onsubmit="return false;" action="">
	<fieldset>
		<label for="forgotpwemail" class="jui-label">Email</label>
		<input type="text" name="forgotpwemail" id="forgotpwemail" autocomplete="OFF" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
	</form>
</div>
<div id="dialog-form" title="Create new user">
	<div id="signup-message" style="color:red; text-align:center;">All form fields are required.</div>
	<div class="validateTips" style="display:none"></div>
	<form id="signup-form" onsubmit="return false;" action="">
	<fieldset>
		<label for="fname" class="jui-label">First Name</label>
		<input type="text" name="fname" id="fname"  class="text ui-widget-content ui-corner-all" />
		<label for="lname" class="jui-label">Last Name</label>
		<input type="text" name="lname" id="lname"  class="text ui-widget-content ui-corner-all" />
		<label for="uname" class="jui-label">User Name</label>
		<input type="text" name="uname" id="uname"  class="text ui-widget-content ui-corner-all" />
		<label for="email" class="jui-label">Email</label>
		<input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
		<label for="password" class="jui-label">Password</label>
		<input type="password" name="password"  id="password" value="" class="text ui-widget-content ui-corner-all" />
		<label for="cpassword" class="jui-label">Confirm Password</label>
		<input type="password" name="cpassword"  id="cpassword" value="" class="text ui-widget-content ui-corner-all" />
		<label>What do you KLECT?</label>
		<?php if(isset($available_collections) && count($available_collections) > 0) { 
			?>
			<select id="add_collection_combobox" name="collection_id">
			<?php 
			foreach($available_collections as $collection_key => $collection) {
			?>
				<option value="<?=$collection_key?>"><?=$collection?></option>
		<?php } ?>
		</select>
		<?php }?>
		<br/><a href="javascript:void(0);"
NAME="My Window Name" title="KLECT Terms and Conditions" style="color:blue; text-decoration:underline; float:right" onClick="window.open('/site/terms','KLECT Terms and Conditions','width=550,height=170,0,status=0,scrollbars=1');">Terms and Conditions</a>
	</fieldset>
	</form>
</div>
<script>
	(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var self = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
					value = selected.val() ? selected.text() : "";
				var input = $( "<input>" )
					.insertAfter( select )
					.val( value )
					.autocomplete({
						delay: 0,
						minLength: 0,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							self._trigger( "selected", event, {
								item: ui.item.option
							});
						},
						change: function( event, ui ) {
							if ( !ui.item ) {
								var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
									valid = false;
								select.children( "option" ).each(function() {
									if ( this.value.match( matcher ) ) {
										this.selected = valid = true;
										return false;
									}
								});
								if ( !valid ) {
									// remove invalid value, as it didn't match anything
									$( this ).val( "" );
									select.val( "" );
									return false;
								}
							}
						}
					})
					.addClass( "ui-widget ui-widget-content ui-corner-left" );

				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					return $( "<li></li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<button>&nbsp;</button>" )
					.attr( "tabIndex", -1 )
					.attr( "title", "Show All Items" )
					.insertAfter( input )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-button-icon" )
					.click(function() {
						// close if already visible
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							return;
						}

						// pass empty string as value to search for, displaying all results
						input.autocomplete( "search", "" );
						input.focus();
					});
			}
		});
	})( jQuery );

	$(function() {
		$( "#add_collection_combobox" ).combobox();
		$('#signup-form .ui-autocomplete-input').attr('disabled', true);
		$( "#toggle" ).click(function() {
			$( "#add_collection_combobox" ).toggle();
		});
	});
</script>