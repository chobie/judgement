<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\Token;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\CodeStyleFilter;

class Others extends CodeStyleFilter
{
	public function apply($node)
	{
		$token = $node->data;
		switch($token->data) {
			case ",":
			case ";":
				if ($node->next->data->type != T_WHITESPACE) {
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node, $node->next);
				}
				break;
		}
	}
}
