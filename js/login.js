function forgotpw()
{
	var username = $("input[name=username]").val();
	$.post(getBaseURL()+"index.php/login/forgot_password", { username: username },
			   function(data, textStatus){
					alert(data);
			   });
}

function getBaseURL() {
    var url = location.href;  // entire url including querystring - also: window.location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));

    if (baseURL.indexOf('http://localhost') != -1) {
        // Base Url for localhost
        var url = location.href;  // window.location.href;
        var pathname = location.pathname;  // window.location.pathname;
        var index1 = url.indexOf(pathname);
        var baseLocalUrl = url.substr(0, index1);

        return baseLocalUrl + "/";
    }
    else {
        // Root Url for domain name
        return baseURL + "/";
    }

}

jQuery.fn.hint = function (blurClass) {
	  if (!blurClass) { 
	    blurClass = 'blur';
	  }

	  return this.each(function () {
	    // get jQuery version of 'this'
	    var $input = jQuery(this),

	    // capture the rest of the variable to allow for reuse
	      title = $input.attr('title'),
	      $form = jQuery(this.form),
	      $win = jQuery(window);

	    function remove() {
	      if ($input.val() === title && $input.hasClass(blurClass)) {
	        $input.val('').removeClass(blurClass);
	      }
	    }

	    // only apply logic if the element has the attribute
	    if (title) { 
	      // on blur, set value to title attr if text is blank
	      $input.blur(function () {
	        if (this.value === '') {
	          $input.val(title).addClass(blurClass);
	        }
	        
	      }).focus(remove).blur(); // now change all inputs to title

	      // clear the pre-defined text when form is submitted
	      $form.submit(remove);
	      $win.unload(remove); // handles Firefox's autocomplete
	    }
	  });
	};
	$(function(){ 
	    // find all the input elements with title attributes
		$('input[title!=""]').hint();
	});
