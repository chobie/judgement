<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\CodeStyleFilter;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\Token;

class ArroundOperators extends CodeStyleFilter
{
	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;
		switch($token->data) {
			case "=":
			case "==":
			case "===":
			case "=>":
			case "!=":
			case "!==":
			case "-=":
			case "+=":
			case "<<":
			case "<":
			case ">":
			case ">>":
			case ">>>":
			case "&":
			case "|":
			case "&&":
			case "||":
			case "/":
			case "*":
			case "^":
			case "%":
			case ".":
			case "use":
				if ($node->previous->data->type != T_WHITESPACE) {
					$this->inject($this->whitespace(), $node->previous, $node);
				}
				if ($node->next->data->type != T_WHITESPACE) {
					$this->inject($this->whitespace(), $node, $node->next);
				}
				break;
		}
	}
}