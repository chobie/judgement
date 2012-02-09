<?php
require "Kuroko/Autoloader.php";

Kuroko\Autoloader::register();

use Kuroko\Config;
use Kuroko\Config\XMLFileLoader;
use Kuroko\DoubleLinkedList;
use Kuroko\TokenParser;
use Kuroko\Token;


$config = new Config(
	new XMLFileLoader("config.xml")
);
$string = file_get_contents($_SERVER['argv'][1]);

/* convert token stream to linked list */
$tokens = TokenParser::parse($string);
$list = new DoubleLinkedList();
foreach($tokens as $token){
	$list->add(new Token($token));
}

/* obtain formatter classes */
$formatter = array();
foreach ($config['formatter'] as $f) {
	$formatter[] = new $f($config);
}

/* do filter */
$current = $list->front;
do {
	foreach($formatter as $f) {
		$f->apply($current);
	}
} while ($current = $current->next());


/* rendering php file */
$current = $list->front;
do {
	echo $current->data->data;
} while ($current = $current->next());

exit(0);
