<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\DoubleLinkedList;
use \Kuroko\Token;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\CodeStyleFilter;

class TernaryOperator extends CodeStyleFilter
{
	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;
		switch($token->data) {
			case "?":
				if ($node->previous->data->type != T_WHITESPACE) {
					$this->inject($this->whitespace(), $node->previous, $node);
				}
				/* do not break here */
			case ":":
				if ($node->next->data->type != T_WHITESPACE) {
					$this->inject($this->whitespace(), $node, $node->next);
				}
				if ($node->next->data->type != T_WHITESPACE) {
					$this->inject($this->whitespace(), $node, $node->next);
				}
				break;
		}
	}
}
