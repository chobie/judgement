<?php
namespace Kuroko;

class TokenParser
{
	public static function parse($string)
	{
		$tokens = token_get_all($string);
		$result = array();
		foreach ($tokens as $token) {
			if (is_array($token) && $token[0] == T_WHITESPACE) {
				while(preg_match("/^\r?\n/",$token[1],$match)) {
					$result[] = array(
						Token::T_NEWLINE,
						"\n",
						0
					);

					$token[1] = substr($token[1], strlen($match[0]) + 1);
				}
			}
			$result[] = $token;
		}

		return $result;
	}
}