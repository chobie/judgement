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
			$type = strtolower($this->config['braces.in_class_declraration']);

			switch($type) {
				case "next":
					if ($lbrace->previous->data->type != Token::T_NEWLINE) {
						$this->inject($this->newline(), $lbrace->previous, $lbrace);
					}
					break;
				case "eol":
					if ($lbrace->previous->data->type == Token::T_NEWLINE) {
						$this->delete($lbrace->previous);
					}
				break;
			}
		}
	}
}
