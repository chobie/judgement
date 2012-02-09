<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\DoubleLinkedList;
use \Kuroko\Token;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\CodeStyleFilter;

class Others extends CodeStyleFilter
{
	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;
		switch($token->data) {
			case ",":
			case ";":
				if ($node->next->data->type != T_WHITESPACE) {
					$this->inject($this->whitespace(), $node, $node->next);
				}
				break;
		}
	}
}
