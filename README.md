# AutoRent - Car Rental Database System

A comprehensive, two-view car rental database application built with PHP, MySQL, HTML, and Vanilla CSS. The system provides a clean, modern Customer Portal for users to browse and rent vehicles, alongside a powerful, data-centric Admin Panel for full database management.

## Features

### Customer Portal (index.php)
- **Modern Light Theme**: A clean, responsive interface designed for excellent user experience.
- **Browse Fleet**: View available cars with real-time pricing and status.
- **Booking Engine**: Rent vehicles with dynamic cost calculation based on dates and daily rates.
- **Reservation Management**: Look up active bookings using a Customer ID and process returns.
- **User Registration**: Simple account creation form.

### Admin Panel (admin.php)
- **Database Management Interface**: A professional, dark-themed dashboard designed for data visibility.
- **Full CRUD Operations**: Create, Read, Update, and Delete capabilities across all entities.
- **Dashboard Analytics**: View total customers, fleet size, active rentals, and total revenue.
- **Table Views**: Monospace font data tables for Customers, Cars, Reservations, and Payments.
- **Real-time Validation**: Form validation and toast notifications for operations.

## Architecture

The project follows a clean, decoupled 5-file architecture:

- **index.php**: The frontend Customer Portal UI.
- **admin.php**: The frontend Admin Panel UI.
- **api.php**: A central JSON API controller that handles all database operations and business logic via POST/GET requests.
- **db_connection.php**: Secure MySQL connection handler using utf8mb4 encoding and strict error reporting.
- **setup.sql**: The complete database schema and seed data.

## Security

- **Prepared Statements**: All database queries utilize parameterized prepared statements to prevent SQL Injection.
- **Foreign Key Constraints**: Strict relational integrity prevents deletion of entities that have active dependencies (e.g., cannot delete a car currently on rent).
- **Data Normalization**: Centralized API ensures uniform data handling and format validation.

## Setup Instructions

1. **Environment Requirement**: A local server environment such as XAMPP (Apache + MySQL) is required.
2. **Database Initialization**: 
   - Open phpMyAdmin.
   - Import the `setup.sql` file to create the `Car_rental` database and populate it with initial seed data (cars, customers, and active reservations).
3. **Run the Application**:
   - Access the Customer Portal at: `http://localhost/car_rental/`
   - Access the Admin Panel at: `http://localhost/car_rental/admin.php`

## License
This project is for educational and portfolio demonstration purposes.
