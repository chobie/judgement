<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\DoubleLinkedList;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\Token;

class BeforeParentheses extends \Kuroko\CodeStyleFilter
{
	/**
	 * expected configurations:
	 *
	 * spaces.before_parentheses.if
	 * spaces.before_parentheses.foreach
	 * spaces.before_parentheses.while
	 * spaces.before_parentheses.for
	 * spaces.before_parentheses.switch
	 * spaces.before_parentheses.catch
	 *
	 * @param \Kuroko\DoubleLinkedListNode $node
	 * @return bool
	 */
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
				} else if ($this->config['spaces.before_parentheses.if'] && $tmp->data->type == T_IF){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($this->config['spaces.before_parentheses.if'] && $tmp->data->type == T_ELSEIF){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($this->config['spaces.before_parentheses.foreach'] && $tmp->data->type == T_FOREACH){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($this->config['spaces.before_parentheses.while'] && $tmp->data->type == T_WHILE){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($this->config['spaces.before_parentheses.for'] && $tmp->data->type == T_FOR){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($this->config['spaces.before_parentheses.switch'] && $tmp->data->type == T_SWITCH){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($this->config['spaces.before_parentheses.catch'] && $tmp->data->type == T_CATCH){
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