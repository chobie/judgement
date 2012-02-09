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
		throw new \Exception("could not set config dynamically");
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