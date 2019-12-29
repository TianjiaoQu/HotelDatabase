
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
	<form method="post" action="Select_room.php">
<p>Hotel ID and Room ID is requred for update and delete</p><br>
		<label class="input-group">Hotel ID</label><br>
                <input type="text" name="Hotel_ID"><br>


                <label class="input-group">Room ID</label><br>
                <input type="text" name="Room_ID"><br>

                <label class="input-group">Room type</label><br>
                <input type="text" name="Room_type"><br>

                <label class="input-group">Room rate</label><br>
                <input type="number" class="number" name="Room_rate" step="0.01"><br>

                <input type="submit" name="insert" class="btn" value="insert">
                <input type="submit" name="delete" class="btn" value="delete">
                 <input type="submit" name="update" class="btn" value="update">
                <input type="submit" name="list" class="btn" value="list"><br>

<?php


	$Search = "";
        $Hotel = "";
        $Room = "";
        $Type = "";
        $Rate = "";
        if (!empty($_POST['insert'])){
                $Hotel = $_POST['Hotel_ID'];
                $Room = $_POST['Room_ID'];
                $Type = $_POST['Room_type'];
                $Rate = $_POST['Room_rate'];
                if (empty($Hotel)) {
                        echo  "<p>Hotel_ID is required</p>";
                }
               if (empty($Room)) {
                        echo  "<p>Room_ID is required</p>";
                }
               if (empty($Type)) {
                        echo  "<p>Room_type is required</p>";
                }
               if (empty($Rate)) {
                        echo  "<p>Room_rate is required</p>";
                }

                if ((!empty($Hotel)) && (!empty($Room)) && (!empty($Type)) && (!empty($Rate))) {
			               $query = "SELECT * FROM Hotel WHERE Hotel_ID='$Hotel'";
			                  $test = $conn->query($query);
                        $queryroom = "SELECT * FROM Room WHERE Hotel_ID='$Hotel' AND Room_ID='$Room'";
   			                  $testroom = $conn->query($queryroom);
			                     if ($test->num_rows == 0){
                        echo "<p>Hotel_ID does not exist!</p>";
                	     }
                       else if ($testroom->num_rows != 0){
                         echo "<p>Room_ID already exists!</p>";
                       }
                        else {

                	         $sql = "Insert into Room (Hotel_ID, Room_ID, Room_type, Room_rate) VALUES ('$Hotel', '$Room', '$Type', '$Rate')";
               		          $result = $conn->query($sql);
               		           if ($result){
			                            $_SESSION['Hotel'] = $Hotel;
			                               $_SESSION['Room'] = $Room;
			                                  $_SESSION['Type'] = $Type;
                                        $_SESSION['Rate'] = $Rate;
               		                    echo "<p>You have successfully inserted </p> ";
			                                   echo "<p>Hotel_ID    " .$_SESSION['Hotel'] . "</p>";
               		                        echo "<p>Room_ID    ". $_SESSION['Room'] . "</p>";
                                          echo "<p>Room_type    ". $_SESSION['Type'] . "</p>";
                                          echo "<p>Room_rate    ". $_SESSION['Rate'] . " $</p>";
                	                       }
               		           else {
                               echo "<p>Error</p>";
                	         }

                }
        }
	}

        if (!empty($_POST['delete'])){
          $Hotel = $_POST['Hotel_ID'];
          $Room = $_POST['Room_ID'];


                if (empty($Hotel)) {
                        echo  "<p>Hotel_ID is required</p>";
                }
               else  if (empty($Room)) {
                        echo "<p>Room_ID is required</p>";
                }

                else {
                        $query = "SELECT * FROM Room WHERE Hotel_ID='$Hotel' AND Room_ID='$Room'";
                        $test = $conn->query($query);

                        if ($test->num_rows == 0){
                        echo "<p>Room_ID dose not exist!</p>";
                        }
                        else {

                        $sql = "DELETE from Room Where Hotel_ID ='$Hotel' AND Room_ID='$Room'";
                         $result = $conn->query($sql);
                         if ($result === TRUE){
                           $_SESSION['Hotel'] = $Hotel;
                              $_SESSION['Room'] = $Room;
                               echo "<p>You have successfully deleted </p> ";
                                  echo "<p>Hotel_ID    " .$_SESSION['Hotel'] . "</p>";
                                   echo "<p>Room_ID    ". $_SESSION['Room'] . "</p>";
                        }
                         else {
                        echo "<p>Error</p>";
                        }

                }
              }
        }
        if (!empty($_POST['update'])){
          $Hotel = $_POST['Hotel_ID'];
          $Room = $_POST['Room_ID'];
          $Type = $_POST['Room_type'];
          $Rate = $_POST['Room_rate'];
          if (empty($Hotel)) {
                  echo  "<p>Hotel_ID is required</p>";
          }
         if (empty($Room)) {
                  echo  "<p>Room_ID is required</p>";
          }

          if ((!empty($Hotel)) && (!empty($Room))) {

                  $queryroom = "SELECT * FROM Room WHERE Hotel_ID='$Hotel' AND Room_ID='$Room'";
                    $testroom = $conn->query($queryroom);

                 if ($testroom->num_rows == 0){
                   echo "<p>Room_ID does not exist!</p>";
                 }
                  else {
                    if (!empty($Type)) {
                            $sql = "UPDATE Room SET Room_type = '$Type' WHERE Hotel_ID='$Hotel' AND Room_ID='$Room'";
                                   $result = $conn->query($sql);
                                    if ($result === TRUE){
                                      $_SESSION['Hotel'] = $Hotel;
                                         $_SESSION['Room'] = $Room;
                                          echo "<p>You have successfully updated  Room  ". $_SESSION['Room'] . " in Hotel ". $_SESSION['Hotel'] . "'s Room type.</p>";
                                   }
                                   else {
                                          echo "<p>Error</p>";
                                        }
                    }
                    if (!empty($Rate)) {
                            $sql = "UPDATE Room SET Room_rate = '$Rate' WHERE Hotel_ID='$Hotel' AND Room_ID='$Room'";
                                   $result = $conn->query($sql);
                                    if ($result === TRUE){
                                      $_SESSION['Hotel'] = $Hotel;
                                         $_SESSION['Room'] = $Room;
                                          echo "<p>You have successfully updated  Room  ". $_SESSION['Room'] . " in Hotel ". $_SESSION['Hotel'] . "'s Room rate.</p>";
                                   }
                                   else {
                                          echo "<p>Error</p>";
                                        }
                    }
                    if(empty($Type)&&empty($Rate)){
                      echo "<p>
                      Room_type and Room_rate cannot be both empty.
                      </p>";
                    }

                   }
        }

      }


?>
</form>

<form method="post" action="Select_room.php">

  <label class="input-group">Search by Hotel ID or Room type</label><br>
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
                        echo "<table><tr><th>Hotel_ID</th><th>Room_ID</th><th>Room_type</th><th>Room_rate</th></tr>";

                         $sql = "Select * from Room WHERE Hotel_ID LIKE '%$Search%' OR Room_type LIKE '%$Search%'";
                         $result = $conn->query($sql);
                         if ($result->num_rows > 0) {
                                 while($row = $result->fetch_assoc()){
                                         echo "<tr><td>". $row["Hotel_ID"] ."</td><td>". $row["Room_ID"] ."</td><td>". $row["Room_type"] ."</td><td>". $row["Room_rate"] . "</td></tr>";
                                }
                              echo "</table>";
                        } else {
                         echo "There are no matching search!";
                        }

                }

        }


        if (!empty($_POST['list'])){

                        echo "<table><tr><th>Hotel_ID</th><th>Room_ID</th><th>Room_type</th><th>Room_rate</th></tr>";
                         $sql = "Select * from Room";
                          $result = $conn->query($sql);
                           if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()){
                                         echo "<tr><td>". $row["Hotel_ID"] ."</td><td>". $row["Room_ID"] ."</td><td>". $row["Room_type"] ."</td><td>". $row["Room_rate"] . "</td></tr>";
                            }  echo "</table>";
                        } else {
                         echo "Empty table";
                        }

        }



$conn->close();
?>
</body>
</html>
