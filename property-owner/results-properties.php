<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  check_page_access('property-owner');
  ?>
  <title>Search Results - My Properties</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <header class="navbar navbar-expand-md navbar-light">
    <?php include("../includes/navigation.php") ?>
  </header>

  <div class="page">
    <div class="page-wrapper">
      <div class="page-body">

        <!-- ! My Properties -->
        <div class="container mb-3 mb-lg-4">
          <div class="row g-2 align-items-center mb-3">
            <div class="col">
              <h2 class="h6">Search Results</h2>
            </div>
          </div>

          <div class="row">

            <div class="col-12">
              <div class="alert alert-success" role="alert">
                Your search returned 1 property
              </div>
            </div>

            <div class="col-12">
              <!-- ! Search bookings -->
              <form method="post" action="./results-bookings.php">
                <div class="input-icon mb-3">
                  <input type="search" value="" class="form-control form-control-rounded" placeholder="Search by property name…">
                  <span class="input-icon-addon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <circle cx="10" cy="10" r="7"></circle>
                      <line x1="21" y1="21" x2="15" y2="15"></line>
                    </svg>
                  </span>
                </div>

              </form>
            </div>

            <div class="row flex-wrap mb-3 mb-lg-4">
              <div class="col col-12 col-lg-6 col-xl-3 mb-3">
                <div class="card card-sm bg-white shadow hover-shadow">

                  <div class="ratio ratio-16x9">
                    <img class="d-block w-100 card-img-top object-cover" alt="Carousel image" src="../assets/static/img/placeholder.jpg">
                  </div>

                  <div class="card-body">
                    <div>
                      <h2 class="fs-3 mb-2 fw-bold">ZUCT Boarding House</h2>
                      <p class="mb-3 d-flex align-items-center text-gray-500 fs-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-16 icon-tabler icon-tabler-map-pin me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <circle cx="12" cy="11" r="3"></circle>
                          <path d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z">
                          </path>
                        </svg>
                        <span class="me-1">5 James Phiri Road,</span><span>Northrise</span>

                      </p>
                      <div class="d-flex flex-column flex-sm-row gap-2">
                        <a href="./edit-listing.php" class="btn btn-outline-primary w-33">Edit</a>
                        <a href="./view-bookings.php" class="btn btn-primary w-66">View Bookings</a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

        </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item"><a href="#" class="link-secondary">List a Property</a></li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    © 2022 -
                    <a href="." class="link-secondary">Ikaleni</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>

</body>

</html>