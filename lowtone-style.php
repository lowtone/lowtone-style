<?php
/*
 * Plugin Name: Lowtone Style
 * Plugin URI: http://wordpress.lowtone.nl/lib-style
 * Description: Lowtone Style library.
 * Version: 1.0
 * Author: Lowtone <info@lowtone.nl>
 * Author URI: http://lowtone.nl
 * License: http://wordpress.lowtone.nl/license
 */

namespace lowtone\style {

	use lowtone\Util;
	
	if (!class_exists("lowtone\\Lowtone"))
		return;
	
	Util::addMergedPath(__NAMESPACE__);
	
}