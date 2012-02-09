<?php
/* do not put a Closure object in global scope */
function load(){
	include __DIR__ .'/../vendor/.composer/autoload.php';
}
load();

class Judgement_CodeStyleFilter_TestCase extends PHPUnit_Framework_TestCase
{
		public function getConfig()
	{
		return new Kuroko\Config(
			new Kuroko\Config\XMLFileLoader("config.xml")
		);
	}

	public function apply($filter, $node)
	{
		$current = $node->front;
		do {
			$filter->apply($current);
		} while ($current = $current->next());
	}

	public function render($node)
	{
		$buffer = "";
		/* rendering php file */
		$current = $node->front;
		do {
			$buffer .= $current->data->data;
		} while ($current = $current->next());

		return $buffer;
	}

	public function getTokens($script)
	{
		$tokens = Kuroko\TokenParser::parse($script);
		$list = new Kuroko\DoubleLinkedList();
		foreach($tokens as $token){
			$list->add(new Kuroko\Token($token));
		}
		return $list;
	}
}