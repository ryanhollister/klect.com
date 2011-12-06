<div id="addcollection-div" title="Start a New Collection">
	<div class="ui-widget">
	<form id="add_collection_form" action="" onsubmit="return false;">
	<label>Choose another collection to begin:</label>
		<?php if(isset($additional_collections) && count($additional_collections) > 0) { 
			?>
			<select id="add_collection_combobox">
			<?php 
			foreach($additional_collections as $collection_key => $collection) {
			?>
				<option value="<?=$collection_key?>"><?=$collection?></option>
		<?php } ?>
		</select>
		<?php }?>
	
	</form>
	<div id="refresh_after" style="color: red; text-align: center; margin-top: 23px; display:none">Refresh your browser for the changes to take effect.</div>
</div>
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
		$('#addcollection-div .ui-autocomplete-input').attr('disabled', true);
		$( "#toggle" ).click(function() {
			$( "#add_collection_combobox" ).toggle();
		});
	});

	$("#addcollection-div").dialog({
		autoOpen: false,
		height: 150,
		width: 350,
		modal: true,
		resizable: false,
		buttons: {
			'Add': function() {
				$.post(getBaseURL()+"/collection_management/add_collection", "collection_id="+ $("#add_collection_combobox").val(),
					function (data)
					{
						if(data)
						{
							$('#add_collection_form').hide();
							$('#refresh_after').show();
							$(".ui-dialog-buttonpane button:contains('Add')").hide();
						}
					});
				
			}
			,Close: function() {
				$(this).dialog('close');
				return false;
			}
		},
		close: function() {
			
		}
	});

	$('#addcollection_btn').click(function() { $('#addcollection-div').dialog('open'); });	
</script>
