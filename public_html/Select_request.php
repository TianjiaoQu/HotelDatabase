
<?php session_start();
     include('db_connect.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Service in Database</title>
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

      <form method="post" action="Select_request.php">
        <p>Username is required for insert</p><br>
                    <label class="input-group">Username</label><br>
                    <input type="text" name="username"><br>
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

                                       echo "<option value='$ServiceID'>" .$row["Service_ID"]. "  " .$row["Service_type"]. "</option>";
                              }
                            echo "</select><br>";
                      }
                      ?>

                    <label class="input-group">Request date</label><br>
                    <input type="date" name="request"><br>
                    <input type="submit" name="insert" class="btn" value="insert">
                    <input type="submit" name="list" class="btn" value="list"><br>




      <?php


            $Searchuser = "";
            $Searchdate = "";
            $UserID = "";
            $Service = "";

            $Service_charge = "";
            $Balance ="";
            $Request = "";
            $RequestID ="";

            if (!empty($_POST['insert'])){

                    $UserID = $_POST['username'];
                    $Service = $_POST['service'];

                    $Request = $_POST['request'];
                    $_SESSION['Date'] = $Request;
                    $_SESSION['customer'] = $UserID;
                    $_SESSION['ServiceID'] = $Service;
                    if (empty($UserID)) {
                            echo  "<p>Username is required</p>";
                    }
                    else if (empty($Service)) {
                            echo  "<p>A Service needs to be selected</p>";
                    }
                    else if (empty($Request)) {
                            echo  "<p>A Date needs to be selected</p>";
                    }
                    else {
                      $querycus = "SELECT * FROM Customer WHERE Customer_ID='$UserID'";
                               $testcus = $conn->query($querycus);
                               if ($testcus->num_rows == 0){
                        echo "<p>Customer has not registered yet!</p>";
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
      }
      if (!empty($_POST['confirm'])){

        $UserID = $_SESSION['customer'];
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
                         echo "<p>Username    " .$_SESSION['customer'] . "</p>";
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
<form method="post" action="Select_request.php">
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
                            echo "<p>Username    " .$_SESSION['customer'] . "</p>";
                            echo "<p>Current balance    ". $_SESSION['Balance'] . " $ </p>";

                        }
                         else {
                        echo "<p>Error</p>";
                        }

                }
              }
        }?>
</form>
      <form method="post" action="Select_request.php">
      <label class="input-group">Search by Username</label><br>
      <input type="text" name="search_username"><br>
      <input type="submit" name="search1" class="btn" value="search"><br>
      <label class="input-group">Search by Request date</label><br>
      <input type="date" name="search_date"><br>
      <input type="submit" name="search2" class="btn" value="search">

      <?php

      if (!empty($_POST['search1'])){

      $Searchuser = $_POST['search_username'];
      if(empty($Searchuser)){
              echo "<p>Username is required</p>";
      }
      }
      if (!empty($_POST['search2'])){
      $Searchdate = $_POST['search_date'];
      if(empty($Searchdate)){
              echo "<p>A date is required</p>";
      }
      }

      ?>
      </form>

      <?php
      if (!empty($_POST['search1'])){

                    $Searchuser = $_POST['search_username'];
                    if(!empty($Searchuser)){
                            echo "<table><tr><th>Request_ID</th><th>Request_date</th><th>Customer_ID</th><th>Service_ID</th></tr>";

                             $sql = "Select * from Request WHERE Customer_ID LIKE '%$Searchuser%'";
                             $result = $conn->query($sql);
                             if ($result->num_rows > 0) {
                                     while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Request_ID"] ."</td><td>". $row["Request_date"] ."</td><td>". $row["Customer_ID"] . "</td><td>". $row["Service_ID"] . "</td></tr>";
                                    }
                                  echo "</table>";
                            } else {
                             echo "There are no matching search!";
                            }

                    }

            }
            if (!empty($_POST['search2'])){

                          $Searchdate = $_POST['search_date'];
                          if(!empty($Searchdate)){
                                  echo "<table><tr><th>Request_ID</th><th>Request_date</th><th>Customer_ID</th><th>Service_ID</th></tr>";

                                   $sql = "Select * from Request WHERE Request_date = '$Searchdate'";
                                   $result = $conn->query($sql);
                                   if ($result->num_rows > 0) {
                                           while($row = $result->fetch_assoc()){
                                                   echo "<tr><td>". $row["Request_ID"] ."</td><td>". $row["Request_date"] ."</td><td>". $row["Customer_ID"] . "</td><td>". $row["Service_ID"] . "</td></tr>";
                                          }
                                        echo "</table>";
                                  } else {
                                   echo "There are no matching search!";
                                  }

                          }

                  }

            if (!empty($_POST['list'])){

                            echo "<table><tr><th>Request_ID</th><th>Request_date</th><th>Customer_ID</th><th>Service_ID</th></tr>";
                             $sql = "Select * from Request";
                              $result = $conn->query($sql);
                               if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Request_ID"] ."</td><td>". $row["Request_date"] ."</td><td>". $row["Customer_ID"] . "</td><td>". $row["Service_ID"] . "</td></tr>";
                                }  echo "</table>";
                            } else {
                             echo "Empty table";
                            }

            }


$conn->close();
 ?>
</body>
</html>
