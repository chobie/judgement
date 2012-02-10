<?php
namespace Kuroko\Command;

use Kuroko\Config;
use Kuroko\Config\XMLFileLoader;
use Kuroko\DoubleLinkedList;
use Kuroko\TokenParser;
use Kuroko\Token;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FilterCommand extends Command
{
	protected function configure()
	{
		$this
			->setName('filter')
			->setDescription('show useage')
			->setHelp("")
			->addArgument("path");
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$path = $input->getArgument("path");

		$config = new Config(
			new XMLFileLoader("config.xml")
		);

		$string = file_get_contents($path);

		/* convert token stream to linked list */
		$tokens = TokenParser::parse($string);
		$list = new DoubleLinkedList();
		foreach($tokens as $token){
			$list->add(new Token($token));
		}

		/* obtain formatter classes */
		$formatter = array();
		foreach ($config['formatter'] as $f) {
			$formatter[] = new $f($config);
		}

		/* do filter */
		$current = $list->front;
		do {
			foreach($formatter as $f) {
				$f->apply($current);
			}
		} while ($current = $current->next());

		/* force adjust php tag */
		if ($config['others.prohibit_shoft_tag']) {
			if($list->front->data->type == Token::T_OPEN_TAG && $list->front->data->data == "<?") {
				$list->front->data->data = "<?php";
			}
		}
		/* force remove end tag */
		if ($config['others.prohibit_end_php_tag']) {
			if($list->back->data->type == Token::T_CLOSE_TAG ) {
				$list->back->previous->next = null;
				$list->back = $list->back->previous;
			}
		}


		/* rendering php file */
		$current = $list->front;
		do {
			echo $current->data->data;
		} while ($current = $current->next());
	}
}