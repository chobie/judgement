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
				if ($node->previous->data->type != T_WHITESPACE) {
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node->previous, $node);
				}
				if ($node->next->data->type != T_WHITESPACE) {
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node, $node->next);
				}
				break;
		}
	}
}