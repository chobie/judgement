<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\Token;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\CodeStyleFilter;

class BracesPlacement extends CodeStyleFilter
{
	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;

		if($token->type == T_CLASS) {
			$lbrace = $this->expect($node, \Kuroko\Token::T_BRACE_LEFT);
			$type = strtolower($this->config['wrapping_and_braces.braces.in_class_declraration']);

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
		} else if ($token->type == T_FUNCTION) {
			$newline = $this->expectr($node, Token::T_NEWLINE);

			if ($newline->next->data->type == Token::T_INDENT) {
				// @Todo: detect indent char.
				$tab = strlen($newline->next->data->data);
			} else {
				$tab = 0;
			}

			$lbrace = $this->expect($node, \Kuroko\Token::T_BRACE_LEFT);
			$type = strtolower($this->config['wrapping_and_braces.braces.in_method_declraration']);

			switch($type) {
				case "next":
					if ($lbrace->previous->data->type != Token::T_INDENT) {
						$this->inject($this->newline(), $lbrace->previous, $lbrace);
						$this->inject($this->indent($tab), $lbrace->previous, $lbrace);
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
