<?php

require_once 'config.php';

function getVendingMachines($city = '', $university = '', $mall = '')
{
    global $conn;

    // Initialize parameters array
    $params = [];
    $sql = "SELECT * FROM vending_machines WHERE 1";

    // Modify the query and parameters array to filter by city if a city is provided
    if (!empty($city)) {
        $sql .= " AND city = ?";
        $params[] = $city;
    }

    // Modify the query and parameters array to filter by university if a university is provided
    if (!empty($university)) {
        $sql .= " AND university_name = ?";
        $params[] = $university;
    }
    if (!empty($mall)) {
        $sql .= " AND mall_name = ?";
        $params[] = $mall;
    }

    $stmt = $conn->prepare($sql);

    // Bind parameters dynamically
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Assuming all parameters are strings
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    $vendingMachines = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $vendingMachines[] = $row;
        }
    }

    return $vendingMachines;
}
function getProductsByVendingMachineId($vmId)
{
    global $conn;
    $query = "SELECT * FROM product p JOIN `product_vendingmahcine` vm ON p.productID = vm.ProductID WHERE vm.machine_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $vmId); // 'i' because vmId is an integer
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}
function getVendingMachineId($vmId)
{
    global $conn;
    $query = "SELECT * FROM vending_machines WHERE machine_id  = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $vmId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
function getVMdetailsByVendingMachineId($vmId)
{
    global $conn;


    $query = "SELECT DISTINCT p.* FROM vending_machines p JOIN product_vendingmahcine vm ON p.machine_id = vm.machine_id WHERE p.machine_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $vmId);
    $stmt->execute();
    $result = $stmt->get_result();

    $vendingmachines = [];
    while ($row = $result->fetch_assoc()) {
        $vendingmachines[] = $row;
    }

    return   $vendingmachines;
}
function getProductDetailsById($productId)
{
    global $conn;
    $query = "SELECT * FROM product WHERE productID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc(); // Return the product details as an associative array
}
function addToCart($userID, $vmID, $productIDs, $quantities, $prices)
{
    global $conn;
    try {
        $conn->begin_transaction();
        foreach ($quantities as $index => $quantity) {
            $price = $prices[$index];
            $productID = $productIDs[$index];
            $totalAmount = $quantity * $price;

            echo "Debug: Inserting $quantity of product $productID at price $price totaling $totalAmount\n";

            $query = "INSERT INTO `cart` (`totalAmount`, `quantity`, `price`, `userID`, `productID`, `machine_id`) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Prepare failed: " . $conn->error);
            }

            if (!$stmt->bind_param("diisss", $totalAmount, $quantity, $price, $userID, $productID, $vmID)) {
                throw new Exception("Bind param failed: " . $stmt->error);
            }

            if (!$stmt->execute()) {
                throw new Exception("Execute failed: " . $stmt->error);
            }
        }

        $conn->commit();
        echo "Debug: Transaction committed.\n";
        return "Items added to cart successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Debug: Transaction rolled back.\n";
        return "Error: " . $e->getMessage();
    }
}
function getCartDetailsByUserId($userId)
{
    global $conn; // Assuming $conn is your database connection object
    $query = "SELECT c.*, p.name,  p.img FROM cart c JOIN product p ON c.productID = p.productID WHERE c.userID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
    return $cartItems;
}
function emptyCartByUserId($userId)
{

    global $conn;

    // SQL to delete all items from the cart for a specific user
    $sql = "DELETE FROM cart WHERE userID = ?";


    if ($stmt = $conn->prepare($sql)) {
        // Bind the integer user ID to the placeholder in the SQL statement
        $stmt->bind_param("i", $userId);

        // Execute the prepared statement
        $stmt->execute();

        // Check for successful execution
        if ($stmt->affected_rows > 0) {
            echo "All items were successfully deleted from the cart.";
        } else {
            echo "No items were deleted from the cart. Maybe it was already empty?";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Handle errors in preparation of statement
        echo "Error preparing statement: " . $conn->error;
    }
}
function deleteProductById($userId, $productId)
{
    global $conn;

    $sql = "DELETE FROM cart WHERE userID = ? AND productID = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ii", $userId, $productId);
        $stmt->execute();
        if ($stmt->affected_rows > 0) {
            echo "Product was successfully deleted from the cart.";
        } else {
            echo "No product was deleted. Please check the product ID.";
        }
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

function updateProductQuantity($userId, $machineId, $productId, $quantity)
{
    global $conn;

    // Check current stock in the vending machine
    $availStmt = $conn->prepare("SELECT quantity FROM product_vendingmahcine WHERE machine_id = ? AND ProductID = ?");
    $availStmt->bind_param("ii", $machineId, $productId);
    $availStmt->execute();
    $availResult = $availStmt->get_result();

    if ($availResult->num_rows == 0) {
        return "This product is not available in the selected vending machine.";
    }

    $availableQuantity = $availResult->fetch_assoc()['quantity'];

    // Check if the requested quantity is available
    if ($quantity > $availableQuantity) {
        return "Requested quantity exceeds available stock.";
    }

    // Check if the product is already in the cart
    $checkStmt = $conn->prepare("SELECT quantity, price FROM cart WHERE userID = ? AND productID = ?");
    $checkStmt->bind_param("ii", $userId, $productId);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows > 0) {
        $cartData = $result->fetch_assoc();
        $currentQuantity = $cartData['quantity'];
        $price = $cartData['price'];  // Assuming price is stored in the cart table
        $newQuantity =  $quantity;

        if ($newQuantity > $availableQuantity) {
            return "Update exceeds available stock in vending machine.";
        }

        $newTotalAmount = $price * $newQuantity;  // Calculate new total amount

        // Update the cart with new quantity and new total amount
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ?, totalAmount = ? WHERE userID = ? AND productID = ?");
        $updateStmt->bind_param("idii", $newQuantity, $newTotalAmount, $userId, $productId);
        if ($updateStmt->execute()) {
            return "Product quantity and total amount updated in cart successfully!";
        } else {
            return "Failed to update product in cart.";
        }
    }
}
