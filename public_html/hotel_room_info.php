<?php
session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Information</title>
    <!-- CSS style tag for html body-->
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico">
    <style media="screen">
    </style>
    <style>
    .head_container {
      /* margin= 0; */
      overflow: hidden;
      position: fixed;
      left: 0;
      top: 0;
      /* display: block; */
    }

    .head_container a:hover {
    background: #ddd;
    }

    .hotel {
      margin-left: 0;
    }

    .hotel h1{
      margin-top: 384px;
      color:#663300;
      font-size:24px;
      font-family:Georgia;
      font-style:italic;
    }

    .hotel h2{
      margin-left: 50px;
      color:#663300;
      font-size:18px;
      font-family:Georgia;

    }

    .hotel p{
      text-align:justify;
      padding: 0px 100px;
      font-family:papyrus;
      font-size: 20px;

    }

    .hotel img{
      width:500px;
      height:400px;
      float: left;
      margin-left: 50px;
      margin-right: 50px;
      margin-bottom: 5px;
      margin-top = 0;
    }

    .room {
      margin-left: 0;
    }

    .room h2{
      margin-left: 50px;
      color:#663300;
      font-size:18px;
      font-family:Georgia;

    }

    .room p{
      text-align:justify;
      padding: 0px 100px;
      font-family:papyrus;
      font-size: 20px;

    }

    .room img{
      width:500px;
      height:300px;
      float: left;
      margin-left: 50px;
      margin-right: 50px;
      margin-bottom: 5px;
      margin-top = 0;
    }

    .clear{
      clear:left;
    }

    .navbar {
      width: 100%;
      overflow: hidden;
      position: fixed;
      left: 0;
      top: 384px;
      background: #FFD100;
      height: 25px;

    }

    .navbar a {
      text-align: center;
      padding: 25px 300px;
    }

    .navbar a:hover {
    background: #ddd;
  }

    footer {
      display: inline-block;
      height: 100px;
      width: 100%;
      background-color: #ffcc99;
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
    <div class="navbar" id = "Hotel/room bar">
      <a href="#Information1" style="color:#663300; font-size:24px; font-family:Georgia; font-style:italic">Browse our best hotels</a>
      <a href="#Information2" style="color:#663300; font-size:24px; font-family:Georgia; font-style:italic">Browse our best rooms</a>
    </div>
    <div class = "hotel" id = "Information1">
      <h1 style="">Browse our best hotels</h1>
      <h2 style="">Rochester Hotel</h2>
      <img class="hotel img" src="hotel1.jpg" alt="hotel1 piciture">
      <p>The Rochester Hotel is the right choice for visitors who are searching for a combination of charm, peace and quiet, and a convenient position. Our staff offer an attentive, personalized service and are always available to offer any help to guests.</p>
      <p>Your other great choices here:</p>
      <p>
       <?php
        include('db_connect.php');
        $sql = "Select * from Hotel Where Hotel_name Like '%Hotel%' And Hotel_name <> 'Rochester Hotel'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
         	while($row = $result->fetch_assoc()){
                 echo $row["Hotel_name"];
		echo "<br>";
     	}
    }
      ?></p>
      <p class="clear"></p>
    </div>
    <div class = "hotel" id = = "Hotel Information">
      <h2 style="color:#663300; font-size:18px; font-family:Georgia;">Erat Inn</h2>
      <img class="hotel img" src="hotel2.jpg" alt="hotel1 piciture" style="width:500px; float: left;float: left; margin-right: 50px; margin-bottom: 5px;">
      <p>The Erat Inn is one of the most convenient inn able to satisfy the different needs of its guests with comfort and first rate services. It is only 2 km from the airport and from highway exits. The hotel has a large parking area , a real luxury in a city like Nice.</p>
      <p>Your other great choices here:</p>
      <p>
       <?php
        include('db_connect.php');
        $sql = "Select * from Hotel Where Hotel_name Like '%Inn%' And Hotel_name <> 'Erat Inn'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
         	while($row = $result->fetch_assoc()){
                 echo $row["Hotel_name"]; echo "<br>";
     	}
    }
      ?></p>
      <p class="clear"></p>
    </div>
    <div class = "hotel" id = = "Hotel Information">
      <h2 style="color:#663300; font-size:18px; font-family:Georgia;">Hilltop Heaven Resort</h2>
      <img class="hotel img" src="hotel4.jpg" alt="hotel1 piciture" style="width:500px; float: left;float: left; margin-right: 50px; margin-bottom: 5px;">
      <p>Among the finest five star hotels in the U.S., the Hilltop Heaven Resort is set in beautifully landscaped tropical gardens, on a superb beach side location in the exclusive Amathus area and 11Km from Limassol town centre.</p>
      <p>Your other great choices here:</p>
      <p>
       <?php
        include('db_connect.php');
        $sql = "Select * from Hotel Where Hotel_name Like '%Resort%' And Hotel_name <> 'Hilltop Heaven Resort'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
         	while($row = $result->fetch_assoc()){
                 echo $row["Hotel_name"]; echo  "<br>";
         	}
        }
      ?></p>
      <p class="clear"></p>
    </div>

    <div class = "room" id = "Information2">
      <h2 style="color:#663300; font-size:18px; font-family:Georgia;">Single Room</h2>
      <img class="room img" src="room1.jpg" alt="room1 piciture" style="width:500px; float: left;float: left; margin-right: 50px; margin-bottom: 5px;">

      <p><span>&#10003;</span>&nbsp En-suite bathroom &nbsp&nbsp<span>&#10003;</span>&nbsp Wireless Internet &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Bar Fridge &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Air conditioned &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Television &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Hairdryer &nbsp&nbsp</p><br>
      <p> Price: $100</p>
      <p class="clear"></p>
    </div>

    <div class = "room" id = = "Room Information">
      <h2 style="color:#663300; font-size:18px; font-family:Georgia;">Double Room</h2>
      <img class="room img" src="room3.jpg" alt="room2 piciture" style="width:500px; float: left;float: left; margin-right: 50px; margin-bottom: 5px;">

      <p><span>&#10003;</span>&nbsp En-suite bathroom &nbsp&nbsp<span>&#10003;</span>&nbsp Wireless Internet &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Bar Fridge &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Air conditioned &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Television &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Hairdryer &nbsp&nbsp</p><br>
      <p> Price: $150</p>
      <p class="clear"></p>
    </div>

    <div class = "room" id = = "Room Information">
      <h2 style="color:#663300; font-size:18px; font-family:Georgia;">Queen Room</h2>
      <img class="room img" src="room2.jpg" alt="room2 piciture" style="width:500px; float: left;float: left; margin-right: 50px; margin-bottom: 5px;">

      <p><span>&#10003;</span>&nbsp En-suite bathroom &nbsp&nbsp<span>&#10003;</span>&nbsp Wireless Internet &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Bar Fridge &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Air conditioned &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Television &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Hairdryer &nbsp&nbsp</p><br>
      <p> Price: $130</p>
      <p class="clear"></p>
    </div>

    <div class = "room" id = = "Room Information">
      <h2 style="color:#663300; font-size:18px; font-family:Georgia;">King Room</h2>
      <img class="room img" src="room4.jpg" alt="room2 piciture" style="width:500px; float: left;float: left; margin-right: 50px; margin-bottom: 5px;">

      <p><span>&#10003;</span>&nbsp En-suite bathroom &nbsp&nbsp<span>&#10003;</span>&nbsp Wireless Internet &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Bar Fridge &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Air conditioned &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Television &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Hairdryer &nbsp&nbsp</p><br>
      <p> Price: $150</p>
      <p class="clear"></p>
    </div>

    <div class = "room" id = = "Room Information">
      <h2 style="color:#663300; font-size:18px; font-family:Georgia;">Suite</h2>
      <img class="room img" src="room5.jpg" alt="room2 piciture" style="width:500px; float: left;float: left; margin-right: 50px; margin-bottom: 5px;">

      <p><span>&#10003;</span>&nbsp En-suite bathroom &nbsp&nbsp<span>&#10003;</span>&nbsp Wireless Internet &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Bar Fridge &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Air conditioned &nbsp&nbsp</p><br>
      <p><span>&#10003;</span>&nbsp Television &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<span>&#10003;</span>&nbsp Hairdryer &nbsp&nbsp</p><br>
      <p> Price: $200</p>
      <p class="clear"></p>
    </div>

    <footer>
      <p>Rochester Hotel Group</p>
      <p>Contact information: <a href="mailto:zpan12@ur.rochester.edu">
      zpan12@ur.rochester.edu</a>.</p>
    </footer>
  </html>
