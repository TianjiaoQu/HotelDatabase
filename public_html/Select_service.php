
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

      <form method="post" action="Select_service.php">
        <p>Service ID is requred for update and delete</p><br>
        <label class="input-group">Service ID</label><br>
                    <input type="text" name="Service_ID"><br>

                    <label class="input-group">Service type</label><br>
                    <input type="text" name="Service_type"><br>

                    <label class="input-group">Service rate</label><br>
                    <input type="number" class= "number" name="Service_rate" step="0.01"><br>

                    <input type="submit" name="insert" class="btn" value="insert">
                    <input type="submit" name="delete" class="btn" value="delete">
                     <input type="submit" name="update" class="btn" value="update">
                    <input type="submit" name="list" class="btn" value="list"><br>

      <?php


      $Search = "";
            $ServiceID = "";
            $Type = "";
            $Rate = "";
            if (!empty($_POST['insert'])){

                    $ServiceID = $_POST['Service_ID'];
                    $Type = $_POST['Service_type'];
                    $Rate = $_POST['Service_rate'];
                    if (empty($ServiceID)) {
                            echo  "<p>A two digits Service_ID is required</p>";
                    }
                   if (empty($Type)) {
                            echo  "<p>Service_type is required</p>";
                    }
                   if (empty($Rate)) {
                            echo  "<p>Service_rate is required</p>";
                    }

                    if ((!empty($ServiceID))  && (!empty($Type)) && (!empty($Rate))) {
                         $query = "SELECT * FROM Service WHERE Service_ID='$ServiceID'";
                            $test = $conn->query($query);

                               if ($test->num_rows != 0){
                            echo "<p>Service ID already exists!</p>";
                           }
                            else {

                               $sql = "Insert into Service (Service_ID, Service_type, Service_rate) VALUES ('$ServiceID', '$Type', '$Rate')";
                                $result = $conn->query($sql);
                                 if ($result){
                                      $_SESSION['Service'] = $ServiceID;

                                            $_SESSION['Type'] = $Type;
                                            $_SESSION['Rate'] = $Rate;
                                          echo "<p>You have successfully inserted </p> ";
                                             echo "<p>Service_ID    " .$_SESSION['Service'] . "</p>";

                                              echo "<p>Service_type    ". $_SESSION['Type'] . "</p>";
                                              echo "<p>Service_rate    ". $_SESSION['Rate'] . " $ </p>";
                                             }
                                 else {
                                   echo "<p>Error</p>";
                               }

                    }
            }
      }

            if (!empty($_POST['delete'])){
              $ServiceID = $_POST['Service_ID'];

                   if (empty($ServiceID)) {
                            echo "<p>Service ID is required</p>";
                    }

                    else {
                            $query = "SELECT * FROM Service WHERE Service_ID='$ServiceID'";
                            $test = $conn->query($query);

                            if ($test->num_rows == 0){
                            echo "<p>Service_ID dose not exist!</p>";
                            }
                            else {

                            $sql = "DELETE from Service WHERE Service_ID='$ServiceID'";
                             $result = $conn->query($sql);
                             if ($result === TRUE){
                                 $_SESSION['Service'] = $ServiceID;

                                   echo "<p>You have successfully deleted </p> ";
                                      echo "<p>Service_ID    " .$_SESSION['Service'] . "</p>";

                            }
                             else {
                            echo "<p>Error</p>";
                            }

                    }
                  }
            }
            if (!empty($_POST['update'])){
              $ServiceID = $_POST['Service_ID'];
              $Type = $_POST['Service_type'];
              $Rate = $_POST['Service_rate'];
              if (empty($ServiceID)) {
                      echo  "<p>Service ID is required</p>";
              }

              else {

                      $query = "SELECT * FROM Service WHERE Service_ID='$ServiceID'";
                        $test = $conn->query($query);

                     if ($test->num_rows == 0){
                       echo "<p>Service_ID does not exist!</p>";
                     }
                      else {
                        if (!empty($Type)) {
                                $sql = "UPDATE Service SET Service_type = '$Type' WHERE Service_ID='$ServiceID'";
                                       $result = $conn->query($sql);
                                        if ($result === TRUE){
                                        $_SESSION['Service'] = $ServiceID;
                                              echo "<p>You have successfully updated Service  ". $_SESSION['Service'] . "'s Service type.</p>";
                                       }
                                       else {
                                              echo "<p>Error</p>";
                                            }
                        }
                        if (!empty($Rate)) {
                                $sql = "UPDATE Service SET Service_rate = '$Rate' WHERE Service_ID='$ServiceID'";
                                       $result = $conn->query($sql);
                                        if ($result === TRUE){
                                          $_SESSION['Service'] = $ServiceID;
                                                echo "<p>You have successfully updated Service  ". $_SESSION['Service'] . "'s Service rate.</p>";
                                       }
                                       else {
                                              echo "<p>Error</p>";
                                            }
                        }
                        if(empty($Type)&&empty($Rate)){
                          echo "<p>
                          Service_type and Service_rate cannot be both empty.
                          </p>";
                        }

                       }
            }

          }


      ?>
      </form>

      <form method="post" action="Select_service.php">

      <label class="input-group">Search by Service ID or Service type</label><br>
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
                            echo "<table><tr><th>Service_ID</th><th>Service_type</th><th>Service_rate</th></tr>";

                             $sql = "Select * from Service WHERE Service_ID LIKE '%$Search%' OR Service_type LIKE '%$Search%'";
                             $result = $conn->query($sql);
                             if ($result->num_rows > 0) {
                                     while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Service_ID"] ."</td><td>". $row["Service_type"] ."</td><td>". $row["Service_rate"] . "</td></tr>";
                                    }
                                  echo "</table>";
                            } else {
                             echo "There are no matching search!";
                            }

                    }

            }


            if (!empty($_POST['list'])){

                            echo "<table><tr><th>Service_ID</th><th>Service_type</th><th>Service_rate</th></tr>";
                             $sql = "Select * from Service";
                              $result = $conn->query($sql);
                               if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()){
                                             echo "<tr><td>". $row["Service_ID"] ."</td><td>". $row["Service_type"] ."</td><td>". $row["Service_rate"] . "</td></tr>";
                                }  echo "</table>";
                            } else {
                             echo "Empty table";
                            }

            }


$conn->close();
 ?>
</body>
</html>
