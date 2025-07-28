<!DOCTYPE html>
<html lang="en">

<head>
  <title>PharmaVend</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
  <link rel="stylesheet" href="fonts/icomoon/style.css">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">
  <link rel="stylesheet" href="css/magnific-popup.css">
  <link rel="stylesheet" href="css/jquery-ui.css">
  <link rel="stylesheet" href="css/owl.carousel.min.css">
  <link rel="stylesheet" href="css/owl.theme.default.min.css">
  <link rel="icon" href="images/logo.png">

  <link rel="stylesheet" href="css/aos.css">

  <link rel="stylesheet" href="css/style.css">

</head>

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
    <?php include('shared/header.php');
    ?> <div class="bg-light py-7rem">
      <div class="container">
        <div class="row">
          <div class="col-md-12 mb-0">
            <a href="index.php">Home</a> <span class="mx-2 mb-0">/</span>
            <strong class="text-black">About Us</strong>
          </div>
        </div>
      </div>
    </div>
    <? $_SESSION['previous_url'] = $_SERVER['REQUEST_URI']; ?>
    <div class="site-blocks-cover overlay" style="background-image: url('images/slider3.png');">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 mx-auto align-self-center">
            <div class="site-block-cover-content text-center">
              <h1 class="mb-0">About PharmaVend</h1>
              <div class="row justify-content-center mb-5">
                <div class="col-lg-6 text-center">

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="site-section">
      <div class="container">

        <div class="row justify-content-between">

          <div class="col-lg-5">
            <div class="title-section">
              <h2 class="mb-5">About <strong class="text-primary">Us</strong></h2>
              <div class="step-number d-flex mb-4 align-items-center">

                <div class="ml-3">
                  <h3 class="text-black h4 mb-0">Who We Are</h3>
                  <p class="mb-0">
                    We were inspired by our experiences abroad, we saw how convenient pharmacy vending machines were in developed countries. That's why we launched PHARMAVEND to bring that accessibility home.
                  </p>
                </div>
              </div>

              <div class="step-number d-flex mb-4 align-items-center">

                <div class="ml-3">
                  <h3 class="text-black h4 mb-0">What We Serve</h3>
                  <p class="mb-0">
                    At Pharmavend, we offer a convenient selection of over-the-counter medications, providing quick relief for common ailments without the need for a prescription </p>
                </div>
              </div>

              <div class="step-number d-flex mb-4 align-items-center">

                <div class="ml-3">
                  <h3 class="text-black h4 mb-0">Our Mission</h3>
                  <p class="mb-0">
                    Our mission at Pharmavend is simple: to make healthcare products easily accessible whenever and wherever you need them.With us, getting what you need is simple and fast.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="title-section">
              <h2>Satisfied <strong class="text-primary">Customers</strong></h2>
            </div>
            <div class="block-3 products-wrap">
              <div class="owl-single no-direction owl-carousel">
                <div class="testimony">
                  <blockquote>
                    <img src="images/person_3.jpg" alt="Image" class="img-fluid">
                    <p>&ldquo;I had my doubts about using a vending machine for medications, but Pharma Vend has exceeded my expectations. The interface is user-friendly, and the process is secure. Plus, it's available 24/7, which is incredibly convenient.&rdquo;</p>
                  </blockquote>

                  <p class="author">&mdash; Osama</p>
                </div>

                <div class="testimony">
                  <blockquote>
                    <img src="images/person_2.jpg" alt="Image" class="img-fluid">
                    <p>&ldquo;Pharma Vend has made my life so much easier! I can now conveniently refill my prescriptions without having to wait in long lines at the pharmacy. The automated system is quick and efficient.&rdquo;</p>
                  </blockquote>

                  <p class="author">&mdash; Bashar</p>
                </div>

                <div class="testimony">
                  <blockquote>
                    <img src="images/person_3.jpg" alt="Image" class="img-fluid">
                    <p>&ldquo;The convenience of Pharma Vend is unmatched. I can refill my prescriptions in just a few minutes, without having to wait in line or deal with paperwork. It's a time-saver and stress-reliever for sure!&rdquo;</p>
                  </blockquote>

                  <p class="author">&mdash; Khaled</p>
                </div>

                <div class="testimony">
                  <blockquote>
                    <img src="images/person_4.jpg" alt="Image" class="img-fluid">
                    <p>&ldquo;I appreciate the privacy and discretion that Pharma Vend offers. I can refill my prescriptions without having to interact with pharmacy staff or other customers, which is especially helpful for sensitive medications.&rdquo;</p>
                  </blockquote>

                  <p class="author">&mdash; Aiman</p>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

















    <div class="site-section bg-light custom-border-bottom" data-aos="fade">
      <div class="container">
        <div class="row justify-content-center mb-5">


          <div class="title-section text-center col-md-7">
            <h2>Our <strong class="text-primary">Team</strong></h2>
          </div>

        </div>
        <!DOCTYPE html>
        <html lang="en">

        <head>
          <title>Your Title</title>
          <!-- Your other meta tags and links to CSS files -->
          <style>
            .block-38-img img {
              height: 200px;
              /* Adjust as needed */
              width: auto;
              /* Maintain aspect ratio */
            }
          </style>
        </head>

        <body>
          <div class="row">
            <div class="col-md-6 col-lg-4 mb-5">
              <div class="block-38 text-center">
                <div class="block-38-img">
                  <div class="block-38-header">
                    <img src="images/person_33.jpg" alt="Image placeholder" class="mb-4">
                    <h3 class="block-38-heading h4">Jumanah Mukheimar</h3>
                  </div>
                </div>
              </div>
            </div>

            <!-- Repeat the same structure for other columns -->

            <div class="col-md-6 col-lg-4 mb-5">
              <div class="block-38 text-center">
                <div class="block-38-img">
                  <div class="block-38-header">
                    <img src="images/DALYA.png" alt="Image placeholder" class="mb-4">
                    <h3 class="block-38-heading h4">Dalya Kharbasheh</h3>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-5">
              <div class="block-38 text-center">
                <div class="block-38-img">
                  <div class="block-38-header">
                    <img src="images/MALAK.png" alt="Image placeholder" class="mb-4">
                    <h3 class="block-38-heading h4">Malak Shamout</h3>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-5">
              <!-- Empty column -->
            </div>

            <div class="col-md-6 col-lg-4 mb-5">
              <div class="block-38 text-center">
                <div class="block-38-img">
                  <div class="block-38-header">
                    <img src="images/RUBA.png" alt="Image placeholder" class="mb-4">
                    <h3 class="block-38-heading h4">Ruba Awad</h3>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 mb-5">
              <!-- Empty column -->
            </div>

          </div>
          <!-- Your other HTML content -->
        </body>

        </html>

      </div>
    </div>






    <!-- <div id="footer-user"></div> -->
    <?php include('shared/footer.php'); ?>
  </div>
  <script src="https://browser.sentry-cdn.com/7.109.0/bundle.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js" integrity="sha384-k6v7j5l6eUzJBax4vf8I9QTQH/Z/8FnQgSqDzQdCx2fpBX5DaSk3/e7a6CoHQU5N" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="js/jquery-3.3.1.min.js"></script>
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