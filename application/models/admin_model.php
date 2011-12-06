<?php

class Admin_model extends CI_Model {
	
	function getUserCount()
	{
		$this->db->select('COUNT(1) as count');
		$query = $this->db->get('person');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getPonyUserCount()
	{
		$this->db->select('COUNT(1) as count');
		$this->db->where('domain_id', '1');
		$query = $this->db->get('collection');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getStampUserCount()
	{
		$this->db->select('COUNT(1) as count');
		$this->db->where('domain_id', '2');
		$query = $this->db->get('collection');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getOwnedItemCount()
	{
		$this->db->select('COUNT(1) as count');
		$query = $this->db->get('owned_item');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getPonyOwnedItemCount()
	{
		$this->db->select('COUNT(1) as count');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', '1');
		$query = $this->db->get('owned_item oi');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getStampOwnedItemCount()
	{
		$this->db->select('COUNT(1) as count');
		$this->db->join('item i', 'i.item_id=oi.item_item_id');
		$this->db->where('i.domain_id', '2');
		$query = $this->db->get('owned_item oi');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getWishListCount()
	{
		$this->db->select('COUNT(DISTINCT(person_id)) as count');
		$query = $this->db->get('wish_list');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getShippingCount()
	{
		$this->db->select('COUNT(1) as count');
		$this->db->where('addr1 !=', '');
		$query = $this->db->get('person');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getSubscriptionCount()
	{
		$this->db->select('COUNT(1) as count');
		$this->db->where('subId !=', '0');
		$this->db->where('subId IS NOT NULL');
		$query = $this->db->get('person');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
	
	function getSaleCount()
	{
		$this->db->select('COUNT(1) as count');
		$this->db->where('buyerId IS NOT NULL');
		$query = $this->db->get('sales');
		
		if($query->num_rows > 0)
		{
			$row = $query->result_array();
			return $row[0]['count'];
		}
	}
}
?>