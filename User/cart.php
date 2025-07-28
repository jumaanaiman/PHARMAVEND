<?php
require_once '../Config/vm.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>PharmaVend </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <link rel="stylesheet" href="path/to/your/styles.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <div class="site-wrap">


    <?php include('shared/header.php'); ?>
    <?php



    $cartItems = getCartDetailsByUserId($_SESSION['user_id']);
    // Default URL if referer is not available
    $url = "vendingmachine.php";

    // Check if there is a referer and cart is empty
    if (empty($cartItems) && isset($_SERVER['HTTP_REFERER'])) {
      $url = "vendingmachine.php"; // Use the referer as the URL to go back to
    } elseif (!empty($cartItems)) {
      // If cart is not empty, continue with existing logic
      $firstCartItem = $cartItems[0]; // Get the first item from the cart items array
      $machineId = $firstCartItem['machine_id']; // Get the machine_id
      $url = "products.php?vmId=" . $machineId; // Create the URL with the machine_id as a query parameter
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_all'])) {
      emptyCartByUserId($_SESSION['user_id']);

      // Redirect to avoid form resubmission
      header('Location: ' . $_SERVER['PHP_SELF']);
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_product'])) {
      $productId = $_POST['product_id'];  // Get the product ID from the form
      deleteProductById($_SESSION['user_id'], $productId);

      // Redirect to avoid form resubmission
      header('Location: ' . $_SERVER['PHP_SELF']);
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_product'])) {
      $productID = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
      $updatedQuantity = isset($_POST['updated_quantity']) ? intval($_POST['updated_quantity']) : null;
      if ($productID && $updatedQuantity && $updatedQuantity > 0) {
        // Check if the product exists in the cart
        $firstCartItem = $cartItems[0]; // Get the first item from the cart items array
        $machineId = $firstCartItem['machine_id'];
        $message = updateProductQuantity(intval($_SESSION['user_id']), $machineId, $productID, $updatedQuantity);
        // echo $message;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
      }
      // Redirect to avoid form resubmission
      header('Location: ' . $_SERVER['PHP_SELF']);
      exit();
    }



    ?>

    <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Cart</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <?php if (!empty($message)) : ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($message) ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
      <div class="container">
        <?php if (!empty($cartItems)) : ?>
          <div class="row justify-content-end">
            <div class="col-auto">
              <!-- Button for removing all products -->
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteConfirmModal">
                Remove all Products
              </button>
            </div>

            <!-- Modal for confirming the removal of all products -->
            <div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    Are you sure you want to delete all products from the cart?
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form method="post" action="" style="display:inline;">
                      <button type="submit" name="delete_all" class="btn btn-danger">Delete All</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="row mb-5">



          <form class="col-md-12" method="post" action="">
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Image</th>
                    <th class="product-name">Product</th>
                    <th class="product-price">Price</th>
                    <th class="product-quantity">Quantity</th>
                    <th class="product-total">Total</th>
                    <th>Remove</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (empty($cartItems)) : ?>
                    <tr>
                      <td colspan="6" class="text-center">No products added to cart.</td>
                    </tr>
                  <?php else : ?>
                    <?php foreach ($cartItems as $product) : ?>
                      <tr>
                        <td class="product-thumbnail">
                          <img src="../Admin/<?= htmlspecialchars($product['img']) ?>" alt="Product Image" class="img-fluid">
                        </td>
                        <td class="product-name">
                          <h2 class="h5 text-black"><?= htmlspecialchars($product['name']) ?></h2>
                        </td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                        <td>
                          <div class="input-group mb-3" style="max-width: 120px;">
                            <div class="input-group-prepend">
                              <button class="btn btn-outline-secondary" type="button" onclick="decreaseQuantity(<?= $product['productID'] ?>)">-</button>
                            </div>
                            <input type="text" class="form-control text-center" name="quantity-<?= $product['productID'] ?>" id="quantity-<?= $product['productID'] ?>" value="<?= isset($_POST['quantity-' . $product['productID']]) ? htmlspecialchars($_POST['quantity-' . $product['productID']]) : htmlspecialchars($product['quantity']) ?>" aria-label="Quantity" aria-describedby="button-addon1">
                            <div class="input-group-append">
                              <button class="btn btn-outline-secondary" type="button" onclick="increaseQuantity(<?= $product['productID'] ?>)">+</button>
                            </div>
                          </div>
                        </td>
                        <td>$<?= htmlspecialchars($product['totalAmount']) ?></td>
                        <td>
                          <form method="post" action="">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['productID']) ?>">
                            <input type="hidden" name="updated_quantity" id="updated-quantity-<?= $product['productID'] ?>" value="<?= isset($_POST['quantity-' . $product['productID']]) ? htmlspecialchars($_POST['quantity-' . $product['productID']]) : '1' ?>">
                            <button type="submit" name="edit_product" class="btn btn-primary">Update Qauntity</button>
                            <button type="submit" name="delete_product" class="btn btn-danger">X</button>
                          </form>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>

                </tbody>

              </table>
            </div>

          </form>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="row mb-5 d-flex justify-content-end">
              <div class="col-md-6 mb-3 mb-md-0">
                <button class="btn btn-primary btn-md btn-block" onclick="window.location='<?php echo isset($_SESSION['previous_url']) ? htmlspecialchars($_SESSION['previous_url']) : "vendingmachine.php"; ?>'">Go back to continue</button>

              </div>
              <?php if (!empty($cartItems)) : ?>
                <div class="col-md-6">
                  <button class="btn btn-outline-primary btn-md btn-block" onclick="window.location='checkout.php'">Proceed To Checkout</button>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>

      </div>
    </div>



    <?php include('shared/footer.php'); ?>



  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

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
  <!-- JAVA Script to increase ,decrease,and update quantity- -->
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

    function increaseQuantity(productId) {
      var quantityInput = document.getElementById('quantity-' + productId);
      quantityInput.value = parseInt(quantityInput.value) + 1;
      updateFormQuantity(productId);
    }

    function decreaseQuantity(productId) {
      var quantityInput = document.getElementById('quantity-' + productId);
      if (quantityInput.value > 1) { // Prevent decreasing below 1
        quantityInput.value = parseInt(quantityInput.value) - 1;
        updateFormQuantity(productId);
      }
    }

    function updateFormQuantity(productId) {
      var quantityInput = document.getElementById('quantity-' + productId);
      var updatedQuantityInput = document.getElementById('updated-quantity-' + productId);
      updatedQuantityInput.value = quantityInput.value;
    }
  </script>
</body>

</html>