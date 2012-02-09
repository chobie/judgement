<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\CodeStyleFilter;

class Indentation extends CodeStyleFilter
{
	public function apply($node)
	{
		$token = $node->data;
		if($token->type == T_WHITESPACE && $node->previous->data->type == \Kuroko\Token::T_NEWLINE) {
			$length = strlen($token->data);
			if ($length) {
				$token->data = str_repeat(" ",$length*4);
			}
		}
	}
}
