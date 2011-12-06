$(function() {
			$("#dialog-modal").dialog({
				height: 600,
				width:375,
				modal: true,
				autoOpen: false,
				resizable: false
			});
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