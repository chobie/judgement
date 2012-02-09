<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\Token;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\CodeStyleFilter;

class BracesPlacement extends CodeStyleFilter
{
	public function apply($node)
	{
		$token = $node->data;
		if($token->type == T_CLASS) {
			$lbrace = $this->expect($node, \Kuroko\Token::T_BRACE_LEFT);
			if ($lbrace->previous->data->type != T_WHITESPACE) {
				$this->inject(new DoubleLinkedListNode(new Token(array(Token::T_NEWLINE,"\n",0))), $lbrace->previous, $lbrace);
			}
		}
	}
}
