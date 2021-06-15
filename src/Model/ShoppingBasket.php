<?php
namespace App\Model;

use App\Model\ShoppingBasketItem;

class ShoppingBasket
{
	protected $id;

	protected $shoppingBasketItems;

	function __construct()
	{
		$this->shoppingBasketItems=[];
	}


	/**
	 * Get the value of id
	 */ 
	public function getId(): Int
	{
		return $this->id;
	}

	/**
	 * Set the value of id
	 *
	 * @param Int numeric ID of this shopping basket
	 * @return  self
	 */ 
	public function setId(Int $id): self
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get the value of shoppingBasketItems
	 *
	 * @return Array array of shopping basket items
	 */ 
	public function getShoppingBasketItems(): Array
	{
		return $this->shoppingBasketItems;
	}

	/**
	 * Set the value of shoppingBasketItems
	 *
	 * @param Array array of shopping basket items
	 * @return  self
	 */ 
	public function setShoppingBasketItems(Array $shoppingBasketItems): self
	{
		$this->shoppingBasketItems = $shoppingBasketItems;

		return $this;
	}

	/**
	 * Add a shoppingBasketItem
	 *
	 * @param ShoppingBasketItem shopping basket item added to this shopping basket
	 * @return  self
	 */ 
	public function addShoppingBasketItem(ShoppingBasketItem $shoppingBasketItem): self
	{
		$this->shoppingBasketItems[] = $shoppingBasketItem;

		return $this;
	}
}
