<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $conn->autocommit(FALSE); // Turn off auto-commit mode

    $data = json_decode(file_get_contents('php://input'), true);

    // Extract and sanitize inputs
    $userId = filter_var($data['userId'], FILTER_SANITIZE_NUMBER_INT);
    $paymentStatus = filter_var($data['paymentStatus'], FILTER_SANITIZE_STRING);
    $amount = filter_var($data['amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $paymentMethod = filter_var($data['paymentMethod'], FILTER_SANITIZE_STRING);
    $machineId = filter_var($data['machineId'], FILTER_SANITIZE_NUMBER_INT);
    $currentDateTime = new DateTime(); // Creates a DateTime object representing now
    $formattedDateTime = $currentDateTime->format('Y-m-d H:i:s'); // Format it to match MySQL's datetime format

    // Insert into payment table
    $stmt = $conn->prepare("INSERT INTO payment (payment_method, payment_date, amount, user_id, payment_status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $paymentMethod, $formattedDateTime, $amount, $userId, $paymentStatus);
    $stmt->execute();
    $paymentId = $stmt->insert_id;

    // Insert into orders table with status set to "waiting to be picked up"
    $status = "waiting to be picked up"; // Define the status string
    $stmt = $conn->prepare("INSERT INTO orders (machine_ID, userID, TIMESTAMP, payment_ID, total_amount, status) VALUES (?, ?, NOW(), ?, ?, ?)");
    $stmt->bind_param("iiids", $machineId, $userId, $paymentId, $amount, $status); // Replace $paymentStatus with $status
    $stmt->execute();
    $orderId = $stmt->insert_id;


    // Fetch products from product and product_vendingmachine tables
    $query = "SELECT p.productID, p.name, p.img, p.description, p.price, pv.quantity 
              FROM product_vendingmahcine pv
              JOIN product p ON pv.ProductID = p.productID
              WHERE pv.machine_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $machineId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $productId = $row['productID'];
        $quantity = $row['quantity'];
        $subtotal = $row['price'] * $quantity;

        // Get quantity from cart
        // Get quantity from cart
        $cartQuery = "SELECT quantity FROM cart WHERE productID = ? AND userID = ?";
        $cartStmt = $conn->prepare($cartQuery);
        $cartStmt->bind_param("ii", $productId, $userId);
        $cartStmt->execute();
        $cartResult = $cartStmt->get_result();
        if ($cartResult->num_rows > 0) {
            $cartRow = $cartResult->fetch_assoc();
            $cartQuantity = $cartRow['quantity'];

            // Insert into orderitems table
            $insertQuery = "INSERT INTO orderitems (orderID, productID, quantity, subtotal) VALUES (?, ?, ?, ?)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertStmt->bind_param("iiid", $orderId, $productId, $cartQuantity, $subtotal);
            $insertStmt->execute();

            // Update quantity in product_vendingmahcine table
            $updateQuery = "UPDATE product_vendingmahcine pv 
                            JOIN cart c ON pv.ProductID = c.productID 
                            SET pv.quantity = pv.quantity - c.quantity 
                            WHERE pv.ProductID = ? AND c.userID = ?";
            $updateStmt = $conn->prepare($updateQuery);
            $updateStmt->bind_param("ii", $productId, $userId);
            $updateStmt->execute();
        }
    }

    // Delete cart items for the user
    $deleteQuery = "DELETE FROM cart WHERE userID = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $userId);
    $deleteStmt->execute();

    $conn->commit(); // Commit all the transaction
    echo json_encode(["status" => "success", "orderId" => $orderId]);
} catch (Exception $e) {
    $conn->rollback(); // Rollback changes if an exception occurs
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
} finally {
    $conn->close();
}
