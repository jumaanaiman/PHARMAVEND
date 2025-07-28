<?php
require_once 'vm.php';

// Get the order ID from the POST request
$orderID = $_POST['orderId'];

// Update the status of the order
$query = "UPDATE orders SET status = 'Picked Up Successfully' WHERE orderID = $orderID";

// Execute the query
$result = mysqli_query($conn, $query);

if ($result) {
    // Redirect to the 'orders.php' page in the 'user' folder with success query parameter
    header("Location: ../User/orders.php?status=success");
    exit();
} else {
    // Redirect to the 'orders.php' page in the 'user' folder with error query parameter
    header("Location: ../User/orders.php?status=error");
    exit();
}
