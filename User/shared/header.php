<?php
require_once '../Config/vm.php';

include '../Config/login-register.php';
// Check if user is logged in
$userLoggedIn = isset($_SESSION['user_id']);

?>
<div class="top-header bg-light py-5rem bg-special-color">
  <div class="container">
    <div class="d-flex align-items-center justify-content-end">
      <div class="sign-in">
        <?php

        if ($userLoggedIn) {
          echo '<a href="signout.php" class="text-primary">Sign Out</a>';
        } else {
          echo '<a href="login.php" class="text-primary">Sign In</a>';
        }
        ?>
      </div>
    </div>
  </div>
</div>

<div class="site-navbar py-2">
  <div class="search-wrap">
    <div class="container">
      <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
      <form action="#" method="post">
        <input type="text" class="form-control" placeholder="Search keyword and hit enter...">
      </form>
    </div>
  </div>

  <div class=" container-header ">
    <div class="d-flex align-items-center justify-content-between widthfull">
      <div class="logo">
        <div class="site-logo">
          <a href="index.php">
            <img class="logo-pharmaven" src="images/pharmavendlogo.png" alt="">
          </a>
        </div>
      </div>
      <div class="main-nav d-none d-lg-block">
        <nav class="site-navigation text-right text-md-center" role="navigation">
          <ul class="site-menu js-clone-nav d-none d-lg-block">
            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"><a href="index.php">Home</a></li>
            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'vendingmachine.php') ? 'active' : ''; ?>"><a href="vendingmachine.php">Vending Machines</a></li>
            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>"><a href="about.php">About Us</a></li>
            <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
          </ul>
        </nav>
      </div>
      <div class="icons">
        <!-- Cart Icon -->
        <?php if ($userLoggedIn) : ?>
          <a href="cart.php" class="icons-btn d-inline-block bag">
            <span class="icon-shopping-bag"></span>
            <?php
            // Fetch cart contents for the current user
            $cartContents = getCartDetailsByUserId($_SESSION['user_id']); // Assuming $_SESSION['user_id'] contains the user ID

            // Initialize a variable to store the total quantity
            $totalQuantity = 0;

            // Iterate over the cart contents and sum up the quantities
            foreach ($cartContents as $item) {
              $totalQuantity += $item['quantity'];
            }
            ?>
            <!-- Display the total quantity -->
            <span class="number"><?php echo $totalQuantity; ?></span>
          </a>

          <!-- User Dropdown -->
          <i class="fa fa-user-circle user-btn" aria-hidden="true" id="dropdownMenuReference" data-toggle="dropdown"></i>
          <div class="dropdown-menu user-dropdown" aria-labelledby="dropdownMenuReference">
            <a class="dropdown-item" href="userprofile.php">My profile</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="orders.php">Orders</a>
          </div>
        <?php endif; ?>
        <!-- Mobile Menu Toggle -->
        <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><span class="icon-menu"></span></a>
      </div>
    </div>
  </div>
</div>