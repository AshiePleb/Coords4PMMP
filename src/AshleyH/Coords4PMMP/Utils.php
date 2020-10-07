<?php

declare(strict_types=1);

namespace AshleyH\Coords4PMMP;

class Utils{

	public static function getCompassDirection(float $deg) : string{
		$deg %= 360;
		if($deg < 0){
			$deg += 360;
		}

		if(22.5 <= $deg and $deg < 67.5){
			return "Northwest";
		}elseif(67.5 <= $deg and $deg < 112.5){
			return "North";
		}elseif(112.5 <= $deg and $deg < 157.5){
			return "Northeast";
		}elseif(157.5 <= $deg and $deg < 202.5){
			return "East";
		}elseif(202.5 <= $deg and $deg < 247.5){
			return "Southeast";
		}elseif(247.5 <= $deg and $deg < 292.5){
			return "South";
		}elseif(292.5 <= $deg and $deg < 337.5){
			return "Southwest";
		}else{
			return "West";
		}
	}

	public static function getFormattedCoords(int $precision, float ...$coords) : string{
		foreach($coords as &$c){
			$c = number_format($c, $precision, ".", ",");
		}

		return implode(", ", $coords);
	}

}