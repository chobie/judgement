<?php
namespace Kuroko;

class Config implements \ArrayAccess
{
	protected $config = array();

	public function __construct(Config\LoaderInterface $loader)
	{
		$this->config = $loader->load();
	}

	public function offsetUnset($offset)
	{
		throw new \Exception("could not unset config dynamically");
	}

	public function offsetSet($offset, $value)
	{
		$entries = explode(".",$offset);
		$count = count($entries);
		$current = &$this->config;
		for ($i = 0; $i < $count; $i++) {
			if (isset($current[$entries[$i]])) {
				if ($i+1 == $count) {
					$current[$entries[$i]] = $value;
				} else {
					$current = &$current[$entries[$i]];
				}
			}
		}
	}

	public function offsetGet($offset)
	{
		$entries = explode(".",$offset);

		$current = $this->config;
		$entry = array_shift($entries);
		do {
			if (isset($current[$entry])) {
				$current = $current[$entry];
			} else {
				return null;
			}
		} while($entry = array_shift($entries));

		return $current;
	}

	public function offsetExists($offset)
	{
		$entries = explode(".",$offset);

		$current = $this->config;
		$entry = array_shift($entries);
		do {
			if (isset($current[$entry])) {
				$current = $current[$entry];
			} else {
				return false;
			}
		} while($entry = array_shift($entries));

		return true;
	}
}