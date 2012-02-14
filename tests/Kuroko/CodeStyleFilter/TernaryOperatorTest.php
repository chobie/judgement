<?php

use Kuroko\CodeStyleFilter\TernaryOperator;
use Kuroko\CodeStyleFilter\LevelManager;
use Kuroko\Config;
use Kuroko\Config\XMLFileLoader;
use Kuroko\Token;
use Kuroko\TokenParser;
use Kuroko\DoubleLinkedList;

class TernaryOperatorTest extends Judgement_CodeStyleFilter_TestCase
{
	public function testAfterQuestion()
	{
		$script = <<<'EOF'
<?php $abc = isset($abc)?$def:$mode;
EOF;

		$config = $this->getConfig();
		$tokens = $this->getTokens($script);

		$filter = array(
			new LevelManager($config),
			new TernaryOperator($config),
		);

		$this->apply($filter, $tokens);

		$result = $this->render($tokens);

		$this->assertEquals('<?php $abc = isset($abc) ? $def: $mode;',$result);
	}
}