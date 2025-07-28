<!DOCTYPE html>
<html lang="en">

<?php
require_once '../Config/login-register.php';

if (isset($_GET['orderID'])) {
    $orderID = $_GET['orderID'];

    // Fetch transaction data from the database
    $query = "SELECT o.order_items_ID, o.orderID, o.productID, o.quantity, o.subtotal, p.name
            FROM orderitems o
            INNER JOIN product p ON o.productID = p.productID
            WHERE o.orderID = '$orderID'";

    $result = mysqli_query($conn, $query);

    // Check if query execution was successful
    if ($result) {
        $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        echo "An error occurred while fetching orders.";
    }
} else {
    echo "OrderID not provided.";
}
?>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Orders</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    <?php
    include('shared/headerNavBar.php');
    ?>
    <!-- End Header -->

    <!-- ======= Sidebar ======= -->

    <?php
    include('shared/sideNavBar.php');
    ?> <!-- End Sidebar-->


    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Order Items</h1>
            <!--nav>
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Orders</li> 
                  </ol>
                </nav-->
        </div><!-- End Page Title -->


        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"></h5>


                            <table class="table table-bordered border-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">Order Items No.</th>
                                        <th scope="col">Order No.</th>
                                        <th scope="col">Products</th>
                                        <th scope="col">Quantity</th>
                                        <th scope="col">subtotal</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order) : ?>
                                        <tr>
                                            <td><?php echo $order['order_items_ID']; ?></td>
                                            <td><?php echo $order['orderID']; ?></td>
                                            <td><?php echo $order['name']; ?></td>
                                            <td><?php echo $order['quantity']; ?></td>
                                            <td><?php echo $order['subtotal']; ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                <tbody>

                                </tbody>
                            </table>
                            <!-- End Primary Color Bordered Table -->

                        </div>
                    </div>



                </div>


            </div>
        </section>
    </main><!-- End #main -->

    <?php
    // Close the database connection
    $conn->close();
    ?>
    <!-- ======= Footer ======= -->
    <?php
    include('shared/footer.php')
    ?>
    <!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/shared.js"></script>

</body>

</html>