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
			case ";":
				if (LevelManager::isInsideParentheses()) {
					if ($node->next->data->type != Token::T_WHITESPACE) {
						$this->inject($this->whitespace(), $node, $node->next);
					}
				} else {
					/* force add newline after semicolon */
					if ($node->next->data->type != Token::T_NEWLINE) {
						$this->inject($this->newline(), $node, $node->next);
						$this->inject($this->indent(LevelManager::getLevel()-1), $node->next, $node->next->next);
					}
				}
				break;
			case ",":
				if ($node->next->data->type != Token::T_WHITESPACE) {
					$this->inject($this->whitespace(), $node, $node->next);
				}
				break;
		}
	}
}
