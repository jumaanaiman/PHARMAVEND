
<?php


require_once 'config.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!function_exists('getItems')) {
    function getItems($transactionID, $conn)
    {
        // SQL query to retrieve items based on TransactionID
        $query = "SELECT product_name FROM products WHERE TransactionID = '$transactionID'";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            $items = "";
            // Loop through each row to get item names
            while ($row = mysqli_fetch_assoc($result)) {
                $items .= $row['product_name'] . "<br/>";
            }
            return $items;
        }

        return "No items";
    }
}

if (!function_exists('getAllUsers')) {
    function getAllUsers()
    {
        global $conn;
        $query = "select * from user";
        return mysqli_query($conn, $query);
    }
}

if (!function_exists('deleteUser')) {
    function deleteUser($userId)
    {
        global $conn;

        // Prepare and execute the DELETE statement
        $sql = "DELETE FROM user WHERE user_id = '$userId'";
        if (mysqli_query($conn, $sql)) {
            // Deletion successful
            echo "User deleted successfully.";
        } else {
            // Deletion failed
            echo "Error deleting user: " . mysqli_error($conn);
        }
        // Close the database connection
        mysqli_close($conn);
    }
}

if (!function_exists('getUserInfo')) {
    function getUserInfo($conn, $user_id)
    {
        $sql = "SELECT * FROM user WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            return null;
        }
    }
}

if (!function_exists('loginUser')) {
    function loginUser($email, $password)
    {
        global $conn;

        // Retrieve the user record from the database based on the provided email
        $query = "SELECT * FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $storedPassword = $row['password'];

            // Verify the provided password against the hashed password stored in the database
            if (password_verify($password, $storedPassword)) {
                // Passwords match, login successful
                return true;
            } else {
                // Passwords do not match
                return false;
            }
        } else {
            // User not found
            return false;
        }
    }
}
// Function to update the profile
if (!function_exists('updateProfile')) {
    function updateProfile($user_id, $full_name, $phone, $email)
    {
        global $conn;

        $full_name = mysqli_real_escape_string($conn, $full_name);
        $phone = mysqli_real_escape_string($conn, $phone);
        $email = mysqli_real_escape_string($conn, $email);

        $sql = "UPDATE user SET full_name = '$full_name', number = '$phone', email = '$email' WHERE user_id = $user_id";

        if (mysqli_query($conn, $sql)) {
            return true; // Profile updated successfully
        } else {
            return false; // Error updating profile
        }
    }
    // Function to update the password
    function updatePassword($conn, $user_id, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE user SET password = ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $hashedPassword, $user_id);

        if ($stmt->execute()) {
            return true; // Password updated successfully
        } else {
            return false; // Error updating password
        }
    }
    if (!function_exists('getAllCustomers')) {
        function getAllCustomers()
        {
            global $conn;
            $query = "select * from user where role = 1";
            return mysqli_query($conn, $query);
        }
    }

    if (!function_exists('getAllAdmins')) {
        function getAllAdmins()
        {
            global $conn;
            $query = "select * from user where role = 0";
            return mysqli_query($conn, $query);
        }
    }
}
?>