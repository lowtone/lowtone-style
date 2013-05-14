<?php
namespace lowtone\style\styles;

class Grid {

	protected static $numerators = array(
			"one",
			"two",
			"three",
			"four",
			"five",
			"six",
			"seven",
			"eight",
			"nine",
			"ten",
			"eleven",
			"twelve",
			"thirteen",
			"fourteen",
			"fifteen",
			"sixteen",
		),
		$denominators = array(
			"whole",
			"half",
			"third",
			"fourth",
			"fifth",
			"sixth",
			"seventh",
			"eighth",
			"ninth",
			"tenth",
			"eleventh",
			"twelfth",
			"thirteenth",
			"fourteenth",
			"fifteenth",
			"sixteenth",
		);

	public function translateWidth($width) {
		list($numerator, $denominator) = explode("/", $width);

		return self::$numerators[$numerator-1] . " " . self::$denominators[$denominator-1];
	}

}