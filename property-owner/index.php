<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  ?>
  <title>Dashboard</title>
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
              <h2 class="h6">My Properties</h2>
            </div>
            <!-- Section actions -->
            <div class="col-12 col-sm-auto ms-auto d-print-none">
              <div class="btn-list">
                <!-- <a href="./my-properties.php" class="btn btn-outline-primary">View All</a> -->
                <a href="./create-listing.php" class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  List a Property
                </a>
              </div>
            </div>
          </div>

          <div class="row flex-wrap mb-3 mb-lg-4">
            <?php
            $get_listings_results = get_listings($_SESSION['user_id']);

            $count = mysqli_num_rows($get_listings_results);

            if ($count == 0) {
              echo "
              <div class='col-12'>
                <div class='alert alert-info' role='alert'>
                  You have no properties listed — <a href='./create-listing.php' class='alert-link'>List now</a>
                </div>
              </div>
              ";
              exit();
            } else {
              while ($row = mysqli_fetch_assoc($get_listings_results)) {

                // $address, $township, $gender, $price, $capacity, $people_per_room, $description, $rules, $cover_image, $features_str

                $id = $row['id'];
                $name = $row['name'];
                $address = $row['address'];
                $township = $row['township'];
                $gender = $row['gender'];
                $price = $row['price_per_month'];
                $cover_image = $row['image'];

                echo "
                <div class='col col-12 col-lg-6 col-xl-3 mb-3'>
                  <div class='card card-sm bg-white shadow hover-shadow'>
    
                    <div class='ratio ratio-16x9'>
                      <img class='d-block w-100 card-img-top object-cover' alt='Carousel image' src='../assets/img/listings/{$cover_image}'>
                    </div>
    
                    <div class='card-body'>
                      <div>
                        <h2 class='fs-3 mb-2 fw-bold'>{$name}</h2>
                        <p class='mb-3 d-flex align-items-center text-gray-500 fs-4'>
                          <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-16 icon-tabler icon-tabler-map-pin me-2' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                            <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                            <circle cx='12' cy='11' r='3'></circle>
                            <path d='M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z'>
                            </path>
                          </svg>
                          <span class='me-1'>{$address},</span><span>{$township}</span>
    
                        </p>
                        <div class='d-flex flex-column flex-sm-row gap-2'>
                        <a href='./view-bookings.php?listing-id={$id}' class='btn btn-primary w-66'>View Bookings</a>
                        <span class='dropdown'>
                          <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                          <div class='dropdown-menu dropdown-menu-end'>
                            <a href='./edit-listing.php?listing-id=${id}' class='dropdown-item'>Edit Listing</a>
                            <a href='./?delete-listing=${id}' class='dropdown-item text-danger'>Delete Listing</a>
                          </div>
                        </span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                ";
              }
            }
            ?>
          </div>
        </div>

      </div>

      <footer class="footer footer-transparent d-print-none">
        <div class="container">
          <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
              <ul class="list-inline list-inline-dots mb-0">
                <li class="list-inline-item"><a href="./create-listing.php" class="link-secondary">List a
                    Property</a></li>
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