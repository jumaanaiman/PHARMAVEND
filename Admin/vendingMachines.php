 <!DOCTYPE html>
 <html lang="en">

 <head>
   <meta charset="utf-8">
   <meta content="width=device-width, initial-scale=1.0" name="viewport">

   <title>PHARMAVEND</title>
   <meta content="" name="description">
   <meta content="" name="keywords">

   <!-- Favicons -->
   <link href="assets/img/favicon.png" rel="icon">
   <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

   <!-- Google Fonts -->
   <link href="https://fonts.gstatic.com" rel="preconnect">
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">

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
    ?>
   <!-- End Sidebar-->

   <main id="main" class="main">
     <div class="pagetitle">
       <h1>Vending Machines</h1>
     </div>

     <section class="section">
       <div class="row">
         <div class="col-lg-12">
           <div class="card">
             <div class="card-body">
               <div class="row">
                 <div class="col-md-8">
                   <h5 class="card-title"></h5>
                 </div>
                 <div class="col-md-4">
                   <h1 class="card-title text-end"> <a href="#" id="openVmModal" data-bs-toggle="modal" data-bs-target="#basicModal">Add New Vending Machine</a></h1>
                 </div>
               </div>
               <div class="modal fade" id="basicModal" tabindex="-1">
                 <div class="modal-dialog">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title">Add a new vending machine</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <form class="row g-3" method="POST">

                       <div class="modal-body">
                         <div class="col-md-12">
                           <div class="mb-3">
                             <label for="machineName" class="form-label">Name</label>
                             <input type="text" class="form-control" id="machineName" placeholder="Name" name="name" required>
                           </div>
                           <div class="mb-3">
                             <label for="machineCity" class="form-label">City</label>
                             <select class="form-select" id="machineCity" name="city">
                               <option value="">Select City</option>
                               <option value="Amman">Amman</option>
                               <option value="Irbid">Irbid</option>
                             </select>
                           </div>
                           <div class="mb-3">
                             <label for="machineAddress" class="form-label">Address</label>
                             <textarea class="form-control" placeholder="Address" id="machineAddress" style="height: 100px;" name="address"></textarea>
                           </div>
                           <div class="mb-3">
                             <label for="machineLocation" class="form-label">Location</label>
                             <input type="text" class="form-control" id="machineLocation" placeholder="Location" name="location">
                           </div>
                           <div class="mb-3">
                             <label for="machineMall" class="form-label">Mall Name</label>
                             <select class="form-select" id="machineMall" name="machineMall">
                               <option value="">Select Mall</option>
                               <option value="City Mall">City Mall</option>
                               <option value="Taj Mall">Taj Mall</option>
                               <option value="Abdali Mall">Abdali Mall</option>
                               <option value="Mecca Mall">Mecca Mall</option>
                               <option value="Irbid City Cente"> Irbid City Center</option>
                               <option value="Arabella Mall"> Arabella Mall</option>
                               <option value="Irbid Mall">Irbid Mall</option>

                             </select>
                           </div>
                           <div class="mb-3">
                             <label for="machineUniversity" class="form-label">University Name</label>
                             <select class="form-select" id="machineUniversity" name="university">
                               <option value="">Select University</option>
                               <option value="Jordan University">Jordan University</option>
                               <option value="Princess Sumaya Universiry for Technology">Princess Sumaya Universiry for Technology</option>
                               <option value="American University of Madaba">American University of Madaba</option>
                             </select>

                           </div>
                           <div class="mb-3">
                             <label for="machineLatitude" class="form-label">Latitude</label>
                             <input type="text" class="form-control" id="machineLatitude" placeholder="Latitude" name="latitude">
                           </div>
                           <div class="mb-3">
                             <label for="machineLongitude" class="form-label">Longitude</label>
                             <input type="text" class="form-control" id="machineLongitude" placeholder="Longitude" name="longitude">
                           </div>

                         </div>
                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary" name='action' value="insertVendingMachine">Save changes</button>
                         </div>
                       </div>
                     </form>
                   </div>
                 </div>
               </div>
               <div class="modal fade" id="EditVmModal" tabindex="-1">
                 <div class="modal-dialog">
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title">Update vending machine</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                     </div>
                     <form class="row g-3" method="POST">

                       <div class="modal-body">
                         <div class="col-md-12">
                           <div class="mb-3">
                             <label for="machineName" class="form-label">Name</label>
                             <input type="text" class="form-control" id="machineNameEdit" placeholder="Name" name="name" required>
                           </div>
                           <div class="mb-3">
                             <label for="machineCity" class="form-label">City</label>
                             <select class="form-select" id="machineCityEdit" name="city">
                               <option value="">Select City</option>
                               <option value="Amman">Amman</option>
                               <option value="Irbid">Irbid</option>
                             </select>
                           </div>
                           <div class="mb-3">
                             <label for="machineAddress" class="form-label">Address</label>
                             <textarea class="form-control" placeholder="Address" id="machineAddressEdit" style="height: 100px;" name="address"></textarea>
                           </div>
                           <div class="mb-3">
                             <label for="machineLocation" class="form-label">Location</label>
                             <input type="text" class="form-control" id="machineLocationEdit" placeholder="Location" name="location">
                           </div>
                           <div class="mb-3">
                             <label for="machineMall" class="form-label">Mall Name</label>
                             <select class="form-select" id="machineMallEdit" name="machineMall">
                               <option value="">Select Mall</option>
                               <option value="City Mall">City Mall</option>
                               <option value="Taj Mall">Taj Mall</option>
                               <option value="Abdali Mall">Abdali Mall</option>
                               <option value="Mecca Mall">Mecca Mall</option>
                               <option value="Irbid City Cente"> Irbid City Center</option>
                               <option value="Arabella Mall"> Arabella Mall</option>
                               <option value="Irbid Mall">Irbid Mall</option>

                             </select>
                           </div>
                           <div class="mb-3">
                             <label for="machineUniversity" class="form-label">University Name</label>
                             <select class="form-select" id="machineUniversityEdit" name="university">
                               <option value="">Select University</option>
                               <option value="Jordan University">Jordan University</option>
                               <option value="Princess Sumaya Universiry for Technology">Princess Sumaya Universiry for Technology</option>
                               <option value="American University of Madaba">American University of Madaba</option>
                             </select>

                           </div>

                           <div class="mb-3">
                             <label for="machineLatitude" class="form-label">Latitude</label>
                             <input type="text" class="form-control" id="machineLatitudeEdit" placeholder="Latitude" name="latitude">
                           </div>
                           <div class="mb-3">
                             <label for="machineLongitude" class="form-label">Longitude</label>
                             <input type="text" class="form-control" id="machineLongitudeEdit" placeholder="Longitude" name="longitude">
                           </div>
                         </div>
                         <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                           <input type="hidden" name="vmId" id="vmId">
                           <button type="submit" class="btn btn-primary" name='action' value="EditVendingMachine">Save changes</button>
                         </div>
                       </div>
                     </form>
                   </div>
                 </div>
               </div>

               <!-- Retrieve data from the vending_machines table -->
               <table class="table table-bordered border-primary">
                 <thead>
                   <tr>
                     <th scope="col">VM No.</th>
                     <th scope="col">Name</th>
                     <th scope="col">City.</th>
                     <th scope="col">Address</th>
                     <th scope="col">Products</th>
                     <th scope="col">Location</th>
                     <th scope="col">University Name</th>
                     <th scope="col">Mall Name</th>
                     <th scope="col">Actions</th>
                   </tr>
                 </thead>
                 <tbody>
                   <!-- PHP code block goes here -->
                   <!-- Retrieve data from the vending_machines table -->
                   <?php
                    $query = "SELECT * FROM vending_machines";
                    $result = mysqli_query($conn, $query);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                       <tr>
                         <th scope="row"><?php echo $row['machine_id']; ?></th>
                         <td><?php echo $row['name']; ?></td>
                         <td><?php echo $row['city']; ?></td>
                         <td><?php echo $row['address']; ?></td>
                         <td>
                           <button type="button" class="btn btn-link m-2 btn-sm">
                             <a href="products.php?vendingMachineID=<?php echo $row['machine_id']; ?>&name=<?php echo urlencode($row['name']); ?>">Show products</a>
                           </button>
                         </td>
                         <td><?php echo $row['location']; ?></td>
                         <td><?php echo $row['university_name']; ?></td>
                         <td><?php echo $row['mall_name']; ?></td>

                         <td>
                           <div class="action-button">
                             <!-- <button type="button" class="btn btn-primary btn-sm btn-update" onclick="updateMachine(<?php echo $row['machine_id']; ?>)">Update</button> -->
                             <button type="button" class="btn btn-primary btn-sm edit-machine-button" data-machine-id="<?= $row['machine_id'] ?>">Update</button>
                             <form method="POST" action="" class="delete-machine-form" data-machine-id="<?= $row['machine_id'] ?>">
                               <input type="hidden" name="machine_id" value="<?php echo $row['machine_id']; ?>">
                               <button type="button" name="action" value="delete" class="btn btn-outline-danger btn-sm delete-machine-button" data-machine-id="<?= $row['machine_id'] ?>">Delete</button>
                             </form>
                           </div>
                         </td>
                       </tr>
                   <?php
                      }
                    } else {
                      // No data found
                      echo '<tr><td colspan="8">No vending machines found.</td></tr>';
                    }
                    ?>
                   <!-- End of PHP code block -->
                 </tbody>
               </table>
               <!-- End Primary Color Bordered Table -->
             </div>
           </div>
         </div>
       </div>
     </section>
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
   <!-- Include SweetAlert -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">


   <!-- Call your SweetAlert function after the DOM has loaded -->
   <?php
    // Start PHP script
    require_once '../Config/user.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
      if (isset($_POST['action']) && $_POST['action'] === 'insertVendingMachine') {
        // Form data is submitted for inserting a vending machine
        $name = $_POST['name'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $location = $_POST['location'];
        $mall = $_POST['machineMall'];
        $university = $_POST['university'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];


        // Check for duplicate vending machine name
        $count = checkDuplicateVendingMachinesName($name);

        if ($count == 0) {
          // If name is not duplicate, add vending machine and show success message
          AddVendingMachines($name, $city, $address, $location, $mall, $university, $latitude, $longitude);
          exit; // Stop further execution
        } else {
          // If name already exists, show SweetAlert warning message
          echo '
                <script>
                    Swal.fire({
                        title: "Error!",
                        text: "Vending machine with this name already exists!",
                        icon: "error"
                    }).then(function() { 
                    });
                </script>
            ';
          exit;
        }
      } else  if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $machine_id = $_POST['machine_id'];
        if (deleteVendingMachineByID($machine_id)) {
          echo '
            <script>
                Swal.fire({
                    title: "Success!",
                    text: "Vending machine deleted successfully!",
                    icon: "success",
                    
                }).then(function() {
                    window.location.href = "vendingMachines.php";
                });
            </script>
            ';
          exit;
        } else {
          echo '
            <script>
                Swal.fire({
                    title: "Error!",
                    text: "Error deleting vending machine!",
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Delete",
                    cancelButtonText: "Close",
                    allowOutsideClick: false 
                }).then(function() {
                  if (result.isConfirmed) {
                    window.location.href = "vendingMachines.php";
                } else {
                  
                } 
                });
            </script>
            ';
          exit;
        }
      } else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "EditVendingMachine") {
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $result = updateVendingMachine($_POST["vmId"], $_POST["name"], $_POST["city"], $_POST["address"], $_POST["location"], $_POST["machineMall"], $_POST["university"], $latitude, $longitude);

        if ($result) {
          echo '
          <script>
              Swal.fire({
                  title: "Success!",
                  text: "Record updated successfully",
                  icon: "success"
              }).then(function() {
                  window.location.href = "vendingMachines.php";
              });
          </script>
          ';
        } else {
          echo '
          <script>
              Swal.fire({
                  title: "Error!",
                  text: "Error updating record!",
                  icon: "error"
              }).then(function() { 
              });
          </script>
          ';
        }
      }
    }
    // End PHP script
    ?>


   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css" rel="stylesheet">
   <script>
     document.querySelectorAll('.edit-machine-button').forEach(button => {
       button.addEventListener('click', function() {
         // Get the product ID from the data attribute
         const machineId = this.getAttribute('data-machine-id');
         document.getElementById('vmId').value = machineId;

         updateMachine(machineId);

       });
     });
     document.querySelectorAll('.delete-machine-button').forEach(button => {
       button.addEventListener('click', function() {
         // Get the machine ID from the data attribute
         const machineId = this.getAttribute('data-machine-id');

         // Show SweetAlert confirmation dialog
         Swal.fire({
           title: "Are you sure?",
           text: "Are you sure you want to delete this vending machine?",
           icon: "warning",
           buttons: true,
           dangerMode: true,
           showCancelButton: true,
           confirmButtonColor: "#3085d6",
           cancelButtonColor: "#d33",
           confirmButtonText: "Delete",
           cancelButtonText: "Close",
           allowOutsideClick: false // Disables closing by clicking outside
         }).then((willDelete) => {
           if (willDelete) {
             // If user confirms deletion, trigger a click event on the submit button
             if (willDelete.isConfirmed) {
               const form = document.querySelector(`form.delete-machine-form[data-machine-id="${machineId}"]`);
               if (form) {
                 const submitButton = form.querySelector('button[type="button"]');
                 if (submitButton) {
                   submitButton.setAttribute('type', 'submit');
                   submitButton.click();
                 } else {
                   console.error("Submit button not found for form:", form); // Debugging
                   Swal.fire({
                     title: "Error!",
                     text: "Submit button not found",
                     icon: "error"
                   });
                 }
               } else {
                 console.error("Form not found for machine ID:", machineId); // Debugging
                 Swal.fire({
                   title: "Error!",
                   text: "Form not found",
                   icon: "error"
                 });
               }
             }
           }
         });
       });
     });

     // Function to handle the click event on "Update" button
     function updateMachine(machineId) {
       fetch(`../Config/userApi.php?machineId=${machineId}&action=getVendingMachineById`, {
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
         .then(machineData => {
           document.getElementById('machineNameEdit').value = machineData.name;
           document.getElementById('machineCityEdit').value = machineData.city;
           document.getElementById('machineAddressEdit').value = machineData.address;
           document.getElementById('machineLocationEdit').value = machineData.location;
           document.getElementById('machineMallEdit').value = machineData.mall_name;
           document.getElementById('machineUniversityEdit').value = machineData.university_name;
           document.getElementById('machineLatitudeEdit').value = machineData.latitude;
           document.getElementById('machineLongitudeEdit').value = machineData.longitude;
           // Show the modal

           const EditVmModal = new bootstrap.Modal(document.getElementById('EditVmModal'));
           EditVmModal.show();

         })
         .catch(error => {
           console.error('Error fetching product data:', error);
         });

     }
   </script>



 </body>

 </html>