<?php
require_once  'config.php';


function getAllProducts()
{
    global $conn;
    $query = "SELECT * FROM product";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    return $products;
}


function getProductById($productId)
{
    global $conn;

    // Prepare the SQL statement
    $query = "SELECT * FROM product WHERE productID = ?";
    $stmt = $conn->prepare($query);

    // Bind the productID parameter
    $stmt->bind_param("i", $productId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the product
    $product = $result->fetch_assoc();

    return $product;
}

function deleteProductById($productId)
{
    global $conn; // Ensure that your database connection variable is accessible

    try {
        // Prepare the SQL statement to avoid SQL injection
        $query = "DELETE FROM product WHERE productID = ?";
        $stmt = $conn->prepare($query);

        // Bind the integer value of $productId to the placeholder in the SQL statement
        $stmt->bind_param("i", $productId);

        // Execute the statement
        $stmt->execute();

        // Check if any rows were affected (if the deletion was successful)
        if ($stmt->affected_rows > 0) {
            // Product was deleted successfully
            return true;
        } else {
            // Product with the given ID was not found
            return false;
        }
    } catch (Exception $e) {
        // Error occurred during execution, handle the error here
        // For simplicity, we're just logging the error message
        error_log("Error deleting product: " . $e->getMessage());

        // Return false to indicate that an error occurred
        return false;
    }
}
function updateProductByIdAPI($productId, $name, $img, $description, $price)
{
    global $conn;
    // Prepare the SQL statement
    $query = "UPDATE product SET name=?, img=?, description=?, price=? WHERE productID=?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        // Handle error if prepare fails

        return   false;
    }

    // Bind parameters
    $stmt->bind_param("sssdi", $name, $img, $description, $price, $productId);

    // Execute the statement
    $success = $stmt->execute();

    if ($success) {
        // If update was successful
        return true;
    } else {
        // If update failed
        return false;
    }
}
function insertProduct($name, $img, $description, $price)
{
    global $conn;

    // Check for duplicate product name
    $query = "SELECT EXISTS(SELECT 1 FROM product WHERE name = ?)";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->bind_result($exists);
        $stmt->fetch();
        $stmt->close();  // Close the statement to free up the connection

        if ($exists) {
            return   "A product with the same name already exists.";
        }
    } else {
        return   "Failed to prepare statement for duplicate check";
    }

    // Prepare the SQL statement for insertion
    $insertQuery = "INSERT INTO `product`(`name`, `img`, `description`, `price`) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    if (!$stmt) {
        return  "Failed to prepare statement for insertion";
    }

    // Bind parameters
    $stmt->bind_param("sssd", $name, $img, $description, $price);
    // Execute the statement
    if ($stmt->execute()) {
        $stmt->close();  // Close the statement to clean up
        return   "Product inserted successfully.";
    } else {
        $stmt->close();  // Ensure to close even if failed
        return "Failed to insert product";
    }
}
function updateProductQuantity($productID, $machine_id, $newQuantity)
{
    global $conn;
    // Validate the new quantity
    if (!is_numeric($newQuantity) || $newQuantity < 0) {
        return ['type' => 'danger', 'message' => 'Invalid quantity input.'];
    }

    // Prepare the update statement
    $query = "UPDATE product_vendingmahcine SET quantity = ? WHERE ProductID = ? AND machine_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "iii", $newQuantity, $productID, $machine_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        return ['type' => 'success', 'message' => "Update successful! Product ID: $productID, Vending Machine ID: $machine_id, New Quantity: $newQuantity"];
    } else {
        return ['type' => 'danger', 'message' => 'Error updating record: ' . mysqli_error($conn)];
    }
}
function deleteProductVm($productID, $machine_id)
{
    global $conn;
    $query = "DELETE FROM product_vendingmahcine WHERE ProductID = ? AND machine_id = ?";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ii", $productID, $machine_id);
        mysqli_stmt_execute($stmt);

        // Get the number of affected rows before closing the statement
        $affectedRows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($affectedRows > 0) {
            return ['type' => 'success', 'message' => 'Product Deleted Successfully'];
        }
    } else {
        return ['type' => 'danger', 'message' => 'Error deleting record: ' . mysqli_error($conn)];
    }
}
function addProductToVendingMachine($productID, $quantity, $vmid)
{
    global $conn;  // Assume $conn is your MySQLi connection object

    // Check if quantity is greater than 0
    if ($quantity <= 0) {
        return ['type' => 'danger', 'message' => 'Quantity must be greater than 0.'];
    }

    try {
        // Check for duplicate productID for the same machine_id
        $checkQuery = "SELECT COUNT(*) FROM product_vendingmahcine WHERE productID = ? AND machine_id = ?";
        $checkStmt = $conn->prepare($checkQuery);
        if (!$checkStmt) {
            return ['type' => 'danger', 'message' => 'Failed to prepare statement for checking duplication.'];
        }
        $checkStmt->bind_param("ii", $productID, $vmid);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            return ['type' => 'warning', 'message' => 'This product is already added to the vending machine.'];
        }

        // If no duplication and quantity is valid, proceed to insert
        $insertQuery = "INSERT INTO product_vendingmahcine (machine_id, productID, quantity) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        if (!$stmt) {
            return ['type' => 'danger', 'message' => 'Failed to prepare statement for insertion.'];
        }
        $stmt->bind_param("iii", $vmid, $productID, $quantity);
        if ($stmt->execute()) {
            $stmt->close();  // Close the statement to clean up
            return ['type' => 'success', 'message' => 'Product inserted successfully.'];
        } else {
            $stmt->close();  // Ensure to close even if failed
            return ['type' => 'danger', 'message' => 'Failed to insert product: ' . mysqli_error($conn)];
        }
    } catch (mysqli_sql_exception $e) {
        return ['type' => 'danger', 'message' => 'Database error: ' . $e->getMessage()];
    }
}

function AddVendingMachines($name, $city, $address, $location, $mall, $university, $latitude, $longitude)
{
    global $conn;  // Assume $conn is your MySQLi connection object
    $sql_insert = "INSERT INTO vending_machines (name, status, location, city, address, university_name, latitude, longitude, mall_name) VALUES ('$name', 'active', '$location', '$city', '$address', '$university', '$latitude', '$longitude', '$mall')";
    if ($conn->query($sql_insert) === TRUE) {
        // Insertion successful
        echo '
        <script>
          Swal.fire({
            title: "Success!",
            text: "Vending machine added successfully!",
            icon: "success"
          }).then(function() {
            window.location.href = "vendingMachines.php";
          });
        </script>
        ';
    } else {
        // Error in insertion
        echo '
        <script>
          Swal.fire({
            title: "Error!",
            text: "Error in adding vending machine. Please try again later.",
            icon: "error"
          }).then(function() { 
          });
        </script>
        ';
    }
}


function checkDuplicateVendingMachinesName($name)
{
    global $conn;
    $sql_check_duplicate = "SELECT COUNT(*) AS count FROM vending_machines WHERE name = '$name'";
    $result = $conn->query($sql_check_duplicate);
    $row = $result->fetch_assoc();
    $count = $row['count'];
    return $count;
}
function deleteVendingMachineByID($machine_id)
{
    global $conn; // Assuming $conn is your MySQLi connection object

    // SQL query to delete vending machine by ID
    $sql_delete = "DELETE FROM vending_machines WHERE machine_id = $machine_id";

    // Execute the query
    if ($conn->query($sql_delete) === TRUE) {
        // Deletion successful
        return true;
    } else {
        // Error in deletion
        return false;
    }
}

function updateVendingMachine($vmId, $name, $city, $address, $location, $mall, $university, $latitude, $longitude)
{
    // Sanitize 
    global $conn; // Assuming $conn is your MySQLi connection object
    $vmId = mysqli_real_escape_string($conn, $vmId);
    $name = mysqli_real_escape_string($conn, $name);
    $city = mysqli_real_escape_string($conn, $city);
    $address = mysqli_real_escape_string($conn, $address);
    $location = mysqli_real_escape_string($conn, $location);
    $mall = mysqli_real_escape_string($conn, $mall);
    $university = mysqli_real_escape_string($conn, $university);
    $latitude = mysqli_real_escape_string($conn, $latitude);
    $longitude = mysqli_real_escape_string($conn, $longitude);

    // Update database
    $sql = "UPDATE vending_machines SET name='$name', city='$city', address='$address', location='$location', mall_name='$mall', university_name='$university', latitude='$latitude', longitude='$longitude' WHERE machine_id=$vmId";

    if (mysqli_query($conn, $sql)) {
        return true; // Record updated successfully
    } else {
        return false; // Error updating record
    }
}
