<?php

namespace src\php;

class Input
{
	private static $flags;

	private function set($key, $value)
	{
		self::$flags[$key] = $value;
	}

	private function setFlags()
	{
		global $argv;
		$curIndex = 0;
		$curFlag = null;
		foreach ($argv as $item)
		{
			if (strpos($item, '--') === 0)
			{
				//	string flag: "--output"
				$curFlag = trim($item, '-');
				self::set($curFlag, true);
			}
			else if (strpos($item, '-') === 0)
			{
				//	char flags: "-xyz"
				$flags = str_split(trim($item, '-'));
				foreach ($flags as $flag)
				{
					$curFlag = $flag;
					self::set($curFlag, true);
				}
			}
			else
			{
				//	some value
				if (empty($curFlag))
				{
					//	number instead of flag
					$curFlag = $curIndex++;
				}
				self::set($curFlag, $item);
				$curFlag = null;
			}
		}
	}

	public static function get($key = null, $default = null)
	{
		if (!isset(self::$flags))
		{
			self::setFlags();
		}
		if (empty($key))
		{
			return self::$flags;
		}
		if (!isset(self::$flags[$key]))
		{
			return $default;
		}
		return self::$flags[$key];
	}

	public static function prompt($text)
	{
		if (!empty($text))
		{
			echo $text;
		}
		$handle = fopen('php://stdin', 'r');
		do {
			$line = fgets($handle);
		}
		while ($line == '');
		fclose($handle);
		return $line;
	}
}