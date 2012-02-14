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
						if ($lbrace->previous->data->type == Token::T_WHITESPACE) {
							$this->delete($lbrace->previous);
						}
						$this->inject($this->newline(), $lbrace->previous, $lbrace);
						if ($lbrace->next->next->data->type != Token::T_INDENT) {
							$this->inject($this->indent(LevelManager::getLevel()+1),$lbrace->next,$lbrace->next->next);
						}
					}
					break;
				case "eol":
					if ($lbrace->next->data->type != Token::T_NEWLINE) {
						$this->inject($this->newline(), $lbrace, $lbrace->next);
					}
					if ($lbrace->previous->data->type == Token::T_INDENT) {
						$this->delete($lbrace->previous);
						$this->delete($lbrace->previous);
					}
				break;
			}
		} else if ($token->type == T_FUNCTION) {
			$newline = $this->expectr($node, Token::T_NEWLINE);

			if ($newline->next->data->type == Token::T_INDENT) {
				$tab = LevelManager::getLevel();
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
		} else if ($token->type == Token::T_BRACE_LEFT && $node->previous->data->type != Token::T_VARIABLE) {
			$lbrace = $node;
			$type = strtolower($this->config['wrapping_and_braces.braces.default']);

			switch($type) {
				case "eol":
					if ($lbrace->previous->data->type == Token::T_INDENT) {
						$i = $lbrace->previous->data;
						$i->data = str_repeat(($this->config['indents.use_tab']) ? "\t" : " ",
							(LevelManager::getLevel()-1) * $this->config['indents.indent']);
					} else if ($lbrace->next->data->type != Token::T_NEWLINE) {
						$this->inject($this->newline(), $lbrace, $lbrace->next);
						$this->inject($this->indent(LevelManager::getLevel()),$lbrace->next,$lbrace->next->next);
					}
				break;
			}
		}
	}
}
