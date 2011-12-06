$(function() {
			$("#dialog-modal").dialog({
				height: 600,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false
			});
		});

function email_wishlist()
{
	$('#wishlist_div').hide();
	$('#add_proc').show();
	$.post(getBaseURL()+"item_management/emailwishlist", $("#item_add_form").serialize(),
			function (data)
			{
				$('#wishlist_div').show();
				$('#add_proc').hide();
				$('#message_div').html(data).show();
			});
}

function submit_wishlist()
{
	$('#wishlist_div').hide();
	$('#add_proc').show();
	$.post(getBaseURL()+"item_management/addtowishlist", $("#item_add_form").serialize(),
			function (data)
			{
				$('#wishlist_div').show();
				$('#add_proc').hide();
				$('#message_div').html(data).show();
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

function showLearnMore()
{
	newwindow=window.open('/site/faq#picture_format','name','height=250,width=900');
	if (window.focus) {newwindow.focus()}
	return false;
}


$(document).ready(function() {
	$("#filterform").keyup(function(event){
		  if(event.keyCode == 13){
			  filter_submit();
		  }
		});
	$('.zoom')
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
});

function prepare4add(item_id, item_name)
{
	var alreadyselected = $('#wishlist_cnt').val().split("|");
	var alreadynamed = $('#wishlist_name').val().split("|");
	var testId = item_id + "";
	var foundIndex = $.inArray(testId, alreadyselected);
	if ( foundIndex != -1)
	{
		alreadyselected.splice(foundIndex,1);
		alreadynamed.splice(foundIndex,1);
		$('#wishlist_cnt').val(alreadyselected.join("|"));
		$('#wishlist_name').val(alreadynamed.join("|"));
		$("#"+item_id+" > span > span.wish_list_num").html('').show();
	}
	else
	{
		if (alreadyselected.length >= 20)
		{
			return;
		}
		
		if (alreadyselected[0] != "" )
		{
			var comma = "|";
		}
		else
		{
			var comma = "";
		}
		$('#wishlist_cnt').val($('#wishlist_cnt').val() + comma + item_id);
		$('#wishlist_name').val($('#wishlist_name').val() + comma + item_name);
		$("#"+item_id+" > span > span.wish_list_num").html("+").show();
	}
	update_wishlist();
}

function update_wishlist()
{
	$('.wishlist-item').each(
			function(i)
			{
				var names = $('#wishlist_name').val().split("|");
				if (names[i] != undefined && names[i] != "")
				{
					$(this).html(names[i]);
				}
				else
				{
					$(this).html("");
				}
			});
	
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
					
					var selected = $('#owned_item_id').val().split("|");
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

function rebuild_plus()
{
	var alreadyselected = $('#wishlist_cnt').val().split("|");
	for (var i = 0; i<=alreadyselected.length; i++)
	{
		$("#"+alreadyselected[i]+" > span > span.wish_list_num").html("+").show();
	}
	
}

function filter_submit()
{
	$("#catalog_container").html("<div id=\"add_proc\" style=\"text-align: center;\"><br/><br/><br/><br/><img src=\"/img/ajax-loader.gif\" height=\"15px\" width=\"128px\" /><br/><br/>Processing...<br/><br/><br/></div>");
	$.post(getBaseURL()+"item_filtering/filter", $("#filterform").serialize(),
			function (data)
			{
				$("#catalog_container").html(data);
				rebuild_plus();
			});
}
$('.pagination_links a').live('click', function() {
	  // Live handler called.
		content_left_processing('catalog_container');
		var page = this.href.split('/');
		page = page[page.length - 1] / 75;
		$.post(getBaseURL()+"item_filtering/filter/" + parseInt(page, 10) * 75, $("#filterform").serialize(),
				function (data)
				{
					$("#catalog_container").html(data);
				});
		return false;
	});