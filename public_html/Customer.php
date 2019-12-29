<?php
session_start(); include('db_connect.php');?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Customer homepage</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico">
    <style media="screen">
    </style>
  </head>
  <body>
    <div class="head_container">
      <img class="rushrhees" src="rushrhees.jpg" alt="rushrhees front picture">
     <h1 class="Welcome">
	 <?php if (!empty($_SESSION['username'])){
		echo "Welcome "; echo $_SESSION['username']; 
}
?></h1>

      <a class="topbar" href="Customer.php">HOME</a>
      <a class="topbar" href="Reservation_page.php">RESERVATION</a>
      <a class="topbar" href="bill_page.php">BILL</a>
      <a class="topbar" href="hotel_room_info.php">HOTELS&ROOMS</a>
	 <a class="topbar" href="Request_page.php">REQUEST</a>
      <a class="topbar" href="logout.php">LOGOUT</a>
</div>
    <div class="header_customer">
  		<h2>PROFILE UPDATE</h2>
  	</div>

  	<form method="post" action="Customer.php">
      <?php $UserID = $_SESSION['username'];
      $query = "SELECT * FROM Customer WHERE Customer_ID = '$UserID'";
      $result = $conn->query($query);
      if($result->num_rows != 0){
        $row = $result->fetch_assoc();
        $_SESSION['Password'] = $row['Password'];
        $_SESSION['Fname'] =  $row['Fname'];
        $_SESSION['Lname'] =  $row['Lname'];
        $_SESSION['Email'] =  $row['Email'];
        $_SESSION['Phone_no'] =  $row['Phone_no'];
          $_SESSION['ID_type'] =  $row['ID_type'];
            $_SESSION['ID_no'] =  $row['ID_No'];
      }

      ?>
  		<label class="input-group">Password</label><br>
  		<input type="password" name="Password" value="<?php echo $_SESSION['Password'];?>"><br>

  		<label class="input-group">Confirm password</label><br>
  		<input type="password" name="Confirm_password"><br>

  		<label class="input-group">First name</label><br>
  		<input type="text" name="First_name" value="<?php echo $_SESSION['Fname'];?>"><br>

  		<label class="input-group">Last name</label><br>
  		<input type="text" name="Last_name" value="<?php echo $_SESSION['Lname'];?>"><br>

  		<label class="input-group">Email</label><br>
  		<input type="email" name="emailaddress" value="<?php echo $_SESSION['Email'];?>"><br>

  		<label class="input-group">Phone number</label><br>
  		<input type="tel" name="phonenumber" value="<?php echo $_SESSION['Phone_no'];?>"><br>
  		<label class="input-group">ID type</label><br>
  		<select id="ID type" name="ID_type">
                <option value="">Select</option>
              	<option value="Passport">Passport</option>
              	<option value="Driver License">Driver License</option>
              </select><br>


  		<label class="input-group">ID number</label><br>
  		<input type="text" name="ID_number" value="<?php echo $_SESSION['ID_no'];?>"><br>

  		<input type="submit" name="Update" class="btn_c" value="Update">
<?php
      $Psw = "";
      $CPsw = "";
      $Fname = "";
      $Lname = "";
      $Email = "";
      $Phone = "";
      $IDtype = "";
      $IDnumber = "";
      if (!empty($_POST['Update'])){

              $Psw = $_POST['Password'];
              $CPsw = $_POST['Confirm_password'];
              $Fname = $_POST['First_name'];
              $Lname = $_POST['Last_name'];
              $Email = $_POST['emailaddress'];
              $Phone = $_POST['phonenumber'];
              $IDtype =$_POST['ID_type'];
              $IDnumber = $_POST['ID_number'];
              if ((empty($Psw)) ||(empty($CPsw)) || (empty($Fname)) || (empty($Lname)) || (empty($Email)) || (empty($Phone)) || (empty($IDtype)) || (empty($IDnumber)) ){
                echo "<p>None of the above should be empty!</p>";
              }
              elseif($Psw != $CPsw) {
                                  echo "<p>Passwords do not match!</p>";
              }
              elseif( (strlen($Psw)>50) && (strlen($Psw) < 4) ){
                    echo "<p>Passwords length should be between 4 and 50 characters!</p>";
              }
              else{

                $sql = "Update Customer SET Fname = '$Fname', Lname = '$Lname', Password = '$Psw', Email = '$Email', Phone_no = '$Phone', ID_type = '$IDtype', ID_No = '$IDnumber' where Customer_ID = '$UserID'";
                $result = $conn->query($sql);
                if ($result === TRUE){
                    echo "<p>
                    You have successfully updated personal information!
                    </p>";

                  }
                  else {
                                  echo "<p>Error</p>";
                      }
              }

    }
       ?>
</form>
  </body>
</html>
