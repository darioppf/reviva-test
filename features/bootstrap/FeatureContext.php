<?php

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
	private $application;
	private $output;
	private $shoppingBasketsIds=[];

	public function __construct(Kernel $kernel)
	{
		$this->application = new Application($kernel);
		$this->output = new BufferedOutput();
	}

	/**
	 * @Given shopping baskets in :arg1
	 */
	public function shoppingBasketsIn($arg1)
	{
		$dir=@opendir($arg1);

		if(!$dir) {
			throw new Exception($arg1." directory not found!");
		}
		while (false !== ($shoppingBasket = readdir($dir))) {
			$shoppingBasketPath=$arg1."/".$shoppingBasket;
			if(is_file($shoppingBasketPath)) {
				if(preg_match('/.*_([0-9]+)\.txt$/',$shoppingBasketPath,$m)!==FALSE) {
					$this->shoppingBasketsIds[]=$m[1];
				}
			}
		}
		closedir($dir);
	}

	/**
	 * @When I run the command :arg1 with arguments :arg2 and :arg3
	 */
	public function iRunTheCommandWithArgumentsAnd($arg1, $arg2, $arg3)
	{
		$src=@opendir($arg2);

		if(!$src) {
			throw new Exception($arg2." directory not found!");
		}

		$dst=@opendir($arg3);

		if(!$dst) {
			throw new Exception($dst." directory not found!");
		}

		$argv=new ArgvInput(["console",$arg1,$arg2,$arg3]);

		$this->application->doRun($argv, $this->output);
	}

	/**
	 * @Then receipts in :arg1 should match those in :arg2
	 */
	public function receiptsInShouldMatchThoseIn($arg1, $arg2)
	{
		foreach($this->shoppingBasketsIds as $receiptId) {
			$receiptPath=$arg1."/receipt_".$receiptId.".txt";
			if(!file_exists($receiptPath)) {
				throw new Exception($receiptPath." not found!");
			}
			$receiptData=file_get_contents($receiptPath);
			$receiptTestPath=$arg2."/receipt_".$receiptId.".txt";
			$receiptTestData=file_get_contents($receiptTestPath);
			if(md5($receiptData)!=md5($receiptTestData)) {
				throw new Exception("Generated:\n".$receiptData."\nTest:\n".$receiptTestData."\nis not valid!");
			}
		}
	}
}
