<?php
require_once 'config.php';
// Set the content type to JSON
header('Content-Type: application/json');

// Check if a specific function is requested
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $productId = isset($_GET['id']) ? $_GET['id'] : null;
    // Call the appropriate function based on the action parameter
    switch ($action) {
        case 'getProductById':
            // Check if productId is provided
            if (isset($_GET['id'])) {
                $productId = $_GET['id'];
                echo json_encode(getProductByIdAPI($productId));
            } else {
                echo json_encode(array("error" => "Product ID is required"));
            }
            break;
        case 'getVendingMachineById':
            // Check if productId is provided
            if (isset($_GET['machineId'])) {
                $machineId = $_GET['machineId'];
                echo json_encode(getVendingMachineById($machineId));
            } else {
                echo json_encode(array("error" => "Product ID is required"));
            }
            break;
        case 'updateProductById':
            if (isset($_GET['id'])) {
                $productId = $_GET['id'];
                echo $_FILES['image'];
                // Check if all fields and file are present
                if (isset($_POST['name'], $_POST['description'], $_POST['price']) && isset($_FILES['image'])) {
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $image = $_FILES['image'];
                    $file_path = 'fileUpload/';

                    $imagePath = $file_path . basename($image['name']);
                    echo  $imagePath;
                    echo $imagePath;
                    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
                        echo json_encode(array("success" => true, "message" => "open Move updated successfully"));

                        // Assuming updateProductByIdAPI is defined and works correctly
                        $result = updateProductByIdAPI($productId, $name, $imagePath, $description, $price);

                        if ($result) {
                            echo json_encode(array("success" => true, "message" => "Product updated successfully"));
                        } else {
                            echo json_encode(array("success" => false, "message" => "Failed to update product"));
                        }
                    } else {
                        echo json_encode(array("success" => false, "message" => "Failed to upload image"));
                    }
                } else {
                    // Log missing fields or file for debugging
                    echo json_encode(array("success" => false, "message" => "Missing required form fields or image file", "post_data" => $_POST, "file_data" => $_FILES));
                }
            } else {
                echo json_encode(array("error" => "Product ID is required"));
            }
            break;
        default:
            echo json_encode(array("error" => "Invalid action"));
    }
} else {
    // If no action is specified, return an error
    echo json_encode(array("error" => "No action specified"));
}


function getProductByIdAPI($productId)
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
function getVendingMachineById($machineId)
{
    global $conn;

    // Prepare the SQL statement
    $query = "SELECT * FROM vending_machines WHERE machine_id = ?";
    $stmt = $conn->prepare($query);

    // Bind the productID parameter
    $stmt->bind_param("i", $machineId);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the product
    $machine = $result->fetch_assoc();

    return $machine;
}

function updateProductByIdAPI($productId, $name, $img, $description, $price)
{
    global $conn;
    // Prepare the SQL statement
    $query = "UPDATE product SET name=?, img=?, description=?, price=? WHERE productID=?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        // Handle error if prepare fails
        echo json_encode(array("success" => false, "message" => "Failed to prepare statement"));
        return;
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
