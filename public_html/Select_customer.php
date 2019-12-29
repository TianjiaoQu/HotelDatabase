
<?php session_start();
     include('db_connect.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Customer in Database</title>
    <!-- CSS style tag for html body-->
    <link rel="stylesheet" href="styles.css">
   <link rel="stylesheet" href="style.css"> 
 <link rel="icon" href="favicon.ico">
    <style media="screen">
    </style>
  </head>
 <body>
      <a class="topbar" href="Index.php">Home</a>
      <a class="topbar" href="Select_hotel.php">Hotel</a>
      <a class="topbar" href="Select_room.php">Room</a>
      <a class="topbar" href="Select_customer.php">Customer</a>
      <a class="topbar" href="Select_reservation.php">Reservation</a>
      <a class="topbar" href="Select_service.php">Service</a>
      <a class="topbar" href="Select_request.php">Request</a>
      <a class="topbar" href="Select_bill.php">Bill</a>
   
      <a class="topbar" href="logout.php">Logout</a>
	<form method="post" action="Select_customer.php">
        
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
		 <option value="">Select</option>

                <option value="Passport">Passport</option>
                <option value="Driver License">Driver License</option>
            </select><br>



                <label class="input-group">ID number</label><br>
                <input type="text" name="ID_number"><br> 
		<label class="input-group">Hotel</label><br>
                <input type="text" name="Hotel_ID"><br>
		<label class="input-group">Room</label><br>
                <input type="text" name="Room_ID"><br>
       
                <input type="submit" name="insert" class="btn" value="insert">
                <input type="submit" name="delete" class="btn" value="delete">
                 <input type="submit" name="update" class="btn" value="update">
                <input type="submit" name="list" class="btn" value="list"><br>

<?php 


	$Search = "";
        $UserID = "";
        $Psw = "";
        $CPsw = "";
        $Fname = "";
        $Lname = "";
        $Email = "";
        $Phone = "";
        $IDtype = "";
        $IDnumber = "";
	$Hotel ="";
	$Room ="";
	if (!empty($_POST['insert'])) {
                $UserID =$_POST['username'];
                $Psw = $_POST['Password'];
                $CPsw = $_POST['Confirm_password'];
                $Fname = $_POST['First_name'];
                $Lname = $_POST['Last_name'];
                $Email = $_POST['emailaddress'];
                $Phone = $_POST['phonenumber'];
                $IDtype =$_POST['ID_type'];
                $IDnumber = $_POST['ID_number'];
		$Hotel = $_POST['Hotel_ID'];
		$Room = $_POST['Room_ID'];
                if (empty($UserID)) {
                        echo  "<p>Username is required</p>";
                }

                if (empty($Psw)) {
                        echo "<p>Password is required</p>";
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
                if ((!empty($UserID)) && (!empty($Psw)) && (!empty($CPsw))&& (!empty($Fname))&& (!empty($Lname))&& (!empty($Email))&& (!empty($Phone))&& (!empty($IDtype))&& (!empty($IDnumber)) ){

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
                	echo "<p>You have successfully inserted</p>";
                	
                	echo "<p>Username    ". $_SESSION['username'] . "</p>";

                	echo "<p>First name    ". $_SESSION['Fname'] ."</p>";
                	echo "<p>Last name    ". $_SESSION['Lname'] ."</p>";
                	echo "<p>Email    ". $_SESSION['Email'] ."</p>";
                        echo "<p>Phone number    ". $_SESSION['Phone_no'] ."</p>";

                }
                else {
                        echo "<p>Error</p>";
                }
              
		}
                if (!empty($Hotel) && !empty($Room) ) {
			$query =" Select * from Room WHERE Hotel_ID = '$Hotel' AND  Room_ID = '$Room'";
			$test = $conn->query($query);
			if($test->num_rows == 0){
			echo "<p>Room does not exist!</p>";
			}
			else{
                      $sql = "Update Customer SET Hotel_ID = '$Hotel', Room_ID = '$Room' where Customer_ID = '$UserID'";
                      $result = $conn->query($sql);
                      if ($result === TRUE){
                      		$_SESSION['Hotel'] = $Hotel;
		      		$_SESSION['Room'] = $Room;
                      		echo "<p>Hotel    ". $_SESSION['Hotel'] . "</p>";
	              		echo "<p>Room    ". $_SESSION['Room'] . "</p>";
                     		}
                                 else {
                                        echo "<p>Error</p>";
                                      }
			}
                 }

        }


	if (!empty($_POST['delete'])){
                $UserID = $_POST['username'];
                


                if (empty($UserID)) {
                        echo  "<p>Username is required</p>";
                }

                else {
                        $query = "SELECT * FROM Customer WHERE Customer_ID ='$UserID'";
                        $test = $conn->query($query);

                        if ($test->num_rows == 0){
                        echo "<p>Username dose not exist!</p>";
                        }
                        else {

                        $sql = "Delete from Customer Where Customer_ID = '$UserID'";
                         $result = $conn->query($sql);
                         if ($result === TRUE){
                        
                         $_SESSION['username'] = $UserID;
			 echo "<p>You have successfully deleted</p>";

                        echo "<p>Username    ". $_SESSION['username'] . "</p>";

                         
                        }
                         else {
                        echo "<p>Error</p>";
                        }

                }
           }
        }



        if (!empty($_POST['update'])){
               
		$UserID =$_POST['username'];
                $Psw = $_POST['Password'];
                $CPsw = $_POST['Confirm_password'];
                $Fname = $_POST['First_name'];
                $Lname = $_POST['Last_name'];
                $Email = $_POST['emailaddress'];
                $Phone = $_POST['phonenumber'];
                $IDtype =$_POST['ID_type'];
                $IDnumber = $_POST['ID_number'];
		$Hotel = $_POST['Hotel_ID'];
                $Room = $_POST['Room_ID'];

                if (empty($UserID)) {
                        echo  "<p>Username is required</p>";
                }
		else if ( (empty($Psw))&& (empty($CPsw))&& (empty($Fname))&& (empty($Lname))&& (empty($Email))&& (empty($Phone))&& (empty($IDtype))&& (empty($IDnumber)) ){
			echo "<p>At least one of above blanks should be filled.</p>";
		}

		else{
			$query = "SELECT * FROM Customer WHERE Customer_ID = '$UserID'";
			$test = $conn->query($query);
			if($test->num_rows == 0){
				echo "<p>Username does not exit!</p>";
			}
                	else {
			if (!empty($Psw)) {
                		if ($Psw != $CPsw) {
	                        	echo "<p>Passwords do not match!</p>";
                			}
				else {
				 $sql = "Update Customer SET Password = '$Psw' where Customer_ID = '$UserID'";
                                 $result = $conn->query($sql);
				  if ($result === TRUE){
                                 	$_SESSION['username'] = $UserID;
                                	echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s password.</p>";
				 }
                                 else {
                                	echo "<p>Error</p>";
                                	}
				   }
			}
               	
               		if (!empty($Fname)) {
                        	$sql = "Update Customer SET Fname = '$Fname' where Customer_ID = '$UserID'";
                                 $result = $conn->query($sql);
                                  if ($result === TRUE){
                                        $_SESSION['username'] = $UserID;
                                        echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s First name.</p>";
                                 }
                                 else {
                                        echo "<p>Error</p>";
                                      }
                	}
                	if (!empty($Lname)) {
                        	 $sql = "Update Customer SET Lname = '$Lname' where Customer_ID = '$UserID'";
                                 $result = $conn->query($sql);
                                  if ($result === TRUE){
                                        $_SESSION['username'] = $UserID;
                                        echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s Last name.</p>";
                                 }
                                 else {
                                        echo "<p>Error</p>";
                                      }	
                	}
                 	if (!empty($Email)) {
				
				$sql = "Update Customer SET Email = '$Email' where Customer_ID = '$UserID'";
                                 $result = $conn->query($sql);
                                  if ($result === TRUE){
                                        $_SESSION['username'] = $UserID;
                                        echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s Email.</p>";
                                 }
                                 else {
                                        echo "<p>Error</p>";
                                      }
                        	
                	}
                 	if (!empty($Phone)) {
                        	$sql = "Update Customer SET Phone_no = '$Phone' where Customer_ID = '$UserID'";
                                 $result = $conn->query($sql);
                                  if ($result === TRUE){
                                        $_SESSION['username'] = $UserID;
                                        echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s Phone.</p>";
                                 }
                                 else {
                                        echo "<p>Error</p>";
                                      }	
                	}
			if (!empty($IDtype)) {
                                $sql = "Update Customer SET ID_type = '$IDtype' where Customer_ID = '$UserID'";
                                 $result = $conn->query($sql);
                                  if ($result === TRUE){
                                        $_SESSION['username'] = $UserID;
                                        echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s ID type.</p>";
                                 }
                                 else {
                                        echo "<p>Error</p>";
                                      }
                        }

                 	if (!empty($IDnumber)) {
  				$sql = "Update Customer SET ID_No = '$IDnumber' where Customer_ID = '$UserID'";
                                 $result = $conn->query($sql);
                                  if ($result === TRUE){
                                        $_SESSION['username'] = $UserID;
                                        echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s ID number.</p>";
                                 }
                                 else {
                                        echo "<p>Error</p>";
                                      }
                      	
                	}
			if (!empty($Hotel) && !empty($Room) ) {
				$query =" Select * from Room WHERE Hotel_ID = '$Hotel' AND  Room_ID = '$Room'";
                        	$test = $conn->query($query);
                        	if($test->num_rows == 0){
                        	echo "<p>Room does not exist!</p>";
                        	}
                        	else{
                      		$sql = "Update Customer SET Hotel_ID = '$Hotel', Room_ID = '$Room' where Customer_ID = '$UserID'";
                     		 $result = $conn->query($sql);
                      		if ($result === TRUE){
                                	$_SESSION['username'] = $UserID;
                                        echo "<p>You have successfully updated    ". $_SESSION['username'] . "'s Room.</p>";	
				}
                                 else {
                                        echo "<p>Error</p>";
                                      }
                        	}
                               


                        }

                  }
		}
              }	
?>

</form>

<form method="post" action="Select_customer.php">

                <label class="input-group">Search by Last Name or Username</label><br>
                <input type="text" name="search_text"><br>
                <input type="submit" name="search" class="btn" value="search">


<?php 

        if (!empty($_POST['search'])){

                $Search = $_POST['search_text'];
                if(empty($Search)){
                        echo "<p>Search content is required</p>";
                }

        }


?>
</form>
<?php
	if (!empty($_POST['search'])){

                $Search = $_POST['search_text'];
                if(!empty($Search)){
                        echo "<table><tr><th>Customer_ID</th><th>Fname</th><th>Lname</th><th>Password</th><th>Email</th><th>Phone_no</th><th>ID_type</th><th>ID_No</th><th>Hotel_ID</th><th>Room_ID</th></tr>";

                         $sql = "Select * from Customer WHERE Customer_ID LIKE '%$Search%' OR Fname LIKE '%$Search%' OR Lname LIKE '%$Search%'";
                         $result = $conn->query($sql);
                         if ($result->num_rows > 0) {
                                 while($row = $result->fetch_assoc()){
                                         echo "<tr><td>". $row["Customer_ID"] ."</td><td>". $row["Fname"] ."</td><td>". $row["Lname"] ."</td><td>". $row["Password"] ."</td><td>". $row["Email"] ."</td><td>". $row["Phone_no"] ."</td><td>". $row["ID_type"] ."</td><td>". $row["ID_No"] ."</td><td>". $row["Hotel_ID"] ."</td><td>". $row["Room_ID"] ."</td></tr>";
                                }
                              echo "</table>";
                        } else {
                         echo "There are no matching search!";
                        }

                }

        }


        if (!empty($_POST['list'])){
                        echo "<table><tr><th>Customer_ID</th><th>Fname</th><th>Lname</th><th>Password</th><th>Email</th><th>Phone_no</th><th>ID_type</th><th>ID_No</th><th>Hotel_ID</th><th>Room_ID</th></tr>";

                         $sql = "Select * from Customer";
                          $result = $conn->query($sql);
                           if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()){
                                         echo "<tr><td>". $row["Customer_ID"] ."</td><td>". $row["Fname"] ."</td><td>". $row["Lname"] ."</td><td>". $row["Password"] ."</td><td>". $row["Email"] ."</td><td>". $row["Phone_no"] ."</td><td>". $row["ID_type"] ."</td><td>". $row["ID_No"] ."</td><td>". $row["Hotel_ID"] ."</td><td>". $row["Room_ID"] ."</td></tr>";
                                }
                              echo "</table>";
                        } else {
                         echo "Empty table";
                        }

        }


$conn->close();
?>



</body>
</html>   
