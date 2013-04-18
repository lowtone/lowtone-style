<?php
namespace lowtone\style\colors;

/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2011-2012, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\libs\lowtone\style\colors
 */
class HSV extends Color {

	// Modification

	public function lighten($perc) {
		$this->{self::VALUE} += $perc/100;

		if ($this->{self::VALUE} > 1)
			$this->{self::VALUE} = (float) 1;
		
		return $this;
	}

	public function darken($perc) {
		$this->{self::VALUE} -= $perc/100;

		if ($this->{self::VALUE} < 0)
			$this->{self::VALUE} = (float) 0;

		return $this;
	}

	// Conversion

	public function __toString() {
		return (string) RGB::fromHsv($this);
	}

	// Static
	
	public static function fromRgb(RGB $rgb) {
		$HSL = array();

		$var_R = ($rgb->r / 255);
		$var_G = ($rgb->g / 255);
		$var_B = ($rgb->b / 255);

		$var_Min = min($var_R, $var_G, $var_B);
		$var_Max = max($var_R, $var_G, $var_B);
		$del_Max = $var_Max - $var_Min;

		$V = $var_Max;

		if ($del_Max == 0)
		{
		  $H = 0;
		  $S = 0;
		}
		else
		{
		  $S = $del_Max / $var_Max;

		  $del_R = ( ( ( $var_Max - $var_R ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
		  $del_G = ( ( ( $var_Max - $var_G ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;
		  $del_B = ( ( ( $var_Max - $var_B ) / 6 ) + ( $del_Max / 2 ) ) / $del_Max;

		  if      ($var_R == $var_Max) $H = $del_B - $del_G;
		  else if ($var_G == $var_Max) $H = ( 1 / 3 ) + $del_R - $del_B;
		  else if ($var_B == $var_Max) $H = ( 2 / 3 ) + $del_G - $del_R;

		  if ($H<0) $H++;
		  if ($H>1) $H--;
		}

		return new static(array(
				self::HUE => $H,
				self::SATURATION => $S,
				self::VALUE => $V
			));
	}

	public static function fromHsl(HSL $hsl) {
		$T = $hsl->{self::SATURATION} * ($hsl->{self::LIGHTNESS} < 50 ? $hsl->{self::LIGHTNESS} : 100 - $hsl->{self::LIGHTNESS}) / 100;

		$H = $hsl->{self::HUE};
		$S = 200 * $T / ($hsl->{self::LIGHTNESS} + $T);
		$V = $T + $hsl->{self::LIGHTNESS};

		if (false === $S)
			$S = 0;

		return new static(array(
				self::HUE => $H,
				self::SATURATION => $S,
				self::VALUE => $V
			));
	}

}