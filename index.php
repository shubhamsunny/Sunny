<?php
		session_start();
		
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
		else{
			//echo 'Connection Success';
			
		}
		
		$message="";

		if(!empty($_POST["login"])) {
			
			//echo "SELECT * FROM user_details WHERE email='" . $_POST["Email"] . "' and password = '". $_POST["Password"]."'";
			$result = mysqli_query($conn,"SELECT * FROM user_details WHERE email='" . $_POST["Email"] . "' and password = '". $_POST["Password"]."'");
			//print_r($result);
			$row  = mysqli_fetch_array($result);
			//print_r($row);
			if(is_array($row)) {
				$_SESSION["Email"] = $row['email'];
				//$message = "Sucessfull"
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
		<?php if(isset($message)) { echo '<font style="color: red;">'. $message.'</font><br><br>'; } ?>
			<b>Email Id </b><input type="text" name="Email" /><br><br>
			<b>Password </b><input type="password" name="Password" /><br><br>
			<input type="submit" name="login" value="Login" />
		</form>
		<a href="http://cheapestkart.com/barcode2/already_generated_barcode.php">Check Already generated Barcode</a>
	</fieldset>
		<?php 
		} else { 
		$result = mysqli_query($conn,"SELECT * FROM user_details WHERE email='" . $_SESSION["Email"] . "'");
		$row  = mysqli_fetch_array($result);
	?>
	<fieldset>
		<legend>Welcome</legend>
		<form action="" method="post" id="frmLogout">
			<div class="member-dashboard">Welcome <?php echo ucwords($row['email']); ?>, You have successfully logged in!<br>
				<input type="submit" name="logout" value="Logout" class="logout-button">
			</div>
		</form>
		<a href="http://cheapestkart.com/barcode2/already_generated_barcode.php">Check Already generated Barcode</a>
	</fieldset>
	<fieldset>
		<legend>Detail Informations</legend>
		<form action="createbarcode.php" method="post"> <!-- Create Post method to createbarcode.php files -->
			<b>First 2 Digit : Factory Code &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><input type="text" name="FDFCbarcode" min="2" max="2" title="Enter 2 Digit Factory Code" /><br><br>
			<b>Next 2 Digit : Year &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b><input type="text" name="NDYbarcode" min="2" max="2" title="Enter Last 2 digit of Years"/><br><br>
			<b>Next 2 Digit : Month &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b><input type="text" name="NDMbarcode" min="2" max="2" title="Enter 2 digit of Month"/><br><br>
			<b>Last 6 Digits: Serial No’s start&nbsp;&nbsp;&nbsp;&nbsp; </b><input type="text" name="LDSbarcode" min="6" max="6" title="Enter Starting of 6 digits Serial Number"/><br><br>
			<b>Last 6 Digits: Serial No’s end&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </b><input type="text" name="LDSUTbarcode" min="6" max="6" title="Enter Last of 6 digits Serial Number"/><br><br>
			<input type="submit" value="Create Barcode" />
		</form>
	</fieldset>
	<?php } ?>
<?php 
	$result2 = mysqli_query($conn,"SELECT * FROM barcode_range");
	
	
?>
<fieldset>
	<legend>Range of Already Generated Barcode</legend>
	<table class="tgtable">
		<tr>
			<th>Barcode Range Id</th>
			<th>Barcode Start</th>
			<th>Barcode End</th>
			<th>Date Time</th>
			<th>Create Barcode</th>
		</tr>
		<?php while($row  = mysqli_fetch_array($result2)):?>
		<tr>
			<td><?php echo $row['barcode_range_id'];?></td>
			<td><?php echo $row['start_barcode'];?></td>
			<td><?php echo $row['last_barcode'];?></td>
			<td><?php echo $row['date_time'];?></td>
			
			<td>
				<form action="createbarcodebtwrange.php" method="post" class="marginbottom-0">
					<input type="hidden" name="LDSbarcode" value="<?php echo $row['start_barcode']; ?>">
					<input type="hidden" name="LDSUTbarcode" value="<?php echo $row['last_barcode']; ?>">
					<input type="submit" value="Click to Create Barcode">
				</form>
			</td>
		</tr>
		<?php endwhile;?>
	</table>
	
</fieldset>

</body>
</html>