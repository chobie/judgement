<?php
namespace Kuroko;

abstract class CodeStyleFilter
{
	protected $config;

	public function __construct($config)
	{
		$this->config = $config;
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