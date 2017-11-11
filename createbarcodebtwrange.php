<?php
	include('barcode128.php'); // include php barcode 128 class
	//include('insertbarcode.php'); // include database conectivity and insert barcode data
		
	echo '<html><head><title>Barcode</title></head><body>';
	// design our barcode display
	//echo '<a href="http://php.kadenappliances.com/">Return to Form</a>';
	echo '<div style="double #333; padding:5px;margin:5px auto;width:40%;height:100%;float:left;">';
	//Get data from form
	$codesum = $_POST['LDSbarcode'];
	$codesumlase = $_POST['LDSUTbarcode'];
	$ser_num = 1;
	
	for($i = $codesum; $i <= $codesumlase; $i++)
	{
		if(strlen($codesum) === 12){
			$zero = "";
		}else{
			$zero = "0";
		}
		echo bar128(stripslashes($zero."".$codesum));
		echo '<br>';
		echo bar128(stripslashes($zero."".$codesum));
		echo '<br>';
		echo bar128(stripslashes($zero."".$codesum));
		echo '<br>';
		
		$ser_num++;
		if($codesum < $codesumlase){
			$codesum++;
		}else{
			break;
		}
	}
	echo '</div></body></html>';
?>