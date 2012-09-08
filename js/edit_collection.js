$(function() {
			$("#dialog-modal").dialog({
				height: 600,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false
			});
			members_area.initMovingFilter("#cpanel-right");
		});

function prepare4edit(owned_item_id)
{
	$.post(getBaseURL()+"item_management/get_oi_details", { owned_item_id: owned_item_id },
			function (data)
			{
				var jObj = $.parseJSON(data);
				$('#edit_div').show();
				$('#clickleft').hide();
				$('#owned_price').val(jObj.purchase_price);
				$('#owned_description').val(jObj.description);
				$('#datepicker').val(jObj.date_acquired);
				$('#owned_condition').val(jObj.condition);
				$('#owned_item_id').val(jObj.owned_item_id);
				$('#owned_mp_visible').attr('checked', (jObj.mp_visible == "0"));
				$('#owned_item_name').html(jObj.name);
			});
}

function remove_owned_item()
{
	var answer = confirm("Are you sure you want to delete this item?");
	if (answer){
		var owned_item_id = $('#owned_item_id').val();
		$.post(getBaseURL()+"item_management/remove_owned_item", { owned_item_id: owned_item_id  },
				   function(data){
						$('#'+data).remove();
						$('#edit_div').hide();
						$('#clickleft').show();
						$('#owned_price').val("");
						$('#owned_description').val("");
						$('#datepicker').val("");
						$('#owned_condition').val("");
						$('#owned_item_id').val("");
						$('#owned_item_name').html("");
				   });
	}
	
}

function submit_item_update()
{
	$.post(getBaseURL()+"item_management/update_owned_item", $("#item_update_form").serialize(),
			function (data)
			{
				if(data)
				{
					$('#message_div').html('Item Updated Successfully!');
					$('#message_div').show();
				}
			});
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

function clearfilters()
{
	$('#filterform').clearForm();
	filter_submit();
}

function filter_item_divs(ids)
{
	ids += '';
	var showitemids = ids.split(",");
	$.showitemids = showitemids;
	
	$('.collection_item_div').each(
			function (indx, el)
			{
				var workingid = $(el).attr('id');
				if ($.inArray(workingid, showitemids) != -1 || showitemids == "")
				{
					$(el).show();
				}
				else
				{
					$(el).hide();
				}
			}
	)
}