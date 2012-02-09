<?php
namespace Kuroko;

class DoubleLinkedListNode
{
	public $data;
	public $next;
	public $previous;

	public function __construct($data)
	{
		$this->data = $data;
	}

	public function next()
	{
		return $this->next;
	}
}