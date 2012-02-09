<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\DoubleLinkedList;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\Token;

class BeforeParentheses extends \Kuroko\CodeStyleFilter
{
	public function apply(DoubleLinkedListNode $node)
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
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($tmp->data->type == T_ELSEIF){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($tmp->data->type == T_FOREACH){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($tmp->data->type == T_WHILE){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($tmp->data->type == T_FOR){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($tmp->data->type == T_SWITCH){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($tmp->data->type == T_CATCH){
					$this->inject($this->whitespace(), $tmp, $node);
				} else {
					return false;
				}
			} while($tmp = $tmp->previous);
		} else {
			return false;
		}
	}
}