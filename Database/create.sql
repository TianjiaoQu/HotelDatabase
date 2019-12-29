Create table Hotel
(Hotel_ID varchar(6) NOT NULL,
Hotel_name varchar(30) NOT NULL,
PRIMARY KEY (Hotel_ID)
);

Create table Room 
(Hotel_ID varchar(6) NOT NULL,
Room_ID varchar(5) NOT NULL,
Room_type varchar(15) NOT NULL,
Room_rate decimal(5,2) Default 0.00,
PRIMARY KEY (Hotel_ID, Room_ID),
FOREIGN KEY (Hotel_ID) REFERENCES Hotel(Hotel_ID)
ON DELETE CASCADE ON UPDATE CASCADE
);

Create table Customer
(Customer_ID varchar(50) NOT NULL,
Fname varchar(20) NOT NULL,
Lname varchar(20) NOT NULL,
Password varchar(50) NOT NULL,
Email varchar(100),
Phone_no varchar(15) Default '9999999999',
ID_type varchar(45) Default 'Driver License',
ID_No varchar(20) NOT NULL,
Hotel_ID varchar(6), 
Room_ID varchar(5), 
PRIMARY KEY (Customer_ID),
FOREIGN KEY (Hotel_ID, Room_ID) REFERENCES Room(Hotel_ID, Room_ID)
ON DELETE CASCADE ON UPDATE CASCADE
);

Create table Reservation
(Reserve_no int NOT NULL AUTO_INCREMENT,
Customer_ID varchar(50) NOT NULL,
Hotel_ID varchar(6) NOT NULL,
Room_ID varchar(5) NOT NULL,
Check_in_date Date,
Check_out_date Date,
PRIMARY KEY (Reserve_no),
FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Hotel_ID, Room_ID) REFERENCES Room(Hotel_ID, Room_ID)
ON DELETE CASCADE ON UPDATE CASCADE
);

Create table Service
(Service_ID varchar(2) NOT NULL,
Service_type varchar(20) NOT NULL,
Service_rate decimal(5,2) Default 0.00,
PRIMARY KEY (Service_ID)
);

Create table Request
(Request_ID int NOT NULL AUTO_INCREMENT,
Request_date date NOT NULL,
Customer_ID varchar(50) NOT NULL,
Service_ID varchar(2) NOT NULL,
PRIMARY KEY (Request_ID),
FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
ON DELETE CASCADE ON UPDATE CASCADE,
FOREIGN KEY (Service_ID) REFERENCES Service(Service_ID)      
ON DELETE CASCADE ON UPDATE CASCADE
);

Create table Bill
(Customer_ID varchar(50) NOT NULL,
Room_charge decimal(5,2) Default 0.00,
Service_charge decimal(5,2) Default 0.00,
Balance decimal(5,2) Default 0.00,
Payment_date Date,
Card_no varchar(25),
PRIMARY KEY (Customer_ID),
FOREIGN KEY (Customer_ID) REFERENCES Customer(Customer_ID)
ON DELETE CASCADE ON UPDATE CASCADE
);

