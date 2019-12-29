LOAD DATA LOCAL INFILE 'Hotel.csv'
INTO TABLE Hotel
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
Ignore 1 Rows;

LOAD DATA LOCAL INFILE 'Room.csv'
INTO TABLE Room
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
Ignore 1 Rows;

LOAD DATA LOCAL INFILE 'Customer.csv'
INTO TABLE Customer
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
Ignore 1 Rows;

LOAD DATA LOCAL INFILE 'Reservation.csv'
INTO TABLE Reservation
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
Ignore 1 Rows
(Reserve_no,Customer_ID,Hotel_ID,Room_ID,@Check_in_date,@Check_out_date)
SET Check_in_date = STR_TO_DATE(@Check_in_date, '%m/%d/%Y'), Check_out_date = STR_TO_DATE(@Check_out_date, '%m/%d/%Y');

LOAD DATA LOCAL INFILE 'Service.csv'
INTO TABLE Service
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
Ignore 1 Rows;

LOAD DATA LOCAL INFILE 'Request.csv'
INTO TABLE Request
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
Ignore 1 Rows
(Request_ID,@Request_date,Customer_ID,Service_ID)
SET Request_date = STR_TO_DATE(@Request_date, '%m/%d/%Y');


LOAD DATA LOCAL INFILE 'Bill.csv'
INTO TABLE Bill
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
Ignore 1 Rows
(Customer_ID,Room_charge,Service_charge,Balance,@Payment_date,Card_no)
SET Payment_date = STR_TO_DATE(@Payment_date, '%m/%d/%Y');
