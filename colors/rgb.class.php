<?php
namespace lowtone\style\colors;

/**
 * @author Paul van der Meijs <code@lowtone.nl>
 * @copyright Copyright (c) 2011-2012, Paul van der Meijs
 * @license http://wordpress.lowtone.nl/license/
 * @version 1.0
 * @package wordpress\libs\lowtone\style\colors
 */
class RGB extends Color {

	// Static
	
	public static function fromString($color) {
		$color = trim($color, "#");

		list($r, $g, $b) = str_split($color, strlen($color) > 3 ? 2 : 1);

		return new static(array(
				self::CHANNEL_RED => hexdec($r),
				self::CHANNEL_GREEN => hexdec($g),
				self::CHANNEL_BLUE => hexdec($b)
			)); 
	}

	public static function fromHsv(HSV $hsv) {
		$H = $hsv->{HSV::HUE};
		$S = $hsv->{HSV::SATURATION};
		$V = $hsv->{HSV::VALUE};
		
		$H *= 6;
		
		$I = floor($H);
		$F = $H - $I;
		
		$M = $V * (1 - $S);
		$N = $V * (1 - $S * $F);
		$K = $V * (1 - $S * (1 - $F));

		switch ($I) {
			case 0:
				list($R,$G,$B) = array($V,$K,$M);
				break;
			case 1:
				list($R,$G,$B) = array($N,$V,$M);
				break;
			case 2:
				list($R,$G,$B) = array($M,$V,$K);
				break;
			case 3:
				list($R,$G,$B) = array($M,$N,$V);
				break;
			case 4:
				list($R,$G,$B) = array($K,$M,$V);
				break;
			case 5:
			case 6: //for when $H=1 is given
				list($R,$G,$B) = array($V,$M,$N);
				break;
		}
		
		return new RGB(array(
				self::CHANNEL_RED => $R*255,
				self::CHANNEL_GREEN => $G*255,
				self::CHANNEL_BLUE => $B*255
			));
	}

	public static function fromHsl(HSL $hsl) {
		return $hsl->toRgb();
	}

}