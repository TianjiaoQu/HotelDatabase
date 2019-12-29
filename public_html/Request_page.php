<?php
session_start(); include('db_connect.php');?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Customer request</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico">
    <style media="screen">
form {
        width: 60%; 
        margin: 0px auto;
        padding-left: 220px;
        border: none;
        background: none;
        font-size:18px;
        font-family:Georgia;
        font-style:italic;
        margin-left: 100px;
        margin-right: 100px;
      }

 table {
      border:none;
      width: 100%;
      color: #000000;
      text-align: left;
background:none;
      
      
    }
    th, td {
	border:none;
     
      padding: 3px;
    }
.input-group label {
        display: block;
        text-align: left;
        margin: 3px;
}
.input-group input{
        height: 30px;
        width: 150px;
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid gray;

}


.input-group select{
        height: 30px;
        width: 150px;
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid gray;
}

.btn {
        padding: 10px;
        font-size: 15px;
        color: white;
        background: #e8a87c;
        border: none;
        border-radius: 5px;
        position:relative;
        bottom:0;
}


    </style>
  </head>
  <body>
    <div class="head_container">
      <img class="rushrhees" src="rushrhees.jpg" alt="rushrhees front picture">
     <h1 class="Welcome">
	 <?php if (!empty($_SESSION['username'])){
		echo "Welcome "; echo $_SESSION['username'];
}
$UserID = "";
?></h1>

      <a class="topbar" href="Customer.php">HOME</a>
      <a class="topbar" href="Reservation_page.php">RESERVATION</a>
      <a class="topbar" href="bill_page.php">BILL</a>
      <a class="topbar" href="hotel_room_info.php">HOTELS&ROOMS</a>
	 <a class="topbar" href="Request_page.php">REQUEST</a>
      <a class="topbar" href="logout.php">LOGOUT</a>
    </div> <!--Creates a button-->

<?php $UserID = $_SESSION['username'];

?></h1>

<form method="post" action="Request_page.php">

              <label class="input-group">Service</label><br>
              <select type="text" name="service"><br>
                <option value="">Select</option>
                <?php
                $ServiceID = "";
                $sql = "Select * from Service ";
                 $result = $conn->query($sql);
                 if ($result->num_rows > 0) {
                         while($row = $result->fetch_assoc()){
                                $ServiceID = $row["Service_ID"];

                                 echo "<option value='$ServiceID'>" .$row["Service_type"]. "</option>";
                        }
                      echo "</select><br>";
                }
                ?>

              <label class="input-group">Service date</label><br>
              <input type="date" name="request"><br>
              <input type="submit" name="insert" class="btn" value="Order">
              <input type="submit" name="list" class="btn" value="All my requests"><br>




<?php


      $Searchuser = "";
      $Searchdate = "";

      $Service = "";

      $Service_charge = "";
      $Balance ="";
      $Request = "";
      $RequestID ="";

      if (!empty($_POST['insert'])){


              $Service = $_POST['service'];

              $Request = $_POST['request'];
              $_SESSION['Date'] = $Request;

              $_SESSION['ServiceID'] = $Service;
              if (empty($Service)) {
                      echo  "<p>A Service needs to be selected</p>";
              }
              else if (empty($Request)) {
                      echo  "<p>A Date needs to be selected</p>";
              }
              else {

                      $query = "SELECT * FROM Service WHERE Service_ID='$Service'";
                      $Charge = $conn->query($query);
                      if ($Charge->num_rows > 0){
                        $row = $Charge->fetch_assoc();
                        $Service_charge = $row["Service_rate"];
                        echo "<p>Your selected service rate is " .$row["Service_rate"]. " $. Please press Confirm to submit order</p>";
                        echo "<input type='submit' name='confirm' class='btn' value='Confirm'>";

                    }

                  }

}
if (!empty($_POST['confirm'])){

  
  $Service = $_SESSION['ServiceID'];

  $Request = $_SESSION['Date'];

  if (empty($UserID)) {
          echo  "<p>Username is required</p>";
  }
  else if (empty($Service)) {
          echo  "<p>A Service needs to be selected</p>";
  }
  else if (empty($Request)) {
          echo  "<p>A Date needs to be selected</p>";
  }else{

    $query = "SELECT * FROM Service WHERE Service_ID='$Service'";
    $Charge = $conn->query($query);
    if ($Charge->num_rows > 0){
      $row = $Charge->fetch_assoc();
      $Service_charge = $row["Service_rate"];

  }
     $sql = "Insert into Request (Request_date, Customer_ID, Service_ID) VALUES ('$Request', '$UserID', '$Service')";
      $result = $conn->query($sql);
      $sql1 = "UPDATE Bill SET Service_charge = Service_charge + '$Service_charge', Balance = Balance + '$Service_charge' WHERE Customer_ID='$UserID'";
      $result1 = $conn->query($sql1);
      $bill = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
        $result2 = $conn->query($bill);
        if ($result2->num_rows > 0){
          $row2 = $result2->fetch_assoc();
          $Balance = $row2["Balance"];

      }
       if ($result && $result1){

                  $_SESSION['Balance'] = $Balance;
                  $_SESSION['Service'] = $row["Service_type"];
                echo "<p>You have successfully inserted order</p> ";

                    echo "<p>Service     ". $_SESSION['Service'] . "</p>";
                    echo "<p>Request date    ". $_SESSION['Date'] . "</p>";
                    echo "<p>Current balance    ". $_SESSION['Balance'] . " $ </p>";
                   }
       else {
         echo "<p>Error</p>";
     }
   }
 }




?>
</form>
<form method="post" action="Request_page.php">
<label class="input-group">Delete by Request ID</label><br>
<input type="text" name="request_id"><br>
<input type="submit" name="delete" class="btn" value="delete"><br>

<?php
if (!empty($_POST['delete'])){
    $RequestID = $_POST['request_id'];
    $_SESSION['Request_ID'] = $RequestID;
         if (empty($RequestID)) {
                  echo "<p>Request ID is required</p>";
          }

          else {
                  $query = "SELECT * FROM Request WHERE Request_ID='$RequestID'";
                  $test = $conn->query($query);

                  if ($test->num_rows == 0){
                  echo "<p>Request does not exist!</p>";
                  }
                  else {
                    $rowtest = $test->fetch_assoc();
                    $Service = $rowtest["Service_ID"];
                    $UserID = $rowtest["Customer_ID"];
                    $query1 = "SELECT * FROM Service WHERE Service_ID='$Service'";
                    $Charge = $conn->query($query1);
                    if ($Charge->num_rows > 0){
                      $row = $Charge->fetch_assoc();
                      $Service_charge = $row["Service_rate"];

                  }
                  $sql = "DELETE From Request WHERE Request_ID='$RequestID'";
                  $sql1 = "UPDATE Bill SET Service_charge = Service_charge - '$Service_charge', Balance = Balance - '$Service_charge' WHERE Customer_ID='$UserID'";
                  $result1 = $conn->query($sql1);
                  $bill = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
                    $result2 = $conn->query($bill);
                    if ($result2->num_rows > 0){
                      $row2 = $result2->fetch_assoc();
                      $Balance = $row2["Balance"];

                  }
                   $result = $conn->query($sql);
                   if ($result&&$result1){
                       $_SESSION['customer'] = $UserID;

                       $_SESSION['Balance'] = $Balance;
                      echo "<p>You have successfully deleted request</p> ";
                      echo "<p>Request ID    " .$_SESSION['Request_ID'] . "</p>";

                      echo "<p>Current balance    ". $_SESSION['Balance'] . " $ </p>";

                  }
                   else {
                  echo "<p>Error</p>";
                  }

          }
        }
  }


      if (!empty($_POST['list'])){

                      echo "<table><tr><th>Request_ID</th><th>Request_date</th><th>Customer_ID</th><th>Service_ID</th></tr>";
                       $sql = "Select * from Request WHERE Customer_ID='$UserID'";
                        $result = $conn->query($sql);
                         if ($result->num_rows > 0) {
                              while($row = $result->fetch_assoc()){
                                       echo "<tr><td>". $row["Request_ID"] ."</td><td>". $row["Request_date"] ."</td><td>". $row["Customer_ID"] . "</td><td>". $row["Service_ID"] . "</td></tr>";
                          }  echo "</table>";
                      } else {
                       echo "You do not have any request yet!";
                      }

      }


$conn->close();
?>



</form>


</body>
</html>
