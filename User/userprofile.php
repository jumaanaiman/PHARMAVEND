<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once '../Config/login-register.php';


  $user_id = $_SESSION['user_id'];

  $userInfo = getUserInfo($conn, $user_id);
  $full_name = $userInfo['full_name'];
  $email = $userInfo['email'];
  $number = $userInfo['number'];
  $hashedPassword = $userInfo['password'];

  $updateSuccess = false; // Initialize update success variable
  $passwordUpdateSuccess = null; // Initialize password update success variable

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form data is for profile update or password update
    if (isset($_POST["fullName"]) && isset($_POST["phone"]) && isset($_POST["email"])) {
      // Profile update form data
      $full_name = $_POST['fullName'];
      $phone = $_POST['phone'];
      $email = $_POST['email'];

      // Update the user profile in the database
      if (updateProfile($user_id, $full_name, $phone, $email)) {
        $updateSuccess = true; // Set update success to true
      }
    } elseif (isset($_POST["currentPassword"]) && isset($_POST["newPassword"]) && isset($_POST["renewPassword"])) {
      // Password update form data
      $currentPassword = $_POST["currentPassword"];
      $newPassword = $_POST["newPassword"];
      $renewPassword = $_POST["renewPassword"];

      // Verify the current password
      $userInfo = getUserInfo($conn, $user_id);
      $password = $userInfo['password'];

      if (password_verify($currentPassword, $hashedPassword)) {
        // Check if the new password and re-entered password match
        if ($newPassword === $renewPassword) {
          // Update the password in the database
          if (updatePassword($conn, $user_id, $newPassword)) {
            $passwordUpdateSuccess = true;
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
          } else {
            echo "Error updating password: " . mysqli_error($conn);
          }
        } else {
          echo "New password and re-entered password do not match.";
        }
      } else {
        echo "Incorrect current password.";
      }
    } else {
      echo "Invalid form data.";
    }
  }


  ?>
  <title>PharmaVend</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="stylesheet" href="css/aos.css">
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>

  <div class="site-wrap">



    <?php include('shared/header.php'); ?>

    <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.html">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Profile</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2 class="h3 mb-5 text-black">Your Profile</h2>
          </div>
          <div class="col-md-12">

            <section class="section profile">
              <div class="row  card-profile         ">


                <div class="col-xl-8">

                  <div class="card">
                    <div class="card-body pt-3">
                      <!-- Bordered Tabs -->
                      <ul class="nav nav-tabs nav-tabs-bordered">

                        <li class="nav-item">
                          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                        </li>



                        <li class="nav-item">
                          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                        </li>

                      </ul>
                      <div class="tab-content pt-2">

                        <div class="tab-pane fade show active custom-profile-overview" id="profile-overview">
                          <h5 class="custom-card-title">Profile Details</h5>
                          <div class="row">
                            <div class="col-lg-3 col-md-4 custom-col-label">Full Name:</div>
                            <div class="col-lg-9 col-md-8"><?php echo isset($full_name) ? $full_name : ''; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-3 col-md-4 custom-col-label">Phone:</div>
                            <div class="col-lg-9 col-md-8"><?php echo isset($number) ? $number : ''; ?></div>
                          </div>
                          <div class="row">
                            <div class="col-lg-3 col-md-4 custom-col-label">Email:</div>
                            <div class="col-lg-9 col-md-8"><?php echo isset($email) ? $email : ''; ?></div>
                          </div>
                        </div>


                        <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">

                            <h5 class="custom-card-title">Edit Profile Details</h5>
                            <div class="custom-row">
                              <label for="fullName" class="custom-col-label">Full Name</label>
                              <div class="custom-col-content">
                                <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo isset($_POST['fullName']) ? $_POST['fullName'] : ''; ?>">
                              </div>
                            </div>

                            <div class="custom-row">
                              <label for="Phone" class="custom-col-label">Phone</label>
                              <div class="custom-col-content">
                                <input name="phone" type="text" class="form-control" id="Phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                              </div>
                            </div>

                            <div class="custom-row">
                              <label for="Email" class="custom-col-label">Email</label>
                              <div class="custom-col-content">
                                <input name="email" type="email" class="form-control" id="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
                              </div>
                            </div>

                            <div class="text-center">
                              <button type="submit" class="btn custom-save-changes">Save Changes</button>
                            </div>
                          </form>
                          <?php
                          // Display success message if update was successful
                          if ($updateSuccess) {
                            echo '<div class="alert alert-success mt-3">Profile updated successfully.</div>';
                          }
                          ?>
                        </div>



                        <div class="tab-pane fade pt-3" id="profile-change-password">
                          <h5 class="custom-card-title">Change your Password</h5>

                          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <div class="row mb-3">
                              <label for="currentPassword" class="col-md-4 col-lg-3 custom-col-label">Current Password</label>
                              <div class="col-md-8 col-lg-9">
                                <input name="currentPassword" type="password" class="form-control" id="currentPassword">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <label for="newPassword" class="col-md-4 col-lg-3 custom-col-label">New Password</label>
                              <div class="col-md-8 col-lg-9">
                                <input name="newPassword" type="password" class="form-control" id="newPassword">
                              </div>
                            </div>

                            <div class="row mb-3">
                              <label for="renewPassword" class="col-md-4 col-lg-3 custom-col-label">Re-enter New Password</label>
                              <div class="col-md-8 col-lg-9">
                                <input name="renewPassword" type="password" class="form-control" id="renewPassword">
                              </div>
                            </div>

                            <div class="text-center">
                              <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                          </form>

                        </div>

                      </div>

                    </div>
                  </div>

                </div>
              </div>
            </section>






          </div>

        </div>
      </div>
    </div>




    <?php include('shared/footer.php'); ?>
  </div>


  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha384-k6v7j5l6eUzJBax4vf8I9QTQH/Z/8FnQgSqDzQdCx2fpBX5DaSk3/e7a6CoHQU5N" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
  <script src="js/main.js"></script>
  <script src="js/shared.js"></script>
  <script>
    $(document).ready(function() {
      // jQuery code to handle tab switching
      $('button[data-bs-toggle="tab"]').on('click', function(e) {
        e.preventDefault();
        var target = $(this).data('bs-target');
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        $('.tab-pane').removeClass('show active');
        $(target).addClass('show active');
      });
    });
  </script>
  <?php
  // Close the database connection
  $conn->close();
  ?>
</body>

</html>