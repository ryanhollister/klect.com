var browse_catalog = {
		initialize : function() {
			
		},
		
		textBoxReady : function() {
			$this = $(this);
			if ($this.val().length > 0) {
				$this.attr('class', 'ready_for_submit');
			}
			else {
				$this.attr('class', '');
			}
		},
		
		community_submission : function() {
			$.post('/community/process_submission/', $("#community_add_form").serialize(), browse_catalog.show_community_thankyou);
		},
		
		show_community_thankyou : function() {
			alert('thanks!');
		}
}


$(document).ready(function() {
			$("#dialog-modal").dialog({
				height: 600,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false
			});
			$("#community_add").dialog({
					height: 600,
					width:375,
					modal: true,
					autoOpen: false,
					resizable: false,
					buttons : {
						'Submit' : browse_catalog.community_submission,
						'Cancel' : function() { }
					}
			});
			
		$("#community_add > form").children('input, textarea').focusout(browse_catalog.textBoxReady);	
			
});

function filter_submit()
{
	$("#catalog_container").html("<div id=\"add_proc\" style=\"text-align: center;\"><br/><br/><br/><br/><img src=\"/img/ajax-loader.gif\" height=\"15px\" width=\"128px\" /><br/><br/>Processing...<br/><br/><br/></div>");
	$.post(getBaseURL()+"item_filtering/filter", $("#filterform").serialize(),
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

function showLearnMore()
{
	newwindow=window.open('/site/faq#picture_format','name','height=250,width=900');
	if (window.focus) {newwindow.focus()}
	return false;
}

$(document).ready(function() {
	$('#-1').click(function() {
		$('#community_add').dialog('open');
	}).find('.zoom').remove();
	
	$('.zoom:not([title="-1"])')
	.live('click', function() {
			$("#catalog_image").unbind('click');
			$.post(getBaseURL()+"item_management/get_catalog_details", { item_id : $(this).attr("title") },
					function (data)
					{
						if(data)
						{
							var jObj = $.parseJSON(data);
							if (jObj.filename != undefined)
							{
								$("#catalog_image").attr("src","/img/" + DOMAIN_TAG + "/full/"+jObj.filename);
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
						}
					});
		});
	 members_area.initMovingFilter("#cpanel-right");
});

function prepare4add(item_id, item_name)
{
	if ($('#owned_item_id').val() == "")
	{
		if ($('#owned_item_id').data('lastitems')!=undefined)
		{
			var old = $('#owned_item_id').data('lastitems');
			for (i=0; i<old.length; i++)
			{
				$("#"+old[i]+" img:first").attr("src", "/img/").hide();
			}
			$('#owned_item_id').data('lastitems', "")
		}
		$('#add_div').show();
		$('#clickleft').hide();
		$('#owned_item_name').html(item_name);
		$('#owned_item_id').val(item_id);
		$("#"+item_id+" img:first").attr("src", "/img/selected.png").show();
	}
	else
	{
		var alreadyselected = $('#owned_item_id').val().split(",");
		var testId = item_id + "";
		if ($.inArray(testId, alreadyselected) != -1)
		{
			alreadyselected = jQuery.grep(alreadyselected, function(value) {
			    return value != testId;
			});
			$('#owned_item_id').val(alreadyselected.join(","));
			$("#"+item_id+" img:first").attr("src", "/img/").hide();
			if (alreadyselected == "")
			{
				$('#add_proc').hide();
				$('#clickleft').show();
				$('#add_div').hide();
			}
			if (alreadyselected.length == 1)
			{
				$('#owned_item_name').html(item_name);
			}
		}
		else
		{
			$('#owned_item_id').val($('#owned_item_id').val() + ","+ item_id);
			$('#owned_item_name').html("Multiple "+DOMAIN_ITEMS);
			$("#"+item_id+" img:first").attr("src", "/img/selected.png").show();
		}
		
	}

}

function submit_item_add()
{
	$('#add_div').hide();
	$('#add_proc').show();
	$.post(getBaseURL()+"item_management/addtocollection", $("#item_add_form").serialize(),
			function (data)
			{
				if(data)
				{
					var owned_item_id = $('#owned_item_id').val();
					$('#filterform').clearForm();
					$('#add_proc').hide();
					$('#clickleft').show();
					var currHTML = $('#'+owned_item_id).html();
					
					var selected = $('#owned_item_id').val().split(",");
					for (i=0; i<selected.length; i++)
					{
						$("#"+selected[i]+" img:first").attr("src", "/img/added.png");
					}
					$('#owned_item_id').data('lastitems', selected);
					$('#owned_item_id').val("")
				}
				else
				{
					$('#message_div').html("Failed to add selected ponies, please contact Klect").show();
					$('#clickleft').show();
					$('#owned_item_id').val("")
					$('#add_proc').hide();
				}
			});
}