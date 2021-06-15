<?php
namespace App\Service;

use App\Model\ShoppingBasket;
use App\Model\ShoppingBasketItem;
use App\Model\Receipt;
use App\Model\ReceiptItem;

/**
 * ShoppingBasketProcessor all shopping basket operations are performed by this service
 */
class ShoppingBasketProcessor {
	/**
	* returns a ShoppingBasket entity from a given shopping basket file suffixed by _ID.txt, where ID is the shopping basket ID
	* @param string shopping basket input file
	* @return ShoppingBasket shopping basket entity or null if input file is invalid
	*/
	public function shoppingBasketFromFile(String $filename): ?ShoppingBasket
	{
		$shoppingBasket=new ShoppingBasket();

		$fd=fopen($filename,"r");

		if($fd===NULL)
			return null;

		if(preg_match('/.*_([0-9]+)\.txt$/',$filename,$m)===FALSE)
			return false;

		$shoppingBasket->setId($m[1]);

		while(($line=fgets($fd))!==false) {
			if(preg_match('/^([0-9]+) (.*) at ([0-9\.]+)$/',$line,$shoppingBasketLineItem)===false) {
				return null;
			}
			$shoppingBasketItem=new ShoppingBasketItem();
			$shoppingBasketItem->setCount(intval($shoppingBasketLineItem[1]));
			$shoppingBasketItem->setName($shoppingBasketLineItem[2]);
			$shoppingBasketItem->setPrice(floatval($shoppingBasketLineItem[3]));
			$shoppingBasket->addShoppingBasketItem($shoppingBasketItem);
		}

		return $shoppingBasket;
	}

	/**
	* transform a ShoppingBasket entity into a Receipt entity by performing all tax calculations
	* @param ShoppingBasket input shopping basket entity
	* @return Receipt entity
	*/
	public function receiptFromShoppingBasket(ShoppingBasket $shoppingBasket): Receipt
	{
		$receipt=new Receipt();
		$receipt->setId($shoppingBasket->getId());

		foreach($shoppingBasket->getShoppingBasketItems() as $shoppingBasketItem) {
			$taxes=0;
			$receiptItem=new ReceiptItem();
			$receiptItem->setName($shoppingBasketItem->getName());
			$receiptItem->setCount($shoppingBasketItem->getCount());
			$net=$shoppingBasketItem->getCount()*$shoppingBasketItem->getPrice();
			if(!preg_match('/(book|chocolate|headache)/i',$shoppingBasketItem->getName())) {
				$taxes+=$this->addTaxes($net,10);
			}
			if(preg_match('/imported/i',$shoppingBasketItem->getName())) {
				$taxes+=$this->addTaxes($net,5);
			}
			$taxes=$this->round($taxes);
			$receiptItem->setTaxes($taxes);
			$receiptItem->setTotal($taxes+$net);
			$receipt->addReceiptItem($receiptItem);
		}

		return $receipt;
	}

	/**
	* calculate taxes and round them to the nearest 0.05
	* @param Float amount to be taxed
	* @param Float tax rate
	* @return Float tax calculated
	*/
	private function addTaxes(Float $baseAmount, Float $taxRate): Float
	{
		return $baseAmount/100*$taxRate;
	} 

	/**
	* round to nearest 0.05
	* @param Float amount to be round
	* @return Float amount rounded
	*/
	private function round(Float $amount): Float
	{
		return round($amount*2,1)/2;
	} 
}
?>
