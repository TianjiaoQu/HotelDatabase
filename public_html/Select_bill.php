
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

      <form method="post" action="Select_bill.php">
        <p>Username is required for insert, update and delete</p><br>
                    <label class="input-group">Username</label><br>
                    <input type="text" name="username"><br>

                    <label class="input-group">Room charge</label><br>
                    <input type="number" class="number" name="Room_charge" step="0.01"><br>

                    <label class="input-group">Service charge</label><br>
                    <input type="number" class="number" name="Service_charge" step="0.01"><br>
                    <label class="input-group">Payment date</label><br>
                    <input type="date" name="payment"><br>
                    <label class="input-group">Card number</label><br>
                    <input type="text" name="Card_no"><br>

                    <input type="submit" name="insert" class="btn" value="insert">
                    <input type="submit" name="delete" class="btn" value="delete">
                     <input type="submit" name="update" class="btn" value="update">
                    <input type="submit" name="list" class="btn" value="list"><br>

      <?php


            $Searchuser = "";
            $Searchdate = "";
            $UserID = "";
            $Room = "";
            $Service = "";
            $Balance = "";
            $Payment = "";
            $Cardnumber = "";


            if (!empty($_POST['insert'])){

                    $UserID = $_POST['username'];
                    $Room = $_POST['Room_charge'];
                    $Service = $_POST['Service_charge'];
                    $Balance = (float)$Room + (float)$Service;
                    $Payment = $_POST['payment'];
                    $Cardnumber = $_POST['Card_no'];
                  
                    if (empty($UserID)) {
                            echo  "<p>Username is required</p>";
                    }

                    else {
                         $query = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
                            $test = $conn->query($query);
                            $querycus = "SELECT * FROM Customer WHERE Customer_ID='$UserID'";
                               $testcus = $conn->query($querycus);
                               if ($test->num_rows != 0){
                            echo "<p>Customer already has a bill!</p>";
                           }
                           elseif ($testcus->num_rows == 0){
                        echo "<p>Customer has not registered yet!</p>";
                       }
                            else {

                               $sql = "Insert into Bill (Customer_ID, Room_charge, Service_charge, Balance, Payment_date, Card_no) VALUES ('$UserID', '$Room', '$Service', '$Balance', '$Payment', '$Cardnumber')";
                                $result = $conn->query($sql);
                                 if ($result){
                                      $_SESSION['customer'] = $UserID;

                                            $_SESSION['Room'] = $Room;
                                            $_SESSION['Service'] = $Service;
                                            $_SESSION['Balance'] = $Balance;
                                            $_SESSION['Date'] = $Payment;
                                            $_SESSION['Card_no'] = $Cardnumber;

                                          echo "<p>You have successfully inserted </p> ";
                                             echo "<p>Username    " .$_SESSION['customer'] . "</p>";

                                              echo "<p>Room charge    ". $_SESSION['Room'] . " $ </p>";
                                              echo "<p>Service charge    ". $_SESSION['Service'] . " $ </p>";
                                              echo "<p>Balance    ". $_SESSION['Balance'] . " $ </p>";
                                              echo "<p>Payment_date    ". $_SESSION['Date'] . "</p>";
                                              echo "<p>Card number    ". $_SESSION['Card_no'] . "</p>";

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
                            echo "<p>Username is required</p>";
                    }

                    else {
                            $query = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
                            $test = $conn->query($query);

                            if ($test->num_rows == 0){
                            echo "<p>Customer dose not have a bill yet!</p>";
                            }
                            else {

                            $sql = "DELETE from Bill WHERE Customer_ID='$UserID'";
                             $result = $conn->query($sql);
                             if ($result === TRUE){
                                 $_SESSION['customer'] = $UserID;

                                   echo "<p>You have successfully deleted </p> ";
                                      echo "<p>Customer    " .$_SESSION['customer'] . "'s Bill</p>";

                            }
                             else {
                            echo "<p>Error</p>";
                            }

                    }
                  }
            }
            if (!empty($_POST['update'])){

              $UserID = $_POST['username'];
              $Room = $_POST['Room_charge'];
              $Service = $_POST['Service_charge'];

              $Payment = $_POST['payment'];
              $Cardnumber = $_POST['Card_no'];

              if (empty($UserID)) {
                      echo  "<p>Username is required</p>";
              }


              else {

                   $query = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
                   $test = $conn->query($query);

                     if ($test->num_rows == 0){
                       echo "<p>Customer dose not have a bill yet!</p>";
                     }
                      else {
                        if (!empty($Room)) {
                                $sql = "UPDATE Bill SET Room_charge = '$Room' WHERE Customer_ID='$UserID'";
                                $result = $conn->query($sql);
                                $select = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
                                $test1 = $conn->query($select);
                                $row = $test1->fetch_assoc();
                                $Balance = (float)$row['Room_charge'] + (float)$row['Service_charge'];
                                $set = "UPDATE Bill SET Balance = '$Balance' WHERE Customer_ID='$UserID'";
                                $test2 = $conn->query($set);

                                        if(($result === TRUE) && ($test2 === TRUE)) {
                                          $_SESSION['customer'] = $UserID;
                                                echo "<p>You have successfully updated Customer  ". $_SESSION['customer'] . "'s Room charge.</p>";
                                       }
                                       else {
                                              echo "<p>Error</p>";
                                            }
                        }
                        if (!empty($Service)) {
                                $sql = "UPDATE Bill SET Service_charge = '$Service' WHERE Customer_ID='$UserID'";
                                $result = $conn->query($sql);
                                $select = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
                                $test1 = $conn->query($select);
                                $row = $test1->fetch_assoc();
                                $Balance = (float)$row['Room_charge'] + (float)$row['Service_charge'];
                                $set = "UPDATE Bill SET Balance = '$Balance' WHERE Customer_ID='$UserID'";
                                $test2 = $conn->query($set);

                                        if(($result === TRUE) && ($test2 === TRUE)) {
                                          $_SESSION['customer'] = $UserID;
                                                echo "<p>You have successfully updated Customer  ". $_SESSION['customer'] . "'s Service charge.</p>";
                                       }
                                       else {
                                              echo "<p>Error</p>";
                                            }
                        }
                        if (!empty($Payment)) {
                                $sql = "UPDATE Bill SET Payment_date = '$Payment' WHERE Customer_ID='$UserID'";
                                       $result = $conn->query($sql);
                                        if ($result === TRUE){
                                          $_SESSION['customer'] = $UserID;
                                                echo "<p>You have successfully updated Customer  ". $_SESSION['customer'] . "'s Payment date.</p>";
                                       }
                                       else {
                                              echo "<p>Error</p>";
                                            }
                        }
                        if (!empty($Cardnumber)) {
                                $sql = "UPDATE Bill SET Card_no = '$Cardnumber' WHERE Customer_ID='$UserID'";
                                       $result = $conn->query($sql);
                                        if ($result === TRUE){
                                          $_SESSION['customer'] = $UserID;
                                                echo "<p>You have successfully updated Customer ". $_SESSION['customer'] . "'s Card number.</p>";
                                       }
                                       else {
                                              echo "<p>Error</p>";
                                            }
                        }
                        if(empty($Room)&&empty($Service)&&empty($Payment)&&empty($Cardnumber)){
                          echo "<p>
                          Room_charge, Service_charge, Payment_date and Card_number cannot be all empty.
                          </p>";
                        }

                       }
            }

          }


      ?>
      </form>

      <form method="post" action="Select_bill.php">

      <label class="input-group">Search by Username</label><br>
      <input type="text" name="search_username"><br>
      <input type="submit" name="search1" class="btn" value="search"><br>
      <label class="input-group">Search by Bill payment date</label><br>
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
                            echo "<table><tr><th>Customer_ID</th><th>Room_charge</th><th>Service_charge</th><th>Balance</th><th>Payment_date</th><th>Card_no</th></tr>";

                             $sql = "Select * from Bill WHERE Customer_ID LIKE '%$Searchuser%'";
                             $result = $conn->query($sql);
                             if ($result->num_rows > 0) {
                                     while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Customer_ID"] ."</td><td>". $row["Room_charge"] ."</td><td>". $row["Service_charge"] . "</td><td>". $row["Balance"] . "</td><td>". $row["Payment_date"] . "</td><td>". $row["Card_no"] . "</td></tr>";
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
                                  echo "<table><tr><th>Customer_ID</th><th>Room_charge</th><th>Service_charge</th><th>Balance</th><th>Payment_date</th><th>Card_no</th></tr>";

                                   $sql = "Select * from Bill WHERE Payment_date = '$Searchdate'";
                                   $result = $conn->query($sql);
                                   if ($result->num_rows > 0) {
                                           while($row = $result->fetch_assoc()){
                                                   echo "<tr><td>". $row["Customer_ID"] ."</td><td>". $row["Room_charge"] ."</td><td>". $row["Service_charge"] . "</td><td>". $row["Balance"] . "</td><td>". $row["Payment_date"] . "</td><td>". $row["Card_no"] . "</td></tr>";
                                          }
                                        echo "</table>";
                                  } else {
                                   echo "There are no matching search!";
                                  }

                          }

                  }

            if (!empty($_POST['list'])){

                            echo "<table><tr><th>Customer_ID</th><th>Room_charge</th><th>Service_charge</th><th>Balance</th><th>Payment_date</th><th>Card_no</th></tr>";
                             $sql = "Select * from Bill";
                              $result = $conn->query($sql);
                               if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Customer_ID"] ."</td><td>". $row["Room_charge"] ."</td><td>". $row["Service_charge"] . "</td><td>". $row["Balance"] . "</td><td>". $row["Payment_date"] . "</td><td>". $row["Card_no"] . "</td></tr>";
                                }  echo "</table>";
                            } else {
                             echo "Empty table";
                            }

            }


$conn->close();
 ?>
</body>
</html>
