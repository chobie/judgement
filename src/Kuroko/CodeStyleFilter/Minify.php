<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\Token;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\DoubleLinkedList;
use \Kuroko\CodeStyleFilter;

/* joke filter */
class Minify extends CodeStyleFilter
{
	protected $map = array();

	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;

		if (!LevelManager::isInsideMethod()) {
			$this->map = array();
		}

		if ($token->type == Token::T_NEWLINE && $node->previous->data->type != Token::T_OPEN_TAG) {
			$this->delete($node);
		}
		if ($token->type == Token::T_INDENT) {
			$this->delete($node);
		}

		if ($token->type == Token::T_VARIABLE) {
/*			if (LevelManager::isInsideMethod()) {
				$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
				$this->map[$token->data] = $chars[count($this->map)];
				$token->data = '$' . $chars[count($this->map)];
			}*/
		}

		if ($token->type == Token::T_WHITESPACE) {
			$token->data = " ";
			if ($node->previous->data->type == Token::T_WHITESPACE) {
				$this->delete($node);
			}
		}

		if ($token->type == Token::T_DOC_COMMENT || $token->type == Token::T_COMMENT) {
			$this->delete($node);
		}

		$chars = array("if","else","for","while","do","elseif","try","catch","<","<<","<<<","<=",">",">>",">>>",">=","==","===","++","--","+=","-=","|=","+","-","*","/","%","|",",","^","?",":","=>","=","}","{","&&",";",".=",".");
		if (in_array($token->data,$chars)) {
			if ($node->previous->data->type == Token::T_WHITESPACE) {
				$this->delete($node->previous);
			}
			if ($node->next->data->type == Token::T_WHITESPACE) {
				$this->delete($node->next);
			}
		}
	}
}
