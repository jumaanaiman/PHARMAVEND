<?php

require_once '../Config/vm.php';
session_start(); // Start the session
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
$vmId = isset($_GET['vmId']) ? htmlspecialchars($_GET['vmId']) : '';
$vendingmachines = getVendingMachineId($vmId);
$productId = isset($_GET['productId']) ? htmlspecialchars($_GET['productId']) : '';
if (isset($_GET['productId'])) {

  $productId = intval($_GET['productId']);
  $product = getProductDetailsById($productId);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>PharmaVend</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="icon" href="images/logo.png">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>


<body>

  <div class="site-wrap">

    <?php include('shared/header.php'); ?>




    <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0"><a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <a href="vendingmachine.php">All Vending Machines</a> <span class="mx-2 mb-0">/</span>
            <?php
            if (!empty($vendingmachines['name'])) {
              echo '<a href="products.php?vmId=' . $vmId . '">' . htmlspecialchars($vendingmachines['name']) . ' Products</a>';
            }
            ?>
            <span class="mx-2 mb-0">/</span>
            <?php
            if (!empty($product['name'])) {
              echo '<strong class="text-black">' . htmlspecialchars($product['name']) . '</strong>';
            }
            ?>


          </div>
        </div>
      </div>
    </div>
    <?php
    function addToCartSingle($conn, $userId, $productId, $quantity, $machineId)
    {
      $checkCartStmt = $conn->prepare("SELECT machine_id FROM cart WHERE userID = ? LIMIT 1");
      $checkCartStmt->bind_param("i", $userId);
      $checkCartStmt->execute();
      $checkCartResult = $checkCartStmt->get_result();

      if ($checkCartResult->num_rows > 0) {
        $firstCartItem = $checkCartResult->fetch_assoc();
        $firstMachineId = $firstCartItem['machine_id'];
        // Compare the machine IDs
        if ($firstMachineId !== $machineId) {
          return "You are buying from another vending machine.";
        }
      }

      $availStmt = $conn->prepare("SELECT quantity FROM product_vendingmahcine  WHERE machine_id = ? AND ProductID = ?");
      $availStmt->bind_param("ii", $machineId, $productId);
      $availStmt->execute();
      $availResult = $availStmt->get_result();

      if ($availResult->num_rows == 0) {
        return "This product is not available in the selected vending machine.";
      }

      $availableQuantity = $availResult->fetch_assoc()['quantity'];
      if ($quantity > $availableQuantity) {
        return "Cannot add to cart, exceeds available stock.";
      }

      // Check if the product is already in the cart
      $checkStmt = $conn->prepare("SELECT quantity FROM cart WHERE userID = ? AND productID = ?");
      $checkStmt->bind_param("ii", $userId, $productId);
      $checkStmt->execute();
      $result = $checkStmt->get_result();

      global $product; // Assuming $product is defined and accessible
      $price = $product['price'];

      if ($result->num_rows > 0) {
        // Product exists in the cart, update it
        $currentQuantity = $result->fetch_assoc()['quantity'];
        $newQuantity = $currentQuantity + $quantity;
        if ($newQuantity > $availableQuantity) {
          return "Update exceeds available stock in vending machine.";
        }
        $newTotalAmount = $price * $newQuantity;
        $updateStmt = $conn->prepare("UPDATE cart SET quantity = ?, totalAmount = ? WHERE userID = ? AND productID = ?");
        $updateStmt->bind_param("idii", $newQuantity, $newTotalAmount, $userId, $productId);
        if ($updateStmt->execute()) {
          return "Product quantity updated in cart successfully!";
        } else {
          return "Failed to update product in cart.";
        }
      } else {
        // Product does not exist, insert new record in cart
        $totalAmount = $price * $quantity;
        $insertStmt = $conn->prepare("INSERT INTO cart (totalAmount, quantity, price, userID, productID, machine_id) VALUES (?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("diidii", $totalAmount, $quantity, $price, $userId, $productId, $machineId);
        if ($insertStmt->execute()) {
          return "Product added to cart successfully!";
        } else {
          return "Failed to add product to cart.";
        }
      }
    }





    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addToCart'])) {
      $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
      if (!isset($_SESSION['user_id'])) {
        $_SESSION['login_required'] = true;
        $message = 'You need to <a href="login.php">Sign In</a> to add items to the cart.';
      } else {
        $userId = $_SESSION['user_id']; // Retrieve userId stored in session
        $productId = isset($_GET['productId']) ? intval($_GET['productId']) : null;
        $machineId = isset($_GET['vmId']) ? intval($_GET['vmId']) : null;

        // Call the function and capture the return message
        $message = addToCartSingle($conn, $userId, $productId, $quantity, $machineId);

        // Store the message in session or use other methods to pass to the redirected page
        $_SESSION['message'] = $message;

        // Redirect to the same page or to another one
        header('Location: ' . $_SERVER['PHP_SELF'] . '?productId=' . $productId . '&vmId=' . $machineId);
        exit();
      }
    }

    // Display the message from session if set
    if (isset($_SESSION['message'])) {
      $message = $_SESSION['message'];
      unset($_SESSION['message']); // Clear the message from session
    }

    ?>
    <?php if (isset($message)) : ?>
      <div class="alert alert-<?php echo strpos($message, 'successfully') !== false ? 'success' : 'danger'; ?>" role="alert">
        <?php echo $message; ?>
      </div>
      <script>
        $(document).ready(function() {
          $(".alert").delay(5000).slideUp(500); // Hide the alert after 5 seconds
        });
      </script>
    <?php endif; ?>



    <div class="site-section">
      <div class="container">
        <?php
        if (isset($_GET['productId'])) {
          if ($product) {
            echo '<div class="row">';
            echo '<div class="col-md-5 mr-auto">';
            echo '<div class="border text-center">';
            echo "<img src='../Admin/{$product['img']}' alt='Product Image' class='img-fluid p-5'>";
            echo '</div>';
            echo '</div>';
            echo '<div class="col-md-6">';
            echo "<h2 class='text-black'>{$product['name']}</h2>";
            echo "<p>{$product['description']}</p>";
            echo "<p><strong class='text-primary h4'>$ {$product['price']}</strong></p>";
            echo '<form method="post" action="">'; // Form to handle add to cart
            echo '<div class="mb-5">';
            echo '<div class="input-group mb-3" style="max-width: 220px;">';
            echo '<div class="input-group-prepend">';
            echo '<button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>';
            echo '</div>';
            echo '<input type="text" name="quantity" class="form-control text-center" value="1" placeholder="" aria-label="Quantity" aria-describedby="button-addon1">';
            echo '<div class="input-group-append">';
            echo '<button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>';
            echo '</div>';
            echo '</div>';
            echo '<button type="submit" name="addToCart" class="buy-now btn btn-sm height-auto px-4 py-3 btn-primary">Add To Cart</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
          } else {
            echo "Product not found";
          }
        } else {
          echo "Product ID not provided";
        }
        ?>
      </div>

    </div>



    <!-- <div id="footer-user"></div> -->
    <?php include('shared/footer.php'); ?>
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
  <script>
    $(document).ready(function() {
      $(".alert").delay(5000).slideUp(500); // Hide the alert after 5 seconds

      // Check if the login required message exists and fade it out after 20 seconds
      if ($(".alert-danger").length > 0) {
        $(".alert-danger").delay(20000).fadeOut(500);
      }
    });
  </script>

</body>

</html>