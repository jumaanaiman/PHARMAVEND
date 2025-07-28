<?php
require_once '../Config/vm.php';

// Start the session
session_start();

// Fetch the user ID from the session
$userID = $_SESSION['user_id'];
$orderNumber = '';

// Rest of your code...



// Fetch the user ID from the session
$userID = $_SESSION['user_id'];
$orderNumber = '';

// Rest of your code...

// Fetch the user ID from the session
$userID = $_SESSION['user_id'];
$orderNumber = '';
// Check if the user has submitted the order number form
if (isset($_POST['orderNumber'])) {
  // Sanitize the input to prevent SQL injection
  $orderNumber = mysqli_real_escape_string($conn, $_POST['orderNumber']);

  // If order number is empty, set $orderNumber to null or empty string
  if (empty($orderNumber)) {
    $orderNumber = null; // or $orderNumber = ''; depending on your preference
  }

  // Modify the SQL query to filter by order number if it's not empty
  $sql = "SELECT orders.orderID,
                 orders.userID,
                 vending_machines.name AS machine_name, 
                 orders.TIMESTAMP, 
                 orders.total_amount, 
                 orders.status,
                 GROUP_CONCAT(CONCAT(product.name, ' x', orderitems.quantity) SEPARATOR ', ') AS products_ordered
          FROM orders
          JOIN vending_machines ON orders.machine_ID = vending_machines.machine_id
          JOIN orderitems ON orders.orderID = orderitems.orderID
          JOIN product ON orderitems.productID = product.productID
          WHERE orders.userID = $userID";

  // Add condition to filter by order number if it's not empty
  if ($orderNumber !== null) {
    $sql .= " AND orders.orderID = '$orderNumber'";
  }

  $sql .= " GROUP BY orders.orderID";
} else {
  // If no order number is submitted, fetch all orders for the user
  $sql = "SELECT orders.orderID,
                 orders.userID,
                 vending_machines.name AS machine_name, 
                 orders.TIMESTAMP, 
                 orders.total_amount, 
                 orders.status,
                 GROUP_CONCAT(CONCAT(product.name, ' x', orderitems.quantity) SEPARATOR ', ') AS products_ordered
          FROM orders
          JOIN vending_machines ON orders.machine_ID = vending_machines.machine_id
          JOIN orderitems ON orders.orderID = orderitems.orderID
          JOIN product ON orderitems.productID = product.productID
          WHERE orders.userID = $userID
          GROUP BY orders.orderID";
}

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>PharmaVend</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="images/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">



  <style>
    @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap');

    body {
      font-family: 'Open Sans', sans-serif;
    }

    .search {
      top: 9px;
      left: 10px;
    }

    .form-control {
      border: none;
      padding-left: 32px;
    }

    .form-control:focus {
      border: none;
      box-shadow: none;
    }

    .table thead th {
      vertical-align: baseline !important;
    }

    .green {
      color: green;
    }
  </style>
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
      <div class="preloader-inner position-relative">
        <div class="preloader-circle"></div>
        <div class="preloader-img pere-text">
          <img src="images/pharmavendlogo.png" alt="">
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
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Orders</strong>
          </div>
        </div>
      </div>
    </div>
    <div class="site-section">
      <div class="container mt-5 px-2">
        <div class="row">
          <div class="col-md-12">
            <h2 class="h3 mb-5 text-black">Your Order History</h2>
          </div>
          <div class="col-md-12">
            <div class="mb-2 d-flex justify-content-between align-items-center">
              <form method="post" action="">
                <div class="position-relative">
                  <span class="position-absolute search"><i class="fa fa-search"></i></span>
                  <input type="text" id="orderNumberInput" name="orderNumber" class="form-control w-100" placeholder="Search by Order Numb" value="<?php echo isset($orderNumber) ? htmlspecialchars($orderNumber) : ''; ?>">
                </div>
              </form>
              <div class="px-2">
              </div>
            </div>

            <div class="table-responsive">
              <table class="table-responsive table-borderless">
                <thead class="order-table">
                  <tr class="bg-light">
                    <!-- New column for status indicator -->
                    <th scope="col" width="5%"></th>
                    <!-- Existing columns -->
                    <th scope="col" width="5%">#</th>
                    <th scope="col" width="20%">Machine Name </th>
                    <th scope="col" width="20%">Placement Time</th>
                    <th scope="col" width="20%">Products Ordered</th>
                    <th scope="col" width="15%"> Payed Amount</th>
                    <th scope="col" width="10%">Status</th>
                    <th scope="col" class="text-end" width="15%"><span>Dispense</span></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      // Determine the color of the circle based on the order status
                      $statusColor = ($row['status'] == 'waiting to be picked up') ? 'red' : 'green';

                      // Output the table row with the status indicator
                      echo "<tr style='border-bottom: 2px solid blue;'>";
                      echo "<td><div style='width: 10px; height: 10px; border-radius: 50%; background-color: $statusColor;'></div></td>"; // Circle indicating status
                      echo "<td>" . $row['orderID'] . "</td>";
                      echo "<td>" . $row['machine_name'] . "</td>";
                      echo "<td>" . $row['TIMESTAMP'] . "</td>";
                      echo "<td>" . $row['products_ordered'] . "</td>";
                      echo "<td>" . $row['total_amount'] . "</td>";
                      echo "<td>" . $row['status'] . "</td>";
                      echo "<td>";
                      // Only display the QR icon button if the status is 'waiting to be picked up'
                      if ($row['status'] == 'waiting to be picked up') {
                        echo "<button class='btn btn-link text-primary qr-button' style='font-size: 1.8rem;' data-bs-toggle='modal' data-bs-target='#qrModal" . $row['orderID'] . "' data-order-id='" . $row['orderID'] . "'><i class='fa fa-qrcode'></i></button>";
                      }
                      echo "</td>";
                      echo "</tr>";


                      // Modal for QR code display and scanner
                      echo "<div class='modal fade' id='qrModal" . $row['orderID'] . "' tabindex='-1' aria-labelledby='qrModalLabel' aria-hidden='true'>";
                      echo "<div class='modal-dialog modal-dialog-centered'>";
                      echo "<div class='modal-content'>";
                      echo "<div class='modal-header'>";
                      echo "<h5 class='modal-title' id='qrModalLabel'>QR Code for Order " . $row['orderID'] . "</h5>";
                      echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                      echo "</div>";
                      echo "<div class='modal-body text-center'>";
                      // Generate the QR code with specific fields from the $row array as parameters in the URL
                      echo "<img id='qrImage" . $row['orderID'] . "' src='https://api.qrserver.com/v1/create-qr-code/?data=http://localhost/GP%20(2)/GP/PHARMAVEND/User/QRaccept.php?orderID=" . urlencode($row['orderID']) . "&machine_name=" . urlencode($row['machine_name']) . "&total_amount=" . urlencode($row['total_amount']) . "&products_ordered=" . urlencode($row['products_ordered']) . "' alt='QR Code for Order " . $row['orderID'] . "'>";
                      echo "<div id='reader" . $row['orderID'] . "'></div>"; // Placeholder for QR code scanner
                      echo "<div class='print-message' id='printMessage" . $row['orderID'] . "'></div>"; // Placeholder for print message
                      echo "</div>";
                      echo "<div class='modal-footer'>";
                      echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                      echo "</div>";
                      echo "</div>";
                      echo "</div>";
                      echo "</div>";
                    }
                  } else {
                    echo "<tr><td colspan='8'>No orders found for this user.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div>
      </div>
    </div>
    <?php include('shared/footer.php'); ?>
  </div>



  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp1qxs-8y6j-hqizrIjbY-Y0KdW_qRpXg&callback=initMap"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js" crossorigin="anonymous"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <script src="js/main.js"></script>
  <script src="js/shared.js"></script>
  <script src="https://cdn.jsdelivr.net/gh/davidshimjs/qrcodejs/qrcode.min.js"></script>
  <script src="https://unpkg.com/html5-qrcode"></script>

  <script>
    <?php
    if (mysqli_num_rows($result) > 0) {
      mysqli_data_seek($result, 0); // Reset the result pointer
      while ($row = mysqli_fetch_assoc($result)) {
    ?>
        // Function to handle scan success
        function onScanSuccess<?= $row['orderID'] ?>(decodedText, decodedResult) {
          console.log("Scan Success for Order <?= $row['orderID'] ?>! Data: " + decodedText);
          var printMessage = document.getElementById('printMessage<?= $row['orderID'] ?>');
          printMessage.innerHTML = "Scan Success! Data: " + decodedText;
        }

        // Function to handle scan error
        function onScanError<?= $row['orderID'] ?>(errorMessage) {
          console.error("Scan error for Order <?= $row['orderID'] ?>:", errorMessage);
          // // alert("Error getting userMedia. Please enable camera access in your browser settings.");
        }

        // Initialize QR code reader for each modal after image is loaded
        function initializeScanner<?= $row['orderID'] ?>() {
          var html5QrCode<?= $row['orderID'] ?> = new Html5Qrcode("reader<?= $row['orderID'] ?>");
          html5QrCode<?= $row['orderID'] ?>.start({
            facingMode: "environment" // could also use "user" for front camera
          }, config<?= $row['orderID'] ?>, onScanSuccess<?= $row['orderID'] ?>, onScanError<?= $row['orderID'] ?>);
        }

        // Wait for the QR code image to load before initializing the scanner
        document.getElementById('qrImage<?= $row['orderID'] ?>').onload = function() {
          initializeScanner<?= $row['orderID'] ?>();
        };
    <?php
      }
    }
    ?>
  </script>

  <!-- Include SweetAlert library -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    // Function to check for query parameter and display SweetAlert accordingly
    function checkStatus() {
      const urlParams = new URLSearchParams(window.location.search);
      const status = urlParams.get('status');

      if (status === 'success') {
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'YOU TOOK THE PRODUCTS.',
          showConfirmButton: false,
          timer: 5000 // Close after 2 seconds
        });
      } else if (status === 'error') {
        Swal.fire({
          icon: 'error',
          title: 'Error!',
          text: 'Error updating status.',
          showConfirmButton: false,
          timer: 2000 // Close after 2 seconds
        });
      }
    }

    // Call the function on page load
    window.onload = checkStatus;
  </script>



</body>

</html>