<?php

use Kuroko\CodeStyleFilter\BeforeParentheses;
use Kuroko\Config;
use Kuroko\Config\XMLFileLoader;
use Kuroko\Token;
use Kuroko\TokenParser;
use Kuroko\DoubleLinkedList;

class BeforeParenthesesTest extends Judgement_CodeStyleFilter_TestCase
{
	public function testEnabledIf()
	{
		$script = <<<'EOF'
<?php if($moe){};
EOF;

		$config = $this->getConfig();
		$config['spaces.before_parentheses.if'] = true;

		$tokens = $this->getTokens($script);

		$filter = new BeforeParentheses($config);
		$this->apply($filter, $tokens);
		$result = $this->render($tokens);

		$this->assertEquals('<?php if ($moe){};',$result);
	}

	public function testDisabledIf()
	{
		$script = <<<'EOF'
<?php if($moe){};
EOF;

		$config = $this->getConfig();
		$config['spaces.before_parentheses.if'] = false;

		$tokens = $this->getTokens($script);
		$filter = new BeforeParentheses($config);
		$this->apply($filter, $tokens);
		$result = $this->render($tokens);
		$this->assertEquals('<?php if($moe){};',$result);
	}
}