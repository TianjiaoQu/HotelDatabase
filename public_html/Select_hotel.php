

<?php session_start();
     include('db_connect.php');
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Hotel in Database</title>
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

<form method="post" action="Select_hotel.php">
		<p>Hotel ID is required for update and delete</p>
                <label class="input-group">Hotel_ID</label><br>
                <input type="text" name="hotel_id"><br>
                <label class="input-group">Hotel_name</label><br>
                <input type="text" name="hotel_name"><br>
                <input type="submit" name="insert" class="btn" value="insert">
                <input type="submit" name="delete" class="btn" value="delete">
		 <input type="submit" name="update" class="btn" value="update">
		<input type="submit" name="list" class="btn" value="list">




<?php
 
        $HotelID = "";
        $Hotelname = "";
	$Search = "";


        if (!empty($_POST['insert'])){
                $HotelID = $_POST['hotel_id'];
                $Hotelname = $_POST['hotel_name'];


                if (empty($HotelID)) {
                        echo  "<p>Hotel_ID is required</p>";
                }

               else  if (empty($Hotelname)) {
                        echo "<p>Hotel_name is required</p>";
                }

                else {
			$query = "SELECT * FROM Hotel WHERE Hotel_ID='$HotelID'";
			$test = $conn->query($query);

			if ($test->num_rows > 0){
                        echo "<p>Hotel_ID already exists!</p>";
                	}
                        else if ((!empty($HotelID)) && (!empty($Hotelname)) ){

                	$sql = "Insert into Hotel (Hotel_ID, Hotel_name) VALUES ('$HotelID', '$Hotelname')";
               		 $result = $conn->query($sql);
               		 if ($result){
			$_SESSION['Hotelname'] = $Hotelname;
			$_SESSION['HotelID'] = $HotelID;
			

               		 echo "<p>You have successfully inserted </p> ";
			echo "<p>Hotel_ID    " .$_SESSION['HotelID'] . "</p>";
               		  echo "<p>Hotel_name    ". $_SESSION['Hotelname'] . "</p>";

			
                	}
               		 else {
                        echo "<p>Error</p>";
                	}

                }	
        }
	}

        if (!empty($_POST['delete'])){
                $HotelID = $_POST['hotel_id'];
                $Hotelname = $_POST['hotel_name'];


                if (empty($HotelID)) {
                        echo  "<p>Hotel_ID is required</p>";
                }
              

                else {
                        $query = "SELECT * FROM Hotel WHERE Hotel_ID='$HotelID'";
                        $test = $conn->query($query);

                        if ($test->num_rows == 0){
                        echo "<p>Hotel_ID dose not exist!</p>";
                        }
                        else {

                        $sql = "Delete from Hotel Where Hotel_ID = '$HotelID'";
                         $result = $conn->query($sql);
                         if ($result === TRUE){
			
                         $_SESSION['HotelID'] = $HotelID;
			echo "<p>You have successfully deleted </p> ";
                        echo "<p>Hotel_ID    " .$_SESSION['HotelID'] . "</p>";
                          echo "<p>Hotel_name    ". $_SESSION['Hotelname'] . "<p>";
                        }
                         else {
                        echo "<p>Error</p>";
                        }

                }
        }
        }
        if (!empty($_POST['update'])){
                $HotelID = $_POST['hotel_id'];
                $Hotelname = $_POST['hotel_name'];


                if (empty($HotelID)) {
                        echo  "<p>Hotel_ID is required</p>";
                }
               else  if (empty($Hotelname)) {
                        echo "<p>Hotel_name is required</p>";
                }

			else {
				$query = "SELECT * FROM Hotel WHERE Hotel_ID='$HotelID'";
				$test = $conn->query($query);

				if ($test->num_rows == 0){
				echo "<p>Hotel_ID dose not exist!</p>";
				}
				else {

				$sql = "Update Hotel SET Hotel_name = '$Hotelname' where Hotel_ID = '$HotelID'";
				 $result = $conn->query($sql);
				 if ($result === TRUE){
				 $_SESSION['HotelID'] = $HotelID;
				 $_SESSION['Hotelname'] = $Hotelname;
				echo "<p>You have successfully updated </p> ";
                       		echo "<p>Hotel_ID    " .$_SESSION['HotelID'] . "</p>";
                          	echo "<p>Hotel_name    ". $_SESSION['Hotelname'] . "</p>";

				 
				}
				 else {
				echo "<p>Error</p>";
				}

			   }
		     }
	      }


	
?>
</form>
<form method="post" action="Select_hotel.php">

                <label class="input-group">Search</label><br>
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
		if (!empty($_POST['list'])){
			echo "<table><tr><th>Hotel_ID</th><th>Hotel_name</th></tr>";
			
  			 $sql = "Select * from Hotel";
 			  $result = $conn->query($sql);
			   if ($result->num_rows > 0) {
			        while($row = $result->fetch_assoc()){
       					 echo "<tr><td>". $row["Hotel_ID"] ."</td><td>". $row["Hotel_name"] ."</td></tr>";
       				 }
       				 echo "</table>";
  			 } else {
       			 echo "Empty table";
			}

        }
        if (!empty($_POST['search'])){

                $Search = $_POST['search_text'];
                if(!empty($Search)){
  			echo "<table><tr><th>Hotel_ID</th><th>Hotel_name</th></tr>";
	
                         $sql = "Select * from Hotel WHERE Hotel_ID LIKE '%$Search%' OR Hotel_name LIKE '%$Search%'";
                         $result = $conn->query($sql);
                         if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()){
                                         echo "<tr><td>". $row["Hotel_ID"] ."</td><td>". $row["Hotel_name"] ."</td></tr>";
                                 }
                                 echo "</table>";
                         } else {
                         echo "There are no matching search!";
                        }
                      
                }

        }
$conn->close();
?>

 </body>
</html>
