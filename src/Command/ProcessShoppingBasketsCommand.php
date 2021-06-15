<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Helper\ProgressBar;

use App\Service\ShoppingBasketProcessor;

use App\Model\ShoppingBasket;

/**
 * Symfony CLI command to run this demo
 */
class ProcessShoppingBasketsCommand extends Command
{
	protected static $defaultName = 'reviva:process-shopping-baskets';
	private $shoppingBasketProcessor;

	public function __construct(ShoppingBasketProcessor $service)
	{
		parent::__construct();

		$this->shoppingBasketProcessor=$service;
	}

	protected function configure()
	{
		$this
			->setDescription('Process shopping baskets')
			->addArgument('source', InputArgument::REQUIRED, 'Source folder')
			->addArgument('destination', InputArgument::REQUIRED, 'Destination folder')
			;
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$source=$input->getArgument("source");
		$destination=$input->getArgument("destination");
		$io = new SymfonyStyle($input, $output);

                $sourceDir=@opendir($source);

                if(!$sourceDir) {
                        throw new Exception($source." directory not found!");
                }

                if(!file_exists($destination) || !is_dir($destination)) {
                        throw new Exception($destination." directory not found or invalid!");
                }
		$shoppingBaskets=[];
		$receipts=[];
		$nprocessed=0;
		$nignored=0;
                while (false !== ($filename = readdir($sourceDir))) {
                        $sourceFullpath=$source."/".$filename;
                        if(is_file($sourceFullpath)) {
                                if(preg_match('/.*_([0-9]+)\.txt$/',$sourceFullpath,$m)!==FALSE) {
                        		$destinationFullpath=$destination."/receipt_".$m[1].".txt";
					$shoppingBasket=$this->shoppingBasketProcessor->shoppingBasketFromFile($sourceFullpath);
					if($shoppingBasket) {
						$shoppingBaskets[]=$shoppingBasket;
						$receipt=$this->shoppingBasketProcessor->receiptFromShoppingBasket($shoppingBasket);
						echo $receipt."\n";
						file_put_contents($destinationFullpath,$receipt);
						$nprocessed++;
					} else {
						$io->warning('Invalid '.$filename);
						$nignored++;
					}
                                } else {
					$io->warning('Ignoring '.$filename);
					$nignored++;
				}
                        }
                }

		$io->success($nprocessed.' shopping baskets processed.');
		if($nignored) {
			$io->warning($nignored.' shopping baskets ignored.');
		}

		if($nignored) {
			return 1;
		} else {
			return 0;
		}
	}

	private function displayMessage($output, $msg, $type="info")
	{
		$output->writeln("\n<$type>".$msg."</$type>\n");
	}
}
