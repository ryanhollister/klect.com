<?php

class DomainVO
{
	private $name;
	private $attributes = array();
	private $id;
	private $tag;
	
	function __construct($inputId, $inputName = "")
	{
		$this->setId($inputId);
		$this->setName($inputName);
	}
	
	function getName()
	{
		return $this->name;
	}
	
	function getAttributes()
	{
		return $this->attributes;
	}
	
	function getId()
	{
		return $this->id;
	}
	
	function getTag()
	{
		return $this->tag;
	}
	
	function setName($value)
	{
		$this->name = $value;
	}
	
	function setAttributes($value)
	{
		if (is_array($value))
		{
			$this->attributes = $value;
		}
	}
	
	function setId($value)
	{
		if (is_int($value))
		{
			$this->id = $value;
		}
	}
	
	function setTag($value)
	{
		$this->tag = $value;
	}
	
	function addAttribute($id, $value)
	{
		$this->attributes[$id] = $value;
	}
	
}