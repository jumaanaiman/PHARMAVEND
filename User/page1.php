<?php
require_once '../Config/login-register.php'; // Ensure your database connection settings are correct

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Query to check if email exists
    $sql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email exists
        // Generate and send code to email here
        // For demonstration purpose, let's assume the code is sent successfully
        // Redirect to page2.php with email as parameter
        header("Location: page2.php?email=" . urlencode($email));
        exit();
    } else {
        $errorMsg = "Email does not exist!";
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



        <div class="login-container" style="background-color: #ffffff; border: 1px solid #188DB7; position: relative;">
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

            <h3 class="login-title" style="color:#0b465c;">Change Password</h3>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label for="email" style="color:#188DB7;">Email</label>
                    <input type="text" id="email" class="form-control" placeholder="Enter your Email" name="email">
                </div>
                <button type="submit" class="login-button">Send Email </button>
            </form>

        </div>

    </div>

</body>

</html>