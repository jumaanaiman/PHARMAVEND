<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/R_CSSStyleReg.css" type="text/css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 signup-container">
                <h2 class="signup-title text-center"style="color:#188DB7;">Edit Profile</h2>
                <div class="profile-photo">
                  <label for="profile-picture"style="color:#188DB7;">Profile Picture:</label>
                  <input type="file" id="profile-picture" name="profile-picture">
                </div>
                <form>
                    <div class="form-group">
                        <label for="fullName" style="color:#188DB7;">First Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Enter your first name">
                    </div>
                    <div class="form-group">
                        <label for="fullName" style="color:#188DB7;">Last Name</label>
                        <input type="text" class="form-control" id="fullName" placeholder="Enter your last name">
                    </div>
                    <div class="form-group">
                        <label for="email"style="color:#188DB7;">Email Address</label>
                        <input type="email" class="form-control" id="email" placeholder="Enter your email address">
                    </div>
                    <div class="form-group">
                        <label for="password"style="color:#188DB7;">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Enter your password">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword"style="color:#188DB7;">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password">
                    </div>
                    <button type="submit" class="btn btn-block btn-primary signup-button">Save Changes</button>
                </form>
                
                <p class="already-member text-center">
                <a href="login.html">Back to Login</a>
                </p>
        </div>
        
    </div>

    </div>

    <!-- Include Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="


 