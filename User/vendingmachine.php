<?php

require_once '../Config/vm.php';
$_SESSION['previous_url'] = $_SERVER['REQUEST_URI']; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>PharmaVend </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
  <link rel="icon" href="images/logo.png">
  <link rel="stylesheet" href="fonts/icomoon/style.css">

  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">

  <link rel="stylesheet" href="path/to/your/styles.css">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>
<?php
// Include the vending machine function file
require_once '../Config/vm.php';
// Get vending machines from the function
// Check if a city has been passed and sanitize it
$city = isset($_GET['city']) ? htmlspecialchars($_GET['city']) : '';
$university = isset($_GET['university']) ? htmlspecialchars($_GET['university']) : '';
$mall = isset($_GET['mall']) ? trim(urldecode($_GET['mall'])) : '';
// Fetch vending machines based on the city
$vendingMachines = getVendingMachines($city, $university, $mall);

?>

<body>
  <div id="preloader-active">
    <div class="preloader d-flex align-items-center justify-content-center">
      <div class="preloader-inner position-relative">
        <div class="preloader-circle"></div>
        <div class="preloader-img pere-text">
          <img src="images/logo.png" alt="">
        </div>
      </div>
    </div>
  </div>

  <div class="site-wrap">


    <!-- <div id="header-user"></div>   -->
    <?php include('shared/header.php'); ?>
    <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">All Vending Machines</strong>
          </div>
        </div>
      </div>
    </div>

    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <h2 class="h3 mb-5 text-black">All Vending Machines</h2>
          </div>
          <div class="col-md-12">

            <form action="#" method="post">

              <section class="shop spad">
                <div class="container">
                  <div class="row">
                    <div class="col-lg-3">
                      <div class="shop__sidebar">
                        <div class="shop__sidebar__accordion">
                          <div class="accordion" id="accordionExample">
                            <div class="card">
                              <div class="card-heading">
                                <a data-toggle="collapse" data-target="#collapseOne">City</a>
                              </div>
                              <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                <div class="card-body">
                                  <form>
                                    <div class="shop__sidebar__categories">
                                      <ul class="nice-scroll">
                                        <li><a href="vendingmachine.php?city=Amman">Amman</a></li>
                                        <li><a href="vendingmachine.php?city=Irbid">Irbid</a></li>
                                      </ul>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="shop__sidebar">
                        <div class="shop__sidebar__accordion">
                          <div class="accordion" id="accordionExample">
                            <div class="card">
                              <div class="card-heading">
                                <a data-toggle="collapse" data-target="#collapseOne">Universities </a>
                              </div>
                              <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                <div class="card-body">
                                  <div class="shop__sidebar__categories">
                                    <ul class="nice-scroll">
                                      <li><a href="vendingmachine.php?university=Jordan University" value="JU">University of Jordan</a></li>
                                      <li><a href="vendingmachine.php?university=Princess Sumaya Universiry for Technology" value="sumaya">Princess Sumaya Universiry for Technology </a></li>
                                      <li><a href="vendingmachine.php?university=American University of Madaba" value="AUB">American University of Madaba </a></li>

                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="shop__sidebar">
                        <div class="shop__sidebar__accordion">
                          <div class="accordion" id="accordionExample">
                            <div class="card">
                              <div class="card-heading">
                                <a data-toggle="collapse" data-target="#collapseOne">Malls </a>
                              </div>
                              <div id="collapseOne" class="collapse show" data-parent="#accordionExample">
                                <div class="card-body">
                                  <div class="shop__sidebar__categories">
                                    <ul class="nice-scroll">
                                      <li><a href="vendingmachine.php?mall=City Mall" value="citymall">City Mall</a></li>
                                      <li><a href="vendingmachine.php?mall=Taj Mall" value=" Tehcno">Taj Mall </a></li>
                                      <li><a href="vendingmachine.php?mall= Abdali Mall" value="Hasemite"> Abdali Mall</a></li>
                                      <li><a href="vendingmachine.php?mall= Mecca Mall" value="yarmouk">Mecca Mall</a></li>
                                      <li><a href="vendingmachine.php?mall= Irbid City Center" value="sumaya">Irbid City Center </a></li>
                                      <li><a href="vendingmachine.php?mall= Arabella Mall" value="german ">Arabella Mall </a></li>
                                      <li><a href="vendingmachine.php?mall= Irbid Mall" value="AUB">Irbid Mall </a></li>

                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-9">
                      <div id="map-section">
                        <div class="container">

                          <div id="map" style="height: 490px; width: 100%;border: 8px solid #188DB7;border-radius: 5px;"></div>
                        </div>
                      </div>
                      <div class="row" style="padding-top:14px;">
                        <?php if (!empty($vendingMachines)) : ?>
                          <?php foreach ($vendingMachines as $machine) : ?>
                            <div class=" col-lg-4 col-md-6 col-sm-6">
                              <!-- Wrapping the entire product item with an <a> tag -->
                              <a href="javascript:void(0);" onclick="navigate(<?php echo $machine['machine_id']; ?>)" style="color: inherit; text-decoration: none;">
                                <div class="product__item" data-city="Amman">
                                  <div class="product__item__pic">
                                    <img src="images/vm.png" alt="Vending Machine" class="imgpharmavend">
                                  </div>
                                  <div class="product__item__text">
                                    <h4><?php echo htmlspecialchars($machine['name']); ?></h4>
                                    <p>Location: <?php echo htmlspecialchars($machine['location']); ?></p>
                                  </div>
                                </div>
                              </a>
                            </div>
                          <?php endforeach; ?>
                        <?php else : ?>
                          <p>No vending machines found.</p>
                        <?php endif; ?>
                      </div>






                      <div class="row">
                        <div class="col-lg-12">
                          <div class="product__pagination">
                            <!-- Pagination links here -->
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </section>
            </form>
          </div>

        </div>
      </div>
    </div>



    <div class="site-section bg-light">


      <!-- <div id="footer-user"></div> -->
      <?php include('shared/footer.php'); ?>
    </div>
    <!-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp1qxs-8y6j-hqizrIjbY-Y0KdW_qRpXg&callback=initMap"></script> -->
    <script>

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha384-k6v7j5l6eUzJBax4vf8I9QTQH/Z/8FnQgSqDzQdCx2fpBX5DaSk3/e7a6CoHQU5N" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/aos.js"></script>

    <script src="js/main.js"></script>
    <script src="js/shared.js"></script>
    <!-- <script>
      //document.addEventListener('DOMContentLoaded', function() {
      // Initialize map
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {
          lat: 31.95,
          lng: 35.93
        }, // Default center coordinates (Amman)
        zoom: 15, // Increased zoom level for a very zoomed-in map
        // Other map options
      });

      function addMarkers(vendingMachines) {
        vendingMachines.forEach(function(machine) {
          debugger;
          if (machine.latitude && machine.longitude && !isNaN(machine.latitude) && !isNaN(machine.longitude)) {
            var machineLocation = {
              lat: parseFloat(machine.latitude),
              lng: parseFloat(machine.longitude)
            };

            var marker = new google.maps.Marker({
              position: machineLocation,
              map: map,
              title: machine.name
            });
          }
        });
      }

      // Call the function to add markers when the page loads, passing vending machine data
      addMarkers(<?php echo json_encode($vendingMachines); ?>);


      //});

      // Global array to store markers
      var markers = [];

      function navigate(id) {
        window.location.href = `products.php?vmId=${id}`;
      }
    </script> -->
    <script>
      // Initialize map
      var map;

      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {
            lat: 31.95,
            lng: 35.93
          },
          zoom: 15
        });

        // Call the function to add markers when the page loads, passing vending machine data
        addMarkers(<?php echo json_encode($vendingMachines); ?>);
      }

      function addMarkers(vendingMachines) {
        vendingMachines.forEach(function(machine) {
          if (machine.latitude && machine.longitude && !isNaN(machine.latitude) && !isNaN(machine.longitude)) {
            var machineLocation = {
              lat: parseFloat(machine.latitude),
              lng: parseFloat(machine.longitude)
            };

            var marker = new google.maps.Marker({
              position: machineLocation,
              map: map,
              title: machine.name
            });
          }
        });
      }

      // Global array to store markers
      var markers = [];

      function navigate(id) {
        window.location.href = `products.php?vmId=${id}`;
      }
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCp1qxs-8y6j-hqizrIjbY-Y0KdW_qRpXg&callback=initMap"></script>

</body>

</html>