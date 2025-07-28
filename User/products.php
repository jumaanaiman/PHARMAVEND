<?php

require_once '../Config/vm.php';
session_start();
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI'];
$vmId = isset($_GET['vmId']) ? htmlspecialchars($_GET['vmId']) : '';
$vendingmachines = getVMdetailsByVendingMachineId($vmId);
$products = getProductsByVendingMachineId($vmId);

?>
<!DOCTYPE html>
<html lang="en">

<head>
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
            <a href="vendingmachine.php">All Vending Machines</a>
            <span class="mx-2 mb-0">/</span>
            <strong class="text-black">
              <?php
              if (!empty($vendingmachines)) {
                foreach ($vendingmachines as $vm) {
                  if (!empty($vm['name'])) {
                    echo htmlspecialchars($vm['name']) . ' products';
                    break;
                  }
                }
              } else {

                echo 'Products';
              }
              ?>
            </strong>
          </div>
        </div>
      </div>
    </div>







    <div class="site-section bg-light">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-3">
            <img src="images/vm.png" alt="Vending Machine" class="imgpharmavend">
          </div>
          <div class="col-lg-3">
            <?php if (!empty($vendingmachines)) : ?>
              <?php foreach ($vendingmachines as $vm) : ?>
                <h4 class="text-black font-weight-bold"><?php echo htmlspecialchars($vm['name']); ?></h4>

                <div class="p-4 mb-3" style="margin-left: -20px;">
                  <?php if (!empty($vm['city'])) : ?>
                    <span class="d-block text-black h6 text-uppercase"><?php echo htmlspecialchars($vm['city']); ?></span>
                  <?php endif; ?>

                  <?php if (!empty($vm['university_name'])) : ?>
                    <span class="d-block text-black h6 text-uppercase"><?php echo htmlspecialchars($vm['university_name']); ?></span>
                  <?php endif; ?>

                  <?php if (!empty($vm['address'])) : ?>
                    <span class="d-block text-black h6 text-uppercase"><?php echo htmlspecialchars($vm['address']); ?></span>
                  <?php endif; ?>

                  <?php if (!empty($vm['mall_name'])) :
                  ?>
                    <span class="d-block text-black h6 text-uppercase"><?php echo htmlspecialchars($vm['mall_name']); ?></span>
                  <?php endif; ?>
                  <?php if (!empty($vm['mall_name'])) :
                  ?>
                    <span class="d-block text-black h6 text-uppercase"><?php echo htmlspecialchars($vm['location']); ?></span>
                  <?php endif; ?>
                  <?php if (!empty($vm['status'])) :
                  ?>
                    <span class="d-block text-black h6 text-uppercase"><?php echo htmlspecialchars($vm['status']); ?></span>
                  <?php endif; ?>






                </div>
              <?php endforeach; ?>
            <?php endif; ?>



          </div>
        </div>
      </div>

    </div>

    <div class="site-section ">
      <div class="container">



        <div class="row">
          <?php if (!empty($products)) : ?>
            <?php foreach ($products as $product) : ?>
              <div class="col-sm-6 col-lg-4 text-center item mb-4 item-v2">
                <!-- Assuming $machine['isSale'] determines if the machine is on sale -->
                <a href="shop-single.php?productId=<?php echo htmlspecialchars($product['productID']); ?>&vmId=<?php echo htmlspecialchars($product['machine_id']); ?>">

                  <img src="../Admin/<?= $product['img']; ?>" alt="Image" style="
                        width: 11em;
                        height: 11em;
                    ">
                </a>
                <!-- Assuming $machine['name'] contains the name of the vending machine -->
                <h3 class="text-dark">
                  <a href="shop-single.php?productId=<?php echo htmlspecialchars($product['productID']); ?>&vmId=<?php echo htmlspecialchars($product['machine_id']); ?>"><?php echo htmlspecialchars($product['name']); ?></a>
                </h3>
                <!-- Assuming $machine['price'] contains the price of the vending machine -->
                <p class="price">$<?php echo $product['price']; ?></p>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <div class="row mt-5">
          <div class="col-md-12 text-center">
            <div class="site-block-27">
              <ul>
                <li><a href="#">&lt;</a></li>
                <li class="active"><span>1</span></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
                <li><a href="#">&gt;</a></li>
              </ul>
            </div>
          </div>
        </div>
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
</body>

</html>