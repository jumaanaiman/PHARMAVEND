<?php
session_start();
// Include the database connection file
require_once '../Config/user.php';
$products = getAllProducts();
if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    $productId = isset($_GET['id']) ? $_GET['id'] : null;
    echo $productId;
    if ($productId) {

        $success = deleteProductById($productId);
        $_SESSION['alert_message'] =  $success == true ?  'Product deleted successfully' : 'Failed to delete product';
        // Send response back to JavaScript
        if ($success) {
            http_response_code(200); // Success

            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(500); // Internal Server Error

            echo json_encode(['message' => 'Failed to delete product']);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['message' => 'Product ID not provided']);
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' &&  !isset($_GET['id'])) {
    if (isset($_POST['editProduct'])) {
        $productName = $_POST['productName'] ?? '';
        $productDescription = $_POST['productDescription'] ?? '';
        $productPrice = $_POST['productPrice'] ?? '';
        $productID = $_POST['productID'] ?? '';
        $image = $_FILES['productImage'];

        $target_dir = "uploads/"; // Ensure this directory exists and has write permissions
        // Check if the uploads directory exists, if not create it
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Creates the directory with read/write permissions
        }

        // Define the path for the uploaded image
        $target_file = $target_dir . basename($image['name']);

        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            // Prepare SQL query to update the product with the path to the image
            $result = updateProductByIdAPI($productID, $productName, $target_file, $productDescription, $productPrice);
            if ($result === true) {

                $_SESSION['alert_message'] = "Product updated successfully.";
            } else {
                $_SESSION['alert_message'] = "Failed to update product.";
            }
        } else {
            $_SESSION['alert_message'] = "Error uploading image.";
        }
        $products = getAllProducts();
        header("Location: allproducts.php");
        exit();
    }

    if (isset($_POST['insertProduct'])) {
        $productName = $_POST['productName'] ?? '';
        $productDescription = $_POST['productDescription'] ?? '';
        $productPrice = $_POST['productPrice'] ?? '';
        $productID = $_POST['productID'] ?? '';
        $image = $_FILES['productImage'];

        $target_dir = "uploads/"; // Ensure this directory exists and has write permissions
        // Check if the uploads directory exists, if not create it
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Creates the directory with read/write permissions
        }

        // Define the path for the uploaded image
        $target_file = $target_dir . basename($image['name']);

        // Attempt to move the uploaded file to the target directory
        if (move_uploaded_file($image['tmp_name'], $target_file)) {
            // Prepare SQL query to update the product with the path to the image
            $result = insertProduct($productName, $target_file, $productDescription, $productPrice);
            $_SESSION['alert_message'] =  $result;
        }
        $products = getAllProducts();
        header("Location: allproducts.php");
        exit();
    }
}
$alertMessage = $_SESSION['alertMessage'] ?? null;
unset($_SESSION['alertMessage']);
?>

<!DOCTYPE html>
<html lang="en">

<!-- Remaining HTML content of your page -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>PHARMAVEND/PRODUCTS</title>
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
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">

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
        <div class="row">
            <div class="col-lg-12">

                <div class="card">

                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="card-title"></h5>
                            </div>
                            <div class="col-md-4 text-end">
                                <h1 class="card-title"> <a href="#" id="OPENProductModal" data-bs-toggle="modal" data-bs-target="#insertProductModal">Add a new product</a></h1>

                            </div>
                        </div>
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
                        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">
                        <?php
                        if (isset($_SESSION['alert_message'])) {
                            $alert_message = $_SESSION['alert_message'];
                            unset($_SESSION['alert_message']); // Clear the message so it doesn't persist on reload
                            echo "<script>Swal.fire('Alert', '$alert_message', 'success');</script>";
                        }
                        ?>

                        <?php  // Fetch the products

                        if (!empty($products)) : ?>
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th scope='col'>#</th>
                                        <th scope='col'>Name</th>
                                        <th scope='col'>Image</th>
                                        <th scope='col'>Description</th>
                                        <th scope='col'>Price</th>
                                        <th scope='col'>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <tr>
                                            <th scope='row'><?= htmlspecialchars($product['productID']) ?></th>
                                            <td><?= htmlspecialchars($product['name']) ?></td>
                                            <td><img src='<?= htmlspecialchars($product['img']) ?>' width='150' height='150' alt='Product Image'></td>
                                            <td style=" width: 31%;
                    overflow-x: auto; 
                    height: 150px;  
                ">
                                                <div style="height: 11em;"><?= htmlspecialchars($product['description']) ?>
                                                </div>
                                            </td>
                                            <td><?= htmlspecialchars($product['price']) ?> JD</td>
                                            <td>
                                                <button type="button" class="btn btn-outline-danger btn-sm delete-product-button" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" data-product-id="<?= $product['productID'] ?>">Delete</button>
                                                <button type="button" class="btn btn-primary btn-sm edit-product-button" data-bs-toggle="modal" data-bs-target="#editProductModal" data-product-id="<?= $product['productID'] ?>">Edit</button>


                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <p>No products found.</p>
                        <?php endif; ?>

                        <!-- End Primary Color Bordered Table -->

                    </div>
                </div>



            </div>


        </div>

        <!-- Bootstrap modal for confirmation dialog -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this product?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editProductForm" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <!-- Form fields for editing product data -->

                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="productName">
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Product Description</label>
                                <textarea class="form-control" id="productDescription" name="productDescription"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price</label>
                                <input type="text" class="form-control" id="productPrice" name="productPrice">
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="productImage" accept="image/*" name=" productImage">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <input type="hidden" name="productID" id="productID">
                            <button type="submit" name="editProduct" class="btn btn-primary" id="saveChangesButton">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="insertProductModal" tabindex="-1" aria-labelledby="insertProductModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">Add Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editProductForm" enctype="multipart/form-data" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <!-- Form fields for editing product data -->

                            <div class="mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="productName">
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Product Description</label>
                                <textarea class="form-control" id="productDescription" name="productDescription"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Product Price</label>
                                <input type="text" class="form-control" id="productPrice" name="productPrice">
                            </div>
                            <div class="mb-3">
                                <label for="productImage" class="form-label">Product Image</label>
                                <input type="file" class="form-control" name="productImage" accept="image/*" name=" productImage">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="insertProduct" class="btn btn-primary" id="saveChangesButton">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </main><!-- End #main -->

    <!-- ======= Header ======= -->


    <!-- ======= Sidebar ======= -->
    <?php
    include('shared/footer.php');
    ?>
    <!-- End Sidebar-->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <!-- Include SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/shared.js"></script>
    <script>
        // Add event listener to the Cancel button
        document.getElementById('cancelButton').addEventListener('click', function() {
            // Close the modal

            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById(
                'deleteConfirmationModal'));
            deleteConfirmationModal.hide();
        });
        // Add event listener to the Delete button
        document.querySelectorAll('.delete-product-button').forEach(button => {
            button.addEventListener('click', function() {
                // Get the product ID from the data attribute
                const productId = this.getAttribute('data-product-id');

                // Open the confirmation modal
                const deleteConfirmationModal = new bootstrap.Modal(document.getElementById(
                    'deleteConfirmationModal'));
                deleteConfirmationModal.show();

                // Add event listener to the Confirm Delete button inside the modal
                document.getElementById('confirmDeleteButton').addEventListener('click', function() {
                    // Make AJAX request to delete the product by ID
                    fetch(`allproducts.php?id=${productId}`, {
                            method: 'DELETE'
                        })
                        .then(response => {
                            if (response.ok) {
                                // Reload the page after successful deletion
                                location.reload();
                            } else {
                                // Handle error
                                console.error('Failed to delete product');
                            }
                        })
                        .catch(error => {
                            console.error('Error deleting product:', error);
                        });
                });
            });
        });

        document.querySelectorAll('.edit-product-button').forEach(button => {
            button.addEventListener('click', function() {
                // Get the product ID from the data attribute
                const productId = this.getAttribute('data-product-id');
                document.getElementById('productID').value = productId;
                // Open the edit modal
                const editProductModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editProductModal.show();

                // Fetch product data based on product ID and populate the form fields
                fetch(`../Config/userApi.php?id=${productId}&action=getProductById`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        document.getElementById('productName').value = data.name;
                        document.getElementById('productDescription').value = data.description;
                        document.getElementById('productPrice').value = data.price;
                    })
                    .catch(error => {
                        console.error('Error fetching product data:', error);
                    });


            });
        });
    </script>
    </script>
</body>

</html>