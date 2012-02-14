<?php
namespace Kuroko\CodeStyleFilter;

use \Kuroko\CodeStyleFilter;
use \Kuroko\DoubleLinkedListNode;
use \Kuroko\Token;

class LevelManager extends CodeStyleFilter
{
	protected static $level = 0;
	protected static $sublevel = 0;
	protected static $paren = 0;
	protected static $case = 0;
	protected static $within_class = false;
	protected static $within_method = false;
	protected static $within_switch = array();
	protected static $brace_left_callback = array();
	protected static $brace_right_callback = array();
	protected static $current_block = array();
	protected static $ternary = false;

	public function decreaseSwitch()
	{
		array_pop(self::$within_switch);
	}

	public function apply(DoubleLinkedListNode $node)
	{
		$token = $node->data;
		if ($token->type == Token::T_BRACE_LEFT) {
			self::$level++;
			if (isset(self::$brace_left_callback[self::$level])) {
				while($callback = array_pop(self::$brace_left_callback[self::$level])) {
					call_user_func_array($callback, array());
				}
			}
		} else if ($token->type == Token::T_BRACE_RIGHT) {
			self::$level--;
			if (self::$level == 0 && self::$within_class) {
				self::$within_class = false;
			}
			if (isset(self::$brace_right_callback[self::$level])) {
				while($callback = array_pop(self::$brace_right_callback[self::$level])) {
					call_user_func_array($callback, array());
				}
			}
		} else if ($token->type == Token::T_PAREN_LEFT) {
			self::$paren++;
		} else if ($token->type == Token::T_PAREN_RIGHT) {
			self::$paren--;
		} else if ($token->type == Token::T_SWITCH) {
			self::$within_switch[] = array("level"=>self::getLevel());

			self::$brace_right_callback[self::getLevel()][] = array($this, "decreaseSwitch");
		} else if ($token->type == Token::T_CASE || $token->type == Token::T_DEFAULT) {
			/* for switch statement */
			// self::$within_switch[count(self::$within_switch)-1];
			// for now, do not increase level when meet case or default statement.
			//self::$level++;
			self::$sublevel++;
			self::$case++;
		} else if ($token->type == Token::T_BREAK && (self::$case > 0)) {
			// for now, do not increase level when meet case or default statement.
			//self::$level--;
			self::$sublevel--;
			self::$case--;
		} else if ($token->data == "?") {
			self::$ternary = true;
		} else if ($token->data == ";") {
			self::$ternary = false;
		}

		if ($token->type == Token::T_CLASS) {
			self::$within_class = true;
		} else if ($token->type == Token::T_FUNCTION) {
			if (self::isInsideClass()) {
				self::$brace_left_callback[self::getLevel()+1][] = array($this, "withinMethod");
				self::$brace_right_callback[self::getLevel()][] = array($this, "moe");
			}
		}
	}

	public function withinMethod()
	{
		self::$within_method = true;
	}

	public function moe()
	{
		self::$within_method = false;
	}

	public static function isInsideTernaryOperator()
	{
		return (bool)self::$ternary;
	}

	public static function isInsideParentheses()
	{
		return (bool)(self::$paren > 0);
	}

	public static function isInsideClass()
	{
		return (bool)(self::$within_class);
	}

	public static function isInsideMethod()
	{
		return (bool)(self::$within_method);
	}

	public static function isInsideSwitch()
	{
		return (bool)(self::$within_switch);
	}

	public static function getLevel()
	{
		return self::$level + self::$sublevel;
	}
}