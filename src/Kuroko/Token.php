<?php
namespace Kuroko;

class Token
{
	const T_NEWLINE = -1;
	const T_BRACE_LEFT = -2;

	public $type;
	public $data;
	public $line;

	public function __construct($token)
	{
		if(is_string($token)){
			$number = 0;
			switch($token) {
				case "{":
					$number = self::T_BRACE_LEFT;
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