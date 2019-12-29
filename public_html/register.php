
<!DOCTYPE html>
<html>
<head>
	<title>User Registeration/Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>	
<body>
	<div class="header">
		<h1>Welcome to ROC Hotel<h1>
		<br>
		<h2>Register</h2>
	</div>

	<form method="post" action="register.php">
	
		<label class="input-group">Username</label><br>
		<input type="text" name="username"><br>
	
	
		<label class="input-group">Password</label><br>
		<input type="password" name="Password"><br>
		
		<label class="input-group">Confirm password</label><br>
		<input type="password" name="Confirm_password"><br>
			
		<label class="input-group">First name</label><br>
		<input type="text" name="First_name"><br>
	
		<label class="input-group">Last name</label><br>
		<input type="text" name="Last_name"><br>
		
		<label class="input-group">Email</label><br>
		<input type="email" name="emailaddress"><br>
		
		<label class="input-group">Phone number</label><br>
		<input type="tel" name="phonenumber"><br>
	
		<label class="input-group">ID type</label><br>
		<select id="ID type" name="ID_type">
            	<option value="Passport">Passport</option>
            	<option value="Driver License">Driver License</option>
            </select><br>
           
		

		<label class="input-group">ID number</label><br>
		<input type="text" name="ID_number"><br>
		
		<input type="submit" name="register" class="btn" value="register">
	
		<p>
			Already a member? <a href="login.php">Sign in</a>
		</p>
<?php	
	session_start();
	$servername = "localhost";
	$username ="tqu2";
	$password = "pZh2iQfV";
	$database = "tqu2_1";

	$conn = mysqli_connect ($servername, $username, $password, $database);

	if ($conn->connect_error) {
	  die("Connection_failed: " .$conn->connect_error);
	}	

        $UserID = "";
	$Psw = "";
	$CPsw = "";
        $Fname = "";
        $Lname = "";
        $Email = "";
	$Phone = "";
	$IDtype = "";
        $IDnumber = "";
  

	
        if (!empty($_POST['register'])) {
                $UserID =$_POST['username'];
                $Psw = $_POST['Password'];
                $CPsw = $_POST['Confirm_password'];
                $Fname = $_POST['First_name'];
                $Lname = $_POST['Last_name'];
                $Email = $_POST['emailaddress'];
                $Phone = $_POST['phonenumber'];
                $IDtype =$_POST['ID_type'];
                $IDnumber = $_POST['ID_number'];

                if (empty($UserID)) {
                        echo  "<p>Username is required</p>";
                }

                if (empty($Psw) || strlen($Psw)>50 || strlen ($Psw)<4) {
                        echo "<p>Legal password between 4 and 50 characters is required</p>";
                }
		if ($Psw != $CPsw) {
                        echo "<p>Passwords do not match!</p>";
                }
               if (empty($Fname)) {
                        echo "<p>First name is required</p>";
                }
	        if (empty($Lname)) {
                        echo "<p>Last name is required</p>";
                }
		if (empty($Email)) {
                        echo "<p>Email is required</p>";
                }
		 if (empty($Phone)) {
                        echo "<p>Phone number is required</p>";
                }
		 if (empty($IDnumber)) {
                        echo "<p>ID number is required</p>";
                }
		
		$query = "SELECT * FROM Customer WHERE Customer_ID='$UserID'";
                        $test = $conn->query($query);

                if ($test->num_rows > 0){
                        echo "<p>Username already exists!</p>";
                }
		
		else if((!empty($IDnumber))&&(!empty($Phone))&&(!empty($Email))&&(!empty($Lname))&&(!empty($Fname))&&(!empty($Psw))&&(!empty($UserID))&&($Psw == $CPsw)&&(strlen($Psw)<=50)&&(strlen($Psw)>=4)){
                $sql = "Insert into Customer (Customer_ID, Fname, Lname, Password, Email, Phone_no, ID_type, ID_No) VALUES ('$UserID', '$Fname', '$Lname', '$Psw', '$Email', '$Phone', '$IDtype', '$IDnumber')";
		$result = $conn->query($sql);
		if ($result === TRUE){
                $bill = "Insert into Bill (Customer_ID) VALUES ('$UserID')"; 
		$bill_result = $conn->query($bill);	
		$_SESSION['username'] = $UserID;
		$_SESSION['Fname'] = $Fname;
                $_SESSION['Lname'] = $Lname;
                $_SESSION['Email'] = $Email;
                $_SESSION['Phone_no'] = $Phone;
		echo "You have successfully registered!<br>";
		echo "<table>";
		echo "<tr><th>User ID</th><td>". $_SESSION['username'] ."</td></tr>";

       		echo "<tr><th>First name</th><td>". $_SESSION['Fname'] ."</td></tr>";
		echo "<tr><th>Last name</th><td>". $_SESSION['Lname'] ."</td></tr>";
		echo "<tr><th>Email</th><td>". $_SESSION['Email'] ."</td></tr>";
		echo "</table>";
  		}
		else {
		 	echo "<p>Error</p>";
		}                
              }
        }
$conn->close();
?>

</form>
</body>
</html>
