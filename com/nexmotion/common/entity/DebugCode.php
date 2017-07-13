<?
class DebugCode {

    function errorMessage($str) {

	if ( $_ENV["SHELL"] ) {
		echo $str . "\n";
	} else {
		echo "<br>";
		echo $str;
        	echo "<br>";
	}
        
        return false;
    
    }
    
    function printSql($sql) {
    
/*
	if ( $_ENV["SHELL"] ) {
        	echo $sql . "\n";
	} else {
*/
        	echo "<pre>";
        	echo $sql;
        	echo "</pre>";        
/*
	}
*/
    
    }

}
?>
