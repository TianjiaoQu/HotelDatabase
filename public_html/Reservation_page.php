<?php
session_start();
include('db_connect.php');?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Make Reservation</title>
    <!-- CSS style tag for html body-->
    <link rel="stylesheet" href="styles.css">

    <link rel="icon" href="favicon.ico">
    <style media="screen">
    </style>
    <style>
    *{
      margin: 0;
      padding: 0;
      }

      .reserveinfo {
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

      .reserveinfo h1{
        color:#663300;
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





    </style>
  </head>
  <body>
    <div class="head_container">
      <img class="rushrhees" src="rushrhees.jpg" alt="rushrhees front picture">
     <h1 class="Welcome"> <?php if (!empty($_SESSION['username'])){
        echo "Welcome ";
         echo $_SESSION['username'];
}
?></h1>
<a class="topbar" href="Customer.php">HOME</a>
      <a class="topbar" href="Reservation_page.php">RESERVATION</a>
      <a class="topbar" href="bill_page.php">BILL</a>
      <a class="topbar" href="hotel_room_info.php">HOTELS&ROOMS</a>
      <a class="topbar" href="Request_page.php">REQUEST</a>
      <a class="topbar" href="logout.php">LOGOUT</a>
    </div>
        <form class= "reserveinfo" method="post" action="Reservation_page.php">
        <h1>Choose a Hotel</h1>
        <label class="input-group">You want to stay at</label>
        <select id="hotel_category" name="hotels">
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
        </select><br>

          <h1>Choose a room</h1>
          <label class="input-group">Your room type will be</label>
          <select id="room_category" name="rooms">
                  <option value="">Select</option>
                  <option value="single">Single</option>
                  <option value="double">Double</option>
                  <option value="queen">Queen</option>
                  <option value="king">King</option>
                  <option value="suite">Suite</option>
          </select><br>

<br>  <h1>How long do you want to stay?</h1>
          <label class="input-group">From</label>
            <input type="date" name="checkin-date"><br>
          <label class="input-group">To&nbsp&nbsp&nbsp&nbsp&nbsp</label>
            <input type="date" name="checkout-date"><br>

        <input type="submit" name="CheckAvail" class="btn" value="Check availability">
        <input type="submit" name="list" class="btn" value="All my reservation"><br>
        <br><label class="input-group">Cancel by Reservation number</label>
        <input type="text" name="reserve_id">
        <input type="submit" name="delete" class="btn" value="Cancel"><br>


        <?php
        $Checkin ="";
        $Checkout ="";
        $UserID = "";
        $UserID = $_SESSION['username'];
        $RoomID ="";
        $Roomtype ="";
        $Room_charge = "";
        $Balance ="";
        $ReservationID = "";
        $days ="";

                if (!empty($_POST['CheckAvail'])){
                        $HotelID = $_POST['hotels'];
                        $Roomtype = $_POST['rooms'];
                        $Checkin = $_POST['checkin-date'];
                        $Checkout = $_POST['checkout-date'];
                        $days = round ( ( strtotime($Checkout) - strtotime($Checkin) )/(60*60*24) ) ;
                        $_SESSION['customer'] = $UserID;
                        $_SESSION['Hotel'] = $HotelID;
                        $_SESSION['Roomtype'] = $Roomtype;
                        $_SESSION['checkindate'] = $Checkin;
                        $_SESSION['checkoutdate'] = $Checkout;

                        if (empty($HotelID)) {
                          echo "<p>Please choose a hotel</p>";
                        }

                        if (empty($Roomtype)) {
                                echo "<p>Please choose a room</p>";
                        }

                        if (empty($Checkin)){
                                echo "<p>Check-in date required!</p>";
                        }

                        if (empty($Checkout)){
                                echo "<p>Check-out date required!</p>";
                        }

                        if ($Checkout <= $Checkin){
                          echo "<p>Check-out date invalid!</p>";
                        }

                        if (!empty($HotelID) && !empty($Roomtype) && !empty($Checkin) && !empty($Checkout) && ($Checkout >= $Checkin)){
                          $query = "SELECT * FROM Room WHERE Hotel_ID ='$HotelID' AND Room_type = '$Roomtype'";
                          $Charge = $conn->query($query);
                          $available = "SELECT * FROM Room WHERE Hotel_ID ='$HotelID' AND Room_type = '$Roomtype'
                          AND Room_ID NOT IN (SELECT Room_ID FROM Reservation WHERE Hotel_ID ='$HotelID' AND '$Checkin' <= Check_out_date AND '$Checkout' >= Check_in_date )";
                          $avail = $conn->query($available);

                          if( ($Charge->num_rows > 0) && ($avail->num_rows > 0)) {
                            $row = $Charge->fetch_assoc();
                            $rowroom = $avail->fetch_assoc();
                            $_SESSION['roomcharge'] = $row["Room_rate"] * $days;
                            $_SESSION['room'] = $rowroom["Room_ID"];
		    		echo "<br><p>Your selected room rate is " .$_SESSION['roomcharge']. " $ in total. Please press Book to submit reservation</p>";
                            echo "<input type='submit' name='confirm' class='btn' value='Book'>";

                            //assign a room not in mysqli_more_results
                          }else{
                            echo "<p>No available room at this time!</p>";
        			            }
                        }
                  }

                  if (!empty($_POST['confirm'])){

                    $HotelID = $_SESSION['Hotel'];
                    $RoomID = $_SESSION['room'];
                    $Room_charge = $_SESSION['roomcharge'];
                    $Checkin = $_SESSION['checkindate'];
                    $Checkout = $_SESSION['checkoutdate'];

                    if (empty($UserID)) {
                            echo  "<p>Username is required</p>";
                    }
                    else if (empty($HotelID) || empty($RoomID)) {
                            echo  "<p>A Hotel and Room need to be selected</p>";
                    }
                    else if (empty($Checkin) || empty($Checkout)) {
                            echo  "<p>A Date needs to be selected</p>";
                    }

                    else{

                       $sql = "Insert into Reservation (Customer_ID, Hotel_ID, Room_ID, Check_in_date, Check_out_date) VALUES ('$UserID', '$HotelID', '$RoomID', '$Checkin', '$Checkout')";
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

			             echo "<br><p>You have successfully booked reservation</p> ";


                                      echo "<p>Check in date    ". $_SESSION['checkindate'] . "</p>";
                                      echo "<p>Check out date    ". $_SESSION['checkoutdate'] . "</p>";
                                      echo "<p>Current balance    ". $_SESSION['Balance'] . " $ </p>";
                                  }
                         else {
                           echo "<p>Error</p>";
                       }
                     }


          }
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
                                echo "<br><p>Reservation does not exist!</p>";
                                }
                                else {
                                  $rowtest = $test->fetch_assoc();
                                  $Checkin =$rowtest["Check_in_date"];
                                  $Checkout =$rowtest["Check_out_date"];
                                  $HotelID = $rowtest["Hotel_ID"];
                                  $RoomID = $rowtest["Room_ID"];

                                  $days = round ( ( strtotime($Checkout) - strtotime($Checkin) )/(60*60*24) ) ;
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


                                     $_SESSION['Balance'] = $Balance;
                                    echo "<br><p>You have successfully cancelled reservation</p> ";
                                    echo "<p>Reservation number    " .$_SESSION['Reservation_ID'] . "</p>";

                                    echo "<p>Current balance    ". $_SESSION['Balance'] . " $ </p>";

                                }
                                 else {
                                echo "<p>Cancellationo Failed</p>";
                                }

                        }
                      }
                }
          if (!empty($_POST['list'])){

                          echo "<table><tr><th>Reserve_no</th><th>Customer_ID</th><th>Hotel_ID</th><th>Room_ID</th><th>Check_in_date</th><th>Check_out_date</th></tr>";
                           $sql = "SELECT * from Reservation WHERE Customer_ID = '$UserID'";
                            $result = $conn->query($sql);
                             if ($result->num_rows > 0) {
                                  while($row = $result->fetch_assoc()){
                                           echo "<tr><td>". $row["Reserve_no"] ."</td><td>". $row["Customer_ID"] ."</td><td>". $row["Hotel_ID"] . "</td><td>". $row["Room_ID"] . "</td><td>". $row["Check_in_date"] . "</td><td>". $row["Check_out_date"] . "</td></tr>";
                              }  echo "</table>";
                          } else {
                           echo "You do not have any reservation yet!";
                          }

          }
        $conn->close();
        ?>
        	</form>

        </body>


        </html>
