<?php
namespace App\Model;

class ShoppingBasketItem
{
	protected $count;

	protected $name;

	protected $price;

	/**
	 * Get the value of name
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
	 * Get the value of count
	 */ 
	public function getCount(): Int
	{
		return $this->count;
	}

	/**
	 * Set the value of count
	 *
	 * @return  self
	 */ 
	public function setCount(Int $count): self
	{
		$this->count = $count;

		return $this;
	}

	/**
	 * Get the value of price
	 */ 
	public function getPrice(): Float
	{
		return $this->price;
	}

	/**
	 * Set the value of price
	 *
	 * @return  self
	 */ 
	public function setPrice(Float $price): self
	{
		$this->price = $price;

		return $this;
	}
}
