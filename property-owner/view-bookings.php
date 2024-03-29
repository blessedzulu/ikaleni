<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  check_page_access('property-owner');
  ?>
  <title>View Bookings</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <?php
  // ? Status Alerts
  if (isset($_SESSION['status'])) {
    if ($_SESSION['status'] == 'approve-booking-success') {
      render_alert('success', 'Booking approved', 'Booking approved successfully.');
    }

    if ($_SESSION['status'] == 'cancel-booking-success') {
      render_alert('success', 'Booking cancelled', 'Booking cancelled successfully.');
    }

    if ($_SESSION['status'] == 'decline-booking-success') {
      render_alert('success', 'Booking declined', 'Booking declined successfully.');
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

        <!-- ! View Bookings -->
        <div class="container mb-3 mb-lg-4">
          <div class="row g-2 align-items-center mb-3">
            <div class="col">
              <?php
              if (!isset($_GET['listing-id'])) {
                header('Location: ./');
              }

              if (isset($_GET['listing-id'])) {
                $result_listing = get_listing($_GET['listing-id']);

                $count = mysqli_num_rows($result_listing);

                if ($count == 0) {
                  header('Location: ./');
                  ob_end_flush();
                }

                $row_listing = mysqli_fetch_assoc($result_listing);
                $listing_name = $row_listing['name'];
              }

              echo "
              <h2 class='h6'>Bookings for <span>{$listing_name}</span></h2>
              ";
              ?>

            </div>

          </div>

          <div class="row">

            <div class="col-12">
              <!-- ! Search bookings -->
              <form method="post" action="./results-bookings.php">
                <div class="mb-3">
                  <div class="input-group mb-2">
                    <input type="text" class="form-control" name="search-query" placeholder="Search by tenant name…">
                    <button class="btn btn-primary" type="submit" name="submit-search">Search</button>
                  </div>
                </div>
              </form>
            </div>

            <?php

            if (isset($_GET['listing-id'])) {
              $_SESSION['search-listing-id'] = $_GET['listing-id'];
              $results_bookings = get_property_bookings($_GET['listing-id']);
              $count = mysqli_num_rows($results_bookings);
              $owner_id = $row_listing['owner_id'];
            }

            if ($_SESSION['user_id'] != $owner_id) {
              header('Location: ./');
              ob_end_flush();
            }

            if ($count == 0) {
              echo "
              <div class='col-12'>
                <div class='alert alert-info' role='alert'>
                 This property has no bookings
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
                          <th class='d-none d-xl-table-cell'>#</th>
                          <th></th>
                          <th>Tenant Name</th>
                          <th>Date Created</th>
                          <th>Date Approved</th>
                          <th>Status</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
              ";

              $iteration_count = 1;

              while ($row_booking = mysqli_fetch_assoc($results_bookings)) {
                // Fetch and store tenant details
                $tenant_id = $row_booking['tenant_id'];
                $result_tenant = get_user_by_id($tenant_id);
                $row_tenant = mysqli_fetch_assoc($result_tenant);
                $tenant_first_name = $row_tenant['first_name'];
                $tenant_last_name = $row_tenant['last_name'];
                $tenant_email = $row_tenant['email'];
                $tenant_initials = substr($tenant_first_name, 0, 1) . substr($tenant_last_name, 0, 1);
                $tenant_phone_number = $row_tenant['phone_number'];

                // Fetch and store boarding house details
                $listing_id = $row_booking['boarding_house_id'];
                $result_listing = get_listing($listing_id);
                $row_listing = mysqli_fetch_assoc($result_listing);
                $listing_name = $row_listing['name'];
                $listing_address = $row_listing['address'];
                $listing_township = $row_listing['township'];

                // Fetch and store owner details
                $owner_id = $row_listing['owner_id'];
                $result_owner = get_user_by_id($owner_id);
                $row_owner = mysqli_fetch_assoc($result_owner);
                $owner_first_name = $row_owner['first_name'];
                $owner_last_name = $row_owner['last_name'];
                $owner_email = $row_owner['email'];
                $owner_phone_number = $row_owner['phone_number'];

                // Booking Details
                $booking_id = $row_booking['id'];
                $booking_status = $row_booking['status'];

                $booking_date_created = $row_booking['date_created'];
                $booking_date_day = date('j',  strtotime($booking_date_created));
                $booking_date_month = date('F',  strtotime($booking_date_created));
                $booking_date_year = date('Y',  strtotime($booking_date_created));
                $booking_date_formated = date('j F, Y',  strtotime($booking_date_created));

                $booking_date_approved = $row_booking['date_approved'];
                $booking_date_approved_day = date('j',  strtotime($booking_date_approved));
                $booking_date_approved_month = date('F',  strtotime($booking_date_approved));
                $booking_date_approved_year = date('Y',  strtotime($booking_date_approved));
                $booking_date_approved_formated = date('j F, Y',  strtotime($booking_date_approved));

                if (strtolower($booking_status) == 'pending') {
                  echo "
                    <tr>
                      <td data-label='#' class='d-none d-xl-table-cell text-gray-300'>{$iteration_count}</td>
                      <td>
                        <span class='avatar avatar-md rounded-circle' style='background-image: src();'>{$tenant_initials}</span>
                      </td>
                      <td data-label='Tenant Name'>{$tenant_first_name} {$tenant_last_name}</td>
                      <td data-label='Date Created'>{$booking_date_formated}</td>
                      <td data-label='Date Approved'>-</td>
                      <td class='text-warning' data-label='Status'>{$booking_status}</td>
                      <td class='text-xl-end'>
                        <span class='dropdown'>
                          <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                          <div class='dropdown-menu dropdown-menu-end'>
                            <a class='dropdown-item text-success' onclick='return confirm(\"Are you sure you want to approve this booking?\")' href='?listing-id={$listing_id}&approve-booking={$booking_id}'>Approve booking</a>
                            <a class='dropdown-item text-danger' onclick='return confirm(\"Are you sure you want to decline this booking?\")' href='?listing-id={$listing_id}&decline-booking={$booking_id}'>Decline booking</a>
                            <a class='dropdown-item' href='tel:260{$owner_phone_number}'>Contact tenant</a>
                          </div>
                        </span>
                      </td>
                    </tr>
                  ";
                }

                if (strtolower($booking_status) == 'approved') {
                  echo "
                    <tr>
                      <td data-label='#' class='d-none d-xl-table-cell text-gray-300'>{$iteration_count}</td>
                      <td>
                        <span class='avatar avatar-md rounded-circle' style='background-image: src();'>{$tenant_initials}</span>
                      </td>
                      <td data-label='Tenant Name'>{$tenant_first_name} {$tenant_last_name}</td>
                      <td data-label='Date Created'>{$booking_date_formated}</td>
                      <td data-label='Date Approved'>{$booking_date_approved_formated}</td>
                      <td class='text-success' data-label='Status'>{$booking_status}</td>
                      <td class='text-xl-end'>
                        <span class='dropdown'>
                          <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                          <div class='dropdown-menu dropdown-menu-end'>
                            <a class='dropdown-item text-danger' onclick='return confirm(\"Are you sure you want to cancel this booking?\")' href='?listing-id={$listing_id}&cancel-booking={$booking_id}'>Cancel booking</a>
                            <a class='dropdown-item' href='tel:260{$owner_phone_number}'>Contact tenant</a>
                          </div>
                        </span>
                      </td>
                    </tr>
                  ";
                }
                $iteration_count += 1;
              }
            }
            ?>

            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php

  // ? Handle booking approvals
  if (isset($_GET['approve-booking'])) {
    $booking_id = $_GET['approve-booking'];

    // ? Fetch booking info
    $result_booking = get_booking($booking_id);
    $row_booking = mysqli_fetch_assoc($result_booking);
    $listing_id = $row_booking['boarding_house_id'];

    // ? Fetch listing owner info
    $result_listing = get_listing($listing_id);
    $row_listing = mysqli_fetch_assoc($result_listing);
    $owner_id = $row_listing['owner_id'];

    if (($_SESSION['user_id'] == $owner_id)) {
      $result_approve_booking = approve_booking($booking_id);

      if ($result_approve_booking) {
        // ? Mail tenant
        $tenant_msg = "Hello " . $tenant_first_name . ",\n";
        $tenant_msg .= "\nYour booking at " . $listing_name . " has been approved by the property owner. Go to your dashboard to see your booking.\n";
        $tenant_msg .= "\nWebsite: https://ikaleni.000webhostapp.com/student/";

        mail($tenant_email, "Booking Approved", $tenant_msg);

        // ? Mail property owner
        $owner_msg = "Hello " . $owner_first_name . ",\n";
        $owner_msg .= "You have approved " . $tenant_first_name . " " . $tenant_last_name . "'s booking at your property - " . $listing_name . "\n";
        $owner_msg .= "\nGo to your dashboard to view and manage other bookings.\n";
        $owner_msg .= "\nDashboard: https://ikaleni.000webhostapp.com/property-owner/";

        mail($owner_email, "Booking Approval Confirmation - " . $name, $owner_msg);

        // ? Redirect
        $_SESSION['status'] = 'approve-booking-success';
        header('Location: ./view-bookings.php?listing-id=' . $listing_id);
        ob_end_flush();
      }
    }
  }

  //  ? Handle Booking Cancellations
  if (isset($_GET['cancel-booking']) || isset($_GET['decline-booking'])) {
    $booking_id = isset($_GET['cancel-booking']) ? $_GET['cancel-booking'] : $_GET['decline-booking'];

    // ? Fetch booking info
    $result_booking = get_booking($booking_id);
    $row_booking = mysqli_fetch_assoc($result_booking);
    $tenant_id = $row_booking['tenant_id'];
    $listing_id = $row_booking['boarding_house_id'];

    // ? Fetch listing owner info
    $result_listing = get_listing($listing_id);
    $row_listing = mysqli_fetch_assoc($result_listing);
    $owner_id = $row_listing['owner_id'];

    if (($_SESSION['user_id'] == $owner_id)) {
      $result_delete_booking = delete_booking($booking_id);

      if ($result_delete_booking) {
        $result_update_vacancies = update_vacancies("increase", $listing_id);

        if (isset($_GET['cancel-booking'])) {
          $_SESSION['status'] = 'cancel-booking-success';

          // ? Mail tenant
          $tenant_msg = "Hello " . $tenant_first_name . ",\n";
          $tenant_msg .= "\nYour booking at " . $listing_name . " was cancelled by the property owner. Visit Ikaleni to find accommodation and to make another booking.\n";
          $tenant_msg .= "\nWebsite: https://ikaleni.000webhostapp.com/";

          mail($tenant_email, "Booking Cancelled", $tenant_msg);

          // ? Mail property owner
          $owner_msg = "Hello " . $owner_first_name . ",\n";
          $owner_msg .= "You have cancelled " . $owner_first_name . " " . $owner_last_name . "'s booking at your property - " . $listing_name . "\n";
          $owner_msg .= "\nGo to your dashboard to view and manage other bookings.\n";
          $owner_msg .= "\nDashboard: https://ikaleni.000webhostapp.com/property-owner/";

          mail($owner_email, "Booking Cancellation Confirmation - " . $listing_name, $owner_msg);
        }

        if (isset($_GET['decline-booking'])) {
          $_SESSION['status'] = 'decline-booking-success';

          // ? Mail tenant
          $tenant_msg = "Hello " . $tenant_first_name . ",\n";
          $tenant_msg .= "\nYour booking at " . $listing_name . " was declined. Visit Ikaleni to find accommodation and to make another booking.\n";
          $tenant_msg .= "\nWebsite: https://ikaleni.000webhostapp.com/";

          mail($tenant_email, "Booking Declined", $tenant_msg);

          // ? Mail property owner
          $owner_msg = "Hello " . $owner_first_name . ",\n";
          $owner_msg .= "You have declined " . $tenant_first_name . " " . $tenant_last_name . "'s booking at your property - " . $listing_name . "\n";
          $owner_msg .= "\nGo to your dashboard to view and manage other bookings.\n";
          $owner_msg .= "\nDashboard: https://ikaleni.000webhostapp.com/property-owner/";

          mail($owner_email, "Booking Declination Confirmation - " . $listing_name, $owner_msg);
        }

        // ? Redirect
        header('Location: ./view-bookings.php?listing-id=' . $listing_id);
        ob_end_flush();
      }
    };
  }
  ?>

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