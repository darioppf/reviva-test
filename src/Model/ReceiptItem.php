<?php
namespace App\Model;

class ReceiptItem
{
	protected $count;

	protected $name;

	protected $taxes;

	protected $total;

	/**
	 * Get the value of count
	 *
	 * @return Int number of items
	 */ 
	public function getCount(): Int
	{
		return $this->count;
	}

	/**
	 * Set the value of count
	 *
	 * @param Int number of items for this line
	 * @return  self
	 */ 
	public function setCount(Int $count): self
	{
		$this->count = $count;

		return $this;
	}

	/**
	 * Get the value of name
	 *
	 * @return String product name
	 */ 
	public function getName(): String
	{
		return $this->name;
	}

	/**
	 * Set the value of name
	 *
	 * @return  self
	 */ 
	public function setName(String $name): self
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Get the value of taxes
	 */ 
	public function getTaxes(): Float
	{
		return $this->taxes;
	}

	/**
	 * Set the value of taxes
	 *
	 * @param Float total taxes for this line
	 * @return  self
	 */ 
	public function setTaxes(Float $taxes): self
	{
		$this->taxes = $taxes;

		return $this;
	}

	/**
	 * Get the value of total
	 *
	 * @return Float total with taxes
	 */ 
	public function getTotal(): Float
	{
		return $this->total;
	}

	/**
	 * Set the value of total
	 *
         * @param Float set total with taxes
	 * @return  self
	 */ 
	public function setTotal(Float $total): self
	{
		$this->total = $total;

		return $this;
	}
}
