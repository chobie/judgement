<?php

namespace Kuroko\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Finder\Finder;

use Kuroko\Command;


class Application extends BaseApplication
{
	public function __construct()
	{
		parent::__construct('judgement',0.1);
	}

	public function run(InputInterface $input = null, OutputInterface $output = null)
	{
		if (null === $output) {
			$styles['highlight'] = new OutputFormatterStyle('red');
			$styles['warning'] = new OutputFormatterStyle('black', 'yellow');
			$formatter = new OutputFormatter(null, $styles);
			$output = new ConsoleOutput(ConsoleOutput::VERBOSITY_NORMAL, null, $formatter);
		}

		return parent::run($input, $output);
	}

	public function doRun(InputInterface $input, OutputInterface $output = null)
	{
		$this->registerCommands();

		return parent::doRun($input, $output);
	}

	protected function registerCommands()
	{
		$this->add(new Command\HelpCommand());
	}
}