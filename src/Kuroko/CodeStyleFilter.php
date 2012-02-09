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
		$current = $node;
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