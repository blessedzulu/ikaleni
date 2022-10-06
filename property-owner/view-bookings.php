<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  ?>
  <title>View Bookings</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
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
              if (isset($_GET['listing-id'])) {
                $result_listing = get_listing($_GET['listing-id']);

                $row_listing = mysqli_fetch_assoc($result_listing);

                $listing_name = $row_listing['name'];
              }
              echo "
              <h2 class='h6'>Bookings for <span>{$listing_name}</span></h2>
              "
              ?>

            </div>

          </div>

          <div class="row">

            <div class="col-12">
              <!-- ! Search bookings -->
              <form method="post" action="./results-bookings.php">
                <div class="input-icon mb-3">
                  <input type="search" value="" class="form-control form-control-rounded" placeholder="Search by tenant name…">
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

            <?php

            if (isset($_GET['listing-id'])) {
              $results_bookings = get_property_bookings($_GET['listing-id']);
              $count = mysqli_num_rows($results_bookings);
            }

            if ($count == 0) {
              echo "
              <div class='col-12'>
                <div class='alert alert-info' role='alert'>
                 This property has no bookings — <a href='#' class='alert-link'>Add a Booking</a>
                </div>
              </div>
              ";
              exit();
            }
            ?>

            <div class="col-12">
              <div class="card">
                <div class="table mb-0">
                  <table class="table table-mobile-xl card-table table-vcenter">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Tenant Name</th>
                        <th>Date Created</th>
                        <th>Rent Due Date</th>
                        <th>Status</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php
                      while ($row_booking = mysqli_fetch_assoc($results_bookings)) {
                        // Fetch and store tenant details
                        $tenant_id = $row_booking['tenant_id'];
                        $result_tenant = get_user_by_id($tenant_id);
                        $row_tenant = mysqli_fetch_assoc($result_tenant);
                        $tenant_first_name = $row_tenant['first_name'];
                        $tenant_last_name = $row_tenant['last_name'];
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
                        $owner_phone_number = $row_owner['phone_number'];

                        // Booking Details
                        $booking_id = $row_booking['id'];
                        $booking_status = $row_booking['status'];

                        $booking_date_created = $row_booking['date_created'];
                        $booking_date_day = date('j',  strtotime($booking_date_created));
                        $booking_date_month = date('F',  strtotime($booking_date_created));
                        $booking_date_year = date('Y',  strtotime($booking_date_created));
                        $booking_date_formated = date('j F, Y',  strtotime($booking_date_created));

                        $booking_due_date = $row_booking['date_approved'];
                        $booking_due_date_day = date('j',  strtotime($booking_due_date));
                        $booking_due_date_month = date('F',  strtotime($booking_due_date));
                        $booking_due_date_year = date('Y',  strtotime($booking_due_date));
                        $booking_due_date_formated = date('j F, Y',  strtotime($booking_due_date));

                        echo "
                        <tr>
                          <td data-label='#'>1</td>
                          <td data-label='Tenant Name'>{$tenant_first_name} {$tenant_last_name}</td>
                          <td data-label='Date Created'>{$booking_date_formated}</td>
                          <td data-label='Rent Due Date'>-</td>
                          <td class='text-warning' data-label='Status'>{$booking_status}</td>
                          <td class='text-xl-end'>
                            <span class='dropdown'>
                              <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                              <div class='dropdown-menu dropdown-menu-end'>
                                <a class='dropdown-item' href='./?booking-id={$booking_id}&approve=1'>Approve booking</a>
                                <a class='dropdown-item' href='tel:260{$owner_phone_number}'>Contact tenant</a>
                              </div>
                            </span>
                          </td>
                        </tr>
                        ";
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