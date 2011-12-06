<?php

class Site extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('domain_model');
	}
	
	/**
	 * Controller for 404 of KLECT.com
	 * 
	 * @param array $data used to pass data on a redirect or logout
	 */
	function page_not_found()
	{
		$data['main_content'] = 'index';
		$data['page_title'] = 'KLECT - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'main';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['js_includes'][] = 'login';
		$data['js_includes'][] = 'signup';
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);
		
		$person_id = (isset($this->phpsession) && $this->phpsession->get('is_logged_in')) ? $this->phpsession->get('personVO')->getPerson_id() : "Not Logged In";
		
		// By default we log this, but allow a dev to skip it
		log_message('error', "404 Page Not Found --> URI String: ".$this->uri->uri_string()." Person Id: ".$person_id." IP: ".$_SERVER['REMOTE_ADDR']);
		
		$data['content_right']['404 Page Not Found'] = "<br/><br/><br/><br/><br/><br/>&nbsp;&nbsp;&nbsp;&nbsp;Sorry this page is not present.<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>";
		$data['logged_in'] = $this->phpsession->get('is_logged_in'); 
		$this->load->view('includes/klect_template', $data);		
	}
	
	/**
	 * Controller for index of KLECT.com
	 * 
	 * @param array $data used to pass data on a redirect or logout
	 */
	function index($data = array())
	{
		$data['main_content'] = 'index';
		$data['page_title'] = 'KLECT - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'main';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['js_includes'][] = 'login';
		$data['js_includes'][] = 'signup';
		$data['available_collections'] = $this->domain_model->getAllCollections();
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);
		
		$data['content_right']['WELCOME TO KLECT'] = $this->load->view('static/index', $data, true);
		$data['logged_in'] = $this->phpsession->get('is_logged_in'); 
		$this->load->view('includes/klect_template', $data);		
	}
	
	/**
	 * About Us page controller
	 * 
	 * @param array $data data to be persisted on a redirect or log out
	 */
	function about_us($data = array())
	{
		$data['main_content'] = 'index';
		$data['page_title'] = 'Welcome to Klect.com - About Us - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'] = array('login', 'signup');
		$data['js_includes'][] = 'main';
		$data['js_includes'][] = 'jquery-ui-1.8.5.custom.min';
		$data['css_includes'][] = 'ui-lightness/jquery-ui-1.8.5.custom';
		$data['available_collections'] = $this->domain_model->getAllCollections();
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);
		
		$data['content_right']['About Us'] = $this->load->view('static/about_us', $data, true);
		$data['logged_in'] = $this->phpsession->get('is_logged_in');
		$this->load->view('includes/klect_template', $data);
	}
	
	
	/**
	 * Contact Us page controller.
	 * 
	 * @param array $data data to be persisted on redirect or logout
	 */
	function contact_us($data=array())
	{
		$data['main_content'] = 'index';
		$data['page_title'] = 'Welcome to Klect.com - Contact Us - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'] = array('login', 'signup');
		$data['js_includes'][] = 'main';
		$data['js_includes'][] = 'jquery-ui-1.8.5.custom.min';
		$data['css_includes'][] = 'ui-lightness/jquery-ui-1.8.5.custom';
		$data['available_collections'] = $this->domain_model->getAllCollections();
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);
		
		$data['content_right']['Contact Us'] = $this->load->view('static/contact_us', $data, true);
		$data['logged_in'] = $this->phpsession->get('is_logged_in');
		$this->load->view('includes/klect_template', $data);
	}
	
	/**
	 * FAQ page controller
	 * 
	 * @param array $data data to be persisted on a redirect or log out
	 */
	function faq($data = array())
	{
		$data['main_content'] = 'index';
		$data['page_title'] = 'Welcome to Klect.com - FAQ - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'] = array('login', 'signup');
		$data['js_includes'][] = 'main';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['css_includes'][] = 'ui-lightness/jquery-ui-1.8.5.custom';
		$data['available_collections'] = $this->domain_model->getAllCollections();
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);		
		$data['content_right']['Frequently Asked Questions'] = $this->load->view('static/faq', $data, true);
		$data['logged_in'] = $this->phpsession->get('is_logged_in');
		$this->load->view('includes/klect_template', $data);
	}
	
	function news()
	{
		$data['main_content'] = 'index';
		$data['page_title'] = 'KLECT - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'][] = JQUERY_UI_JS;
		$data['js_includes'][] = 'main';
		$data['css_includes'][] = JQUERY_UI_CSS;
		$data['js_includes'][] = 'login';
		$data['js_includes'][] = 'signup';
		$data['available_collections'] = $this->domain_model->getAllCollections();
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);		
		$data['logged_in'] = $this->phpsession->get('is_logged_in');
		$data['content_right']['KLECT News'] = $this->load->view('static/news', $data, true);
		$this->load->view('includes/klect_template', $data);		
	}
	
	function blog()
	{
		$data['main_content'] = 'index';
		$data['page_title'] = 'Welcome to Klect.com - Contact Us - Where collectors inventory, value and trade stamps, coins, and so much more!';
		$data['js_includes'] = array('login', 'signup');
		$data['js_includes'][] = 'main';
		$data['js_includes'][] = 'jquery-ui-1.8.5.custom.min';
		$data['css_includes'][] = 'ui-lightness/jquery-ui-1.8.5.custom';
		$data['available_collections'] = $this->domain_model->getAllCollections();
		$data['content_left']['Events and Updates'] = $this->load->view('static/recent_news', $data, true);
		$blogs['entries']['20110724'] = array("author" => "Ryan Hollister", "title" => "KLECT Premium Membership", "height" => "825px",
		"content" => "
<p>I would like to take this opportunity to explain a young but important feature of our site, premium membership. When we first started developing KLECT we focused solely on the core features: collection management, wish list creation, and an extensive catalog. These features, wrapped in a secure, easy to use, and friendly interface took the better part of 6 months. I continue to focus on improving these features even as new features are rolled out. Once we had these features at a mature state we began working on more advanced features.</p>
<p>The first premium feature we rolled out was the KLECT marketplace. In this marketplace you are able to buy and sell your collectibles. Buying from the KLECT marketplace is free, all we require is a shipping address so the sellers know where to send your item. As a member, if you wish to sell one of your collectibles you are required to have a premium membership. Currently a KLECT premium membership is $6.00 a month or $24.00 every 6 months. We strongly believe this is an excellent value compare to the big player in this space, eBay. There are no insertion fees or final value fees. On top of the better price we believe our value is the selling format.</p> 
<p>Did you know, when you list an item in the KLECT marketplace, everyone who has that item on his or her wish list is notified of the new listing? With KLECT's advanced filtering system, users are able to quickly find the item they are looking for. There is no need to worry about misspellings or listing expirations either. You are able to leverage KLECT's extensive catalog and only need to fill in the details specific to your item. With a few clicks your item is visible in the KLECT marketplace!</p>
<p>The marketplace was the first premium feature, it was received well by out members and we currently have over 50 items listed in the marketplace with new ones being added each day. The latest feature we just rolled out for our premium members is custom images. KLECT's catalog is pretty extensive and is growing all the time. As we continue to add items to the marketplace, we try to keep up with the matching images. Unfortunately this isn't always possible. The custom images feature allows your upload your own images for your items. With a few clicks you can have KLECT's stock images replaced with your custom images. These images are visible only to you and are not shared with other members. Custom images can be uploaded for any of the items in KLECT's catalog, not just the ones without images. Custom images are a great way to put a personal touch to your collection.</p>
<p>Those are the two main features of premium membership today. We are quickly rolling out new features to make it even more of a value. We are honest and forth coming people, and want you to know canceling your membership at any time is even easier than subscribing. With one click your membership is cancel. No calling in and no minimum commitments. On top of that, we offer a free 30-day trial! What are you waiting for? Give the KLECT membership a try. In addition to getting those great features, you will also be supporting our continued growth :-)</p>");
		$blogs['entries']['20110710'] = array("author" => "Ryan Zintgraff", "title" => "One Year of KLECT", "height" => "900px",
		"content" => "
<p>Wow! One year flies by and what a year it has been. At this time last year we launched KLECT.com and debut the site at the My Little Pony fair in Louisville KY. At that time I showed up to a room full of passionate collectors, as an  outsider and  honestly just a bit nervous. Well that fist day went great as collectors realized that even if I am a stamp collector instead of a pony collector, the passion and commitment were the same, and that we had reflected that in our design. It also didn't hurt that i could cite my daughter and sister as collectors either. By the end of the weekend, 77 new accounts existed and we were underway. Also, I had made a new group of friends.</p>
<p>Over the next several months, we worked to add data.  We had gone live with only the G1 Ponies, about 400 or so.  Our site allowed you to build your collection, filter, identify and get a valuation. Not bad, but I knew we were going to do, and needed to do more. Our user base started to grow as users started telling others and we stared getting emails with ideas and suggestions. I was blown away when 3 months into it we started seeing accounts from users in other countries show up too! Keep on mind we haven't advertised, this was viral! The feedback we were getting too was great. We started surveying users on how we could make the site better, and which features should be next.  About 6 months later we had added both G3 and G4 data. We also launched the Marketplace, an addition that let's users post items for sale, and alerts potential buyers when it posts. Users liked the idea, but it wasn't an instant hit as we needed to add some additional features still. At that time, we also launched into the US Airmail and US Postage stamp communities.  I had the opportunity to debut that at the ASDA stamp show in New York, and since in some smaller regional shows. Our user base continued to grow!</p>
<p>This week, we added G2 data, again thanks to Summer, and added the user feedback feature so buyers and sellers could see ratings and help them decide in their purchase decisions.  We added custom photo option that premium members can use to upload their own images to their inventory. Superimposed initials on images in a members dashboard is also new and is a great help in quickly seeing the differences of your items. Our invite a friend was included to let users tell their friends and they will gain some referral points as we develop that further. Might be some free swag or even site credits.</p>
<p>So with all these new features, how are we doing? We broke past 1000 total users, over 51,000 inventories items and are starting to have more items posted in the Marketplace. More importantly, we continue to listen. This week at the 2011 MLP fair hosted at Hasbro, I had the chance to re-connect with so many of our users, meet new friends, bit also get some great feedback. As before, we will take all of this back to the lab and see how we can cook up more features that will continue to augment the collectors toolbox. I know, as a user too, I am excited about some of the ideas!</p>
<p>From a business perspective, we continue to operate as a start-up, but are looking for the right financial partner to help us grow. We. Also are looking to add more collection data to our existing communities, and look for collector communities to add to KLECT.  What an amazing first year. We couldn't have  had this without the support and help of our users and for that I say Thank You All!</p>");
		$blogs['entries']['20110411'] = array("author" => "Ryan Zintgraff", "title" => "ASDA Show in NYC", "height" => "754px",
		"content" => "
<p>I just am returning from having debuted KLECT at the 2011 American Stamp Dealers Show in New York City from April 6-10th and it was a great experience. KLECT was able to debut for stamp collectors and stamp dealers alike. Stamp collectors visiting our booth like that they do not have to download any software, and can do stamp inventory from their Mac/Apple, PC iPad or other devices that permit them web access! I personally was able to use it while I walked about the sales and using my KLECT Stamp dashboard, make sure I knew what to look for and not buy duplicates of things I already have. I think stamp collectors liked even more was the fact it is free to use for inventory management, general valuation of their collection and to find stamps they are looking for.</p>
<p>Many collectors took the time to walk through the simplicity of adding stamps to their collection, seeing how to make a wishilist and general review of stamp history and stamp facts. KLECT.com was a big hit with all the kids that came by as they can use it, with their parents permission, to learn and identify stamps and start a stamp collection. They also liked the small magnifiers I was handing out too. Parents liked that it is safe and secure, not allowing any chat or communications. The advanced philatelists recognized that KLECT helps bring stamp collecting to the next generation in familiar format and helps pass on the history and continue the philatelic community.</p>
<p>More senior Philatelists like that they can better understand the value of their collection and zero in on stamps they are looking for. Some great feedback was shared as KLECT currently has US Airmail and US Postage as single stamps. Quite a bit of interest was in adding Plate Block, line pairs and covers, servicing again, but the beginner and advanced philatelists. Stamp Collectors all genuinely wanted to know how KLECT could provide inventory management for free and when I explained that the $6 monthly subscription for users that want to post stamps for sale is how we run the site. Almost ever stamp collector that had ever posted stamps for sale on other site, recognized instantly that we offered a hassle free and direct approach with our flat fee subscription model.</p>
<p>KLECT is working to pilot a program with other ASDA dealers to provide a portal where dealers can bulk load listings of stamps they are selling, and therefore leverage the wishlist alerts and help stamp collectors find wanted stamps even faster and with more variety. Also, the ability to provide users with some new features since I got some great ideas from several stamp collectors that we will try and implement for them soon!</p>
<p>Overall, the show was great. I got to meet and get to know some great stamp dealers, ASDA members and stamp collectors from the beginning collector to some very knowledgeable and amazing philatelists. Thank you all for such a great time.</p>");
		$blogs['entries']['20110407'] = array("author" => "Ryan Hollister", "title" => "Welcome to the KLECT blog", "height" => "715px",
		"content" => "
<p>Thank you taking a moment to check out KLECT.com and even this first blog entry. My name is Ryan Hollister and I am the web developer of this site. Right now KLECT is a very barebones operation, with my partner Ryan Zintgraff and I wearing all the hats. As with any young business, we hope to some day move KLECT into an office and hire lots of smart people. Until those days arrive, we work from home in our spare time.</p>
<p>We decided to make KLECT because we saw a need and had a passion. The need was evident from the lack of modern software to manage and inventory the various collectables out there. The passion stemmed from being collectors ourselves. I would like to take this space as an informal way to explain what KLECT is today, what features we currently have and what features we plan to roll out in the coming months.</p>
<p>It is simple to create a KLECT account. You go to the home page and click the yellow \"Sign Up\" button and complete the requested field. That’s it. Once logged in, your current collection will be display. Obviously since it is your first time logging into the system it is empty. You can quickly add your collection by navigating to the \"Add Collection\" button on the right side bar. This page will present you with our current catalog. There are hundreds, and sometimes thousands, of items in our catalog. You can browse our catalog one page at a time by using the page navigation buttons at the top of the screen. If you would like to learn more about an item, simply click the magnifying glass in the bottom right corner of the item's image.</p>
<p>Browsing the catalog is fun but you often come looking for the specific items you own. This is where KLECT really shines. With our rapid filtering feature it is easy to find the item you are looking for, even if you do not know the specific name. Simply begin typing some of the attributes you know about the item you are looking for and hit enter. The listing of items on the left will quickly begin to diminish, leaving only the items that match your search.</p>
<p>You then click the item you wish to add to your collection, optionally add details about the item (condition, purchase price, date acquired, etc) and then hit \"Add Collection\". The blue check mark will turn green and you will be ready to add your next item.</p>
<p>Now what if you have LOTS of items? Well KLECT is perfect for you. The time it takes to build your collection in KLECT is unmatched. You can click unlimited items before hitting \"Add Collection\". Select 10, 20, 50, or more items and then hit \"Add Collection\". This will add all the selected items to your inventory. When you navigate back to your dashboard you will be presented with a beautiful display of your collection.</p>
<p>I hope this gives you a brief introduction to KLECT. Be sure to check back here often as I cover the other exciting features of KLECT.</p>
");
		
		$data['content_right']['KLECT Blog'] = $this->load->view('modules/blog_page', $blogs, true);
		$data['logged_in'] = $this->phpsession->get('is_logged_in');
		$this->load->view('includes/klect_template', $data);
	}
	
	function terms()
	{
		echo <<<STRING
KLECT Corp. is a web-based service that allows members to inventory and manage collectable items that they value. The services offered by KLECT include the website and any other features, content, or applications offered from time to time by KLECT in connection with the KLECT Website. The KLECT Services are hosted in the U.S.
This Terms of Use Agreement ("Agreement") sets forth the legally binding terms for your use of the KLECT Services. By using the KLECT Services, you agree to be bound by this Agreement, whether you are a "Member" (which means that you register for use of inventory management and purchasing) or you are a "Subscriber" (which means that you have registered with KLECT as a paid subscriber for an premium service account). The term "User" refers to a Visitor or a Subscriber. You are only authorized to use the KLECT system (regardless of whether your access or use is intended) if you agree to abide by all applicable laws and to this Agreement. Please read this Agreement carefully and save it. If you do not agree with it, you should leave the KLECT Website and discontinue use of the KLECT  Services immediately. If you wish to become a Subscriber,you must read this Agreement and indicate your acceptance during the Registration process.
KLECT may modify this Agreement from time to time and such modification shall be effective upon posting by KLECT Corp on the KLECT Website. You agree to be bound to any changes to this Agreement when you use the KLECT Services after any such modification is posted. It is therefore important that you review this Agreement regularly to ensure you are updated as to any changes.
Eligibility. Use of and Subscribership in the KLECT Services is void where prohibited. By using the KLECT Services, you represent and warrant that (a) all registration information you submit is truthful and accurate; (b) you will maintain the accuracy of such information; (c)  your use of the KLECT Services does not violate any applicable law or regulation. Your profile may be deleted and your Subscribership may be terminated at any time without warning and in our sole discretion, if we believe that you are in violation of any of these terms.
Term. This Agreement shall remain in full force and effect while you use the KLECT Services or are a Subscriber. You may terminate your Subscribership at any time, for any reason, by following the instructions on the Subscriber's Account Settings page. KLECT Corp. may terminate your Subscribership at any time, without warning. Even after Subscribership is terminated, this Agreement will remain in effect.
Fees. You acknowledge that KLECT reserves the right to charge for the KLECT Premium Services and to change its fees from time to time in its discretion. If KLECT terminates your Subscribership because you have breached the Agreement, you shall not be entitled to the refund of any unused portion of subscription fees.
Password. When you sign up to become a User, you will also be asked to choose a password. You are entirely responsible for maintaining the confidentiality of your password. You agree not to use the account, username, or password of another User at any time or to disclose your password to any third party. You agree to notify KLECT  immediately if you suspect any unauthorized use of your account or access to your password. You are solely responsible for any and all use of your account.
Non-commercial Use by Users. The KLECT Services are for the personal use of Users only and may not be used in connection with any commercial endeavors except those that are specifically endorsed or approved by KLECT Corporation. Illegal and/or unauthorized use of the KLECT Services, including collecting usernames and/or email addresses of Users  by electronic or other means for the purpose of sending unsolicited email or unauthorized framing of or linking to the KLECT Website is prohibited. Commercial advertisements, affiliate links, and other forms of solicitation may be removed from User profiles without notice and may result in termination of User privileges. Appropriate legal action will be taken for any illegal or unauthorized use of the KLECT Services.
Personal Use of Information Only. You may make personal use of all of the information ("Information") you access or receive on or through the KLECT Website and Services, but you may not take any of the Information and reformat and display it, or copy it on your or any other Web site, and you may not store or migrate any of the Information or other data from KLECT without KLECT's written permission. By using the Service, you agree not to sell, store, distribute, transmit, display, reproduce, modify, migrate, create derivative works from, or otherwise exploit any of the Information content or data related to any portion of the Service. You may print a copy of particular item values and prices and, subject to the disclaimers set forth elsewhere in this Agreement, use the Information for your personal, non-commercial use, but you may not otherwise reproduce any material appearing on or through the KLECT Website and Services. If you want to make commercial use of the Information, you must enter into an agreement with us to do so in advance of such use.
 <br/><br/>
Use Restrictions. You agree that you will use the KLECT Website and KLECT Services in compliance with all applicable local, state, national, and international laws, rules and regulations, including any laws regarding the transmission of technical data exported from your country of residence. You shall not, shall not agree to, and shall not authorize or encourage any third party to: (i) use the KLECT Website to upload, transmit or otherwise distribute any content that is unlawful, defamatory, libelous, harassing, abusive, fraudulent, obscene, contains viruses, or is otherwise objectionable as determined by KLECT Corp.; (ii) upload, transmit or otherwise distribute content that infringes upon another party's intellectual property rights or other proprietary, contractual or fiduciary rights or obligations; (iii) prevent others from using the KLECT Website; or (iv) use the KLECT Website for any fraudulent or inappropriate purpose. Violation of any of the foregoing may result in immediate termination of this Agreement, and may subject you to state and federal penalties and other legal consequences. KLECT reserves the right, but shall have no obligation, to investigate your use of the KLECT Website in order to determine whether a violation of the Agreement has occurred or to comply with any applicable law, regulation, legal process or governmental request.
Content Posted. KLECT may delete any Content that in the sole judgment of KLECT violates this Agreement or which may be offensive, illegal or violate the rights, harm, or threaten the safety of any person. KLECT assumes no responsibility for monitoring the KLECT Services for inappropriate Content or conduct. 
Subscriber Disputes. You are solely responsible for your interactions with other KLECT Users. KLECT reserves the right, but has no obligation, to monitor disputes between you and other Users.
Privacy. Use of the KLECT Services is also governed by our Privacy Policy, which is incorporated into this Agreement by this reference.
ITEM VALUATIONS ARE OPINIONS AND MAY VARY FROM ITEM TO ITEM. ACTUAL VALUATIONS ARE BASED UPON CURRENT AVAILABLE INFORMATION AND ANALYSIS OF MARKET CONDITIONS, AND WILL VARY DEPENDING ON SPECIFICATIONS, ITEM CONDITION OR OTHER PARTICULAR CIRCUMSTANCES PERTINENT TO A PARTICULAR ITEM OR THE TRANSACTION OR THE PARTIES TO THE TRANSACTION. KLECT  ASSUMES NO RESPONSIBILITY FOR THE ACCURACY OF ITEM VALUES AND NO RESPONSIBILITY FOR ERRORS OR OMISSIONS.
 <br/><br/>
Limitation on Liability. IN NO EVENT SHALL KLECT CORPORATION OR ITS LICENSORS BE LIABLE TO YOU OR ANY THIRD PARTY FOR ANY DIRECT, INDIRECT, CONSEQUENTIAL, EXEMPLARY, INCIDENTAL, SPECIAL OR PUNITIVE DAMAGES, INCLUDING LOST PROFIT DAMAGES ARISING FROM YOUR USE OF THE SERVICES, EVEN IF KLECT CORPORATION HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES. NOTWITHSTANDING ANYTHING TO THE CONTRARY CONTAINED HEREIN, KLECT'S LIABILITY TO YOU FOR ANY CAUSE WHATSOEVER AND REGARDLESS OF THE FORM OF THE ACTION, WILL AT ALL TIMES BE LIMITED TO THE AMOUNT PAID, IF ANY, BY YOU TO KLECT FOR THE KLECT SERVICES DURING THE TERM OF MEMBERSHIP.
Disputes. If there is any dispute about or involving the KLECT Services, you agree that the dispute shall be governed by the laws of the State of Texas, USA, without regard to conflict of law provisions and you agree to exclusive personal jurisdiction and venue in the state and federal courts of the United States located in the State of Texas, City of Austin.
 <br/><br/>
Please contact us at: contact@klect.com  with any questions regarding this Agreement.
 <br/><br/>
 <br/><br/>
This Terms of Use Agreement for KLECT.com set forth the legally binding terms for your use of the KLECT premium member Service. If you wish to become a Subscriber you must read this document and indicate your acceptance.
 <br/><br/>
KLECT Premium Service
The features of the KLECT Premium Service are described here and may change from time to time in KLECT's sole discretion, without notice.
 <br/><br/>
Payment
By agreeing to these KLECT's Premium Service Terms, you are expressly agreeing that we are authorized to charge you a monthly (or biannual or annual, as elected by you) subscription fee, any applicable tax and any other charges you may incur in connection with your use of the KLECT Premium Service through the payment method ("Payment Method") you provided during registration and which we support. Current subscription fees are posted on our KLECT site under FAQ's. 
 <br/><br/>
Ongoing Subscription / Automatic Renewal
The KLECT Premium Service subscription fee will be billed at the beginning of your subscription and on each automatic monthly (or biannual or annual, if bi/annual subscription is elected at registration) renewal thereafter unless and until you cancel your subscription as provided below. We will automatically bill your Payment Method each month (or period based on selection elected at registration) on the calendar day corresponding to the commencement of your subscription. In the event your subscription began on a day not contained in a given month, we will bill your Payment Method on the last day of such month. For example, if you became a paying subscriber on a monthly basis on October 31st, your Payment Method would next be billed on November 30th.
 <br/><br/>
All fees and charges are charged in advance and nonrefundable and there are no refunds or credits for partially used periods. We may change the fees and charges in effect, or add new fees and charges from time to time, but we will give you advance notice of these changes by email. If you want to use a different Payment Method or if there is a change in your credit card validity or expiration date, you may edit your Payment Method information through the third party payment processor. If your Payment Method reaches its expiration date, your continued use of the service constitutes your authorization for us to continue billing that Payment Method and you remain responsible for any uncollected amounts. 
 <br/><br/>
Cancellation
As stated above, your KLECT Premium Service subscription will continue in effect unless and until you cancel your subscription or we terminate it. You must cancel your subscription before it renews each month (or each renewal period based on subscription elected at registration) in order to avoid billing of the next period's subscription fees to your Payment Method. 
 <br/><br/>
You may cancel your KLECT Premium Service subscription at any time, and cancellation will be effective immediately. WE DO NOT PROVIDE REFUNDS OR CREDITS FOR ANY PARTIAL-MONTH SUBSCRIPTION PERIODS.
<br/><br/>
To cancel, send us an email with your username to service@klect.com requesting for your KLECT Premium Service subscription to be canceled.
<br/><br/>
KLECT reserves the right to terminate your subscription for any or no reason.<br/>
STRING;
	}
}
