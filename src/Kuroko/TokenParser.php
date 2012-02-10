<?php
namespace Kuroko;

class TokenParser
{
	public static function parse($string)
	{
		$tokens = token_get_all($string);
		$result = array();
		foreach ($tokens as $token) {
			$is_indent = false;

			if (is_array($token) && $token[0] == T_WHITESPACE) {
				while(preg_match("/^\r?\n/",$token[1],$match)) {
					$is_indent = true;
					$result[] = array(
						Token::T_NEWLINE,
						$match[0],
						0
					);

					$token[1] = substr($token[1], strlen($match[0]));
					if (empty($token[1])) {
						$token = null;
						break;
					}
				}
			}

			if (!is_null($token)){
				if ($is_indent) {
					$token[0] = Token::T_INDENT;
				}
				$result[] = $token;
			}
		}

		return $result;
	}
}