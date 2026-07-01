CREATE DATABASE IF NOT EXISTS `Car_rental`;
USE `Car_rental`;

DROP TABLE IF EXISTS `Reservations`;
DROP TABLE IF EXISTS `Payments`;
DROP TABLE IF EXISTS `Cars`;
DROP TABLE IF EXISTS `Customers`;

CREATE TABLE `Customers` (
    `Customer_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(100) NOT NULL,
    `Email` VARCHAR(100) UNIQUE NOT NULL,
    `Phone` VARCHAR(20) NOT NULL,
    `Drivers_License` VARCHAR(50) UNIQUE NOT NULL,
    `Address` VARCHAR(255) NOT NULL,
    `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Cars` (
    `Car_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `Brand` VARCHAR(50) NOT NULL,
    `Model` VARCHAR(50) NOT NULL,
    `Year` INT NOT NULL,
    `Color` VARCHAR(30) NOT NULL,
    `License_Plate` VARCHAR(20) UNIQUE NOT NULL,
    `Rental_Price` DECIMAL(10,2) NOT NULL,
    `Available` TINYINT(1) DEFAULT 1,
    `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Payments` (
    `Payment_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `Customer_ID` INT NOT NULL,
    `Amount` DECIMAL(10,2) NOT NULL,
    `Payment_Method` VARCHAR(50) DEFAULT 'Cash',
    `Payment_Date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`Customer_ID`) REFERENCES `Customers`(`Customer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `Reservations` (
    `Reservation_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `Customer_ID` INT NOT NULL,
    `Car_ID` INT NOT NULL,
    `Start_Date` DATE NOT NULL,
    `End_Date` DATE NOT NULL,
    `Total_Cost` DECIMAL(10,2) NOT NULL,
    `Payment_ID` INT,
    `Status` ENUM('Active','Completed','Cancelled') DEFAULT 'Active',
    `Created_At` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`Customer_ID`) REFERENCES `Customers`(`Customer_ID`),
    FOREIGN KEY (`Car_ID`) REFERENCES `Cars`(`Car_ID`),
    FOREIGN KEY (`Payment_ID`) REFERENCES `Payments`(`Payment_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Cars` (`Brand`, `Model`, `Year`, `Color`, `License_Plate`, `Rental_Price`, `Available`) VALUES
('Toyota', 'Camry', 2023, 'Silver', 'ABC-1234', 45.00, 1),
('BMW', '3 Series', 2024, 'Black', 'BMW-5678', 89.00, 0),
('Honda', 'Civic', 2022, 'Blue', 'HND-9012', 38.00, 1),
('Mercedes', 'C-Class', 2024, 'White', 'MBZ-3456', 95.00, 0),
('Ford', 'Mustang', 2023, 'Red', 'FRD-7890', 75.00, 1),
('Audi', 'A4', 2023, 'Gray', 'AUD-2345', 82.00, 1),
('Tesla', 'Model 3', 2024, 'White', 'TSL-6789', 110.00, 1),
('Hyundai', 'Sonata', 2022, 'Black', 'HYN-0123', 35.00, 1);

INSERT INTO `Customers` (`Name`, `Email`, `Phone`, `Drivers_License`, `Address`) VALUES
('James Rodriguez', 'james.rodriguez@gmail.com', '(555) 234-5678', 'DL-2023-48291', '142 Oak Street, Austin, TX 78701'),
('Sarah Mitchell', 'sarah.mitchell@gmail.com', '(555) 345-6789', 'DL-2022-73654', '87 Maple Avenue, Denver, CO 80202'),
('David Chen', 'david.chen@gmail.com', '(555) 456-7890', 'DL-2024-15937', '2305 Pine Road, Seattle, WA 98101'),
('Emily Thompson', 'emily.thompson@gmail.com', '(555) 567-8901', 'DL-2023-86420', '56 Birch Lane, Portland, OR 97201'),
('Michael Brooks', 'michael.brooks@gmail.com', '(555) 678-9012', 'DL-2024-39175', '731 Cedar Drive, Chicago, IL 60601');

INSERT INTO `Payments` (`Customer_ID`, `Amount`, `Payment_Method`, `Payment_Date`) VALUES
(1, 623.00, 'Credit Card', '2026-06-15 10:30:00'),
(2, 665.00, 'Cash', '2026-06-20 14:15:00'),
(3, 180.00, 'Credit Card', '2026-06-25 09:45:00');

INSERT INTO `Reservations` (`Customer_ID`, `Car_ID`, `Start_Date`, `End_Date`, `Total_Cost`, `Payment_ID`, `Status`) VALUES
(1, 2, '2026-06-25', '2026-07-02', 623.00, 1, 'Active'),
(2, 4, '2026-06-28', '2026-07-05', 665.00, 2, 'Active'),
(3, 1, '2026-06-10', '2026-06-14', 180.00, 3, 'Completed');
