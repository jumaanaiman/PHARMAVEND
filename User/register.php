<?php
require_once '../Config/login-register.php'; // Ensure your database connection settings are correct

$errors = array();

if (isset($_POST['signUp'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];

    // Validation Checks
    if (empty($fullName)) {
        $errors['fullName'] = "Full Name is required.";
    }
    if (empty($email)) {
        $errors['email'] = "Email Address is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email address.";
    }
    if (empty($phoneNumber)) {
        $errors['phoneNumber'] = "Phone Number is required.";
    }
    if (empty($password)) {
        $errors['password'] = "Password is required.";
    } else {
        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            $errors['password'] = "Password should be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }
    }

    // Check if the email already exists in the database
    if (!isset($errors['email'])) { // Only check if the email is otherwise valid
        $stmt = mysqli_prepare($conn, "SELECT email FROM user WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errors['email'] = "This email is already registered.";
        }
        mysqli_stmt_close($stmt);
    }

    // If there are no errors, proceed to insert the new user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO user (full_name, password, email, number, role) VALUES (?, ?, ?, ?, 1)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $fullName, $hashedPassword, $email, $phoneNumber);
        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            session_start();
            $_SESSION['registration_success'] = "Your account has been successfully created. Please Sign In  to PharmaVend.";
            header("Location: login.php"); // Redirect to login page upon successful registration
            exit(); // Ensure script execution stops after redirection
        } else {
            echo "An error occurred. Please try again."; // Handle database error
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - PharmaVend</title>

    <link rel="icon" href="images/logo.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/Y_CSSStyleReg.css" type="text/css">

</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 signup-container">
                <div class="logo-container d-flex justify-content-center mb-3">

                    <a href="index.php">
                        <img src="images/logo.png" alt="PharmaVend Logo" class="logo">
                    </a>
                </div>
                <h2 class="signup-title text-center">Sign Up to PharmaVend</h2>

                <form action="register.php" method="post">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" class="form-control <?php if (isset($errors['fullName'])) echo 'is-invalid'; ?>" id="fullName" name="fullName" placeholder="Enter your full name">
                        <?php if (isset($errors['fullName'])) echo '<div class="invalid-feedback">' . $errors['fullName'] . '</div>'; ?>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control <?php if (isset($errors['email'])) echo 'is-invalid'; ?>" id="email" name="email" placeholder="Enter your email address">
                        <?php if (isset($errors['email'])) echo '<div class="invalid-feedback">' . $errors['email'] . '</div>'; ?>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Phone Number</label>
                        <input type="number" class="form-control <?php if (isset($errors['phoneNumber'])) echo 'is-invalid'; ?>" id="phoneNumber" name="phoneNumber" placeholder="Enter your phone number">
                        <?php if (isset($errors['phoneNumber'])) echo '<div class="invalid-feedback">' . $errors['phoneNumber'] . '</div>'; ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control <?php if (isset($errors['password'])) echo 'is-invalid'; ?>" id="password" name="password" placeholder="Enter your password">
                        <?php if (isset($errors['password'])) echo '<div class="invalid-feedback">' . $errors['password'] . '</div>'; ?>
                    </div>

                    <button type="submit" name="signUp" class="btn btn-block btn-primary signup-button">Sign Up</button>
                    <p class="already-member text-center">
                        I am already a member! <a href="login.php">Sign In</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

</body>

</html>