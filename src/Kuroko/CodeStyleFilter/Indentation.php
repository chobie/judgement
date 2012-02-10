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
		if($token->type == Token::T_INDENT) {
			$length = strlen($token->data);
			if ($length) {
				//@todo implemnt tab and spaces.
				$token->data = str_repeat(" ",$length * $this->config['indents.indent']);
			}
		}
	}
}
