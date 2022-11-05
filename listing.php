<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 1;
  include("./includes/head.php");
  ?>
  <title>Boarding House</title>
</head>

<body>
  <div class="page">
    <!-- ! Header & Navigation -->
    <header class="navbar navbar-expand-md navbar-light">
      <?php include("./includes/navigation.php") ?>
    </header>

    <!-- ! Main Content -->
    <main class="page-body mt-0">
      <?php
      if (!isset($_GET['listing-id'])) {
        header('Location: ./index.php');
        ob_end_flush();
      }

      if (isset($_GET['listing-id'])) {
        $result_listing = get_listing($_GET['listing-id']);
        $row = mysqli_fetch_assoc($result_listing);
        $count = mysqli_num_rows($result_listing);

        // Redirect if listing doest not exist
        if ($count == 0) {
          header('Location: ./index.php');
          ob_end_flush();
        }

        // Get owner details
        $owner_id = $row['owner_id'];
        $result_owner = get_user_by_id($owner_id);
        $row_owner = mysqli_fetch_assoc($result_owner);
        $owner_first_name = $row_owner['first_name'];
        $owner_last_name = $row_owner['last_name'];
        $owner_email = $row_owner['email'];
        $owner_phone_number = $row_owner['phone_number'];
        $owner_initials = substr($owner_first_name, 0, 1) . substr($owner_last_name, 0, 1);

        // Get listing details
        $id = $row['id'];
        $name = $row['name'];
        $address = $row['address'];
        $township = $row['township'];
        $gender = $row['gender'];
        $price = $row['price_per_month'];
        $capacity = $row['capacity'];
        $vacancies = $row['vacancies'];
        $people_per_room = $row['people_per_room'];
        $description = nl2br($row['description']);
        $rules = nl2br($row['rules']);
        $features = $row['features'];
        $cover_image = $row['image'];

        $vacancies_text = $vacancies == 0 || $vacancies > 1 ? 'vacancies' : 'vacancy';
        $people_per_room_text = $people_per_room == 1 ? 'person' : 'people';

        echo "
          <div class='container mt-4 mt-lg-5 mb-2 mb-lg-3'>
            <div class='d-flex flex-column'>
              <h1 class='h5 text-gray-900 fw-bold'>{$name}</h1>
              <div class='text-gray-500 d-flex align-content-center'>
                <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-map-pin' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                  <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                  <circle cx='12' cy='11' r='3'></circle>
                  <path d='M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z'></path>
                </svg>
                <p class='ms-2 mb-0'>
                  <span>{$address}</span>,
                  <span>{$township}</span>
                </p>
              </div>
            </div>
          </div>
    
          <div class='container mb-3 mb-lg-4'>
            <div>
              <div class='bg-white'>
                <div class='ratio ratio-16x9'>
                  <img class='d-block w-100 card-img-top object-cover' alt='Carousel image' src='./assets/img/listings/{$cover_image}'>
                </div>
              </div>
            </div>
          </div>
    
          <div class='container'>
            <div class='row justify-content-lg-between'>
              <div class='col col-12 col-lg-6'>
                <h2 class='fs-2 mb-3 border-bottom pb-2'>Overview</h2>
    
                <p class='text-gray-500 mb-4'>
                  {$description}
                </p>
          
                <h2 class='fs-2 mb-2'>Boarding House Features</h2>
    
                <p class='text-gray-500 border-bottom pb-2 mb-3'>Services offered to every tenant at this boarding house</p>
          ";

        echo "<div class='d-flex flex-wrap gap-2 text-gray-500 mb-3 mb-lg-4'>";

        $features_arr = explode(',', $features);

        foreach ($features_arr as $feature) {
          echo "
              <span class='d-flex gap-2 justify-content-center align-items-center badge border bg-transparent text-gray-500  px-3 py-2 badge-pill'>
                <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-check' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                  <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                  <path d='M5 12l5 5l10 -10'></path>
                </svg>
                {$feature}
              </span>
              ";
        }
        echo "</div>";

        echo "
          <h2 class='fs-2 mb-3 border-bottom pb-2'>Property Owner</h2>
            <div class='row'>
              <div class='col col-12 col-lg-6'>
                <div class='card'>
                  <div class='d-flex gap-3 align-items-center mb-3 ps-3 pt-3'>
                    <span class='avatar avatar-lg rounded-circle' style='background-image: url();'>{$owner_initials}</span>
                    <div class='d-flex gap-2 flex-column'>
                      <span class='fw-bold'>{$owner_first_name} {$owner_last_name}</span>
                      <span class='border px-2 border-success bg-transparent text-success rounded-pill align-self-start fs-5'>Property
                        Owner</span>
                    </div>
                  </div>
                  <div class='d-flex'>
                    <a href='tel:+260{$owner_phone_number}' class='card-btn py-2'>
                      <svg xmlns='http://www.w3.org/2000/svg' class='icon me-2 text-muted' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                        <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                        <path d='M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2'>
                        </path>
                      </svg>
                      Call
                    </a>

                    <a href='mailto:{$owner_email}' class='card-btn py-2'>
                      <svg xmlns='http://www.w3.org/2000/svg' class='icon me-2 text-muted' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                        <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                        <rect x='3' y='5' width='18' height='14' rx='2'></rect>
                        <polyline points='3 7 12 13 21 7'></polyline>
                      </svg>
                      Email
                    </a>
                  </div>
                </div>
              </div>
            </div>
    
              </div>
    
              <div class='col col-12 col-lg-4 col-xl-3 mt-4'>
                <div class='card card-sm sticky-lg-top top-lg-5 bg-white hover-shadow-sm'>
                  <div class='card-body'>
                    <div>
                      <h2 class='fs-3 text-gray-700 border-bottom p-0 pb-2 mb-3'>Booking Information</h2>
                      <div class='d-flex align-items-baseline gap-1 mb-2'>
                        <span class='h5'>K{$price}</span>
                        <span class='text-gray-500'>/ month</span>
                      </div>
                      <div class='mb-3'>
                        <p class='text-gray-500 mb-1'>{$vacancies} {$vacancies_text}</p>
                        <p class='text-gray-500'>{$people_per_room} {$people_per_room_text} / room </p>
                      </div>
    
                      <a href='#' class='btn btn-primary w-100' data-bs-toggle='modal' data-bs-target='#modal-scrollable'>
                        Book Now
                      </a>
                    </div>
    
                  </div>
                </div>
              </div>
            </div>
          </div>
    
          <div class='modal modal-blur fade' id='modal-scrollable' tabindex='-1' style='display: none;' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered modal-dialog-scrollable' role='document'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h5 class='modal-title fs-2'>Boarding House Rules</h5>
                  <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                </div>
                <div class='modal-body text-gray-500'>
                  {$rules}
                </div>
                <div class='modal-footer'>
                  <a type='button' class='btn me-auto' data-bs-dismiss='modal'>Close</a>
                  <a href='./listing.php?listing-id={$_GET['listing-id']}&make-booking=yes' type='button' class='btn btn-primary'>Confirm Booking</a>
                </div>
              </div>
            </div>
          </div>
          ";
      }
      ?>

      <?php
      if (isset($_GET['listing-id']) && isset($_GET['make-booking'])) {

        // If user is not logged in
        if (empty($_SESSION['user_id'])) {
          header('Location: ./login.php?checkpoint=not-logged-in&location=' . urlencode($_SERVER['REQUEST_URI']));
        }

        // ! Handle users that are not logged in

        if (!empty($_SESSION['user_id'])) {
          $user_id = $_SESSION['user_id'];
          $boarding_house_id = $_GET['listing-id'];

          // ? Ensure user is a student
          if ($_SESSION['account_type'] != 'student') {
            render_alert('danger', 'Booking failed!', 'Only students can book accommodation');
          }

          if ($_SESSION['account_type'] == 'student') {
            // Check if user already has a booking at a given property
            $results_user_bookings = get_user_bookings_at_listing($user_id, $boarding_house_id);
            $count_user_bookings = mysqli_num_rows($results_user_bookings);

            if ($count_user_bookings > 0) {
              render_alert('danger', 'Booking failed!', 'You already booked a room here. ', './student/index.php', 'View your bookings.');
            }

            if ($count_user_bookings == 0) {
              update_vacancies("decrease", $boarding_house_id);
              $result_booking = create_booking($user_id, $boarding_house_id);

              if ($result_booking) {
                render_alert('success', 'Booking successful!', 'To view your bookings, ', './student/index.php', 'go to your dashboard');
              }
            }
          }
        }
      }

      ?>
    </main>

    <!-- ! Footer -->
    <div class="footer">
      <?php include("./includes/footer.php") ?>
    </div>

  </div>
</body>

</html>