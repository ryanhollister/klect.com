function show_edit_item_div(owned_item_id)
{
	$.post(getBaseURL()+"index.php/item_management/get_item_details", { owned_item_id: owned_item_id },
			function (data)
			{
				var jObj = $.parseJSON(data);				
				$('#owned_item_details_div').show();
				$('#owned_price').val(jObj.purchase_price);
				$('#owned_description').val(jObj.description);
				$('#datepicker').val(jObj.date_acquired);
				$('#owned_condition').val(jObj.condition);
				$('#owned_item_id').val(jObj.owned_item_id);
			});
}



