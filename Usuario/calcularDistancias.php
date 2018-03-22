
 <?php
 
function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit, $decimals) {
	$degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
 
	switch($unit) {
		case 'km':
			$distance = $degrees * 111.13384;
			}
	return round($distance, $decimals);
}

echo "la distancia es de ".distanceCalculation(41.434027, 2.189413, 41.431099, 2.182809, 'km', 4)*(1000)." metros";
?>

 