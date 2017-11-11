<?php
		session_start();
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

		$message="";

		if(!empty($_POST["login"])) {
			$result = mysqli_query($conn,"SELECT * FROM user_details WHERE email='" . $_POST["Email"] . "' and password = '". $_POST["Password"]."'");
			$row  = mysqli_fetch_array($result);
			print_r();
			if(is_array($row)) {
				$_SESSION["Email"] = $row['Email'];
			} else {
				$message = "Invalid Username or Password!";
			}
		}
		
		if(!empty($_POST["logout"])) {
			$_SESSION["Email"] = "";
			session_destroy();
		}
?>
<html>
<head>
	<title>PHP Barcode Generator</title>
	
<style>
.icon_logo {
	padding: 0 6px;
    width: 20%;
    display: block;
    margin: 0px auto;
}
.icon_logo img {
	width: 100%;
}
.back_page_btn {
	float: right;
}
.tgtable {
	width:100%;
}
.tgtable th {
	border: 1px solid #999;
    padding: 6px 0px;
    vertical-align: middle;
    font-size: 14px;
}
.tgtable td {
	border: 1px solid #999;
    text-align: center;
    vertical-align: middle;
    padding: 4px 0px;
}
.marginbottom-0{
	margin-bottom: 0px;
}
</style>
</head>
<body>
	<div class="icon_logo"><a href="http://cheapestkart.com/barcode2/"><img src="kaden-logo.png"></a></div>
	
	<?php if(empty($_SESSION["Email"])) { ?>
	<fieldset>
	<legend>Login</legend>
		<form action="" method="post"> <!-- Create Post method to createbarcode.php files -->
		<?php if(isset($message)) { echo $message; } ?>
			<b>Email Id </b><input type="text" name="Email" /><br><br>
			<b>Password </b><input type="password" name="Password" /><br><br>
			<input type="submit" name="login" value="Login" />
		</form>
	</fieldset>
		<?php 
		} else { 
		$result = mysqli_query($conn,"SELECT * FROM user_details WHERE email='" . $_SESSION["Email"] . "'");
		$row  = mysqli_fetch_array($result);
	?>
	
	<?php } ?>
<?php 
	
	$result1 = mysqli_query($conn,"SELECT * FROM barcode");
	
?>

<fieldset>
	
	<legend>Already Generated Barcode!! Click to Return &nbsp;<div class="back_page_btn"><a href="http://cheapestkart.com/barcode2/"><img src="back.png" title="Return"></a></div>&nbsp;&nbsp;</legend>
		
		<table class="tgtable">
			<tr>
				<th>Barcode Id</th>
				<th>Serial Number</th>
				<th>Vendor Code</th>
				<th>Barcode</th>
				
				<th>Date Time</th>
				
			</tr>
			<?php while($row  = mysqli_fetch_array($result1)):?>
			<tr>
				<td><?php echo $row['barcode_id'];?></td>
				<td><?php echo $row['serial_number'];?></td>
				<td><?php echo $row['vendor_code'];?></td>
				<td><?php echo $row['barcode'];?></td>
				
				<td><?php echo $row['date_time'];?></td>
				
			</tr>
			<?php endwhile;?>
		</table>
</fieldset>

</body>
</html>