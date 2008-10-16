<?php

/**
 * Class to facilitate command-line output.
 * Support less-trivial output stuff such as colours (on xterm-color)
 */
class SSCli extends Object {
	static function supports_colour() {
		if(!defined('STDOUT')) define('STDOUT', fopen("php://stdout","w"));
		return @posix_isatty(STDOUT);
	}
	
	/**
	 * Return text encoded for CLI output, optionally coloured
	 * @param string $fgColour The foreground colour - black, red, green, yellow, blue, magenta, cyan, white.  Null is default.
	 * @param string $bgColour The foreground colour - black, red, green, yellow, blue, magenta, cyan, white.  Null is default.
	 * @param string $bold A boolean variable - bold or not.
	 */
	static function text($text, $fgColour = null, $bgColour = null, $bold = false) {
		if(!self::supports_colour()) return $text;

		$colours = array(
			'black' => 0,
			'red' => 1,
			'green' => 2,
			'yellow' => 3,
			'blue' => 4,
			'magenta' => 5,
			'cyan' => 6,
			'white' => 7,
		);
		
		$prefix = $suffix = "";

		if($fgColour || $bgColour || $bold) {
			$suffix .= "\033[0m";

			if($fgColour || $bold) {
				if(!$fgColour) $fgColour = "white";
				$prefix .= "\033[" . ($bold ? "1;" :"") . "3" . $colours[$fgColour] . "m";
			}
			

			if($bgColour) {
				$prefix .= "\033[4" . $colours[$bgColour] . "m";
			}
		}
		
		return $prefix . $text . $suffix;
		
		
	}
}

?>
