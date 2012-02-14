<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\Token;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\DoubleLinkedList;
use \Kuroko\CodeStyleFilter;

class Indentation extends CodeStyleFilter
{
	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;

		if ($token->type == Token::T_INDENT) {
			$level = LevelManager::getLevel();

			if ($node->next->data->type == Token::T_BRACE_RIGHT) {
				$level--;
			}

			$token->data = str_repeat(($this->config['indents.use_tab']) ? "\t" : " ",$level * $this->config['indents.indent']);
		}
	}
}
