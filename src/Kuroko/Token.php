<?php
namespace Kuroko;

class Token
{
	/* extended constants */
	const T_NEWLINE = -1;
	const T_BRACE_LEFT = -2;

	/* default token constants (5.3.8) */
	const T_FMT = \T_FMT;
	const T_FMT_AMPM = \T_FMT_AMPM;
	const T_REQUIRE_ONCE = \T_REQUIRE_ONCE;
	const T_REQUIRE = \T_REQUIRE;
	const T_EVAL = \T_EVAL;
	const T_INCLUDE_ONCE = \T_INCLUDE_ONCE;
	const T_INCLUDE = \T_INCLUDE;
	const T_LOGICAL_OR = \T_LOGICAL_OR;
	const T_LOGICAL_XOR = \T_LOGICAL_XOR;
	const T_LOGICAL_AND = \T_LOGICAL_AND;
	const T_PRINT = \T_PRINT;
	const T_SR_EQUAL = \T_SR_EQUAL;
	const T_SL_EQUAL = \T_SL_EQUAL;
	const T_XOR_EQUAL = \T_XOR_EQUAL;
	const T_OR_EQUAL = \T_OR_EQUAL;
	const T_AND_EQUAL = \T_AND_EQUAL;
	const T_MOD_EQUAL = \T_MOD_EQUAL;
	const T_CONCAT_EQUAL = \T_CONCAT_EQUAL;
	const T_DIV_EQUAL = \T_DIV_EQUAL;
	const T_MUL_EQUAL = \T_MUL_EQUAL;
	const T_MINUS_EQUAL = \T_MINUS_EQUAL;
	const T_PLUS_EQUAL = \T_PLUS_EQUAL;
	const T_BOOLEAN_OR = \T_BOOLEAN_OR;
	const T_BOOLEAN_AND = \T_BOOLEAN_AND;
	const T_IS_NOT_IDENTICAL = \T_IS_NOT_IDENTICAL;
	const T_IS_IDENTICAL = \T_IS_IDENTICAL;
	const T_IS_NOT_EQUAL = \T_IS_NOT_EQUAL;
	const T_IS_EQUAL = \T_IS_EQUAL;
	const T_IS_GREATER_OR_EQUAL = \T_IS_GREATER_OR_EQUAL;
	const T_IS_SMALLER_OR_EQUAL = \T_IS_SMALLER_OR_EQUAL;
	const T_SR = \T_SR;
	const T_SL = \T_SL;
	const T_INSTANCEOF = \T_INSTANCEOF;
	const T_UNSET_CAST = \T_UNSET_CAST;
	const T_BOOL_CAST = \T_BOOL_CAST;
	const T_OBJECT_CAST = \T_OBJECT_CAST;
	const T_ARRAY_CAST = \T_ARRAY_CAST;
	const T_STRING_CAST = \T_STRING_CAST;
	const T_DOUBLE_CAST = \T_DOUBLE_CAST;
	const T_INT_CAST = \T_INT_CAST;
	const T_DEC = \T_DEC;
	const T_INC = \T_INC;
	const T_CLONE = \T_CLONE;
	const T_NEW = \T_NEW;
	const T_EXIT = \T_EXIT;
	const T_IF = \T_IF;
	const T_ELSEIF = \T_ELSEIF;
	const T_ELSE = \T_ELSE;
	const T_ENDIF = \T_ENDIF;
	const T_LNUMBER = \T_LNUMBER;
	const T_DNUMBER = \T_DNUMBER;
	const T_STRING = \T_STRING;
	const T_STRING_VARNAME = \T_STRING_VARNAME;
	const T_VARIABLE = \T_VARIABLE;
	const T_NUM_STRING = \T_NUM_STRING;
	const T_INLINE_HTML = \T_INLINE_HTML;
	const T_CHARACTER = \T_CHARACTER;
	const T_BAD_CHARACTER = \T_BAD_CHARACTER;
	const T_ENCAPSED_AND_WHITESPACE = \T_ENCAPSED_AND_WHITESPACE;
	const T_CONSTANT_ENCAPSED_STRING = \T_CONSTANT_ENCAPSED_STRING;
	const T_ECHO = \T_ECHO;
	const T_DO = \T_DO;
	const T_WHILE = \T_WHILE;
	const T_ENDWHILE = \T_ENDWHILE;
	const T_FOR = \T_FOR;
	const T_ENDFOR = \T_ENDFOR;
	const T_FOREACH = \T_FOREACH;
	const T_ENDFOREACH = \T_ENDFOREACH;
	const T_DECLARE = \T_DECLARE;
	const T_ENDDECLARE = \T_ENDDECLARE;
	const T_AS = \T_AS;
	const T_SWITCH = \T_SWITCH;
	const T_ENDSWITCH = \T_ENDSWITCH;
	const T_CASE = \T_CASE;
	const T_DEFAULT = \T_DEFAULT;
	const T_BREAK = \T_BREAK;
	const T_CONTINUE = \T_CONTINUE;
	const T_GOTO = \T_GOTO;
	const T_FUNCTION = \T_FUNCTION;
	const T_CONST = \T_CONST;
	const T_RETURN = \T_RETURN;
	const T_TRY = \T_TRY;
	const T_CATCH = \T_CATCH;
	const T_THROW = \T_THROW;
	const T_USE = \T_USE;
	const T_GLOBAL = \T_GLOBAL;
	const T_PUBLIC = \T_PUBLIC;
	const T_PROTECTED = \T_PROTECTED;
	const T_PRIVATE = \T_PRIVATE;
	const T_FINAL = \T_FINAL;
	const T_ABSTRACT = \T_ABSTRACT;
	const T_STATIC = \T_STATIC;
	const T_VAR = \T_VAR;
	const T_UNSET = \T_UNSET;
	const T_ISSET = \T_ISSET;
	const T_EMPTY = \T_EMPTY;
	const T_HALT_COMPILER = \T_HALT_COMPILER;
	const T_CLASS = \T_CLASS;
	const T_INTERFACE = \T_INTERFACE;
	const T_EXTENDS = \T_EXTENDS;
	const T_IMPLEMENTS = \T_IMPLEMENTS;
	const T_OBJECT_OPERATOR = \T_OBJECT_OPERATOR;
	const T_DOUBLE_ARROW = \T_DOUBLE_ARROW;
	const T_LIST = \T_LIST;
	const T_ARRAY = \T_ARRAY;
	const T_CLASS_C = \T_CLASS_C;
	const T_METHOD_C = \T_METHOD_C;
	const T_FUNC_C = \T_FUNC_C;
	const T_LINE = \T_LINE;
	const T_FILE = \T_FILE;
	const T_COMMENT = \T_COMMENT;
	const T_DOC_COMMENT = \T_DOC_COMMENT;
	const T_OPEN_TAG = \T_OPEN_TAG;
	const T_OPEN_TAG_WITH_ECHO = \T_OPEN_TAG_WITH_ECHO;
	const T_CLOSE_TAG = \T_CLOSE_TAG;
	const T_WHITESPACE = \T_WHITESPACE;
	const T_START_HEREDOC = \T_START_HEREDOC;
	const T_END_HEREDOC = \T_END_HEREDOC;
	const T_DOLLAR_OPEN_CURLY_BRACES = \T_DOLLAR_OPEN_CURLY_BRACES;
	const T_CURLY_OPEN = \T_CURLY_OPEN;
	const T_PAAMAYIM_NEKUDOTAYIM = \T_PAAMAYIM_NEKUDOTAYIM;
	const T_NAMESPACE = \T_NAMESPACE;
	const T_NS_C = \T_NS_C;
	const T_DIR = \T_DIR;
	const T_NS_SEPARATOR = \T_NS_SEPARATOR;
	const T_DOUBLE_COLON = \T_DOUBLE_COLON;

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