<?php
namespace Kuroko\Config;

class XMLFileLoader implements LoaderInterface
{
	protected $path;

	public function __construct($filename)
	{
		if (!is_file($filename)) {
			throw new \Exception("{$filename} is not file");
		}

		$this->path = $filename;
	}

	protected function parse_xml(\SimpleXMLIterator $itr)
	{
		foreach ($itr as $key => $val) {
			if ($key == "entry") {
				$child = $itr->getChildren();
				$k =  strval($child->key);
				$v =  strval($child->value);
				if ($v == "true") {
					$v = true;
				} else if ($v == "false") {
					$v = false;
				}
				if (empty($k)) {
					$arr[] = $v;
				} else {
					$arr[$k] = $v;
				}
			} else {
				$arr[$key] = ($itr->hasChildren()) ?
					$this->parse_xml($val) :
					strval($val);
			}
		}
		return $arr;
	}

	public function load()
	{
		return $this->parse_xml(
			new \SimpleXmlIterator(file_get_contents($this->path),null)
		);
	}

}