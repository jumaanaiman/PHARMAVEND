<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  require_once '../Config/login-register.php';

  $user_id = $_SESSION['user_id'];


  // Check if a feedback entry should be deleted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a feedback entry should be deleted
    if (isset($_POST['contactID'])) {
      $contactID = $_POST['contactID'];

      // Example validation: Check if ContactID is not empty
      if (!empty($contactID)) {
        // Delete feedback from the 'contact' table
        $stmt = $conn->prepare("DELETE FROM contact WHERE ContactID = ?");
        $stmt->bind_param("i", $contactID);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->affected_rows > 0) {
          // Feedback deleted successfully
          echo "Feedback deleted from the database.";
          header('location:feedbacks.php');
          exit;
        } else {
          // Failed to delete feedback
          echo "Failed to delete feedback from the database.";
        }

        $stmt->close();
      } else {
        // ContactID is empty
        echo "Invalid ContactID.";
      }
    }
  }

  // Retrieve feedback data with user's full name from the database
  $contact = $conn->query("SELECT ContactID, full_name, email, comment FROM contact");
  ?>

  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
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

  <link href="assets\css\users_feedbacks.css" rel="stylesheet">
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

    </div><!-- End Page Title -->
    <section class="section">
      <div class="pagetitle">
        <h1>Feedbacks</h1>
      </div><!-- End Page Title -->
      <section class="section">
        <div class="row">
          <?php
          if ($contact->num_rows > 0) {
            while ($row = $contact->fetch_assoc()) {
              $contactID = $row['ContactID'];
              $contact_full_name = $row['full_name'];
              $contact_email = $row['email'];
              $contact_comment = $row['comment'];
          ?>
              <div class="col-lg-6">
                <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">User: <?php echo $contact_full_name; ?></h5>
                    <p><?php echo $contact_comment; ?></p>
                    <h6><?php echo $contact_email; ?></h6>
                    <form method="POST" class="delete-form">
                      <input type="hidden" name="contactID" value="<?php echo $contactID; ?>">
                      <button type="button" name="deleteFeedback" id="deleteButton_<?php echo $contactID; ?>" class="btn btn-outline-danger delete-button">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
          <?php
            }
          } else {
            echo "No feedbacks found.";
          }
          ?>
        </div>
      </section>
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
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>


  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="assets/js/shared.js"></script>
  <script src="assets/js/sweetalert.min.js"></script>

  <script>
    // Get all delete buttons
    const deleteButtons = document.querySelectorAll('.delete-button');

    // Add click event listener to each delete button
    deleteButtons.forEach(button => {
      button.addEventListener('click', function() {
        const contactID = this.id.split('_')[1]; // Extract the contact ID from the button's ID

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
            // Send AJAX request to delete the feedback
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
              if (xhr.readyState === 4 && xhr.status === 200) {
                // Remove the card element from the DOM
                const card = button.parentNode.parentNode;
                card.remove();
                // Display success message with SweetAlert
                Swal.fire(
                  'Deleted!',
                  'The feedback has been deleted.',
                  'success'
                );
              }
            };
            xhr.send(`contactID=${contactID}`);
          }
        });
      });
    });
  </script>

</body>


</html>