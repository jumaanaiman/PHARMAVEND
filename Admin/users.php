<!DOCTYPE html>
<html lang="en">

<?php

require_once '../Config/login-register.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['makeAdmin'])) {
    $userId = $_POST['userId'];

    // Update the user's role in the database
    $query = "UPDATE user SET role = 0 WHERE user_id = '$userId'";
    mysqli_query($conn, $query);
    header('location:users.php');
    // Return a response
    echo "success";
  } elseif (isset($_POST['deleteUser'])) {
    $userId = $_POST['userId'];

    // Delete the user from the database
    $query = "DELETE FROM user WHERE user_id = '$userId'";
    mysqli_query($conn, $query);

    // Return a response
    echo "success";
  }
}


?>

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PharmaVend</title>
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
      <h1>Admins</h1>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>


              <table class="table table-bordered border-primary">
                <thead>
                  <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">User Type</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $results = getAllAdmins();
                  while ($row = mysqli_fetch_array($results)) {
                  ?>
                    <tr>
                      <td><?php echo $row['user_id']; ?></td>
                      <td><?php echo $row['full_name']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td>
                        <?php
                        if ($row['role'] == 0) {
                          echo "Admin";
                        } else {
                          echo "User";
                          if ($row['role'] == 1) {
                            echo '
                        <form method="POST" class="make-admin-form" style="display: inline;">
                          <input type="hidden" name="userId" value="' . $row['user_id'] . '">
                          <button type="button" name="makeAdmin" class="btn btn-primary make-admin-btn" style="float: right;">Make an Admin</button>
                        </form>
                        ';
                          }
                        }
                        ?>
                      </td>
                      <td>
                        <form method="POST" class="delete-form">
                          <input type="hidden" name="userId" value="<?php echo $row['user_id']; ?>">
                          <button type="button" class="btn btn-outline-danger delete-button">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <!-- End Primary Color Bordered Table -->

            </div>
          </div>



        </div>


      </div>
    </section>





    <div class="pagetitle">
      <h1>Customers</h1>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title"></h5>


              <table class="table table-bordered border-primary">
                <thead>
                  <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">User Type</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $results = getAllCustomers();
                  while ($row = mysqli_fetch_array($results)) {
                  ?>
                    <tr>
                      <td><?php echo $row['user_id']; ?></td>
                      <td><?php echo $row['full_name']; ?></td>
                      <td><?php echo $row['email']; ?></td>
                      <td>
                        <?php
                        if ($row['role'] == 0) {
                          echo "Admin";
                        } else {
                          echo "User";
                          if ($row['role'] == 1) {
                            echo '
                            <form method="POST" class="make-admin-form" style="display: inline;">
                              <input type="hidden" name="userId" value="' . $row['user_id'] . '">
                              <button type="button" name="makeAdmin" class="btn btn-primary make-admin-btn" style="float: right;">Make an Admin</button>
                            </form>
                            ';
                          }
                        }
                        ?>
                      </td>
                      <td>
                        <form method="POST" class="delete-form">
                          <input type="hidden" name="userId" value="<?php echo $row['user_id']; ?>">
                          <button type="button" class="btn btn-outline-danger delete-button">Delete</button>
                        </form>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
              <!-- End Primary Color Bordered Table -->

            </div>
          </div>



        </div>


      </div>
    </section>

  </main><!-- End #main -->

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
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/shared.js"></script>
  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/shared.js"></script>
  <script src="assets/js/sweetalert.min.js"></script>

  <script>
    // Function to handle the make admin button click
    document.querySelectorAll('.make-admin-btn').forEach(function(button) {
      button.addEventListener('click', function() {
        Swal.fire({
          title: 'Confirmation',
          text: 'Are you sure you want to make this user an admin?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }).then((result) => {
          if (result.isConfirmed) {
            // AJAX request to update the user's role
            const userId = this.parentNode.querySelector('input[name="userId"]').value;
            const formData = new FormData();
            formData.append('makeAdmin', true);
            formData.append('userId', userId);

            fetch(window.location.href, {
              method: 'POST',
              body: formData
            }).then((response) => {
              if (response.ok) {
                Swal.fire('Success', 'User has been made an admin', 'success').then(() => {
                  location.reload(); // Refresh the page after successful update
                });
              } else {
                Swal.fire('Error', 'Failed to make user an admin', 'error');
              }
            }).catch((error) => {
              Swal.fire('Error', 'An error occurred while making user an admin', 'error');
            });
          }
        });
      });
    });
  </script>


  <script>
    // Get all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-button');

    // Add click event listener to each delete button
    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const form = this.parentNode;
        const userId = form.querySelector('input[name="userId"]').value;

        // Display confirmation pop-up with SweetAlert
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            // Send AJAX request to delete the user
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true); // Current page URL
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                // Remove the table row from the DOM
                const tableRow = form.parentNode.parentNode;
                tableRow.remove();
                // Display success message with SweetAlert
                Swal.fire(
                  'Deleted!',
                  'The user has been deleted.',
                  'success'
                );
              }
            };
            xhr.send(`deleteUser=true&userId=${userId}`);
          }
        });
      });
    });
  </script>
  <?php
  // Close the database connection
  $conn->close();
  ?>

</body>

</html>
</body>

</html>