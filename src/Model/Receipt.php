<?php
namespace App\Model;

use App\Model\ReceiptItem;

class Receipt
{
	protected $id;

	protected $receiptItems;

	function __construct()
	{
		$this->receiptItems=[];
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
         * @param Int numeric ID of this receipt, it would match the originating shopping basket
         * @return  self
         */
        public function setId(Int $id): self
        {
                $this->id = $id;

                return $this;
        }

	function getTaxes(): Float
	{
		$taxes=0;
		foreach($this->receiptItems as $receiptItem) {
			$taxes+=$receiptItem->getTaxes();
		}

		return $taxes;
	}

	function getTotal(): Float
	{
		$total=0;
		foreach($this->receiptItems as $receiptItem) {
			$total+=$receiptItem->getTotal();
		}

		return $total;
	}

	/**
	 * Get the value of receiptItems
	 */ 
	public function getReceiptItems(): Array
	{
		return $this->receiptItems;
	}

	/**
	 * Set the value of receiptItems
	 *
	 * @param Array array of receipt items
	 * @return  self
	 */ 
	public function setReceiptItems(Array $receiptItems): self
	{
		$this->receiptItems = $receiptItems;

		return $this;
	}

        /**
         * Add a receiptItem
         *
         * @param ReceiptItem receipt item to be added to this receipt
         * @return  self
         */
        public function addReceiptItem(ReceiptItem $receiptItem): self
        {
                $this->receiptItems[] = $receiptItem;

                return $this;
        }

	/**
	 * Print out text receipt
	 *
 	 * @return receipt in text format
	 */
	public function __toString(): String
	{
		$receiptText="";
		foreach($this->receiptItems as $receiptItem) {
			$receiptText.=$receiptItem->getCount()." ".$receiptItem->getName().": ".number_format($receiptItem->getTotal(),2)."\n";
		}
		$receiptText.="Sales Taxes: ".number_format($this->getTaxes(),2)."\n";
		$receiptText.="Total: ".number_format($this->getTotal(),2)."\n";

		return $receiptText;
	}
}
