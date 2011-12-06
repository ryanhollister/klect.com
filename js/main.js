
//Script by Drew Noakes
//http://drewnoakes.com
//14 Dec 2006 - Initial release
//08 Jun 2010 - Added support for password textboxes

var HintUClass = "hintUTextbox";
var HintPClass = "hintPTextbox";
var HintActiveClass = "hintTextboxActive";

//define a custom method on the string class to trim leading and training spaces
String.prototype.trim = function() { return this.replace(/^\s+|\s+$/g, ''); };

function initHintTextboxes() {
var inputs = document.getElementsByTagName('input');
for (i=0; i<inputs.length; i++) {
 var input = inputs[i];
 if (input.type!="text" && input.type!="password")
   continue;
   
 if ((input.className.indexOf(HintUClass)!=-1) || (input.className.indexOf(HintPClass)!=-1)) {
   input.hintText = input.value;
   if (input.name == "username" && input.value == "")
	{
		input.className = HintUClass;
	}
	else if (input.name == "password"  && input.value == "")
	{
		input.className = HintPClass;
	}
	else if (input.value != "")
	{
		input.className = HintActiveClass;
	}
   input.onfocus = onHintTextboxFocus;
   input.onblur = onHintTextboxBlur;
 }
}
}

function onHintTextboxFocus() {
var input = this;
if (input.value.trim()==input.hintText || input.value.trim()=="") {
 input.className = HintActiveClass;
 if (input.value == "Invalid Credentials, try again.")
	{
		input.value = "";
	}
}
}

function onHintTextboxBlur() {
var input = this;
if (input.value.trim().length==0) {
	if (input.name == "username")
	{
		input.className = HintUClass;
	}
	else if (input.value == "Invalid Credentials, try again.")
	{
		input.value = "";
	}
	else
	{
		input.className = HintPClass;
	}
}
}

window.onload = initHintTextboxes;

