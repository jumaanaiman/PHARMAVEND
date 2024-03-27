<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            background-image: url(img/background.png);
            background-size: 100% 100%;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
<<<<<<< HEAD
        
=======







>>>>>>> 2faad95f948d357e3b72e1fede9fed5e4339bb58
        .login-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 40px 60px; /* Increased padding for larger box */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 500px; /* Adjust the maximum width as needed */
        }

        .login-title {
            font-size: 28px; /* Increased font size */
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group label {
            font-weight: bold;
            font-size: 18px; /* Increased font size */
        }

        .form-control {
            border: 1px solid #ced4da;
            border-radius: 10px; /* Larger border radius */
            font-size: 20px; /* Increased font size */
            padding: 14px; /* Increased padding for input fields */
        }

        .login-button {
            background-color: #188DB7;
            border: none;
            border-radius: 5px; /* Smaller border radius */
            color: #ffffff;
            font-weight: bold;
            transition: background-color 0.3s;
            cursor: pointer;
            width: 100%;
            font-size: 18px; /* Smaller font size */
            padding: 10px; /* Smaller padding for button */
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .forgot-password {
            margin-top: 10px;
            text-align: center;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="login-title" style="color:#188DB7;">Login</h2>
        <form>
            <div class="form-group">
                <label for="username" style="color:#188DB7;">Username</label>
                <input type="text" id="username" class="form-control" placeholder="Enter your username">
            </div>
            <div class="form-group">
                <label for="password" style="color:#188DB7;">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Enter your password">
            </div>
            <button type="submit" class="login-button">Login</button>
        </form>
        <div class="forgot-password">
            <a href="#">Forgot password?</a>
        </div>
    </div>
</body>
</html>