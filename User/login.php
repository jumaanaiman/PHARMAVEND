<?php
require_once '../Config/login-register.php';

// Define an empty error message
$errorMsg = "";

// Check if a registration success message is set in the session
if (isset($_SESSION['registration_success'])) {
    // Display the success message
    $successMsg = $_SESSION['registration_success'];
    // Remove the message from the session to prevent displaying it again
    unset($_SESSION['registration_success']);
}

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get full_name and password from form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize inputs to prevent SQL injection
    //$email = $conn->real_escape_string($email);
    //$password = $conn->real_escape_string($password);

    // Query to fetch user from database
    $query = "SELECT * FROM user WHERE email=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];

            if ($user['role'] == '0') {
                $_SESSION['role'] = '0';
                // Redirect to admin page
                header("Location: ../Admin/index.php");
            } else {
                $_SESSION['role'] = '1';
                // Redirect to user page
                header("Location: index.php");
            }
            exit();
        } else {
            // Incorrect password
            $errorMsg = "Incorrect password. Please try again.";
        }
    } else {
        // User not found
        $errorMsg = "Invalid email or password. Please try again.";
    }
} else {
    // This block executes when the page is loaded and no form submission has occurred
    // Set $errorMsg to empty
    $errorMsg = "";
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PharmaVend</title>

    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="css/R_CSSStyleLogin.css" type="text/css">
</head>

<body style="display: flex; justify-content: center; align-items: center; height: 100vh;background-color: #f0f0f0;">
    <div style="display: flex; flex-direction: column; align-items: center;">

        <div style="text-align: right; margin-bottom: 10px; padding-right: 10px;">
            <a href="index.php" style="color: #0b465c;">Back to PharmaVend</a>
        </div>

        <div class="login-container" style="background-color: #ffffff; border: 1px solid #188DB7; position: relative;">
            <?php if (isset($successMsg)) { ?>
                <div style="background-color: #328700; color: #ffffff; padding: 20px; border-radius: 5px; position: absolute; width: calc(100% - 22px); left: 11px;">
                    <?php echo $successMsg; ?>
                </div>
            <?php } ?>
            <?php if (!empty($errorMsg)) { ?>
                <div style="background-color: #FF2525; color: #ffffff; padding: 20px; border-radius: 5px; position: absolute; width: calc(100% - 22px); left: 11px;">
                    <?php echo $errorMsg; ?>
                </div>

            <?php } ?>
            <div class=" logo-container">
                <a href="index.php">
                    <img src="images/logo.png" alt="PharmaVend Logo" class="logo">
                </a>
            </div>


            <h3 class="login-title" style="color:#0b465c;">Sign In to PharmaVend</h3>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email" style="color:#188DB7;">Email</label>
                    <input type="text" id="email" class="form-control" placeholder="Enter your email" name="email">
                </div>
                <div class="form-group">
                    <label for="password" style="color:#188DB7;">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password">
                </div>
                <button type="submit" class="login-button">Sign In</button>
                <p class="already-member text-center">
                    I'm not a member! <a href="register.php">Sign up</a>
                </p>
            </form>
            <div class="forgot-password">
                <a href="page1.php">Forgot password?</a>
            </div>
        </div>

    </div>

</body>

</html>
<script>
    // Remove error and success messages after a certain time
    $(document).ready(function() {
        $(".error-msg, .success-msg").delay(3000).fadeOut(500);
    });
</script>