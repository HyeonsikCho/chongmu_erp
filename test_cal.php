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
?>