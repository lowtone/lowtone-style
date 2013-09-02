<?php
namespace lowtone\style\styles;

/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2011-2012, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\libs\lowtone\style\styles;
 */
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

	protected static $__divisions = array();

	/**
	 * Convert a numeric division to a textual identifier.
	 * @param string $width The numeric identifier.
	 * @return string Returns a textual division identifier.
	 */
	public function translateWidth($width) {
		list($numerator, $denominator) = explode("/", $width);

		return self::$numerators[$numerator-1] . "-" . self::$denominators[$denominator-1];
	}

	/**
	 * Callback function for column shortcode. The shortcode will create a 
	 * column div using the width, alpha, and omega value from the attributes.
	 * @param array $atts The attributes used to create the output.
	 * @param string $content The content for the column.
	 * @return string Returns the column output.
	 */
	public function shortcode($atts, $content) {
		$atts = array_merge(array(
				"class" => "column",
			), (array) $atts);

		$class = array();

		if (isset($atts["width"])) {
			$width = $atts["width"];

			if (strstr($width, "/"))
				$width = Grid::translateWidth($width);

			$class[] = $width;
		}

		$class[]  = $atts["class"];

		$att = function($key) use ($atts) {
			return isset($atts[$key])
				? $atts[$key]
				: (false !== ($i = array_search($key, $atts)) && is_int($i) ?: NULL);
		};

		if (($alpha = $att("alpha")) && $alpha)
			$class[] = "alpha";

		if (($omega = $att("omega")) && $omega)
			$class[] = "omega";

		return sprintf('<div class="%s">', implode(" ", $class)) . 
			$content .
			'</div>';
	}

	/**
	 * Get a list of all positible divisions using the provided maximum number 
	 * of columns.
	 * @param integer $numberOfColumns The maximum number of columns.
	 * @return array Returns a list of divisions.
	 */
	public function divisions($numberOfColumns = 16) {
		if (isset(self::$__divisions[$numberOfColumns]))
			return self::$__divisions[$numberOfColumns];

		$divisions = array();

		for ($widths = array(), $denominator = 1; $denominator <= $numberOfColumns; $denominator++) 
			for ($numerator = 1; $numerator <= $denominator; $numerator++) {
				$width = 100/$denominator*$numerator;

				if (in_array($width, $widths))
					continue;

				$divisions[] = compact("numerator", "denominator");

				$widths[] = $width;
			}

		return self::$__divisions[$numberOfColumns] = $divisions;
	}

	/**
	 * Register column shortcodes using the given maximum number of columns. 
	 * Shortcodes are created using their textual identifier as tag (e.g. 
	 * one-half or two-third).
	 * @param int $numberOfColumns The maximum number of columns.
	 * @param array $defaults Default attributes for the shortcode.
	 */
	public function registerShortcodes($numberOfColumns, $defaults = array()) {
		foreach (self::divisions($numberOfColumns) as $div) {
			$defaults["width"] = $width = self::$numerators[$div["numerator"]-1] . "-" . self::$denominators[$div["denominator"]-1];

			add_shortcode($width, function($atts, $content) use ($defaults) {
				return Grid::shortcode(array_merge((array) $atts, $defaults), $content);
			});
		}
	}

}