$(function() {
		$( "#accordion" ).accordion({
			collapsible: true,
			active: 1
		});
		$("#filterform").keyup(function(event){
			  if(event.keyCode == 13){
				  filter_submit();
			  }
			});
	});

function filter_submit(workingset)
{
	workingset = workingset || ""
	$("#catalog_container").html("<div id=\"add_proc\" style=\"text-align: center;\"><br/><br/><br/><br/><img src=\"/img/ajax-loader.gif\" height=\"15px\" width=\"128px\" /><br/><br/>Processing...<br/><br/><br/></div>");
	$.post(getBaseURL()+"mp_filtering/filter/" + workingset, $("#filterform").serialize(),
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

$(function() {
			$('.catalog_item_div')
			.live('click', function() {
				location.href = getBaseURL() + "marketplace/buy_item/" + this.id;
				});
		});