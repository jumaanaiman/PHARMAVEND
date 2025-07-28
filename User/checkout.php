<?php
require_once '../Config/vm.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>PharmaVend </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" href="images/logo.png">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

    <?php include('shared/header.php');
    ?>

    <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <a href="cart.php">Cart</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">Checkout</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">

        <div class="row justify-content-center align-items-center" style="min-height: 70vh;">

          <div class="col-md-6">

            <div class="d-flex align-items-center justify-content-center">
              <div class="container">
                <div class="row justify-content-center">
                  <div class="col-md-12">
                    <div class="row mb-5">
                      <div class="col-md-12">
                        <h2 class="h3 mb-3 text-black">Your Order</h2>
                        <div class="p-3 p-lg-5 border">
                          <table class="table site-block-order-table mb-5">
                            <thead>
                              <tr>
                                <th>Product</th>
                                <th>Total</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              // Assuming you already have session_start() and getCartDetailsByUserId() function defined

                              // Retrieve cart items
                              $cartItems = getCartDetailsByUserId($_SESSION['user_id']);
                              $total = 0;
                              if (!is_null($cartItems) && count($cartItems) > 0) {
                                $firstItem = $cartItems[0];  // Access the first item in the array
                                if (!is_null($firstItem) && is_array($firstItem)) {
                                  $machineId = $firstItem['machine_id'];  // Extract the machine_id
                                  foreach ($cartItems as $item) : ?>
                                    <tr>
                                      <td><?= htmlspecialchars($item['name']) ?> <strong class="mx-2">x</strong> <?= $item['quantity'] ?></td>
                                      <td>$<?= number_format($item['totalAmount'], 2) ?></td>
                                    </tr>
                                    <?php $total += $item['totalAmount'] * $item['quantity']; ?>
                              <?php endforeach;
                                } else {
                                  $machineId = null;
                                  echo "Your cart seems to have an unexpected format."; // Improved message for clarity
                                }
                              } else {
                                echo "Your cart is empty."; // This handles the case where $cartItems is null or empty
                              }
                              ?>

                              <tr>
                                <td class="text-black font-weight-bold"><strong>Order Total</strong></td>
                                <td class="text-black font-weight-bold"><strong>$<?= number_format($total, 2) ?></strong></td>
                              </tr>

                            </tbody>
                          </table>

                          <p>Product information <span style="color: #999; font-size: 14px;">(Prices shown include applicable taxes.)</span></p>


                          <div class="form-group">
                            <button type="submit" class="btn btn-success" name="check_out_btn" style="display: none;">Checkout</button>
                            <div id="paypal-button-container" class="mt-3"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>


    <?php include('shared/footer.php'); ?>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>
  <!-- Replace "test" with your own sandbox Business account app client ID -->
  <script src="https://www.paypal.com/sdk/js?client-id=AShNYaBVlK9-fD2nR_eBe4z3FnLOzMH-b4p-WfH_8JQXpyOsh9VkrTT27tafEu6khIomICUKDSmUNra-"></script>
  <script>
    // JavaScript to handle payment method selection
    // document.getElementById('payOrderBtn').addEventListener('click', function() {
    //   // Hide the "Pay Order" button
    //   this.style.display = 'none';
    //   // Show the payment method section
    //   document.getElementById('paymentMethodSection').style.display = 'block';
    // });
  </script>
  <script>
    var jsTotal = <?= json_encode($total, JSON_NUMERIC_CHECK); ?>;
    var jsUserId = <?= json_encode($_SESSION['user_id'], JSON_NUMERIC_CHECK); ?>;
    var jsMachineId = <?= json_encode($machineId, JSON_NUMERIC_CHECK); ?>; // Now correctly passing $machineId
    console.log("Total: ", jsTotal);
    console.log("User ID: ", jsUserId);
    console.log("Machine ID: ", jsMachineId);
  </script>
  <script>
    paypal.Buttons({
      onClick() {

      },

      createOrder: (data, actions) => {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: jsTotal.toString(),
              currency_code: 'USD'
            }
          }]
        });
      },
      onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
          const transaction = orderData.purchase_units[0].payments.captures[0];
          console.log(orderData)
          if (transaction.status === "COMPLETED") {
            const body = JSON.stringify({
              userId: jsUserId.toString(),
              amount: orderData.purchase_units[0].amount.value,
              paymentStatus: orderData.status,
              paymentMethod: '1',
              machineId: jsMachineId.toString()
            })
            fetch('../Config/processPayment.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json'
                },
                body: body
              }).then(response => response.json())
              .then(data => {
                console.log('Success:', data);
                if (data.status == 'success') {
                  window.location.href = 'thankyou.php?status=1';
                } else {
                  window.location.href = 'thankyou.php?status=2';
                }
                // window.location.href = 'thankyou.php'; // Redirect after processing
              });
          } else {
            window.location.href = 'thankyou.php?status=2';
          }
        });
      }
    }).render('#paypal-button-container');
  </script>
  <script src="js/main.js"></script>

</body>

</html>