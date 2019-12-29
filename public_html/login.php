
<!DOCTYPE html>
<html>
<head>
	<title>User Registeration/Login</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>	
<body>

	<div class="header">
		<h1>Welcom to ROC Hotel</h1>
		<br>
		<h2>Login</h2>
	</div>

	<form method="post" action="login.php">
		<label class="input-group">Username</label><br>
		<input type="text" name="username"><br>
		<label class="input-group">Password</label><br>
		<input type="password" name="Password"><br>
		<input type="submit" name="login" class="btn" value="login">
                <input type="submit" name="deactivate" class="btn" value="deactivate">

		<p class="error">
			Not a member? <a href="register.php">Register</a>
		</p>
<?php
  	session_start();
        $servername = "localhost";
        $username ="tqu2";
        $password = "pZh2iQfV";
        $database = "tqu2_1";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if ($conn->connect_error) {
          die("Connection_failed: " .$conn->connect_error);
        }

        $UserID = "";
        $Psw = "";

        if (!empty($_POST['login'])){
                $UserID = $_POST['username'];
                $Psw = $_POST['Password'];


                if (empty($UserID)) {
                        echo  "<p>Username is required</p>";
                }

                if (empty($Psw)) {
                        echo "<p>Password is required</p>";
                }

                else {

                        $query = "SELECT * FROM Customer WHERE Customer_ID='$UserID' AND Password = '$Psw'";
                        $result = $conn->query($query);

                        if( ($result->num_rows > 0) && ($UserID == "Admin" )){
                                //log user in
                                header('location: Index.php');
                        }else if (($result->num_rows > 0) && ($UserID != "Admin" )){
			$_SESSION['username'] = $UserID;

			header('location: Customer.php');
			}

			else{
                                echo "<p>Wrong username/password</p>";
                        }
                }
        }
        if (!empty($_POST['deactivate'])){
                $UserID = $_POST['username'];
                $Psw = $_POST['Password'];


                if (empty($UserID)) {
                        echo  "<p>Username is required</p>";
                }

                else if (empty($Psw)) {
                        echo "<p>Password is required</p>";
                }
		else  if ($UserID == "Admin") {
                        echo  "<p>Administrator cannot be deactivated!</p>";
                }
                else {

                        $query = "SELECT Customer_ID  FROM Customer WHERE Customer_ID='$UserID' AND Password = '$Psw'";
		
                        $result = $conn->query($query);

                        if($result->num_rows>0){
                                //log user in
                        echo "Account has been successfully deleted!";
                 	$delete = "DELETE FROM Customer WHERE Customer_ID='$UserID' AND Password = '$Psw'";
		
			$conn->query($delete);
			$conn->query($delete_bill);
                        }

                        else{
                                echo "<p>Wrong username/password</p>";
                        }
                }
        }

$conn->close();
?>
	</form>

</body>


</html>
