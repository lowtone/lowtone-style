<?php
namespace lowtone\style\colors;
use lowtone\types\objects\Object;

/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2011-2012, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\libs\lowtone\style\colors
 */
abstract class Color extends Object {

	const CHANNEL_ALPHA = "a",
		CHANNEL_RED = "r",
		CHANNEL_GREEN = "g",
		CHANNEL_BLUE = "b",
		CHANNEL_CYAN = "c",
		CHANNEL_MAGENTA = "m",
		CHANNEL_YELLOW = "y",
		CHANNEL_BLACK = "k";

	const HUE = "h",
		SATURATION = "s",
		VALUE = "v",
		LIGHTNESS = "l";

	// Modification

	public function lighten($perc) {
		$this->{self::LIGHTNESS} += $perc/100;

		if ($this->{self::LIGHTNESS} > 1)
			$this->{self::LIGHTNESS} = (float) 1;
		
		return $this;
	}

	public function darken($perc) {
		return $this($this->toHsl()->darken($perc));
	}

	// Conversion

	public function toHsl() {
		if ($this instanceof HSL)
			return $this;

		if ($this instanceof HSV)
			return HSL::fromHsv($this);

		if ($this instanceof RGB)
			return HSL::fromRgb($this);
	}

	public function toHsv() {
		if ($this instanceof HSV)
			return $this;

		if ($this instanceof HSL)
			return HSV::fromHsl($this);

		if ($this instanceof RGB)
			return HSV::fromRgb($this);
	}

	public function toRgb() {
		if ($this instanceof RGB)
			return $this;

		if ($this instanceof HSL)
			return RGB::fromHsl($this);

		if ($this instanceof HSV)
			return RGB::fromHsv($this);
	}

	public function __toString() {
		return "#" . str_pad(dechex((int) round($this->{self::CHANNEL_RED}) % 256), 2, "0", STR_PAD_LEFT) . 
			str_pad(dechex((int) round($this->{self::CHANNEL_GREEN}) % 256), 2, "0", STR_PAD_LEFT) . 
			str_pad(dechex((int) round($this->{self::CHANNEL_BLUE}) % 256), 2, "0", STR_PAD_LEFT);
	}

}