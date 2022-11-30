<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  check_page_access('student');
  ?>
  <title>Dashboard</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <?php
  // ? Status Alerts
  if (isset($_SESSION['status'])) {

    if ($_SESSION['status'] == 'cancel-booking-success') {
      render_alert('success', 'Booking cancelled', 'You cancelled your booking. ', '../index.php', 'Make a new booking.');
    }

    unset($_SESSION['status']);
  }
  ?>

  <header class="navbar navbar-expand-md navbar-light">
    <?php include("../includes/navigation.php") ?>
  </header>

  <div class="page">
    <div class="page-wrapper">
      <div class="page-body">

        <!-- ! My Bookings -->
        <div class="container mb-3 mb-lg-4">
          <div class="row g-2 align-items-center mb-3">
            <div class="col">
              <h2 class="h6">My Bookings</h2>
            </div>
            <!-- Section actions -->
            <div class="col-12 col-sm-auto ms-auto d-print-none">
              <div class="btn-list">
                <a href="../index.php" class="btn btn-primary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                  </svg>
                  Find Accommodation
                </a>
              </div>
            </div>
          </div>

          <div class="row">

            <?php
            $results_bookings = get_user_bookings($_SESSION['user_id']);
            $count = mysqli_num_rows($results_bookings);

            if ($count == 0) {
              echo "
              <div class='col-12'>
                <div class='alert alert-info' role='alert'>
                 You have no active bookings — <a href='../index.php' class='alert-link'>Find Accommodation</a>
                </div>
              </div>
              ";
            }

            if ($count > 0) {
              echo "
                <div class='col-12'>
                  <div class='card'>
                    <div class='table mb-0'>
                      <table class='table table-mobile-xl card-table table-vcenter'>
                        <thead>
                          <tr>
                            <th d-none d-xl-table-cell>#</th>
                            <th>BH Name</th>
                            <th>BH Address</th>
                            <th>Date Created</th>
                            <th>Date Approved</th>
                            <th>Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                ";
            }

            $iteration_count = 1;

            while ($row_bookings = mysqli_fetch_assoc($results_bookings)) {
              // ? Fetch and store tenant details
              $tenant_id = $row_bookings['tenant_id'];
              $result_tenant = get_user_by_id($tenant_id);
              $row_tenant = mysqli_fetch_assoc($result_tenant);
              $tenant_first_name = $row_tenant['first_name'];
              $tenant_last_name = $row_tenant['last_name'];
              $tenant_email = $row_tenant['email'];

              // ? Fetch and store boarding house details
              $listing_id = $row_bookings['boarding_house_id'];
              $result_listing = get_listing($listing_id);
              $row_listing = mysqli_fetch_assoc($result_listing);
              $listing_name = $row_listing['name'];
              $listing_address = $row_listing['address'];
              $listing_township = $row_listing['township'];

              // ? Fetch and store owner details
              $owner_id = $row_listing['owner_id'];
              $result_owner = get_user_by_id($owner_id);
              $row_owner = mysqli_fetch_assoc($result_owner);
              $owner_first_name = $row_owner['first_name'];
              $owner_last_name = $row_owner['last_name'];
              $owner_phone_number = $row_owner['phone_number'];
              $owner_email = $row_owner['email'];

              // ? Booking Details
              $booking_id = $row_bookings['id'];
              $booking_status = $row_bookings['status'];

              $booking_date_created = $row_bookings['date_created'];
              $booking_date_day = date('j',  strtotime($booking_date_created));
              $booking_date_month = date('F',  strtotime($booking_date_created));
              $booking_date_year = date('Y',  strtotime($booking_date_created));
              $booking_date_formated = date('j F, Y',  strtotime($booking_date_created));

              $booking_date_approved = $row_bookings['date_approved'];
              $booking_date_approved_day = date('j',  strtotime($booking_date_approved));
              $booking_date_approved_month = date('F',  strtotime($booking_date_approved));
              $booking_date_approved_year = date('Y',  strtotime($booking_date_approved));
              $booking_date_approved_formated = date('j F, Y',  strtotime($booking_date_approved));

              if (strtolower($booking_status) == 'pending') {
                echo "
                  <tr>
                    <td data-label='#' class='text-gray-300 d-none d-xl-table-cell'>{$iteration_count}</td>
                    <td data-label='BH Name'>{$listing_name}</td>
                    <td data-label='BH Address'>{$listing_address}, {$listing_township}</td>
                    <td data-label='Date Created'>{$booking_date_formated}</td>
                    <td data-label='Date Approved'>-</td>
                    <td class='text-warning' data-label='Status'>{$booking_status}</td>
                    <td class='text-xl-end'>
                      <span class='dropdown'>
                        <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                        <div class='dropdown-menu dropdown-menu-end'>
                          <a class='dropdown-item' href='tel:+260{$owner_phone_number}'>
                            Call Property Owner
                          </a>
                          <a class='dropdown-item text-danger' onclick='return confirm(\"Are you sure you want to cancel this booking?\")' href='./?cancel-booking={$booking_id}'>
                            Cancel Booking
                          </a>
                        </div>
                      </span>
                    </td>
                  </tr>
                ";
              }

              if (strtolower($booking_status) == 'approved') {
                echo "
                  <tr>
                    <td data-label='#' class='text-gray-300 d-none d-xl-table-cell'>{$iteration_count}</td>
                    <td data-label='BH Name'>{$listing_name}</td>
                    <td data-label='BH Address'>{$listing_address}, {$listing_township}</td>
                    <td data-label='Date Created'>{$booking_date_formated}</td>
                    <td data-label='Date Approved'>{$booking_date_approved_formated}</td>
                    <td class='text-success' data-label='Status'>{$booking_status}</td>
                    <td class='text-xl-end'>
                      <span class='dropdown'>
                        <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                        <div class='dropdown-menu dropdown-menu-end'>
                          <a class='dropdown-item' href='tel:+260{$owner_phone_number}'>
                            Call Property Owner
                          </a>
                          <a class='dropdown-item' href='../listing.php?listing-id={$listing_id}'>
                            View Listing
                          </a>
                          <a class='dropdown-item text-danger' onclick='return confirm(\"Are you sure you want to cancel this booking?\")' href='./?cancel-booking={$booking_id}'>
                            Cancel Booking
                          </a>
                        </div>
                      </span>
                    </td>
                  </tr>
                ";
              }

              $iteration_count += 1;
            }

            ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Handle Booking Cancellations -->
  <?php
  if (isset($_GET['cancel-booking'])) {
    $booking_id = $_GET['cancel-booking'];

    // ? Fetch booking info
    $result_booking = get_booking($booking_id);
    $row_booking = mysqli_fetch_assoc($result_booking);
    $tenant_id = $row_booking['tenant_id'];
    $listing_id = $row_booking['boarding_house_id'];

    if (($_SESSION['user_id'] == $tenant_id)) {
      $result_delete_booking = delete_booking($booking_id);

      if (!empty($result_delete_booking)) {
        $result_update_vacancies = update_vacancies("increase", $listing_id);

        // ? Mail tenant
        $tenant_msg = "Hello " . $tenant_first_name . ",\n";
        $tenant_msg .= "\nYour booking at " . $listing_name . " has been cancelled successfully. Visit Ikaleni to find accommodation and to make another booking.\n";
        $tenant_msg .= "\nWebsite: https://ikaleni.000webhostapp.com/";

        mail($tenant_email, "Booking Cancellation Confirmation", $tenant_msg);

        // ? Mail property owner
        $owner_msg = "Hello " . $owner_first_name . ",\n";
        $owner_msg .= $tenant_first_name . " " . $tenant_last_name . "\n has cancelled their booking at your property - " . $listing_name . " The vacancy is now available for another tenant to book.\n";
        $owner_msg .= "\nGo to your dashboard to view and manage other bookings.\n";
        $owner_msg .= "\nDashboard: https://ikaleni.000webhostapp.com/property-owner/";

        mail($owner_email, "Booking Cancelled - " . $listing_name, $owner_msg);

        // ? Redirect
        $_SESSION['status'] = 'cancel-booking-success';
        header('Location: ./');
        ob_end_flush();
      }
    };
  }
  ?>

  <footer class="footer footer-transparent d-print-none">
    <div class="container">
      <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
          <ul class="list-inline list-inline-dots mb-0">
            <li class="list-inline-item">
              <a href="../index.php" class="link-secondary">Find Accommodation</a>
            </li>
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