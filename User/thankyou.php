<!DOCTYPE html>
<html lang="en">

<head>
  <title>PharmaVend</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="images/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

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

  <div class="site-wrap">
    <?php include('shared/header.php'); ?>

    <div id="header-user"></div>


    <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span> <strong class="text-black">Thank You</strong></div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 text-center">
            <img src="images/vm.png" alt="Vending Machine" class="imgpharmavend" style="width: 70%; height: auto;">
          </div>
          <div class="col-md-6 text-center">
            <span class="icon-check_circle display-3" style="color: rgb(0, 128, 0);"></span>
            <h2 class="display-3 text-black">Thank you!</h2>
            <p class="lead mb-3" style="font-size: 20px; color: #333;">Congratulations! Your purchase is complete.</p>
            <!-- Your custom message here -->
            <p style="font-size: 20px; color: #333; margin-bottom: 20px;">To collect your items, click the button below to view your orders and get the QR code for the vending machine you bought from.</p>
            <!-- Back to store button -->
            <p><a href="orders.php" class="btn btn-md height-auto px-4 py-3 btn-primary" style="background-color: #007bff; color: #fff;">Go to your Orders</a></p>
          </div>


        </div>
      </div>



      <?php include('shared/footer.php'); ?>

    </div>


  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
  <script src="js/shared.js"></script>

</body>

</html>