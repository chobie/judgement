<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\CodeStyleFilter;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\Token;

class BeforeLeftBraces extends CodeStyleFilter
{
	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;
		//@todo 前のopcodeでなにするか変える

		if ($token->data == "{") {
			$tmp = $node->previous;
			$stack = array();
			do {
				if($tmp->data->type == T_WHITESPACE) {
					$stack[] = $tmp;
					continue;
				} else if ($tmp->data->data == ")"){
					$this->inject($this->whitespace(), $tmp, $node);
				} else if ($tmp->data->type == Token::T_CLASS) {
					if ($this->config['spaces.before_left_brace.class']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_FUNCTION) {
					if ($this->config['spaces.before_left_brace.function']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_IF) {
					if ($this->config['spaces.before_left_brace.if']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_ELSE) {
					if ($this->config['spaces.before_left_brace.else']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_FOR) {
					if ($this->config['spaces.before_left_brace.for']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_WHILE) {
					if ($this->config['spaces.before_left_brace.while']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_DO) {
					if ($this->config['spaces.before_left_brace.do']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_SWITCH) {
					if ($this->config['spaces.before_left_brace.switch']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_TRY) {
					if ($this->config['spaces.before_left_brace.try']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else if ($tmp->data->type == Token::T_CATCH) {
					if ($this->config['spaces.before_left_brace.catch']) {
						$this->inject($this->whitespace(), $tmp, $node);
					} else {
						foreach ($stack as $ignore) {
							$this->delete($ignore);
						}
					}
				} else {
					return false;
				}
			} while($tmp = $tmp->previous);
		} else {
			return false;
		}
	}
}