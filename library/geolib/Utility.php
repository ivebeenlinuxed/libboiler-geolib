<?php
namespace Library\GeoLib;

class Utility {
	public static function WktToArray($wkt) {
		$out = array();
		foreach (explode(")),((", $wkt) as $pt) {
			preg_match_all("/\-?[\d+\.]+\s\-?[\d+\.]+/", $pt, $matches);
			$coords = array();
			foreach ($matches[0] as $coord) {
				$coords[] = explode(" ", $coord);
			}
			$out[] = $coords;
		}
		return $out;
	}
	public static function doRayTest($testPoint, $wkt) {
		$shp = explode(")),((", $wkt);
		foreach ($shp as $pt) {
			$result = false;
			preg_match_all("/\-?[\d+\.]+\s\-?[\d+\.]+/", $pt, $coords);
			$coords = $coords[0];
			for ($i=1; $i<count($coords); $i++) {
				
				$ll = explode(" ",$coords[$i-1]);
				
				$llA = explode(" ",$coords[$i]);
				
				
				if (($ll[1] >= $testPoint[1]  && $testPoint[1] >= $llA[1]) || ($ll[1] <= $testPoint[1]  && $testPoint[1] <= $llA[1])) {
					//If vertical lines cross
					if ($llA[0] == $ll[0]) {
						if ($llA[0] <= $testPoint[0]) {
							var_dump("IN");
							$result = !$result;
						}
						continue;
					}
					
					
					//y=mx+c
					//m = dy/dx
					$m = ($llA[1]-$ll[1])/($llA[0]-$ll[0]);
					
					$c = $ll[1]-$m*$ll[0];
					$eqC = $testPoint[1]-$m*$testPoint[0];
					
					
					if ($m < 0 && $c < $eqC || $m > 0 && $c > $eqC) {
						
						if (!(
							($ll[1] == $testPoint[1] && $llA[1] < $testPoint[1]) || 
							($llA[1] == $testPoint[1] && $ll[1] < $testPoint[1])
						)) {
							$result = !$result;
						}
					}
				}
			}
			if ($result) {
				return true;
			}
		}
		return false;
	}
}