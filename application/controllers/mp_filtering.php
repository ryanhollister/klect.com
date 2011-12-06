<?php
class Mp_filtering extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		is_logged_in();
	}
	
	function filter($working_set = false)
	{
		$this->load->model('item_model');
		$this->load->model('buy_model');
		$item_ids = array();
		$selects = array();
		$sales = array();
		$core_wheres = "";
		$and = "";
		$sql = "";
		$subselects = "";
		$data['filter_ids']= false;
		$data['filter_values'] = false;
		
		switch($working_set) {
			case "wishlist":
				$joins = " JOIN wishlist w ON w.item_id=i.item_id";
				break;
			default:
				$joins = "";
				break;
			}
		
		foreach ($_POST as $attr_id => $attr_val)
		{
			if ((strpos($attr_id, '_input') != false) && $attr_val != false)
			{
				$attr_id = str_replace('_input', '', $attr_id);
				$attr_val = addslashes($attr_val);
				$data['filter_values'][$attr_id] = $attr_val;
				$selects[] = "select item_id from item_attribute ia where ia.domain_attribute_id='$attr_id' AND ia.value='$attr_val'";
			}
			elseif (strpos($attr_id, '_core') != false && $attr_val != false)
			{
				$attr_id = str_replace('_core', '', $attr_id);
				$attr_val = addslashes($attr_val);
				$data['filter_values'][$attr_id] = $attr_val;
				$core_wheres .= "$attr_id='$attr_val'".$and;
				$and = " AND ";
			}
		}
		
		$and = "";
		if (count($selects) > 0)
		{
			foreach ($selects as $select)
			{
				$subselects .= $and." i.item_id IN (".$select.")";
				$and = " AND ";
			}
		}
		$and = "";
		if ($core_wheres != "" && $subselects != "")
		{
			$and = " AND ";
		}
		elseif ($core_wheres == "" && $subselects == "")
		{
			switch($this->input->post('source')) {
				case 'wishlist':
					$item_array = $this->buy_model->get_open_sales(false, $working_set);
					$sales['counts'] = array_count_values($item_array);
					$sales['sale_items'] = $this->item_model->getItems(array_unique($item_array));
					$this->load->view('modules/items_forsale', $sales);
					break;
					
				case 'unowned':
					$item_array = $this->buy_model->get_open_sales(false, $working_set);
					$sales['counts'] = array_count_values($item_array);
					$sales['sale_items'] = $this->item_model->getItems(array_unique($item_array));
					$this->load->view('modules/items_forsale', $sales);
					break;
					
				default:
					$item_array = $this->buy_model->get_open_sales(false, $working_set);
					$sales['counts'] = array_count_values($item_array);
					$sales['sale_items'] = $this->item_model->getItems(array_unique($item_array));
					$this->load->view('modules/items_forsale', $sales);
					break;
			}
			return;
		}

		//@todo seperate this query out using db library
		$sql = "SELECT DISTINCT(item_id) FROM item i JOIN owned_item oi ON oi.item_item_id=i.item_id JOIN sales s ON s.owned_item_id=oi.owned_item_id".$joins." WHERE ".$core_wheres.$and.$subselects;
		$query = $this->db->query($sql);

		
		$data['filter_ids']= array();

		foreach ($query->result() as $row)
		{
			$data['filter_ids'][] = $row->item_id;
		}
		
		if ($query->num_rows() == 0)
		{
			$data['filter_ids'][] = '-1';
		}
		
		switch($this->input->post('source')) {
		default:
			$item_array = $this->buy_model->get_open_sales(implode(',',$data['filter_ids']));
			if (count($item_array) > 0 )
			{
				$sales['counts'] = array_count_values($item_array);
				$sales['sale_items'] = $this->item_model->getItems(array_unique($item_array));
			}
			$this->load->view('modules/items_forsale', $sales);
			break;
		}
	}
}
?>