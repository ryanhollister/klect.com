<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once('item_model.php');
class Sale_model extends Item_model {
	
	/**
	Submits a sale to the system or updates and existing sale if a saleId is specified
	**/
	function submit_sale()
	{
		$saleId = (int)$this->input->post('saleId');
		$price = $this->input->post('price');
		
		//check that price is a good dollar amount
		if (!is_numeric($price))
		{
			echo "-1";
			return;
		}
		
		$desc = $this->input->post('desc');
		$paypal = (bool)$this->input->post('paypal');
		$money = (bool)$this->input->post('moneyorder');
		$oi_id = (int)$this->input->post('oi_id');
		$person_id = (int)$this->phpsession->get('personVO')->getPerson_id();
		$mysqltime = date ("Y-m-d H:i:s");
		
		require_once APPPATH.'models/VOs/SaleVO'.EXT;
		
		$saleVO = new SaleVO();
		
		// If a saleId is specified then we are updating an existing sale.
		if ($saleId !== '')
		{
			$saleVO->setSaleId($saleId);
			$saleVO->Load();
		}
		
		$saleVO->setPrice($price);
		$saleVO->setDescription($desc);
		$saleVO->setPaypal($paypal);
		$saleVO->setMoneyorder($money);
		$saleVO->setOwned_item_id($oi_id);
		$saleVO->setSellerId($person_id);
		$saleVO->setList_date($mysqltime);
		
		// if the seller submitted a custom picture
		if ($this->input->post('filename') != "stock" && $this->input->post('filename') != $saleVO->getCustomImg() && ($this->input->post('filename') != 'custom'))
		{
			$this->load->library('image_lib');
			
			
			$config['image_library'] = 'gd2';
			$config['source_image'] = './img/'.$this->phpsession->get('current_domain')->getTag().'/uploads/'.$this->input->post('filename');

			//initialize first to get the dimensions
			$this->image_lib->initialize($config);
			$config['width'] = "200";
			$config['maintain_ratio'] = TRUE;
			
			//load width and ratio setting to resize image to 200px wide
			$this->image_lib->initialize($config);
			$this->image_lib->resize();
			$this->image_lib->clear();
			
			$config = array();
			$config['image_library'] = 'gd2';
			$config['quality'] = "25%";
			$config['source_image'] = './img/'.$this->phpsession->get('current_domain')->getTag().'/uploads/'.$this->input->post('filename');
			$config['new_image'] = './img/'.$this->phpsession->get('current_domain')->getTag().'/customs/'.$this->input->post('filename');
			
			//begin configuration for cropping
			if($this->input->post('x1') != "")
			{
				$config['x_axis'] = $this->input->post('x1');
				$config['y_axis'] = $this->input->post('y1');
				$config['width'] = $this->input->post('w');
				$config['height'] = $this->input->post('h');
				$config['maintain_ratio'] = FALSE;
			}
			else
			{
				$config['maintain_ratio'] = TRUE;
			}
			
			$this->image_lib->initialize($config);
			
			if ( !$this->image_lib->crop())
			{
			    echo $this->image_lib->display_errors();
			    return;
			}
			else
			{
				//save custom image filename and delete original uploaded pic
				$saleVO->setCustomImg($this->input->post('filename'));
				//unlink('./img/'.$this->phpsession->get('current_domain')->getTag().'/uploads/'.$this->input->post('filename'));
			}
		}
		// User has the option of using their custom catalog picture for the sale.
		elseif ($this->input->post('filename') == 'custom')
		{
			$oiVO = $this->getOwnedItems(array($oi_id), false, false, true);
			$oiVO = current($oiVO);
			$saleVO->setCustomImg($oiVO->getCustImg());
		}
		else
		{
			$saleVO->setCustomImg('stock');
		}
		
		$ret =  $saleVO->Save();
		
		// if save was successful
		if ($ret > 0)
		{
			// Only send wish list notifications if this is a new listing, not an edit.
			if ($saleId == '')
			{
				$this->send_wishlist_emails($oi_id);
			}
			echo $saleVO->getSaleId();
		}
		else
		{
			echo "-1";
		}
	}
	
	/**
	 * Returns the applicable sales information for an item that has not sold.
	 */
	public function get_sale_info()
	{
		$saleId = $this->input->post('saleid');
		$this->db->select('s.saleId, per.username, i.item_id, s.description as list_description, s.price, m.name as manufacturer, s.list_date, s.paypal, s.moneyorder, oi.owned_item_id, i.name, s.sellerId, i.catalog_description, p.filename, oi.description, oi.condition, i.general_attribute, s.custImg');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'oi.item_item_id=i.item_id');
		$this->db->join('pictures p', 'p.item_id=i.item_id', 'left');
		$this->db->join('manufacturer m', 'm.manufacturer_id=i.manufacturer_id');
		$this->db->join('person per', 's.sellerId=per.person_id');
		$this->db->where('s.saleId',$saleId);
		$query = $this->db->get('sales s');
		$row = $query->row();
		
		$row->list_date = date("m/d/Y", strtotime($row->list_date));
		
		$methods = array();
		if($row->paypal == '1')
		{
			$methods[] = 'Paypal';
		}
		
		if($row->moneyorder == '1')
		{
			$methods[] = 'Money Order';
		}
		
		$row->methods = implode(', ', $methods);
		
		unset($row->paypal);
		unset($row->moneyorder);
		
		$attrArray = array();
		$this->db->select('iv.value, vl.label');
		$this->db->join('value_label vl', 'iv.level=vl.level', 'left');
		$this->db->where('iv.item_id', $row->item_id);
		$this->db->where('iv.level', $row->condition);
		$query = $this->db->get('item_value iv');
		
		// Were any values found?
		if ($query->num_rows > 0)
		{
			foreach ( $query->result() as $row2 )
			{
					$attrArray['value'] = $row2->value;
					$attrArray['label'] = $row2->label;
			}
		}
		// If not, return an "Unknown Value"
		else
		{
			$this->db->select('vl.label');
			$this->db->where('vl.level', $row->condition);
			$query = $this->db->get('value_label vl');
			
			$row2 = $query->row();
			
			$attrArray['value'] = 'Unknown Value';
			$attrArray['label'] = $row2->label;
		}
		$obj_merged = (object) array_merge((array) $row, (array) $attrArray);
		
		
		$attrArray2 = array();
		$sql = "SELECT da.text, ia.value, da.domain_attribute_id FROM domain_attribute da JOIN item_attribute ia ON ia.domain_attribute_id=da.domain_attribute_id JOIN owned_item oi ON oi.item_item_id=ia.item_id JOIN item i ON i.item_id=oi.item_item_id WHERE oi.owned_item_id=$row->owned_item_id";
		$query = $this->db->query($sql);
		$attrStr = '';
		foreach ( $query->result() as $row3 )
		{
			$attrStr .= '<br/>'.$row3->text.': <div id="catalog_attribute_'.$row3->domain_attribute_id.'" class="catalog_div" style="text-transform:capitalize">'.$row3->value.'</div>';
		}
		$obj_merged->item_attributes = $attrStr;
		
		return $obj_merged;
	}
	
	/**
	 * Returns the applicable sales information for an item that has sold but is not resolved.
	 */
	public function get_pending_sale_info()
	{
		$saleId = $this->input->post('saleid');
		$personId = $this->phpsession->get('personVO')->getPerson_id();
		$this->db->select('s.saleId, per.username as sellerUsername, per.email as sellerEmail, i.item_id, s.description as list_description, s.price, m.name as manufacturer, s.list_date, s.paypal, s.moneyorder, oi.owned_item_id, i.name, i.catalog_description, p.filename, oi.description, oi.condition, i.general_attribute, s.custImg, s.shipped, s.resolved');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'oi.item_item_id=i.item_id');
		$this->db->join('pictures p', 'p.item_id=i.item_id', 'left');
		$this->db->join('manufacturer m', 'm.manufacturer_id=i.manufacturer_id');
		$this->db->join('person per', 's.sellerId=per.person_id');
		$this->db->where('s.saleId',$saleId);
		$this->db->where('(s.sellerId = '.$personId.' OR s.buyerId = '.$personId.')');
		$this->db->where('s.resolved', '0');
		$query = $this->db->get('sales s');
		$row = $query->row();
		
		$row->list_date = date("m/d/Y", strtotime($row->list_date));
		
		$methods = array();
		if($row->paypal == '1')
		{
			$methods[] = 'Paypal';
		}
		
		if($row->moneyorder == '1')
		{
			$methods[] = 'Money Order';
		}
		
		$row->methods = implode(', ', $methods);
		
		unset($row->paypal);
		unset($row->moneyorder);
		
		$this->db->select('per.email as buyerEmail, per.username as buyerUsername');
		$this->db->join('person per', 's.buyerId=per.person_id');
		$this->db->where('s.saleId',$saleId);
		$this->db->where('s.resolved', '0');
		$this->db->where('(s.sellerId = '.$personId.' OR s.buyerId = '.$personId.')');
		$query = $this->db->get('sales s');
		
		// Were any values found?
		if ($query->num_rows > 0)
		{
			$buyerInfo = $query->row();
			$obj_merged = (object) array_merge((array) $row, (array) $buyerInfo);
		}

		$sql = "SELECT da.text, ia.value, da.domain_attribute_id FROM domain_attribute da JOIN item_attribute ia ON ia.domain_attribute_id=da.domain_attribute_id JOIN owned_item oi ON oi.item_item_id=ia.item_id JOIN item i ON i.item_id=oi.item_item_id WHERE oi.owned_item_id=$row->owned_item_id";
		$query = $this->db->query($sql);
		$attrStr = '';
		foreach ( $query->result() as $row3 )
		{
			$attrStr .= '<br/>'.$row3->text.': <div id="catalog_attribute_'.$row3->domain_attribute_id.'" class="catalog_div" style="text-transform:capitalize">'.$row3->value.'</div>';
		}
		$obj_merged->item_attributes = $attrStr;
		
		return json_encode($obj_merged);
	}
	
	/**
	 * Get TOP 10 recent sales for the current user.
	 */
	function get_persons_recent()
	{
		$this->db->limit(10);
		$this->db->select('s.owned_item_id');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where('s.sellerId', $this->phpsession->get('personVO')->getPerson_id());
		$this->db->where('comp_date IS NOT NULL');
		$this->db->where('buyerId IS NOT NULL');
		
		$query = $this->db->get('sales s');
		
		$retVal = array();
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$retVal[] = $row->owned_item_id;
			}
			return $this->getOwnedItems($retVal);
		}
		return array();	
	}
	
	/**
	 * Get all pending sales for the current user.
	 */
	function get_persons_sales_id($active = true)
	{
		$this->db->select('s.owned_item_id, s.resolved');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where('s.sellerId', $this->phpsession->get('personVO')->getPerson_id());
		
		if($active)
		{	
			$this->db->where('comp_date IS NULL');
			$this->db->where('buyerId IS NULL');
		}
		else
		{
			$this->db->where('comp_date IS NOT NULL');
			$this->db->where('buyerId IS NOT NULL');
			$this->db->where('resolved', '0');
		}
		
		$query = $this->db->get('sales s');
		
		//echo $this->db->last_query();
		
		$retVal = array();
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$retVal[$row->owned_item_id] = $row->resolved;
			}
			return $retVal;
		}
		return array();	
	}
	
	function get_persons_active()
	{
		$person_items = $this->getPersonsItems();
		$person_sales = $this->get_persons_sales_id(true);
		
		return array_intersect_key($person_items, $person_sales);
	}
	
	function get_persons_pending()
	{
		$person_items = $this->getPersonsItems();
		$person_sales = $this->get_persons_sales_id(false);
		
		return array_intersect_key($person_items, $person_sales);
	}
	
	function get_oi_to_sale_map()
	{
		$this->db->select('s.owned_item_id, s.saleId');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where('s.sellerId', $this->phpsession->get('personVO')->getPerson_id());
		
		$query = $this->db->get('sales s');
		
		$retVal = array();
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$retVal[$row->owned_item_id] = $row->saleId;
			}
			return $retVal;
		}
		return array();	
	}
	
	/**
	 *  Gets all items available for sale for the current user
	 */
	
	function get_persons_sellables()
	{
		$person_items = $this->getPersonsItems(false, false, true);
		$person_sales = $this->get_persons_sales_id();
		
		//A person can only sell items that are in their collection and not currently for sale
		return array_diff_key($person_items, $person_sales);
	}
	
	/**
	 * Handle the XHR upload request and return the results 
	 * 
	 * @param string $filename
	 */
	function upload_sale_pic($filename)
	{
		require_once APPPATH.'libraries/FileUploader'.EXT;
		$allowedExtensions = array("jpeg", "bmp", "jpg", "png", "gif");
		// max file size in bytes
		$sizeLimit = 6 * 1024 * 1024;
		
		$uploader = new FileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload('./img/'.$this->phpsession->get('current_domain')->getTag().'/uploads/', FALSE, $filename);
		// to pass data through iframe you will need to encode all html tags
		echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
	}
	
	private function send_sale_emails(SaleVO $saleVO)
	{
		/* @var $saleItemVO ItemVO */
		$saleItemVO = $this->getItems(array($saleVO->getOwned_item_id()), true);
		$saleItemVO = $saleItemVO[0];
		
		$saleName = $saleItemVO->getName();
		$saleId = $saleVO->getSaleId();
		
		$seller = $this->getSellerEmail($saleVO->getSaleId());
		$sellerEmail = $seller['email'];
		$sellerName = $seller['name'];
		/* @var $buyerVO PersonVO */
		$buyerVO = $this->phpsession->get('personVO');
		
		//Buyer's email
		$buyer_email = $this->phpsession->get('personVO')->getEmail();
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = FALSE;
		
		$this->email->initialize($config);

		$this->email->from('contact@klect.com', 'Klect.com');
		$this->email->to($buyerVO->getEmail());
		
		$this->email->subject('Klect.com - Your Purchase!');
		$message = <<<STRING
You have successfully bought $saleName, transaction : $saleId on the KLECT Marketplace!<br/>
The next steps for you is to arrange payment with the seller once they send you the total with shipping. If you do not hear from them in a reasonable time, please contact them at:<br/>
<br/>
Email: $sellerEmail<br/>
Shipping Name: $sellerName<br/>
<br/>
Once the seller has sent you the total, please provide your payment in a timely fashion. Once they receive payment and mark the item shipped, you will be able to see the update on the KLECT marketplace. Once you receive the item, mark it received and we will automatically update your inventory with the new item!<br/>
<br/>
Thank you for using KLECT.<br/>
STRING;
		$this->email->message($message, 'Congratulations!');
		
		$this->email->send($buyerVO->getEmail());
		
		//Seller's email
		$this->load->library('email');
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = FALSE;
		
		$this->email->initialize($config);

		$this->email->from('contact@klect.com', 'Klect.com');
		$this->email->to($sellerEmail);
		
		$this->email->subject('Klect.com - You Made a Sale!');
		
		
		$buyer_name = $buyerVO->getFname().' '.$buyerVO->getLname();
		$buyer_addr = $buyerVO->getAddr1().' '.$buyerVO->getAddr2();
		$buyer_city = $buyerVO->getCity();
		$buyer_state = $buyerVO->getState();
		$buyer_zip = $buyerVO->getZip();

		$message = <<<STRING
You have successfully sold your $saleName, Sale Id : $saleId on the KLECT Marketplace!<br/>
The next steps for you is to arrange payment and shipping with the buyer. Their contact information is :<br/>
<br/>
Email: $buyer_email<br/>
Shipping Name: $buyer_name<br/>
Shipping Address: $buyer_addr<br/>
Shipping City: $buyer_city<br/>
Shipping State: $buyer_state<br/>
Shipping Zip: $buyer_zip<br/>
<br/>
Please provide the buyer with the shipping and payment details.<br/>
<br/>
Once you have received payment, update the status of the sale in the Marketplace when you have shipped the item.  Updating will send an email to the buyer and once they receive the item and confirm, KLECT will automatically remove the item from your online inventory.<br/>
<br/>
Thank you for using KLECT.<br/>
STRING;
		$this->email->message($message, 'Congratulations!');
		
		$this->email->send();
	}
	
	public function getSellerEmail($saleId)
	{
		$this->db->select('email, first_name, last_name');
		$this->db->where('saleId', $saleId);
		$this->db->join('person p', 'p.person_id=s.sellerId');
		$query = $this->db->get('sales s');
		
		if($query->num_rows == 1)
		{
			$row = $query->result();
			return array('email' => $row[0]->email, 'name' => $row[0]->first_name.' '.$row[0]->last_name);
		}
		else
		{
			return '';
		}
	}
	
	public function getBuyerEmail($saleId)
	{
		$this->db->select('email');
		$this->db->where('saleId', $saleId);
		$this->db->join('person p', 'p.person_id=s.buyerId');
		$query = $this->db->get('sales s');
		
		if($query->num_rows == 1)
		{
			$row = $query->result();
			return $row[0]->email;
		}
		else
		{
			return '';
		}
	}
	
	public function delete_sale()
	{
		require_once APPPATH.'models/VOs/SaleVO'.EXT;
		$saleId = $this->input->post('saleId');
		$saleVO = new SaleVO($saleId);
		$saleVO->Load();
		
		if ($saleVO->getCustomImg() != "stock")
		{
			unlink('./img/'.$this->phpsession->get('current_domain')->getTag().'/customs/'.$saleVO->getCustomImg());	
		}
		
		return $this->db->delete('sales', array('saleId' => $saleId));
	}
	
	public function mark_as_shipped()
	{	
		$saleId = $this->input->post('saleId');
		
		/* @var $saleVO SaleVO */
		require_once APPPATH.'models/VOs/SaleVO'.EXT;
		$saleVO = new SaleVO($saleId);
		$saleVO->Load();
		
		/* @var $saleItemVO ItemVO */
		$saleItemVO = $this->getItems(array($saleVO->getOwned_item_id()), true);
		$saleItemVO = $saleItemVO[0];
		
		$saleVO->setShipped(true);
		
		if($saleVO->Save())
		{
			//Buyer's email
			$this->load->library('email');
			
			$config['mailtype'] = 'html';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = FALSE;
			
			$this->email->initialize($config);
	
			$this->email->subject('Klect.com - Your Item Has Shipped!');
			$this->email->from('contact@klect.com', 'Klect.com');
			$this->email->to($this->getBuyerEmail($saleVO->getSaleId()));
			
			$saleName = $saleItemVO->getName();
			$saleId = $saleVO->getSaleId();
			
			/* @var $sellerVO PersonVO */
			$sellerVO = $this->phpsession->get('personVO');
			$seller_name = $sellerVO->getFname().' '.$sellerVO->getLname();
			
			$message = <<<STRING
This email is to update you on your recent purchase of $saleName, Sale ID: $saleId.  $seller_name has updated that they have shipped your item. Once you receive it, click on the receipt button and your inventory will be automatically updated!<br/>
<br/>
Should you not receive your item in the expected time frame, or have any issues with the item, please contact the seller directly.<br/>
<br/>
Thank you for using KLECT!<br/>
STRING;

			$this->email->message($message);
		
			$this->email->send();
			return true;
		}
		else
		{
			return false;
		}

	}
	
	// function to send emails to people when an item in their wishlist becomes listed.
	function send_wishlist_emails($oi_id)
	{
		$item_name = $this->input->post('sale_item_name');
		$subject = "$item_name just was posted for sale on KLECT.com!";
		$message = <<<STRING
This is an automated email to alert you that one of the items on your wishlist has just come up for sale on the KLECT Marketplace!<br/>
Login in and buy the item before someone else does, and keep your wishlist updated and full!<br/>
<br/>
Thank you for using KLECT.<br/>
STRING;

		$this->db->select('p.email as email');
		$this->db->where('oi.owned_item_id', $oi_id);
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->join('wish_list w', 'w.item_id=i.item_id');
		$this->db->join('person p', 'w.person_id=p.person_id');
		$query = $this->db->get('owned_item oi');
		
	
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$emails[] = $row->email;
			}
		
			if (count($emails) > 0)
			{
				$this->load->library('email');
				
				$config['mailtype'] = 'html';
				$config['charset'] = 'iso-8859-1';
				$config['wordwrap'] = FALSE;
				
				$this->email->initialize($config);
		
				$this->email->subject($subject);
				$this->email->from('contact@klect.com', 'Klect.com');
				$this->email->bcc($emails);
				$this->email->message($message, 'Good News!');
				$this->email->send();
			}
		}
		return;
	}
	
	function delete_pending_sales()
	{
		$this->db->where('comp_date IS NULL');
		$this->db->where('buyerId IS NULL');
		$this->db->where('sellerId' , $this->phpsession->get('personVO')->getPerson_id());
		return $this->db->delete('sales');
	}
	
	/**
	 * After a successful sale, move the owned item from the sell to the buyer
	 * 
	 * @param saleVO $saleVO
	 */
	private function move_sale($saleVO)
	{
		$this->db->where('owned_item_id', $saleVO->getOwned_item_id());
		$this->db->where('person_id', $saleVO->getSellerId());
		return $this->db->update('owned_item', array('person_id' => $this->phpsession->get('personVO')->getPerson_id()));
	}
}
