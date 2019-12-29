<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Billing Info</title>
    <!-- CSS style tag for html body-->
    <link rel="stylesheet" href="customer_style.css">
    <link rel="icon" href="favicon.ico">
    <style media="screen">
    </style>
    <style>
 
    body {
      margin: 0;
      background-color: #ebebeb;
    }

    h1 {
      margin-top: 0;
      color: #71c9ce;
    }
    h3 {
      color: #71c9ce;
    }
    a {
      color: #71c9ce;
      text-decoration: none;
    }

    .head_container {
        display: inline-block;
        height: 380px;
        background: #e8a87c;
        border-bottom: #FFD100 4px solid;
        width:2000px;
    }
    .topbar {
      color: #501B1D;
      display: inline-block;
      position: relative;
      
     
      left:200px;
      margin-right: 20px;
      font-style:normal;
      font-weight: 300;
      font-size: 150%;
      bottom: auto;
   }

    .rushrhees{
	display: inline-block;
	text-align: right;
	display: inline;
	border-radius: 4px;
	height: auto;
	position: relative;
	left: 100px;
	top: 25px;
	width: 25%;
	}
	.Welcome {
	  
	  display: inline-block;
	  color:black;
	  position: absolute;
	  font-size: 40pt;
	  padding-left:200px;
          padding-top:100px;
	  font-weight: bold;
	  
	}



    .Headline {
  	font-size: 250%;
  	font-style: italic;
  	font-weight: bold;
  	position: relative;
  	left: 120px;
  	bottom: 20px;
	}

    hr {
     border-style: none;
      border-top-style: dotted;
      border-top-color: grey;
      border-top-width: 5px;
      height: 2px;
      width: 5%;
    }
    .ROC {
      color:#c38de9;
      position: relative;
      bottom: 250px;
      left: 280px;
      font-size: 500%;
      font-weight: bold;
    }
    .Intro {
      color:#501B1D;
      position: relative;
      bottom: 250px;
      left: 280px;
      font-size: 300%;
      font-style: italic;
    }

    .header_Index {
     padding: 300px;
     background-image: url("background_one.jpg");
     background-repeat: no-repeat;
     background-position: left top;
     background-attachment:fixed;
     background-size: cover;
     margin: 0;
     opacity: 0.9;
    }
    
    img {
      width: 50%;
      height: 400px;

    }/* tag selectors*/

    .hotel_picture{
      height: 400px;
      display: inline-block;
    } /* class selector*/
    #heading{
      color: red;
    }  /* id selector*/


{
        margin: 0px;
        padding:0px;
}

.header{
        width: 30%;
        margin: 10px auto 0px;
        color: white;
        background: #5F9EA0;
        text-align: center;
        border: 1px solid #B0C4DE;
        border-bottom: none;
        border-radius: 10px 10px 0px 0px;
        padding: 20px;
}


.header_customer{
        width: 30%;
        margin: 10px auto 0px;
        color: white;
        background: #e9a87c;
        text-align: center;
        border: 1px solid #B0C4DE;
        border-bottom: none;
        border-radius: 10px 10px 0px 0px;
        padding: 20px;
}

    .head_container a{
      text-align: left;
    }

    .head_container a:hover {
      background: #ddd;
    }

    body{
  

    	background-repeat: auto;
      	background-size: cover;

      	background-position: center;
    }


    .header{
    	width: 30%;
    	margin: 50px auto 0px;
    	color: white;
    	background: #5F9EA0;
    	text-align: center;
    	border: 1px solid #B0C4DE;
    	border-bottom: none;
    	border-radius: 10px 10px 0px 0px;
    	padding: 20px;
    }
    form, .content {
    	width: 50%;
    	margin: 0px auto;

    	border: 1px solid #B0C4DE;
    	background: white;
    	border-radius: 0px 0px 10px 10px;
        height: 200px;
    }
    .input-group {
    	margin: 10px 0px 10px 0px;
    }

    .input-group label {
      color: #663300;
    	display: block;
    	text-align: left;
    	margin: 3px;
    }
    .input-group input{
    	height: 30px;
    	width: 93%;
    	padding: 5px 10px;
    	font-size: 16px;
    	border-radius: 5px;
    	border: 1px solid gray;
    }

    .input-group select{
    	height: 40px;
    	width: 98.5%;
    	padding: 5px 10px;
    	font-size: 16px;
    	border-radius: 5px;
    	border: 1px solid gray;
    }

    .btn {
	margin-left:625px;
    	position: absolute;
    	font-size: 15px;
    	color: white;
    	background: #5F9EA0;
    	border: none;
    	border-radius: 5px;
    }
	p{
	margin-left:100px;
	}
    input[type=text] {
      text-align: left;
      width: 70%;
      padding-left: 12px;
      margin-left: 100px;
      margin-bottom: 20px;
      
    }
    /* Style the submit button */
    input[type=submit] {
      background-color: #e8a87c;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
           
    }

    table {

      font-family: Georgia;
      font-size: 20px;
      background-color: #ffffcc;
      LINE-HEIGHT:50px;
    }

    .b_detail h1 {
      text-align:center;
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
    </div> <!--Creates a button-->
  </body>
  <div class="b_detail" id="billing">
  <h1 style="color: black;" >Billing Details</h1>
  <table>
   <?php
    include('db_connect.php');
    $UserID = $_SESSION['username'];
    $sql = "Select * from Bill where Customer_ID = '$UserID'";
    $result = $conn->query($sql);
       if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
              echo "<tr><td>Customer ID</td><td>".$row["Customer_ID"]."</td>";
              echo "<tr><td>Room Charge</td><td>".$row["Room_charge"]."</td>";
              echo "<tr><td>Service Charge</td><td>".$row["Service_charge"]."</td>";
              echo "<tr><td>Balance</td><td>".$row["Balance"]."</td>";
              echo "<tr><td>Payment Date</td><td>".$row["Payment_date"]."</td>";
              echo "<tr><td>Card No</td><td>".$row["Card_no"]."</td>";
            }
        }
  ?>
  </table>
  <form method="post" action="bill_page.php">



  <label class="input-group" style="color: #663300; margin-left: 120px; text-align: center;">Card number</label><br>
  <input type="text" name="card_no"><br>
  <input type="submit" name="pay" class="btn" value="Make payment">
  <?php

  if (!empty($_POST['pay'])){

                $Cardnumber = $_POST['card_no'];
                if(empty($Cardnumber)){
                  echo "<p>
                  Card number is required!
                  </p>";
                }
                if(!empty($Cardnumber)){
                          $date = date('Y-m-d');

                         $sql = "UPDATE Bill SET Card_no = '$Cardnumber', Service_charge = '0', Room_charge = '0', Balance = '0', Payment_date = '$date' WHERE Customer_ID='$UserID'";
                         $result = $conn->query($sql);
                         $select = "SELECT * FROM Bill WHERE Customer_ID='$UserID'";
                         $test1 = $conn->query($select);
                         $row = $test1->fetch_assoc();

                         if ($result) {
                                 echo "<p>
                                 Thank you for your payment! Your current balance is ".$row['Balance']." $.
                                 </p>";
                        } else {
                         echo "Payment Failed";
                        }

                }

        }
   ?>
</form>
</div>

</html>
