<?php
require_once '../Config/vm.php';

// Start the session
session_start();

// Fetch the user ID from the session
$userID = $_SESSION['user_id'];
$query = "SELECT full_name FROM user WHERE user_id = $userID";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
  // Fetch the row from the result set
  $row = mysqli_fetch_assoc($result);

  // Extract the username from the row
  $username = $row['full_name'];
} else {
  // Handle the case where the query failed
  echo "Error fetching username.";
}
// Fetch the orderID from the URL parameter
$orderID = $_GET['orderID'];

// Fetch order details from the database based on the orderID
$query = "SELECT orders.orderID,
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
          WHERE orders.orderID = $orderID AND orders.userID = $userID";

$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
  // Fetch the row from the result set
  $row = mysqli_fetch_assoc($result);

  // Extract the required information from the row
  $machine_name = $row['machine_name'];
  $total_amount = $row['total_amount'];
  $products_ordered = $row['products_ordered'];
} else {
  // Handle the case where the query failed
  echo "Error fetching order details.";
}
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
  <link rel="stylesheet" href="css/aos.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/custom.css">


</head>

<body class="p-3">
  <div class="site-wrap d-flex flex-column justify-content-center align-items-center" style="border: 9px solid #188DB7;">
    <!-- PharmaVend logo -->
    <img src="images/logo.png" alt="PharmaVend Logo" class="mb-3">

    <!-- Machine name -->
    <div class="site-section text-center">
      <div class="container px-2">
        <div class="row">
          <div class="col-md-12">
            <h2 class="h5 mb-3" style="color: #0B465C;">Machine Name: <?php echo $machine_name; ?></h2>
            <p class="mb-0"></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Order table -->
    <div class="site-section text-center" style="margin-top: 20px;">
      <div class="container px-2">
        <div class="table-responsive center-table" style="height: 300px;">
          <table class="table-responsive table-borderless">
            <thead class="order-table">
              <tr class="bg-light">
                <th scope="col" width="50%">Product Name</th>
                <th scope="col" width="20%">Quantity</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Split products_ordered into an array of product name and quantity pairs
              $products = explode(", ", $products_ordered);
              foreach ($products as $product) {
                // Split each product name and quantity pair
                $product_details = explode(" x", $product);
                $product_name = $product_details[0];
                $quantity = $product_details[1];
              ?>
                <tr>
                  <td><?php echo $product_name; ?></td>
                  <td><?php echo $quantity; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>

        <!-- Accept button -->
        <form id="statusForm" method="post" action="../CONFIG/update_status.php">
          <input type="hidden" name="orderId" value="<?php echo $orderID; ?>">
          <button type="submit" class="btn btn-primary btn-sm" style="background-color: #178DB7;">Accept QR code and dispense <?php echo $username; ?> products </button>
        </form>

      </div>
    </div>
  </div>
</body>



</html>