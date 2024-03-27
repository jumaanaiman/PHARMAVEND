DROP DATABASE IF EXISTS `Vending_Data`;
CREATE DATABASE `Vending_Data`;
USE `Vending_Data`;

CREATE TABLE user (
  user_id INT NOT NULL,
  username VARCHAR(50),
  email VARCHAR(100),
  password INT,
  first_name VARCHAR(50),
  last_name VARCHAR(50),
  location text,
  number int,
  PRIMARY KEY (user_id)
);


CREATE TABLE vending_machines (
  machine_id INT NOT NULL,
 name VARCHAR(100),
 status ENUM('Active','Inactive'),
  location text,
  
  PRIMARY KEY (machine_id)
);

CREATE TABLE Product (
  ProductID INT PRIMARY KEY,
  Name VARCHAR(100) ,
  Description TEXT,
  Price DECIMAL(10, 2) NOT NULL,
  Quantity INT NOT NULL
);

CREATE TABLE Transaction (
  TransactionID INT PRIMARY KEY,
  UserID INT,
  MachineID INT,
  ProductID INT,
  TIMESTAMP TIMESTAMP,
  TotalAmount DECIMAL(10, 2) ,
  PaymentMethod VARCHAR(50) ,
  Status ENUM('Pending', 'Completed', 'Cancelled') ,
    FOREIGN KEY (UserID) REFERENCES user(user_id),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID),
    FOREIGN KEY (MachineID) REFERENCES vending_machines(machine_id)
);

CREATE TABLE Cart (
    CartID INT PRIMARY KEY,
    TotalAmount DECIMAL(10, 2),
    UserID INT,
     ProductID INT,
    FOREIGN KEY (UserID) REFERENCES User(user_id),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
    
);

CREATE TABLE Orders (
    OrderID INT PRIMARY KEY,
    UserID INT,
    NameOnCard VARCHAR(50),
    CardNumber INT,
    Cvv INT,
    TIMESTAMP timestamp,
    FOREIGN KEY (UserID) REFERENCES User(user_id)
    
);

CREATE TABLE OrderDetails (
    OrderDetailsID INT PRIMARY KEY,
    OrderID INT,
    ProductID INT,
    Quantity INT,
    TotalAmount DECIMAL(10, 2),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (ProductID) REFERENCES Product(ProductID)
);
CREATE TABLE Feedback (
    FeedbackID INT PRIMARY KEY,
    UserID INT,
    TransactionID INT,
    Rating INT,
    Comment TEXT,
    FOREIGN KEY (UserID) REFERENCES user(user_id),
    FOREIGN KEY (TransactionID) REFERENCES Transaction(TransactionID)
);


