<?php
require_once '../Config/login-register.php'; // Ensure your database connection settings are correct

// Function to validate password
function validatePassword($password)
{
    // Validate length
    if (strlen($password) < 8) {
        return false;
    }
    // Validate uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }
    // Validate lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }
    // Validate number
    if (!preg_match('/[0-9]/', $password)) {
        return false;
    }
    // Validate special character
    if (!preg_match('/[^a-zA-Z0-9]/', $password)) {
        return false;
    }
    return true;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $static_code = $_POST['code'];
    $new_password = $_POST['New_password'];
    $confirm_password = $_POST['Re-enter_password'];

    // No need to check if email exists again as it's already verified in page1.php

    // Check static code
    if ($static_code === '1234') {
        // Static code is correct
        // Check if passwords match
        if ($new_password === $confirm_password) {
            // Validate password
            if (validatePassword($new_password)) {
                // Update password in the database
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE user SET password = '$hashed_password' WHERE email = '$email'";
                if ($conn->query($update_sql) === TRUE) {
                    $successMsg = "Password updated successfully!";
                } else {
                    $errorMsg = "Error updating password: " . $conn->error;
                }
            } else {
                $errorMsg = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
            }
        } else {
            $errorMsg = "Passwords do not match!";
        }
    } else {
        $errorMsg = "Invalid  code!";
    }
}
?>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forget Password - PharmaVend</title>

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
            <div class="logo-container">
                <a href="index.php">
                    <img src="images/logo.png" alt="PharmaVend Logo" class="logo">
                </a>
            </div>

            <h3 class="login-title" style="color:#0b465c;">Forget Password</h3>
            <?php
            // Check if email parameter is provided in the URL
            if (isset($_GET['email']) && !empty($_GET['email'])) {
                // Use the email parameter
                $email = htmlspecialchars($_GET['email']);
            } else {
                // Handle the case when email parameter is null or empty
                echo "Email parameter is missing or empty.";
                // You can redirect the user to an error page or take any other appropriate action
                exit(); // Stop further execution
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <input type="hidden" name="email" value="<?php echo $email; ?>">

                <div class="form-group">
                    <label for="code" style="color:#188DB7;">Code</label>
                    <input type="password" id="code" class="form-control" placeholder="Enter code from your email" name="code" required>
                </div>

                <div class="form-group">
                    <label for="New_password">New Password</label>
                    <input type="password" class="form-control" id="New_password" name="New_password" placeholder="Enter your new password" required>
                </div>

                <div class="form-group">
                    <label for="Re-enter_password">Re-enter Password</label>
                    <input type="password" class="form-control" id="Re-enter_password" name="Re-enter_password" placeholder="Re-enter your new password" required>
                </div>

                <button type="submit" class="login-button">Confirm</button>

                <p class="already-member text-center">
                    Go to Sign In <a href="login.php">Sign In</a>
                </p>
            </form>


        </div>

    </div>

</body>

</html>