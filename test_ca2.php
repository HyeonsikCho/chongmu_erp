<?PHP
	$h = 88;
	$w = 54;
	$sum = $h + $w;

	for($i=0;$i < 201; $i++){

		for($z=0;$z<201;$z++){
			$h1 = $h+$i;
			$w1 = $w+$z;
			$val1 = ($h1 / $h)+0.999;
			$val2 = ($w1 / $w)+0.999;
			$val3 = floor($val1) * floor($val2);

			$vval1 = ($h1 / $w)+0.999;
			$vval2 = ($w1 / $h)+0.999;
			$vval3 = floor($vval1) * floor($vval2);
			echo $val1."//".$val2."//".$val3."//".$vval1."//".$vval2."//".$vval3."<br>";
			$val = ($val3 > $vval3)?$vval3:$val3; 

			echo $h1."+".$w1."=".$val."//건수:".$val."<br>";
		}
	}
/*
기초값 높이 
기초값 넓이

고객이입력한 높이
고객이입력한 넓이


계산식1 : floor((고객이입력한높이/기초값높이)+0.999)) * floor((고객이입력한넓이/기초값넓이)+0.999))

계산식2 : floor((고객이입력한높이/기초값넓이)+0.999)) * floor((고객이입력한넓이/기초값높이)+0.999))

1과 2를 비교한후 작은값을 건수로 적용하고 가격은 최초가격 * 건수로 보이면됨

*/

?>

