<?php
namespace Kuroko\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelpCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('help')
			->setDescription('show useage')
			->setHelp("")
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln("judgement filter <file/to/path>");
	}
}