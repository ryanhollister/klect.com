$(function() {
			$("#dialog-modal").dialog({
				height: 600,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false
			});
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

$.fn.clearForm = function() {
  return this.each(function() {
    var type = this.type, tag = this.tagName.toLowerCase();
    if (tag == 'form')
      return $(':input',this).clearForm();
    if (type == 'text' || type == 'password' || tag == 'textarea')
      this.value = '';
    else if (type == 'checkbox' || type == 'radio')
      this.checked = false;
    else if (tag == 'select')
      this.selectedIndex = -1;
  });
};


$(document).ready(function() {
	$("#filterform").keyup(function(event){
		  if(event.keyCode == 13){
			  filter_submit();
		  }
		});
	var name = "#cpanel-right";  
	 if (screen.height>899)
	 {
		var menuYloc = null;  
		menuYloc = parseInt($(name).css("margin-top").substring(0,$(name).css("margin-top").indexOf("px")))  
		var offset = -169+$(document).scrollTop(); 
		    if (offset < 0)
		    {
		   	 offset = 0;
		    }
		    else
		    {
		   	 offset = offset+"px";
		    }
		$(name).animate({marginTop:offset},{duration:400,queue:false});
		$(window).scroll(function () {
		    var offset = -169+$(document).scrollTop(); 
		    if (offset < 0)
		    {
		   	 offset = 0;
		    }
		    else
		    {
		   	 offset = offset+"px";
		}
		$(name).animate({marginTop:offset},{duration:400,queue:false});  
		});  
	 }
});


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

$('.pagination_links a').live('click', function() {
	  // Live handler called.
		content_left_processing('catalog_container');
		var page = this.href.split('/');
		page = page[page.length - 1] / 75;
		$.post(getBaseURL()+"item_filtering/filter_collection/" + parseInt(page, 10) * 75, $("#filterform").serialize(),
				function (data)
				{
					$("#catalog_container").html(data);
				});
		return false;
	});