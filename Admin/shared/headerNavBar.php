<?php
require_once '../Config/login-register.php';

if (!isset($_SESSION['user_id'])) {
  // Redirect the user to the login page
  header("Location: ../User/login.php");
  exit();
} else {
  $user_id = $_SESSION['user_id'];
  $userInfo = getUserInfo($conn, $user_id);
  $full_name = $userInfo['full_name'];

  $query = "SELECT ContactID, full_name, comment FROM contact ORDER BY ContactID DESC LIMIT 3";
  $result = mysqli_query($conn, $query);

  // Count the number of messages retrieved
  $num_messages = mysqli_num_rows($result);


  // Function to fetch notifications for products with quantity less than 5
  function getLowQuantityNotifications()
  {
    global $conn;

    // Query to fetch notifications
    $query = "SELECT p.productID, p.name AS product_name, vm.machine_id, vm.quantity 
              FROM product_vendingmahcine vm 
              INNER JOIN product p ON vm.productID = p.productID 
              WHERE vm.quantity < 5";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $notifications = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    return $notifications;
  }

  // Fetch notifications
  $notifications = getLowQuantityNotifications();
}


?>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">

    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div>

  <div class="search-bar">

    <a href="index.php" class="logo ">
      <img src="assets/img/logo.png" alt="">
    </a>
  </div>

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <li class="nav-item d-block d-lg-none">
        <a class="nav-link nav-icon search-bar-toggle " href="#">
          <i class="bi bi-search"></i>
        </a>
      </li>

      <!-- Notification Nav -->
      <li class="nav-item dropdown">
        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-bell"></i>
          <span class="badge bg-primary badge-number"><?php echo count($notifications); ?></span>
        </a>
        <!-- End Notification Icon -->
        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
          <li class="dropdown-header">
            You have <?php echo count($notifications); ?> new notifications
          <li>
            <hr class="dropdown-divider">
          </li>
          <?php foreach ($notifications as $notification) : ?>
            <div class="notification-wrapper">
              <ul class="notification-list">
                <li class="notification-item">
                  <i class="bi bi-exclamation-circle text-warning"></i>
                  <div>
                    <h4><?php echo $notification['product_name']; ?></h4>
                    <p>Quantity in Vending Machine <?php echo $notification['machine_id']; ?> is less than 5.</p>
                  </div>
                </li>
              </ul>

            </div>
            <li>
              <hr class="dropdown-divider">
            </li>
          <?php endforeach; ?>
        </ul><!-- End Notification Dropdown Items -->
      </li><!-- End Notification Nav -->

      <!-- Other navigation items... -->

      <li class="nav-item dropdown">

        <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
          <i class="bi bi-chat-left-text"></i>
          <span class="badge bg-success badge-number"><?php echo $num_messages; ?></span>
        </a><!-- End Messages Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
          <li class="dropdown-header">
            You have <?php echo $num_messages; ?> new messages
            <a href="feedbacks.php"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <?php
          // Iterate over the fetched messages and populate the list items
          while ($row = mysqli_fetch_assoc($result)) {
            $fullName = $row['full_name'];
            $comment = $row['comment'];
          ?>

            <li class="message-item">
              <a href="#">
                <div>
                  <h4>User: <?php echo $fullName; ?></h4>
                  <p><?php echo $comment; ?></p>
                  <p><?php echo date('Y-m-d H:i:s'); ?></p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

          <?php
          }
          ?>

        </ul><!-- End Messages Dropdown Items -->
      </li><!-- End Messages Nav -->

      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="assets/img/user .png" alt="Profile" class="rounded-circle">
          <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $full_name; ?></span>
        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6><?php echo $full_name; ?></h6>
            <span>Administrator</span>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="profileadmin.php">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>


          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="../User/signout.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Log Out</span>
            </a>
          </li>

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header><!-- End Header -->