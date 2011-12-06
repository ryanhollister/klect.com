<div id="invite_a_friend-div" title="Invite a Friend">
	<div id="message_sent" style="color: red; font-size: 14px; text-align: center; margin-top: 84px;display:none">Message sent.<br/>Thanks for sharing KLECT with your friends!</div>
	<div id="process_message" style="font-size: 14px; text-align: center; margin-top: 84px;display:none">Processing...<br/><img src="/img/ajax-loader.gif" /></div>
	<div class="ui-widget" id="invite_form">
	<form id="invite_a_friend_form" action="" onsubmit="return false;">
	<label>Friends' Email Addresses (seperated by commas): </label><input type="text" name="friends_email" style="width:319px" id="friends_email"/>
	<label>Message:</label><textarea name="message" id="invite_message" style="height:400px; width:323px">Hello Friend!
	I know your a collector like I am and so I wanted to share this exciting collector focused website with you. I started using it for my collection and I love it. You can inventory, value and manage your collection for FREE!  KLECT allows you to identify and filter to find your items quickly, that includes stock photos. When you add to your collection, you can assign condition, add personal notes and more. The Marketplace allows us to find items that you are looking for and buy them from other collectors.
	If you want to upgrade for a subscription, it is as low as $2.00 per month, and you get to post up to 20 items at a time for sale on the Marketplace and you get to post personal custom images to all of your collection.

	KLECT continues to grow in both depth of our collection and users so I hope you enjoy it too.

	Again, it is free to use and lots of fun!

www.klect.com
	
Sincerely,
<?=$this->phpsession->get('personVO')->getFname();?>
	</textarea>
	</form>
	<div id="message_sent" style="color: red; text-align: center; margin-top: 23px; display:none">Your friend has been sent the message.</div>
</div>
</div>
<script>
	$("#invite_a_friend-div").dialog({
		autoOpen: false,
		height: 550,
		width: 350,
		modal: true,
		resizable: false,
		buttons: {
			'Send Invite': function() {
				$(".ui-dialog-buttonpane button:contains('Send Invite')").hide();
				$("#process_message").show();
				$("#invite_form").hide();
				
				$.post(getBaseURL()+"/social/invite_a_friend", $("#invite_a_friend_form").serialize(),
					function (data)
					{
						if(data.success)
						{
							$("#process_message").hide();
							$("#message_sent").show();
						}
						else
						{
							$("#process_message").hide();
							$(".ui-dialog-buttonpane button:contains('Send Invite')").show();
							$("#invite_form").show();
						}
						
					}, "json");
				
			}
			,Close: function() {
				$(this).dialog('close');
				$("#message_sent").hide();
				$("#invite_form").show();
				$(".ui-dialog-buttonpane button:contains('Send Invite')").show();
				$("#invite_message").val("");
				$("#friends_email").val("");
				
				return false;
			}
		},
		close: function() {
			
		}
	});

	$('#inviteafriend_btn').click(function() { $('#invite_a_friend-div').dialog('open'); return false;});	
</script>
