<?php
namespace Kuroko;

abstract class CodeStyleFilter
{
	protected $config;

	abstract public function apply(DoubleLinkedListNode $node);

	public function __construct($config)
	{
		$this->config = $config;
	}

	public function newline()
	{
		return new DoubleLinkedListNode(new Token(array(Token::T_NEWLINE,"\n",0)));
	}

	public function indent($size=1)
	{
		switch($this->config["indents.use_tab"]) {
			case true:
				$indent = "\t";
				break;
			case false:
				$indent = str_repeat(" ",$this->config["indents.indent"]);
				break;
		}

		return new DoubleLinkedListNode(new Token(array(T_WHITESPACE,str_repeat($indent,$size),0)));
	}

	public function whitespace($size=1)
	{
		return new DoubleLinkedListNode(new Token(array(T_WHITESPACE,str_repeat(" ",$size),0)));
	}

	public function newVisibility($visibility = "public")
	{
		switch ($visibility) {
			case "protected":
				$data = array(T_PROTECTED,"protected",0);
				break;
			case "private":
				$data = array(T_PRIVATE,"private",0);
				break;
			case "public":
			default:
				$data = array(T_PUBLIC, "public",0);
				break;
		}

		return new DoubleLinkedListNode(new Token($data));
	}

	public function delete(DoubleLinkedListNode $ws)
	{
		$previous = $ws->previous;
		$next = $ws->next;

		$next->previous = $previous;
		$previous->next = $next;
	}

	public function inject(DoubleLinkedListNode $ws,DoubleLinkedListNode $previous,DoubleLinkedListNode $next)
	{
		$previous->next = $ws;
		$ws->previous = $previous;
		$ws->next = $next;
		$next->previous = $ws;
	}

	public function without(DoubleLinkedListNode $node, $without)
	{
		$current = $node->next;
		do {
			if ($current->data->type != $type) {
				return $current;
			}
		} while($current = $current->next);
	}

	public function expect(DoubleLinkedListNode $node, $type)
	{
		$current = $node;
		do {
			if ($current->data->type == $type) {
				return $current;
			}
		} while($current = $current->next);
	}

	// expect block end
	public function expectb(DoubleLinkedListNode $node)
	{
		$level = 0;

		$current = $node;
		do {
			if ($current->data->type == Token::T_BRACE_LEFT) {
				$level++;
			} else if ($current->data->type == Token::T_BRACE_RIGHT) {
				$level--;
			}

			if (level == 0 && $current->data->type == Token::T_BRACE_RIGHT) {
				return $current;
			}
		} while($current = $current->next);

		throw new \Exception("Mismatched block found");
	}

	public function expectr(DoubleLinkedListNode $node, $type)
	{
		$current = $node;
		do {
			if ($current->data->type == $type) {
				return $current;
			}
		} while($current = $current->previous);
	}

}