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

		if ($this->config["others.force_add_method_visibility"]) {
			if ($token->type == Token::T_FUNCTION && LevelManager::isInsideClass()) {
				$current = $node->previous;
				$tokens = array(Token::T_WHITESPACE, Token::T_INDENT, Token::T_NEWLINE);
				do {
					if (in_array($current->data->type, $tokens)) {
						continue;
					} else {
						$expects = array(Token::T_PUBLIC, Token::T_PRIVATE, Token::T_PROTECTED);
						if (in_array($current->data->type, $expects)) {
							/* visibility ok */
							break;
						} else {
							/* omitted visibility: force add public visibility */
							if (!LevelManager::isInsideMethod()) {
								$this->inject($this->whitespace(1),$node->previous,$node);
								$this->inject($this->newVisibility(),$node->previous->previous,$node->previous);
							}
							break;
						}
					}
				} while ($current = $current->previous);
			}
		}

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
