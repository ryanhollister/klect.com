<?php
include_once('item_model.php');
class Buy_model extends Item_model {
	
	/**
	 * Returns only the KLECT catalog details of the item.
	 */
	public function get_market_info($item_id)
	{
		// get standard item information
		$this->db->select('m.name as manufacturer, i.name, i.catalog_description, p.filename, i.general_attribute');
		$this->db->join('manufacturer m', 'm.manufacturer_id=i.manufacturer_id');
		$this->db->join('pictures p', 'p.item_id=i.item_id', 'left');
		$this->db->where('i.item_id', $item_id);
		$query = $this->db->get('item i');
		$row = $query->row();
		
		// Get the items value based on the entered condition
		$attrArray = array();
		$this->db->select('iv.value,vl.label');
		$this->db->join('value_label vl', 'iv.level=vl.level', 'left');
		$this->db->where('iv.item_id', $item_id);
		$query = $this->db->get('item_value iv');
		
		if ($query->num_rows > 0)
		{
			foreach ( $query->result() as $row2 )
			{
					$attrArray['value'] = $row2->value;
					$attrArray['label'] = $row2->label;
			}
		}
		
		// Add the item's value based on condition to the previous result set.
		$obj_merged = (object) array_merge((array) $row, (array) $attrArray);
		
		// Get the domain details of the item.
		$attrArray2 = array();
		$this->db->select('da.text, ia.value');
		$this->db->join('domain_attribute da', 'da.domain_attribute_id=ia.domain_attribute_id');
		$this->db->where('ia.item_id', $item_id);
		$query = $this->db->get('item_attribute ia');
		foreach ( $query->result() as $row3 )
		{
			$attrArray2[$row3->text] = $row3->value;
		}
		
		// Add the item's domain details to the previous result set.
		$obj_merged = (object) array_merge((array) $obj_merged, (array) $attrArray2);
		
		// Get the market info for this current item
		$this->db->select('COUNT(s.saleId) as count, AVG(s.price) as avg, MIN(s.price) as min, MAX(s.price) as max');
		$this->db->join('owned_item oi', 'oi.item_item_id=i.item_id');
		$this->db->join('sales s', 's.owned_item_id=oi.owned_item_id');
		$this->db->where('i.item_id', $item_id);
		$query = $this->db->get('item i');
		$row = $query->row(); 
		$row->avg = number_format($row->avg, 2);
		$row->min = number_format($row->min, 2);
		$row->max = number_format($row->max, 2);
		
		return (object) array_merge((array) $obj_merged, (array) $row);
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
	
	/**
	 * Get all open sales with an option to return only open sales for a specified item.
	 * 
	 * @param int $item_id
	 */
	function get_open_sales($item_id = false, $filters = false)
	{
		$person_id = $this->phpsession->get('personVO')->getPerson_id();
		$this->db->select('oi.item_item_id');
		$this->db->join('owned_item oi', 's.owned_item_id=oi.owned_item_id');
		$this->db->join('item i', 'oi.item_item_id=i.item_id');
		$this->db->where('comp_date IS NULL');
		$this->db->where('buyerId IS NULL');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		
		switch ($filters)
		{
			case 'wishlist':
				$this->db->join('wish_list w', 'w.item_id=i.item_id');
				$this->db->where('w.person_id', $person_id);
				break;
			
			case 'unowned':
				$this->db->where('i.item_id NOT IN (select item_item_id FROM owned_item WHERE person_id='.$person_id.')');
				break;
		}
		
		if ($item_id)
		{
			$this->db->where('i.item_id IN ('.$item_id.')');
		}
		
		$query = $this->db->get('sales s');
		
		$retVal = array('-1');
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$retVal[] = $row->item_item_id;
			}
		}
		
		return $retVal;
	}
	
	function get_persons_pending()
	{
		$person_items = $this->getPersonsItems();
		$person_sales = $this->get_persons_sales_id(false);
		
		return array_intersect_key($person_items, $person_sales);
	}
	
	function get_pending_purchases()
	{
		$this->db->select('s.saleId, s.resolved, i.name, s.owned_item_id');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where('s.buyerId', $this->phpsession->get('personVO')->getPerson_id());
		
		$this->db->where('comp_date IS NOT NULL');
		$this->db->where('resolved', '0');
		
		$query = $this->db->get('sales s');
		
		$retVal = array();
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$itemVO = $this->getItems(array($row->owned_item_id), true);
				$itemVO = $itemVO[0];
				$retVal[$row->saleId] = $itemVO->getItem_label();
			}
			return $retVal;
		}
		return array();	
	}
	
	/**
	 * Close a sale with a buyer and seller.
	 */
	function close_sale()
	{
		$saleId = (int)$this->input->post('saleId');
		$person_id = $this->phpsession->get('personVO')->getPerson_id();
		$mysqltime = date ("Y-m-d H:i:s");
		
		require_once APPPATH.'models/VOs/SaleVO'.EXT;
		
		$saleVO = new SaleVO($saleId);
		$saleVO->Load();
		
		$saleVO->setBuyerId($person_id);
		$saleVO->setComp_date($mysqltime);
		
		if($saleVO->Save())
		{
			$this->send_sale_emails($saleVO);
			return "You have successfully bought this item. An email has been sent to you and the seller with contact information. Please work with the seller to send payment.";
		}
		else
		{
			return "Completion of the sale failed, please contact KLECT.com with the sale Id: $saleId for help.";
		}
	}
	
	/**
	 * Mark a sale as recieved.
	 */
	public function mark_as_recieved()
	{
		$saleId = (int)$this->input->post('saleId');
		
		require_once APPPATH.'models/VOs/SaleVO'.EXT;
		$saleVO = new SaleVO($saleId);
		$saleVO->Load();
		
		$saleVO->setResolved(true);
		
		if($saleVO->getShipped() && $saleVO->Save() && $this->move_sale($saleVO))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function get_awaiting_feedback_info()
	{
		$saleId = (int)$this->input->post('saleid');
		$personId = $this->phpsession->get('personVO')->getPerson_id();
		$this->db->select('s.saleId, per.username as sellerUsername, per.email as sellerEmail, i.item_id, s.description as list_description, s.price, m.name as manufacturer, s.list_date, s.paypal, s.moneyorder, oi.owned_item_id, i.name, i.catalog_description, p.filename, oi.description, oi.condition, i.general_attribute, s.custImg, s.shipped, s.resolved');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'oi.item_item_id=i.item_id');
		$this->db->join('pictures p', 'p.item_id=i.item_id', 'left');
		$this->db->join('manufacturer m', 'm.manufacturer_id=i.manufacturer_id');
		$this->db->join('person per', 's.sellerId=per.person_id');
		$this->db->where('s.saleId',$saleId);
		$this->db->where('(s.sellerId = '.$personId.' OR s.buyerId = '.$personId.')');
		$this->db->where('s.resolved', '1');
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
		$this->db->where('s.resolved', '1');
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
	
	function give_feedback()
	{
		$saleId = (int)$this->input->post('saleId');
		$rating_val = (int)$this->input->post('rating_val');
		$person_id = $this->phpsession->get('personVO')->getPerson_id();
		$mysqltime = date ("Y-m-d H:i:s");
		
		require_once APPPATH.'models/VOs/SaleVO'.EXT;
		
		$saleVO = new SaleVO($saleId);
		$saleVO->Load();
		
		if (($saleVO->getBuyerId() == $person_id) && ($saleVO->getSeller_rating() == "0"))
		{
			$saleVO->setSeller_rating($rating_val);
		}
		elseif(($saleVO->getSellerId() == $person_id) && ($saleVO->getBuyer_rating() == "0"))
		{
			$saleVO->setBuyer_rating($rating_val);
		}
		
		if($saleVO->Save())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function getAwaitingFeedback()
	{
		$this->db->select('s.saleId, s.resolved, i.name, s.owned_item_id');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where('s.sellerId', $this->phpsession->get('personVO')->getPerson_id());
		
		$this->db->where('comp_date IS NOT NULL');
		$this->db->where('resolved', '1');
		$this->db->where('s.buyer_rating', '0');
				
		$query = $this->db->get('sales s');
		
		$retVal = array();
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$itemVO = $this->getItems(array($row->owned_item_id), true);
				$itemVO = $itemVO[0];
				$retVal[$row->saleId] = $itemVO->getItem_label();
			}
			return $retVal;
		}
		
		$this->db->select('s.saleId, s.resolved, i.name, s.owned_item_id');
		$this->db->join('owned_item oi', 'oi.owned_item_id=s.owned_item_id');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where('s.buyerId', $this->phpsession->get('personVO')->getPerson_id());
		
		$this->db->where('comp_date IS NOT NULL');
		$this->db->where('resolved', '1');
		$this->db->where('s.seller_rating', '0');
		
		$query = $this->db->get('sales s');
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				$itemVO = $this->getItems(array($row->owned_item_id), true);
				$itemVO = $itemVO[0];
				$retVal[$row->saleId] = $itemVO->getItem_label();
			}
			return $retVal;
		}
		return array();
	}
	
	/**
	 * This method will return an array of sale images indexed by the saleId
	 * 
	 * There are three possible values for the sale:
	 * 
	 * 1) path to the custom image uploaded by the seller
	 * 2) path to the stock KLECT photo of the item
	 * 3) path to the stock "No Picture Available" photo
	 * 
	 * @param $item_id
	 */
	function getCustImgs($item_id)
	{
		$this->db->select('s.custImg, s.saleId, p.filename');
		$this->db->join('owned_item oi', 's.owned_item_id=oi.owned_item_id');
		$this->db->join('item i', 'oi.item_item_id=i.item_id');
		$this->db->join('pictures p', 'p.item_id=i.item_id', 'left');
		$this->db->where('comp_date IS NULL');
		$this->db->where('buyerId IS NULL');
		$this->db->where('i.domain_id', $this->phpsession->get('current_domain')->getId());
		$this->db->where('i.item_id', $item_id);
		
		$query = $this->db->get('sales s');
		
		$retVal = array();
		$tag = $this->phpsession->get('current_domain')->getTag();
		
		if($query->num_rows > 0)
		{
			foreach ( $query->result() as $row )
			{
				if($row->custImg == 'stock')
				{
					if(isset($row->filename))
					{
						$retVal[$row->saleId] = "/img/".$tag."/full/".$row->filename;
					}
					else
					{
						$retVal[$row->saleId] = "/img/".$tag."/full/nopic.jpg";
					}
					
				}
				else
				{
					$retVal[$row->saleId] = '/img/'.$tag.'/customs/'.$row->custImg;
				}
			}
		}
		
		return $retVal;
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