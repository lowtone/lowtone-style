<?php
namespace lowtone\style\colors;

/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2011-2012, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\libs\lowtone\style\colors
 */
class HSL extends Color {

	// Modification

	public function lighten($perc) {
		$this->{self::LIGHTNESS} += $perc/100;

		if ($this->{self::LIGHTNESS} > 1)
			$this->{self::LIGHTNESS} = (float) 1;
		
		return $this;
	}

	public function darken($perc) {
		$this->{self::LIGHTNESS} -= $perc/100;

		if ($this->{self::LIGHTNESS} < 0)
			$this->{self::LIGHTNESS} = (float) 0;

		return $this;
	}

	// Conversion

	public function __toString() {
		return (string) HSV::fromHsl($this);
	}

	// Static
	
	public static function fromHsv(HSV $hsv) {
		$L = (2 - $hsv->{self::SATURATION} / 100) * $hsv->{self::VALUE} / 2;

		$H = $hsv->{self::HUE};
		$S = $hsv->{self::SATURATION} * $hsv->{self::VALUE} / ($L < 50 ? $L * 2 : 200 - $L * 2);

		if (false === $S)
			$S = 0;

		return new static(array(
				self::HUE => $H,
				self::SATURATION => $S,
				self::LIGHTNESS => $L
			));
	}

	public static function fromRgb(RGB $rgb) {
		return $rgb->toHsl();
	}

}