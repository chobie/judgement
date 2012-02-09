<?php
namespace Kuroko;

class DoubleLinkedList
{
	public $front;
	public $back;

	protected $offset;

	public function add($data)
	{
		$node = new DoubleLinkedListNode($data);
		if (is_null($this->front)) {
			$this->front = $node;
		}

		if ($this->back) {
			$this->back->next = $node;
		}
		$node->previous = $this->back;
		$node->next = null;
		$this->back = $node;
	}
}
