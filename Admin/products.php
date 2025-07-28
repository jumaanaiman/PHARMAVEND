<?php
session_start();
// Include the database connection file 
require_once '../Config/user.php';
// Check if the vending machine ID is provided in the URL
$type = '';
if (isset($_GET['vendingMachineID'])) {
  $vendingMachineID = $_GET['vendingMachineID'];
  $products = getAllProducts();
  if (isset($_GET['name'])) {
    $vendingMachineName = $_GET['name'];
  } else {
    $vendingMachineName = null;
  }
} else {
  // If vending machine ID is not provided, redirect or show an error message
  // For now, let's set a default ID
  $vendingMachineID = null;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['editVmProduct'])) {
  $productID = $_POST['productName'];  // This holds the productID selected in the dropdown
  $quantity = $_POST['productQuantity'];

  // Validate and sanitize inputs
  $productID = filter_var($productID, FILTER_SANITIZE_NUMBER_INT);
  $quantity = filter_var($quantity, FILTER_SANITIZE_NUMBER_INT);


  // Insert into database
  $result  = addProductToVendingMachine($productID, $quantity, $vendingMachineID);
  $type = $result['type'];
  $_SESSION['alertMessage'] = "<div class='alert alert-" . $result['type'] . "' role='alert'>" . htmlspecialchars($result['message']) . "</div>";
  session_write_close();
  // Redirect to avoid form resubmission
  session_write_close();
  header('Location: ' . $_SERVER['PHP_SELF'] . '?vendingMachineID=' . $vendingMachineID);
  exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
  $action_parts = explode('_', $_POST['action']);
  if ($_POST['action'] === 'delete') {
    // Handle delete
    $productID = $_POST['productID'];
    $machine_id = $_POST['machine_id'];
    $result = deleteProductVm($productID, $machine_id);
    $type = $result['type'];
    $_SESSION['alertMessage'] = "<div class='alert alert-" . $result['type'] . "' role='alert'>" . $result['message'] . "</div>";
  } elseif (count($action_parts) === 3 && $action_parts[0] === 'edit') {
    // Handle edit
    $productID = $action_parts[1];
    $machine_id = $action_parts[2];
    $newQuantity = $_POST['newQuantity'];
    $result = updateProductQuantity($productID, $machine_id, $newQuantity);
    $type = $result['type'];
    $_SESSION['alertMessage'] = "<div class='alert alert-" . $result['type'] . "' role='alert'>" . $result['message'] . "</div>";
  } else {
    $_SESSION['alertMessage'] = "<div class='alert alert-danger' role='alert'>Invalid request.</div>";
  }
  session_write_close();
  header('Location: ' . $_SERVER['PHP_SELF'] . '?vendingMachineID=' . $vendingMachineID);
  exit();
}

$alertMessage = $_SESSION['alertMessage'] ?? null;
//unset($_SESSION['alertMessage']);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PharmaVend/PRODUCTS</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="icon" href="assets/img/logo1.png">

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
  ?>
  <!-- End Sidebar-->

  <main id="main" class="main">
    <?php if ($vendingMachineName) : ?>
      <div class="pagetitle">
        <h1>Vending Machine <?php echo $vendingMachineName; ?> products</h1>
      </div>
    <?php endif; ?>
    <div class="row">
      <div class="col-lg-12">
        <div class="card">

          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <h5 class="card-title "></h5>
              </div>
              <div class="col-md-4">
                <h1 class="card-title text-end"> <a href="#" id="openVmModal" data-bs-toggle="modal" data-bs-target="#basicModal">Add New Vending products</a></h1>
              </div>
            </div>


            <div class="modal fade" id="basicModal" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Add a New Vending Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form id="editProductForm" method="post">
                    <div class="modal-body">
                      <!-- Product Name Dropdown -->
                      <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <select class="form-control" id="productName" name="productName">
                          <?php foreach ($products as $product) { ?>
                            <option value="<?php echo htmlspecialchars($product['productID']); ?>">
                              <?php echo htmlspecialchars($product['name']); ?>
                            </option>
                          <?php } ?>
                        </select>
                      </div>
                      <!-- Quantity Input -->
                      <div class="mb-3">
                        <label for="productQuantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="productQuantity" placeholder="Quantity" name="productQuantity">
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                      <button type="submit" name="editVmProduct" class="btn btn-primary" id="saveChangesButton">Save Changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">
            <script>
              <?php
              // Determine the icon based on the message type
              $icon = '';
              switch ($type) {
                case 'success':
                  $icon = 'success';
                  break;
                case 'warning':
                  $icon = 'warning';
                  break;
                case 'error':
                  $icon = 'error';
                  break;
                default:
                  $icon = 'info';
                  break;
              }
              ?>
              <?php if (isset($_SESSION['alertMessage'])) : ?>
                Swal.fire({
                  title: 'Alert',
                  html: `<?php echo $_SESSION['alertMessage']; ?>`,
                  icon: '<?php echo $icon; ?>'
                });
                <?php unset($_SESSION['alertMessage']); ?>
              <?php endif; ?>
            </script>

            <table class="table table-bordered border-primary">
              <thead>
                <tr>
                  <th scope="col">ID</th>
                  <th scope="col">Name</th>
                  <th scope="col">Photo</th>

                  <th scope="col">Price</th>
                  <th scope="col" style="width: 9em;">Quantity</th>
                  <th scope=" col" style="
                        width: 8em;
                    "></th>
                </tr>
              </thead>
              <tbody>
                <?php
                include('../Config/config.php');

                // Check if the vending machine ID is provided in the URL
                if (isset($_GET['vendingMachineID'])) {
                  $vendingMachineID = $_GET['vendingMachineID'];
                } else {
                  // If vending machine ID is not provided, redirect or show an error message
                  // For now, let's set a default ID
                  $vendingMachineID = 1;
                }


                // Your database query
                $query = "SELECT product.*,product_vendingmahcine.machine_id , product_vendingmahcine.quantity AS vm_quantity FROM product 
                            INNER JOIN product_vendingmahcine 
                            ON product.productID = product_vendingmahcine.ProductID 
                            WHERE product_vendingmahcine.machine_id = ?";
                $stmt = mysqli_prepare($conn, $query);

                // Check if prepare was successful
                if ($stmt) {
                  // Bind parameters
                  mysqli_stmt_bind_param($stmt, "i", $vendingMachineID);

                  // Execute query
                  mysqli_stmt_execute($stmt);

                  // Get result
                  $result = mysqli_stmt_get_result($stmt);

                  // Display products
                  if ($result) {
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        // Output product details
                        echo "<form action='' method='post'>";
                        echo "<tr>";
                        echo "<th scope='row'>" . $row['productID'] . "</th>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td><img src='" . $row['img'] . "' width='150' height='150' alt=''></td>";
                        echo "<td>" . $row['price'] . " JD</td>";
                        echo "<td>
                        <div class='input-group'>
                            <button class='btn btn-outline-secondary btn-sm' type='button' onclick='decreaseQuantity(" . $row['productID'] . ", " . $row['machine_id'] . ")'>-</button>
                            <input type='text' class='form-control' name='newQuantity'  value='" . $row['vm_quantity'] . "' id='quantity_" . $row['productID'] . "'> 

                            <button class='btn btn-outline-secondary btn-sm' type='button' onclick='increaseQuantity(" . $row['productID'] . ", " . $row['machine_id'] . ")'>+</button>
                        </div>
                      </td>";
                        echo "<td>
                          <div class='action-button'>
                        
                              <input type='hidden' name='productID' value='" . $row['productID'] . "'>
                              <input type='hidden' name='machine_id' value='" . $row['machine_id'] . "'> 
                              <button type='submit' class='btn btn-primary btn-sm' name='action' value='edit_" . $row['productID'] . "_" . $row['machine_id'] . "'>Update the quantity</button>
                              <button type='button' class='btn btn-outline-danger btn-sm delete-product-button' data-product-id='" . $row['productID'] . "' data-machine-id='" . $row['machine_id'] . "'>Delete</button>
                              </td>";

                        echo "</tr>";
                        echo "</form>";
                      }
                    } else {
                      // No products found for the vending machine ID
                      echo "<tr><td colspan='7'>No products found for vending machine with ID: $vendingMachineID</td></tr>";
                    }
                  } else {
                    // Error retrieving result
                    echo "<tr><td colspan='7'>Error retrieving result: " . mysqli_error($conn) . "</td></tr>";
                  }

                  // Close statement
                  mysqli_stmt_close($stmt);
                } else {
                  // Error preparing statement
                  echo "<tr><td colspan='7'>Error preparing statement: " . mysqli_error($conn) . "</td></tr>";
                }
                ?>

              </tbody>
            </table>


          </div>
        </div>
      </div>
    </div>
  </main><!-- End #main -->

  <!-- ======= Sidebar ======= -->
  <?php
  include('shared/footer.php');
  ?>
  <!-- End Sidebar-->

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
  <script>
    function increaseQuantity(productId, machineId) {
      var input = document.getElementById('quantity_' + productId);
      var currentValue = parseInt(input.value, 10);
      input.value = isNaN(currentValue) ? 0 : currentValue + 1;
    }

    function decreaseQuantity(productId, machineId) {
      var input = document.getElementById('quantity_' + productId);
      var currentValue = parseInt(input.value, 10);
      if (!isNaN(currentValue) && currentValue > 0) {
        input.value = currentValue - 1;
      }
    }
    document.querySelectorAll('.delete-product-button').forEach(button => {
      button.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        const machineId = this.getAttribute('data-machine-id');

        Swal.fire({
          title: "Are you sure?",
          text: "Are you sure you want to delete this product?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, delete it!",
          cancelButtonText: "No, cancel!",
          reverseButtons: true
        }).then((result) => {
          if (result.isConfirmed) {
            // If user confirms deletion, submit the form
            const form = document.createElement('form');
            form.method = 'post';
            form.action = '';
            const inputProductId = document.createElement('input');
            inputProductId.type = 'hidden';
            inputProductId.name = 'productID';
            inputProductId.value = productId;
            const inputMachineId = document.createElement('input');
            inputMachineId.type = 'hidden';
            inputMachineId.name = 'machine_id';
            inputMachineId.value = machineId;
            const inputAction = document.createElement('input');
            inputAction.type = 'hidden';
            inputAction.name = 'action';
            inputAction.value = 'delete';
            form.appendChild(inputProductId);
            form.appendChild(inputMachineId);
            form.appendChild(inputAction);
            document.body.appendChild(form);
            form.submit();
          }
        });
      });
    });
  </script>

  </script>
</body>

</html>