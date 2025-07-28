<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once '../Config/login-register.php';
  $_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
  // Initialize alert variables
  $alertType = '';
  $alertMessage = '';

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['c_full_name'];
    $email = $_POST['c_email'];
    $comment = $_POST['c_message'];

    // Validate and sanitize user input before inserting into the database

    // Example validation: Check if required fields are not empty
    if (!empty($full_name) && !empty($email) && !empty($comment)) {
      // Insert data into the 'contact' table
      $stmt = $conn->prepare("INSERT INTO contact (full_name, email, comment) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $full_name, $email, $comment);
      $stmt->execute();

      // Check if the insertion was successful
      if ($stmt->affected_rows > 0) {
        // Data inserted successfully
        $alertType = 'success';
        $alertMessage = 'Message sent successfully!';
      } else {
        // Failed to insert data
        $alertType = 'danger';
        $alertMessage = 'Failed to send message.';
      }
      $stmt->close();
    } else {
      // Required fields are empty
      $alertType = 'danger';
      $alertMessage = 'Please fill in all the required fields.';
    }
  }
  ?>
  <title>PharmaVend</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="images/logo.png">
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

  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
      <div class="preloader-inner position-relative">
        <div class="preloader-circle"></div>
        <div class="preloader-img pere-text">
          <img src="images/logo.png" alt="">
        </div>
      </div>
    </div>
  </div>
  <div class="site-wrap">
    <?php include('shared/header.php'); ?>
    <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.html">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Contact</strong>
          </div>
        </div>
      </div>
    </div>
    <div class="site-section">
      <div class="container">
        <div class="row  ">
          <div class="col-md-12 ">
            <h2 class="h3 mb-5 text-black">We value your feedback! Please feel free to share your thoughts about our website.</h2>
          </div>
          <div class="col-md-12">
            <!-- Display alert if applicable -->
            <?php if (!empty($alertType) && !empty($alertMessage)) : ?>
              <div class="alert alert-<?php echo $alertType; ?> alert-dismissible fade show" role="alert">
                <?php echo $alertMessage; ?>

              </div>
            <?php endif; ?>
            <form action="#" method="post">
              <div class="p-3 p-lg-5 border " style="background-color:#f8f9fa !important" ;>
                <div class=" form-group row ">
                  <div class=" col-md-12">
                    <label for="c_full_name" class="text-black"><span class="text-danger">Full Name</span></label>
                    <input type="text" class="form-control" id="c_full_name" name="c_full_name" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_email" class="text-black"><span class="text-danger">Email</span></label>
                    <input type="email" class="form-control" id="c_email" name="c_email" placeholder="">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_message" class="text-black"><span class="text-danger">Message</span></label>
                    <textarea name="c_message" id="c_message" cols="30" rows="7" class="form-control"></textarea>
                  </div>
                </div>
                <div class="form-group row justify-content-center ">
                  <div class="col-lg-4">
                    <input type="submit" class="btn btn-primary btn-lg btn-block " value="Send Message">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include('shared/footer.php'); ?>
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
  <script src="js/shared.js"></script>

  <script>
    // Remove alert message after a certain time
    $(document).ready(function() {
      $(".alert").fadeTo(2000, 500).slideUp(500, function() {
        $(".alert").slideUp(500);
      });
    });
  </script>
</body>

</html>