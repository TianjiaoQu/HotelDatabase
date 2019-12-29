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

      <form method="post" action="Select_reservation.php">

                    <label class="input-group">Username</label><br>
                    <input type="text" name="username"><br>
                    <label class="input-group">Hotel</label><br>
                    <select type="text" name="hotel"><br>
                      <option value="">Select</option>
                      <?php
                      $HotelID = "";
                      $sql = "Select * from Hotel ";
                       $result = $conn->query($sql);
                       if ($result->num_rows > 0) {
                               while($row = $result->fetch_assoc()){
                                      $HotelID = $row["Hotel_ID"];

                                       echo "<option value='$HotelID'>" .$row["Hotel_ID"]. "  " .$row["Hotel_name"]. "</option>";
                              }
                            echo "</select><br>";
                      }
                      ?>
                      <label class="input-group">Room Type</label><br>
                      <select type="text" name="room"><br>
                        <option value="">Select</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                        <option value="queen">Queen</option>
                        <option value="king">King</option>
                        <option value="suite">Suite</option>
                      </select><br>
                    <label class="input-group">Check in date</label><br>
                    <input type="date" name="check_in_date"><br>
                    <label class="input-group">Check out date</label><br>
                    <input type="date" name="check_out_date"><br>
                    <input type="submit" name="availablity" class="btn" value="Check availablity">
                    <input type="submit" name="list" class="btn" value="list"><br>




      <?php


            $Searchuser = "";
            $Searchdate = "";
            $Checkindate ="";
            $Checkoutdate ="";
            $UserID = "";

            $RoomID ="";
            $Roomtype ="";
            $Room_charge = "";
            $Balance ="";
            $ReservationID = "";
            $days ="";


            if (!empty($_POST['availablity'])){

                    $UserID = $_POST['username'];
                    $HotelID = $_POST['hotel'];
                    $Roomtype = $_POST['room'];
                    $Checkindate =$_POST['check_in_date'];
                    $Checkoutdate =$_POST['check_out_date'];;
                    $days = round ( ( strtotime($Checkoutdate) - strtotime($Checkindate) )/(60*60*24) ) ;
                    $_SESSION['customer'] = $UserID;
                    $_SESSION['Hotel'] = $HotelID;
                    $_SESSION['Roomtype'] = $Roomtype;
                    $_SESSION['checkindate'] = $Checkindate;
                    $_SESSION['checkoutdate'] = $Checkoutdate;
                    if (empty($UserID)) {
                            echo  "<p>Username is required</p>";
                    }
                    else if (empty($HotelID)) {
                            echo  "<p>A Hotel needs to be selected</p>";
                    }
                    else if (empty($Roomtype)) {
                            echo  "<p>A Room type needs to be selected</p>";
                    }
                    else if (empty($Checkindate)) {
                            echo  "<p>A Check in date needs to be selected</p>";
                    }
                    else if (empty($Checkoutdate)) {
                            echo  "<p>A Check out date needs to be selected</p>";
                    }
                    else {
                      $querycus = "SELECT * FROM Customer WHERE Customer_ID='$UserID'";
                               $testcus = $conn->query($querycus);
                               if ($testcus->num_rows == 0){
                        echo "<p>Customer has not registered yet!</p>";
                       }
                       else {
                            $query = "SELECT * FROM Room WHERE Hotel_ID ='$HotelID' AND Room_type = '$Roomtype'";
                            $Charge = $conn->query($query);
                            $available = "SELECT * FROM Room WHERE Hotel_ID ='$HotelID' AND Room_type = '$Roomtype' AND Room_ID NOT IN (SELECT Room_ID FROM Reservation WHERE Hotel_ID ='$HotelID' AND '$Checkindate' <= Check_out_date AND '$Checkoutdate' >= Check_in_date )";
                            $avail = $conn->query($available);
                            if (($Charge->num_rows > 0) && ($avail->num_rows > 0)){
                              $row = $Charge->fetch_assoc();
                              $rowroom = $avail->fetch_assoc();
                              $_SESSION['roomcharge'] = $row["Room_rate"] * $days;
                              $_SESSION['room'] = $rowroom["Room_ID"];
                              echo "<p>Your selected room rate is " .$_SESSION['roomcharge']. " $ in total. Please press Book to submit reservation</p>";
                              echo "<input type='submit' name='confirm' class='btn' value='Book'>";

                          }else {
                            echo "<p>
                            Sorry, currently there is no available room based on your selection.
                            </p>";
                          }

                        }
                      }
      }
      if (!empty($_POST['confirm'])){

        $UserID = $_SESSION['customer'];
        $HotelID = $_SESSION['Hotel'];
        $RoomID = $_SESSION['room'];
        $Room_charge = $_SESSION['roomcharge'];
        $Checkindate = $_SESSION['checkindate'];
        $Checkoutdate = $_SESSION['checkoutdate'];

        if (empty($UserID)) {
                echo  "<p>Username is required</p>";
        }
        else if (empty($HotelID) || empty($RoomID)) {
                echo  "<p>A Hotel and Room need to be selected</p>";
        }
        else if (empty($Checkindate) || empty($Checkoutdate)) {
                echo  "<p>A Date needs to be selected</p>";
        }else{

           $sql = "Insert into Reservation (Customer_ID, Hotel_ID, Room_ID, Check_in_date, Check_out_date) VALUES ('$UserID', '$HotelID', '$RoomID', '$Checkindate', '$Checkoutdate')";
            $result = $conn->query($sql);
            $sql1 = "UPDATE Bill SET Room_charge = Room_charge + '$Room_charge', Balance = Balance + '$Room_charge' WHERE Customer_ID='$UserID'";
            $result1 = $conn->query($sql1);
            $bill = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
              $result2 = $conn->query($bill);
              if ($result2->num_rows > 0){
                $row2 = $result2->fetch_assoc();
                $Balance = $row2["Balance"];

            }
             if ($result && $result1){

                        $_SESSION['Balance'] = $Balance;
                       
                      echo "<p>You have successfully booked reservation </p> ";
                         echo "<p>Username    " .$_SESSION['customer'] . "</p>";

                          echo "<p>Check in date    ". $_SESSION['checkindate'] . "</p>";
                          echo "<p>Check out date    ". $_SESSION['checkoutdate'] . "</p>";
                          echo "<p>Current balance    ". $_SESSION['Balance'] . " $ </p>";
                         }
             else {
               echo "<p>Error</p>";
           }
         }
       }




      ?>
      </form>
<form method="post" action="Select_reservation.php">
  <label class="input-group">Delete by Reservation number</label><br>
  <input type="text" name="reserve_id"><br>
  <input type="submit" name="delete" class="btn" value="delete"><br>

  <?php
  if (!empty($_POST['delete'])){
          $ReservationID = $_POST['reserve_id'];
          $_SESSION['Reservation_ID'] = $ReservationID;
               if (empty($ReservationID)) {
                        echo "<p>Request ID is required</p>";
                }

                else {
                        $query = "SELECT * FROM Reservation WHERE Reserve_no ='$ReservationID'";
                        $test = $conn->query($query);

                        if ($test->num_rows == 0){
                        echo "<p>Reservation does not exist!</p>";
                        }
                        else {
                          $rowtest = $test->fetch_assoc();
                          $Checkindate =$rowtest["Check_in_date"];
                          $Checkoutdate =$rowtest["Check_out_date"];
                          $HotelID = $rowtest["Hotel_ID"];
                          $RoomID = $rowtest["Room_ID"];
                          $UserID = $rowtest["Customer_ID"];
                          $days = round ( ( strtotime($Checkoutdate) - strtotime($Checkindate) )/(60*60*24) ) ;
                          $query1 = "SELECT * FROM Room WHERE Hotel_ID='$HotelID' AND Room_ID ='$RoomID'";
                          $Charge = $conn->query($query1);
                          if ($Charge->num_rows > 0){
                            $row = $Charge->fetch_assoc();
                            $Room_charge = $row["Room_rate"];
                            $Room_charge = $Room_charge * $days;

                        }
                        $sql = "DELETE From Reservation WHERE Reserve_no='$ReservationID'";
                        $sql1 = "UPDATE Bill SET Room_charge = Room_charge - '$Room_charge', Balance = Balance - '$Room_charge' WHERE Customer_ID='$UserID'";
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
                            echo "<p>You have successfully deleted reservation</p> ";
                            echo "<p>Reservation number    " .$_SESSION['Reservation_ID'] . "</p>";
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
      <form method="post" action="Select_reservation.php">
      <label class="input-group">Search by Username</label><br>
      <input type="text" name="search_username"><br>
      <input type="submit" name="search1" class="btn" value="search"><br>
      <label class="input-group">Search by Check in date</label><br>
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
                            echo "<table><tr><th>Reserve_no</th><th>Customer_ID</th><th>Hotel_ID</th><th>Room_ID</th><th>Check_in_date</th><th>Check_out_date</th></tr>";

                             $sql = "Select * from Reservation WHERE Customer_ID LIKE '%$Searchuser%'";
                             $result = $conn->query($sql);
                             if ($result->num_rows > 0) {
                                     while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Reserve_no"] ."</td><td>". $row["Customer_ID"] ."</td><td>". $row["Hotel_ID"] . "</td><td>". $row["Room_ID"] . "</td><td>". $row["Check_in_date"] . "</td><td>". $row["Check_out_date"] . "</td></tr>";
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
                                  echo "<table><tr><th>Reserve_no</th><th>Customer_ID</th><th>Hotel_ID</th><th>Room_ID</th><th>Check_in_date</th><th>Check_out_date</th></tr>";

                                   $sql = "Select * from Reservation WHERE Check_in_date = '$Searchdate'";
                                   $result = $conn->query($sql);
                                   if ($result->num_rows > 0) {
                                           while($row = $result->fetch_assoc()){
                                                   echo "<tr><td>". $row["Reserve_no"] ."</td><td>". $row["Customer_ID"] ."</td><td>". $row["Hotel_ID"] . "</td><td>". $row["Room_ID"] . "</td><td>". $row["Check_in_date"] . "</td><td>". $row["Check_out_date"] . "</td></tr>";
                                          }
                                        echo "</table>";
                                  } else {
                                   echo "There are no matching search!";
                                  }

                          }

                  }

            if (!empty($_POST['list'])){

                            echo "<table><tr><th>Reserve_no</th><th>Customer_ID</th><th>Hotel_ID</th><th>Room_ID</th><th>Check_in_date</th><th>Check_out_date</th></tr>";
                             $sql = "Select * from Reservation";
                              $result = $conn->query($sql);
                               if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Reserve_no"] ."</td><td>". $row["Customer_ID"] ."</td><td>". $row["Hotel_ID"] . "</td><td>". $row["Room_ID"] . "</td><td>". $row["Check_in_date"] . "</td><td>". $row["Check_out_date"] . "</td></tr>";
                                }  echo "</table>";
                            } else {
                             echo "Empty table";
                            }

            }


$conn->close();
 ?>
</body>
</html>
