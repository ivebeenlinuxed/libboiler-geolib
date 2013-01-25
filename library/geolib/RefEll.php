<?php
namespace Library\GeoLib;

class RefEll {

	var $maj;
	var $min;
	var $ecc;


	/**
	 * Create a new RefEll object to represent a reference ellipsoid
	 *
	 * @param maj the major axis
	 * @param min the minor axis
	 */
	function __construct($maj, $min) {
		$this->maj = $maj;
		$this->min = $min;
		$this->ecc = (($maj * $maj) - ($min * $min)) / ($maj * $maj);
	}
}