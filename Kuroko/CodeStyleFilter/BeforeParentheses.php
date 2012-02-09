<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\DoubleLinkedListNode;
use \Kuroko\Token;

class BeforeParentheses extends \Kuroko\CodeStyleFilter
{
	public function apply(\Kuroko\DoubleLinkedListNode $node)
	{
		$token = $node->data;
		if ($token->data == "(") {
			$tmp = $node->previous;
			$stack = array();
			do {
				if($tmp->data->type == T_WHITESPACE) {
					$stack[] = $tmp;
					continue;
				} else if ($tmp->data->type == T_IF){
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_ELSEIF){
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_FOREACH){
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_WHILE){
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_FOR){
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_SWITCH){
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_CATCH){
					$this->inject(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else {
					return false;
				}
			} while($tmp = $tmp->previous);
		} else {
			return false;
		}
	}
}