<?php

namespace App;

class Output
{
	public static function write($string, $color = false, $style = false, $eol = "")
	{
		//	no text styling
		if (empty($color) && empty($style))
		{
			echo $string . $eol;
			return;
		}
		//	styled text
		$colors = [
			'BLACK' => 30,
			'RED' => 31,
			'GREEN' => 32,
			'YELLOW' => 33,
			'BLUE' => 34,
			'MAGENTA' => 35,
			'CYAN' => 36,
			'WHITE' => 37,
			'BLACKBG' => 40,
			'REDBG' => 41,
			'GREENBG' => 42,
			'YELLOWBG' => 43,
			'BLUEBG' => 44,
			'MAGENTABG' => 45,
			'CYANBG' => 46,
			'WHITEBG' => 47,
		];
		$styles = [
			'RESET' => 0,
			'BOLD' => 1,
			'UNDERLINE' => 4,
			'INVERSE' => 7,
			'BOLDOFF' => 21,
			'UNDERLINEOFF' => 24,
			'INVERSEOFF' => 27,
		];
		$colorCode = $colors[$color] ?? $colors['WHITE'];
		$styleCode = $styles[$style] ?? $styles['RESET'];
		echo sprintf("\033[%d;%dm%s\033[0m%s", $styleCode, $colorCode, $string, $eol);
	}

	public static function writeln($string, $color = false, $style = false)
	{
		self::write($string, $color, $style, PHP_EOL);
	}

	public static function json($data, $pretty = JSON_PRETTY_PRINT)
	{
		self::writeln(json_encode($data, $pretty));
	}

	public static function error($string)
	{
		self::writeln($string, 'RED');
	}

	public static function warning($string)
	{
		self::writeln($string, 'YELLOW');
	}

	public static function success($string)
	{
		self::writeln($string, 'GREEN');
	}

	public static function clear()
	{
		system('clear');
	}
}