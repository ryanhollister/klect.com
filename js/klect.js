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

/* code from qodo.co.uk */
//create as many regular expressions here as you need:
var digitsOnly = /[1234567890]/g;
var integerOnly = /[0-9\.]/g;
var alphaOnly = /[A-Z]/g;
function restrictCharacters(myfield, e, restrictionType) {
	if (!e) var e = window.event
	if (e.keyCode) code = e.keyCode;
	else if (e.which) code = e.which;
	var character = String.fromCharCode(code);
	//if they pressed esc... remove focus from field...
	if (code==27) { this.blur(); return false; }
	//ignore if they are press other keys
	//strange because code: 39 is the down key AND ' key...
	//and DEL also equals .
	if (!e.ctrlKey && code!=9 && code!=8 && code!=36 && code!=37 && code!=38 && (code!=39 || (code==39 && character=="'")) && code!=40) {
		if (character.match(restrictionType)) {
			return true;
		} else {
			return false;
		}
	}
}

function subnav_change()
{
	$(".button-subnav").removeClass("selected-subnav");
	$(this).addClass("selected-subnav");
	$(".subbanner").hide();
	$("#" + $(this).attr("ref")).show();
}

function subnav_cycle()
{
	var nextDisplay = "";
	$(".button-subnav").filter(":not(.selected-subnav)");
	$(".button-subnav").removeClass("selected-subnav");
	$(this).addClass("selected-subnav");
	$(".subbanner").hide();
	$("#"+nextDisplay).show();
}

function content_left_processing(containt_name)
{
	$("#" + containt_name).html('<div class="content_left_processing"><img src="/img/ajax-loader.gif" height="15px" width="128px" /><br/><br/>Processing...</div>');
}
$(document).ready(function() {
	$(".min_max").click(function () { 
		$(this).parent().next('.cpanel-right-box-content:first').toggle( 'blind', '', 500 );
		return false;
	    });
	$(".min_max").toggle(function () { $(this).attr('src', '/img/maximize.png');} , function () { $(this).attr('src', '/img/minimize.png');} );

});

$(document).ready(function() {
	$(".max_min").click(function () { 
		$(this).parent().next('.cpanel-right-box-content:first').toggle( 'blind', '', 500 );
		return false;
	    });
	$(".max_min").toggle(function () { $(this).attr('src', '/img/maximize.png');} , function () { $(this).attr('src', '/img/minimize.png');} );
	$(".max_min").click();
});