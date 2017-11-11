<?php
	include('barcode128.php'); // include php barcode 128 class
	//include('insertbarcode.php'); // include database conectivity and insert barcode data
		
	function insert_barcode_range($codesum, $codesumlase){
		//$servername = "localhost";
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "database_name";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$date = date('Y-m-d H:i:s');
		//$v_code = NULL;
		$query = "INSERT INTO barcode_range(start_barcode, last_barcode, date_time)VALUES('".$codesum."', '".$codesumlase."', '".stripslashes($date)."')";
		//$params1 = array();
		
			//print_r($query);
			//print_r($params1);
		$result = mysqli_query($conn,$query);
		/* Prepare and execute the query. */  
		//$stmt = sqlsrv_query($conn, $tsql, $params);  
		if ($result) {
			//echo "Row successfully inserted.\n";  
		} else {  
			echo "Row insertion failed.\n";  
			die(print_r(mysqli_errors(), true));  
		}  

		/* Free statement and connection resources. */  
		//mysqli_free_stmt($result);  
		mysqli_close($conn);
	}
	
	function insert_barcode($ser_num, $v_code, $barcode){
		//$servername = "localhost";
		
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "database_name";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$date = date('Y-m-d H:i:s');
		//$v_code = NULL;
		$result3 = mysqli_query($conn,"SELECT TOP 1 * FROM barcode_range ORDER BY barcode_range_id DESC");
		//print_r($result3);
		while($row  = mysqli_fetch_array($result3)):
			$barcode_range_id = $row['barcode_range_id'];
			//print_r($barcode_range_id);
		endwhile;
		
		$query = "INSERT INTO barcode(serial_number, vendor_code, barcode, date_time, barcode_range_id)VALUES('".$ser_num."', '".$v_code."', '".$barcode."', '".stripslashes($date)."', '".$barcode_range_id."')";
		//$params1 = array($ser_num, $v_code, $barcode, stripslashes($date), $barcode_range_id);
			//print_r($query);
			//print_r($params1);
		$result = mysqli_query($conn,$query);
		/* Prepare and execute the query. */  
		//$stmt = sqlsrv_query($conn, $tsql, $params);  
		if ($result) {
			//echo "Row successfully inserted.\n";  
		} else {  
			echo "Row insertion failed.\n";  
			die(print_r(mysqli_errors(), true));  
		}  

		/* Free statement and connection resources. */  
		//mysqli_free_stmt($result);  
		mysqli_close($conn);  
		
	}
	
	echo '<html><head><title>Barcode</title>
			</head><body>';
	// design our barcode display
	//echo '<a href="http://php.kadenappliances.com/">Return to Form</a>';
	echo '<div style="double #333; padding:5px;margin:5px auto;width:40%;height:100%;float:left;">';
	$v_code = $_POST['FDFCbarcode'];
	$codesum = $_POST['NDYbarcode']."".$_POST['NDMbarcode']."".$_POST['LDSbarcode'];
	$codesumlase = $_POST['NDYbarcode']."".$_POST['NDMbarcode']."".$_POST['LDSUTbarcode'];
	//$lastdigitstart = $_POST['LDSbarcode'];
	//$lastdigitend = $_POST['LDSUTbarcode'];
	//$lastdigitstart;
	//$lastdigitend;
	//$start_barcode = $_POST['LDSbarcode'];
	//$last_barcode = $_POST['LDSUTbarcode'];
	//$servername = "localhost";
		
	$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "database_name";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 
		$result_compare = mysqli_query($conn,"SELECT * FROM barcode where barcode ='".$codesum."'");
		$result_barecode ="";
		while($row  = mysqli_fetch_array($result_compare)):
			$result_barecode = $row['barcode'];
		endwhile;
		
	if($codesum != $result_barecode){
		$barstart = $_POST['FDFCbarcode']."".$codesum;
		$barend = $_POST['FDFCbarcode']."".$codesumlase;
		insert_barcode_range($barstart, $barend);
		$ser_num = 1;
		//$strlength = strlen($codesum);
		for($i = $codesum; $i <= $codesumlase; $i++)
		{
			$codebar = $_POST['FDFCbarcode']."".$codesum;
			//if($strlength === strlen($codesum))
			//{	
				echo bar128(stripslashes($codebar));
				echo '<br>';
				echo bar128(stripslashes($codebar));
				echo '<br>';
				echo bar128(stripslashes($codebar));
				echo '<br>';
				insert_barcode($ser_num, $v_code, stripslashes($codebar));
			//}else{
				//echo bar128(stripslashes($codesum));
				//echo '<br>';
				//echo bar128(stripslashes($codesum));
				//echo '<br>';
				//echo bar128(stripslashes($codesum));
				//echo '<br>';
				//insert_barcode($ser_num, $v_code, stripslashes($codesum));
			//}
			$ser_num++;
			if($codesum < $codesumlase){
				$codesum++;
			}else{
				break;
			}
		}
		
	}else{
		echo '<script language="javascript">';
		echo 'alert("Your Barcode is Already In Database");window.location = "http://cheapestkart.com/barcode2/" ';
		echo '</script>';
		
		
		//echo $message = ' Return on <a href="http://php.kadenappliances.com/">Home</a>';
	}
	echo '</div></body></html>';
?>