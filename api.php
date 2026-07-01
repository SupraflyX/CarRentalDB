<?php
header('Content-Type: application/json');
require_once 'db_connection.php';

$action = $_GET['action'] ?? $_POST['action'] ?? '';

function respond($success, $message, $data = null) {
    $response = ['success' => $success, 'message' => $message];
    if ($data !== null) {
        $response['data'] = $data;
    }
    echo json_encode($response);
    exit;
}

function post($key) {
    if (isset($_POST[$key])) return $_POST[$key];
    $alt = str_contains($key, '_') ? implode('_', array_map('ucfirst', explode('_', $key))) : lcfirst($key);
    if (isset($_POST[$alt])) return $_POST[$alt];
    $lower = strtolower($key);
    foreach ($_POST as $k => $v) {
        if (strtolower($k) === $lower) return $v;
    }
    return '';
}

try {
    switch ($action) {

        case 'get_stats':
            $stats = [];

            $result = $conn->query("SELECT COUNT(*) AS total_customers FROM Customers");
            $stats['total_customers'] = (int)$result->fetch_assoc()['total_customers'];

            $result = $conn->query("SELECT COUNT(*) AS total_cars FROM Cars");
            $stats['total_cars'] = (int)$result->fetch_assoc()['total_cars'];

            $result = $conn->query("SELECT COUNT(*) AS available_cars FROM Cars WHERE Available = 1");
            $stats['available_cars'] = (int)$result->fetch_assoc()['available_cars'];

            $result = $conn->query("SELECT COUNT(*) AS active_rentals FROM Reservations WHERE Status = 'Active'");
            $stats['active_rentals'] = (int)$result->fetch_assoc()['active_rentals'];

            $result = $conn->query("SELECT COALESCE(SUM(Amount), 0) AS total_revenue FROM Payments");
            $stats['total_revenue'] = (float)$result->fetch_assoc()['total_revenue'];

            $result = $conn->query("SELECT r.Reservation_ID, c.Name AS Customer_Name, CONCAT(ca.Brand, ' ', ca.Model) AS Car_Name, r.Status, r.Total_Cost, r.Start_Date, r.End_Date FROM Reservations r JOIN Customers c ON r.Customer_ID = c.Customer_ID JOIN Cars ca ON r.Car_ID = ca.Car_ID ORDER BY r.Reservation_ID DESC LIMIT 5");
            $recent = [];
            while ($row = $result->fetch_assoc()) {
                $recent[] = $row;
            }
            $stats['recent_reservations'] = $recent;

            respond(true, 'Stats retrieved successfully', $stats);
            break;

        case 'get_customers':
            $result = $conn->query("SELECT * FROM Customers ORDER BY Customer_ID DESC");
            $customers = [];
            while ($row = $result->fetch_assoc()) {
                $customers[] = $row;
            }
            respond(true, 'Customers retrieved successfully', $customers);
            break;

        case 'get_cars':
            $result = $conn->query("SELECT * FROM Cars ORDER BY Car_ID DESC");
            $cars = [];
            while ($row = $result->fetch_assoc()) {
                $cars[] = $row;
            }
            respond(true, 'Cars retrieved successfully', $cars);
            break;

        case 'get_reservations':
            $result = $conn->query("SELECT r.*, c.Name AS Customer_Name, CONCAT(ca.Brand, ' ', ca.Model) AS Car_Name FROM Reservations r JOIN Customers c ON r.Customer_ID = c.Customer_ID JOIN Cars ca ON r.Car_ID = ca.Car_ID ORDER BY Reservation_ID DESC");
            $reservations = [];
            while ($row = $result->fetch_assoc()) {
                $reservations[] = $row;
            }
            respond(true, 'Reservations retrieved successfully', $reservations);
            break;

        case 'get_payments':
            $result = $conn->query("SELECT p.*, c.Name AS Customer_Name FROM Payments p JOIN Customers c ON p.Customer_ID = c.Customer_ID ORDER BY Payment_ID DESC");
            $payments = [];
            while ($row = $result->fetch_assoc()) {
                $payments[] = $row;
            }
            respond(true, 'Payments retrieved successfully', $payments);
            break;

        case 'get_available_cars':
            $result = $conn->query("SELECT * FROM Cars WHERE Available = 1 ORDER BY Brand, Model");
            $cars = [];
            while ($row = $result->fetch_assoc()) {
                $cars[] = $row;
            }
            respond(true, 'Available cars retrieved successfully', $cars);
            break;

        case 'get_customer':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if ($id <= 0) {
                respond(false, 'Please provide a valid customer ID');
            }
            $stmt = $conn->prepare("SELECT * FROM Customers WHERE Customer_ID = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $customer = $result->fetch_assoc();
            $stmt->close();
            if (!$customer) {
                respond(false, 'Customer not found');
            }
            respond(true, 'Customer retrieved successfully', $customer);
            break;

        case 'get_customer_reservations':
            $customer_id = isset($_GET['customer_id']) ? (int)$_GET['customer_id'] : 0;
            if ($customer_id <= 0) {
                respond(false, 'Please provide a valid customer ID');
            }
            $stmt = $conn->prepare("SELECT r.*, CONCAT(ca.Brand, ' ', ca.Model) AS Car_Name FROM Reservations r JOIN Cars ca ON r.Car_ID = ca.Car_ID WHERE r.Customer_ID = ? ORDER BY r.Reservation_ID DESC");
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $reservations = [];
            while ($row = $result->fetch_assoc()) {
                $reservations[] = $row;
            }
            $stmt->close();
            respond(true, 'Customer reservations retrieved successfully', $reservations);
            break;

        case 'add_customer':
            $name = post('Name');
            $email = post('Email');
            $phone = post('Phone');
            $license = post('Drivers_License');
            $address = post('Address');

            if (empty($name) || empty($email) || empty($phone) || empty($license) || empty($address)) {
                respond(false, 'All fields are required');
            }

            $stmt = $conn->prepare("INSERT INTO Customers (Name, Email, Phone, Drivers_License, Address) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $name, $email, $phone, $license, $address);
            $stmt->execute();
            $new_id = $stmt->insert_id;
            $stmt->close();

            respond(true, 'Customer registered successfully', ['id' => $new_id]);
            break;

        case 'add_car':
            $brand = post('Brand');
            $model = post('Model');
            $year = (int)post('Year');
            $color = post('Color');
            $plate = post('License_Plate');
            $price = (float)post('Rental_Price');

            if (empty($brand) || empty($model) || $year <= 0 || empty($color) || empty($plate) || $price <= 0) {
                respond(false, 'All fields are required and must be valid');
            }

            $stmt = $conn->prepare("INSERT INTO Cars (Brand, Model, Year, Color, License_Plate, Rental_Price) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssissd", $brand, $model, $year, $color, $plate, $price);
            $stmt->execute();
            $new_id = $stmt->insert_id;
            $stmt->close();

            respond(true, 'Car added successfully', ['id' => $new_id]);
            break;

        case 'rent_car':
            $customer_id = (int)post('customer_id');
            $car_id = (int)post('car_id');
            $start_date = post('start_date');
            $end_date = post('end_date');
            $payment_method = post('payment_method') ?: 'Cash';

            if ($customer_id <= 0 || $car_id <= 0 || empty($start_date) || empty($end_date)) {
                respond(false, 'Customer ID, Car ID, start date, and end date are required');
            }

            $stmt = $conn->prepare("SELECT Car_ID, Rental_Price, Available FROM Cars WHERE Car_ID = ?");
            $stmt->bind_param("i", $car_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $car = $result->fetch_assoc();
            $stmt->close();

            if (!$car) {
                respond(false, 'Car not found');
            }

            if ((int)$car['Available'] !== 1) {
                respond(false, 'This car is not currently available for rental');
            }

            $start = new DateTime($start_date);
            $end = new DateTime($end_date);
            $diff = $start->diff($end);
            $days = max(1, $diff->days);
            $total_cost = round($days * (float)$car['Rental_Price'], 2);

            $stmt = $conn->prepare("INSERT INTO Payments (Customer_ID, Amount, Payment_Method) VALUES (?, ?, ?)");
            $stmt->bind_param("ids", $customer_id, $total_cost, $payment_method);
            $stmt->execute();
            $payment_id = $stmt->insert_id;
            $stmt->close();

            $stmt = $conn->prepare("INSERT INTO Reservations (Customer_ID, Car_ID, Start_Date, End_Date, Total_Cost, Payment_ID, Status) VALUES (?, ?, ?, ?, ?, ?, 'Active')");
            $stmt->bind_param("iissdi", $customer_id, $car_id, $start_date, $end_date, $total_cost, $payment_id);
            $stmt->execute();
            $reservation_id = $stmt->insert_id;
            $stmt->close();

            $stmt = $conn->prepare("UPDATE Cars SET Available = 0 WHERE Car_ID = ?");
            $stmt->bind_param("i", $car_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Car rented successfully', [
                'reservation_id' => $reservation_id,
                'total_cost' => $total_cost,
                'days' => $days
            ]);
            break;

        case 'return_car':
            $reservation_id = (int)post('reservation_id');

            if ($reservation_id <= 0) {
                respond(false, 'Please provide a valid reservation ID');
            }

            $stmt = $conn->prepare("SELECT Reservation_ID, Car_ID FROM Reservations WHERE Reservation_ID = ? AND Status = 'Active'");
            $stmt->bind_param("i", $reservation_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $reservation = $result->fetch_assoc();
            $stmt->close();

            if (!$reservation) {
                respond(false, 'Active reservation not found');
            }

            $car_id = (int)$reservation['Car_ID'];

            $stmt = $conn->prepare("UPDATE Reservations SET Status = 'Completed' WHERE Reservation_ID = ?");
            $stmt->bind_param("i", $reservation_id);
            $stmt->execute();
            $stmt->close();

            $stmt = $conn->prepare("UPDATE Cars SET Available = 1 WHERE Car_ID = ?");
            $stmt->bind_param("i", $car_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Car returned successfully');
            break;

        case 'update_customer':
            $customer_id = (int)post('customer_id');
            $name = post('Name');
            $email = post('Email');
            $phone = post('Phone');
            $license = post('Drivers_License');
            $address = post('Address');

            if ($customer_id <= 0 || empty($name) || empty($email) || empty($phone) || empty($license) || empty($address)) {
                respond(false, 'All fields are required');
            }

            $stmt = $conn->prepare("UPDATE Customers SET Name = ?, Email = ?, Phone = ?, Drivers_License = ?, Address = ? WHERE Customer_ID = ?");
            $stmt->bind_param("sssssi", $name, $email, $phone, $license, $address, $customer_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Customer updated successfully');
            break;

        case 'update_car':
            $car_id = (int)post('car_id');
            $brand = post('Brand');
            $model = post('Model');
            $year = (int)post('Year');
            $color = post('Color');
            $plate = post('License_Plate');
            $price = (float)post('Rental_Price');
            $available = post('Available') !== '' ? (int)post('Available') : 1;

            if ($car_id <= 0 || empty($brand) || empty($model) || $year <= 0 || empty($color) || empty($plate) || $price <= 0) {
                respond(false, 'All fields are required and must be valid');
            }

            $stmt = $conn->prepare("UPDATE Cars SET Brand = ?, Model = ?, Year = ?, Color = ?, License_Plate = ?, Rental_Price = ?, Available = ? WHERE Car_ID = ?");
            $stmt->bind_param("ssissdii", $brand, $model, $year, $color, $plate, $price, $available, $car_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Car updated successfully');
            break;

        case 'delete_customer':
            $customer_id = (int)post('customer_id');

            if ($customer_id <= 0) {
                respond(false, 'Please provide a valid customer ID');
            }

            $stmt = $conn->prepare("SELECT COUNT(*) AS active_count FROM Reservations WHERE Customer_ID = ? AND Status = 'Active'");
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ((int)$row['active_count'] > 0) {
                respond(false, 'Cannot delete customer with active reservations');
            }

            $stmt = $conn->prepare("DELETE FROM Customers WHERE Customer_ID = ?");
            $stmt->bind_param("i", $customer_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Customer deleted successfully');
            break;

        case 'delete_car':
            $car_id = (int)post('car_id');

            if ($car_id <= 0) {
                respond(false, 'Please provide a valid car ID');
            }

            $stmt = $conn->prepare("SELECT COUNT(*) AS active_count FROM Reservations WHERE Car_ID = ? AND Status = 'Active'");
            $stmt->bind_param("i", $car_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();

            if ((int)$row['active_count'] > 0) {
                respond(false, 'Cannot delete car with active reservations');
            }

            $stmt = $conn->prepare("DELETE FROM Cars WHERE Car_ID = ?");
            $stmt->bind_param("i", $car_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Car deleted successfully');
            break;

        case 'delete_reservation':
            $reservation_id = (int)post('reservation_id');

            if ($reservation_id <= 0) {
                respond(false, 'Please provide a valid reservation ID');
            }

            $stmt = $conn->prepare("SELECT Reservation_ID, Car_ID, Status FROM Reservations WHERE Reservation_ID = ?");
            $stmt->bind_param("i", $reservation_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $reservation = $result->fetch_assoc();
            $stmt->close();

            if (!$reservation) {
                respond(false, 'Reservation not found');
            }

            if ($reservation['Status'] === 'Active') {
                $stmt = $conn->prepare("UPDATE Cars SET Available = 1 WHERE Car_ID = ?");
                $stmt->bind_param("i", (int)$reservation['Car_ID']);
                $stmt->execute();
                $stmt->close();
            }

            $stmt = $conn->prepare("DELETE FROM Reservations WHERE Reservation_ID = ?");
            $stmt->bind_param("i", $reservation_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Reservation deleted successfully');
            break;

        case 'delete_payment':
            $payment_id = (int)post('payment_id');

            if ($payment_id <= 0) {
                respond(false, 'Please provide a valid payment ID');
            }

            $stmt = $conn->prepare("DELETE FROM Payments WHERE Payment_ID = ?");
            $stmt->bind_param("i", $payment_id);
            $stmt->execute();
            $stmt->close();

            respond(true, 'Payment deleted successfully');
            break;

        default:
            respond(false, 'Invalid or missing action parameter');
            break;
    }
} catch (mysqli_sql_exception $e) {
    $message = $e->getMessage();

    if (strpos($message, 'Duplicate entry') !== false) {
        if (strpos($message, 'Email') !== false) {
            respond(false, 'This email address is already registered');
        } elseif (strpos($message, 'Drivers_License') !== false) {
            respond(false, 'This driver\'s license number is already registered');
        } elseif (strpos($message, 'License_Plate') !== false) {
            respond(false, 'This license plate is already registered');
        } else {
            respond(false, 'A record with this information already exists');
        }
    }

    if (strpos($message, 'a]foreign key constraint fails') !== false) {
        respond(false, 'Cannot complete this action because related records exist');
    }

    respond(false, 'A database error occurred. Please try again later.');
} catch (Exception $e) {
    respond(false, 'An unexpected error occurred. Please try again later.');
}

$conn->close();
