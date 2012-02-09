<?php

$xml = simplexml_load_file("config.xml");
$config = array();

function parse_config(SimpleXmlIterator $itr)
{
	foreach ($itr as $key => $val) {
		if ($key == "entry") {
			$child = $itr->getChildren();
			$k =  strval($child->key);
			$v = strval($child->value);
			if ($v == "true") {
				$v = true;
			} else if ($v == "false") {
				$v = false;
			}
			
			$arr[$k] = $v;
		} else {
			$arr[$key] = ($itr->hasChildren()) ?
				parse_config($val) :
				strval($val);
		}
	}
	return $arr;
}

$config = parse_config(new SimpleXmlIterator(file_get_contents("config.xml"),null));


define("T_NEWLINE",-1);
define("T_BRACE_LEFT",-2);

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

class Token
{
	public $type;
	public $data;
	public $line;
	
	public function __construct($token)
	{
		if(is_string($token)){
			$number = 0;
			switch($token) {
				case "{":
					$number = T_BRACE_LEFT;
					break;
			}

			$this->type = $number;
			$this->data = $token;
			$this->line = null;
		}else{
			$this->type = $token[0];
			$this->data = $token[1];
			$this->line = $token[2];
		}
	}
}

function ab($ws,$previous,$next)
{
	$previous->next = $ws;
	$ws->previous = $previous;
	$ws->next = $next;
	$next->previous = $ws;
}

abstract class Filter
{
	protected $config;
	
	public function __construct($config)
	{
		$this->config = $config;
	}
}

class BeforeParenthesesFilter extends Filter
{
	public function apply($node)
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
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_ELSEIF){
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_FOREACH){
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_WHILE){
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_FOR){
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_SWITCH){
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else if ($tmp->data->type == T_CATCH){
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else {
					return false;
				}
			} while($tmp = $tmp->previous);
		} else {
			return false;
		}
	}
}

class BeforeLeftBracesFilter extends Filter
{
	public function apply($node)
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
						ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $tmp, $node);
				} else {
					return false;
				}
			} while($tmp = $tmp->previous);
		} else {
			return false;
		}
	}
}

class ArroundOperatorsFilter extends Filter
{
	public function apply($node)
	{
		$token = $node->data;
		switch($token->data) {
			case "=":
			case "==":
			case "===":
			case "!=":
			case "!==":
			case "-=":
			case "+=":
			case "<<":
			case "<":
			case ">":
			case ">>":
			case ">>>":
			case "&":
			case "|":
			case "&&":
			case "||":
			case "/":
			case "*":
			case "^":
			case "%":
			case ".":
				if ($node->previous->data->type != T_WHITESPACE) {
					ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node->previous, $node);
				}
				if ($node->next->data->type != T_WHITESPACE) {
					ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node, $node->next);
				}
				break;
		}
	}
}

class TernaryOperatorFilter extends Filter
{
	public function apply($node)
	{
		$token = $node->data;
		switch($token->data) {
			case "?":
			case ":":
				if ($node->next->data->type != T_WHITESPACE) {
					ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node, $node->next);
				}
				if ($node->next->data->type != T_WHITESPACE) {
					ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node, $node->next);
				}
				break;
		}
	}
}

class OtherFilter extends Filter
{
	public function apply($node)
	{
		$token = $node->data;
		switch($token->data) {
			case ",":
			case ";":
				if ($node->next->data->type != T_WHITESPACE) {
					ab(new DoubleLinkedListNode(new Token(array(T_WHITESPACE," ",0))), $node, $node->next);
				}
				break;
		}
	}
}

class IndentationFilter extends Filter
{
	public function apply($node)
	{
		$token = $node->data;
		if($token->type == T_WHITESPACE && $node->previous->data->type == T_NEWLINE) {
			$length = strlen($token->data);
			if ($length) {
				$token->data = str_repeat(" ",$length*4);
			}
		}
	}
}

function without(DoubleLinkedListNode $node, $without)
{
	$current = $node;
	do {
		if ($current->data->type != $type) {
			return $current;
		}
	} while($current = $current->next);
}

function expect(DoubleLinkedListNode $node, $type)
{
	$current = $node;
	do {
		if ($current->data->type == $type) {
			return $current;
		}
	} while($current = $current->next);
}

function expectr(DoubleLinkedListNode $node, $type)
{
	$current = $node;
	do {
		if ($current->data->type == $type) {
			return $current;
		}
	} while($current = $current->previous);
}


class BracesPlacementFilter extends Filter
{
	public function apply($node)
	{
		$token = $node->data;
		if($token->type == T_CLASS) {
			$lbrace = expect($node, T_BRACE_LEFT);
			if ($lbrace->previous->data->type != T_WHITESPACE) {
				ab(new DoubleLinkedListNode(new Token(array(T_NEWLINE,"\n",0))), $lbrace->previous, $lbrace);
			}
		}
	}
}

function super_token_get_all($string)
{
	$tokens = token_get_all($string);
	$result = array();
	foreach ($tokens as $token) {
		if (is_array($token) && $token[0] == T_WHITESPACE) {
			while(preg_match("/^\r?\n/",$token[1],$match)) {
				$result[] = array(
					T_NEWLINE,
					"\n",
					0
					);
				$token[1] = substr($token[1],strlen($match[1])+1);
			}
		}
		$result[] = $token;
	}

	return $result;
}

$tokens = super_token_get_all(file_get_contents("tmp.php"));

$d = new DoubleLinkedList();
foreach($tokens as $token){
	$d->add(new Token($token));
}

$formatter = array(
	new IndentationFilter($config),
	new BeforeParenthesesFilter($config),
	new BeforeLeftBracesFilter($config),
	new ArroundOperatorsFilter($config),
	new TernaryOperatorFilter($config),
	new OtherFilter($config),
	new BracesPlacementFilter($config),
);

$current = $d->front;
do {
	foreach($formatter as $f) {
		$f->apply($current);
	}
} while ($current = $current->next());

$current = $d->front;
do {
	echo $current->data->data;
} while ($current = $current->next());
