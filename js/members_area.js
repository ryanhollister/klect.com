var members_area = {
	initMovingFilter : function(name) {
		$("#filterform").keyup(function(event){
			  if(event.keyCode == 13){
				  filter_submit();
			  }
		});
		
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
	},



	initialize : function () { 
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
	}
}

