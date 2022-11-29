<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  check_page_access('institution-admin');
  ?>
  <title>Search Results - Students</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <header class="navbar navbar-expand-md navbar-light">
    <?php include("../includes/navigation.php") ?>
  </header>

  <div class="page">
    <div class="page-wrapper">
      <div class="page-body">

        <!-- ! All Students -->
        <div class="container mb-3 mb-lg-4">
          <div class="row g-2 align-items-center mb-3">
            <div class="col">
              <?php
              if (!isset($_POST['submit-search'])) {
                header("Location: ./");
                ob_end_flush();
              }

              if (isset($_POST['submit-search'])) {
                $conn = connect();
                $query_string = mysqli_real_escape_string($conn,  $_POST['search-query']);

                $first_name = $query_string;
                $last_name = ' ';

                if (strpos($query_string, ' ')) {
                  $first_name = substr($query_string, 0, strpos($query_string, ' '));
                  $last_name = substr($query_string, strpos($query_string, ' '));
                };

                $results_search = search_bookings_by_status("Approved", $first_name, $last_name);

                $count = mysqli_num_rows($results_search);

                $students_text = $count == 1 ? 'student' : 'students';
              }

              echo "
              <h2 class='h6'>{$count} {$students_text} found</span></h2>
              "
              ?>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <!-- ! Search bookings -->
              <form method="post" action="./results-students.php">
                <div class="mb-3">
                  <div class="input-group mb-2">
                    <input type="text" class="form-control" name="search-query" placeholder="Search by tenant name…">
                    <button class="btn btn-primary" type="submit" name="submit-search">Search</button>
                  </div>
                </div>
              </form>
            </div>

            <?php
            if ($count > 0) {
              echo "              
                <div class='col-12'>
                  <div class='card'>
                    <div class='table mb-0'>
                      <table class='table table-mobile-xl card-table table-vcenter'>
                        <thead>
                          <tr>
                            <th d-none d-xl-table-cell>#</th>
                            <th></th>
                            <th>Student Name</th>
                            <th>Boarding House Name</th>
                            <th>Boarding House Address</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
              ";

              $iteration_count = 1;

              while ($row_booking = mysqli_fetch_assoc($results_search)) {
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
                $booking_id = $row_booking['booking_id'];
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
                  <td data-label='#' class='text-gray-300 d-none d-xl-table-cell'>{$iteration_count}</td>
                  <td>
                    <span class='avatar avatar-md rounded-circle' style='background-image: src();'>{$tenant_initials}</span>
                  </td>
                  <td data-label='Student Name'>{$tenant_first_name} {$tenant_last_name}</td>
                  <td data-label='BH Name'>{$listing_name}</td>
                  <td data-label='BH Address'>{$listing_address}, {$listing_township}</td>
                  <td class='text-xl-end'>
                    <span class='dropdown'>
                      <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                      <div class='dropdown-menu dropdown-menu-end'>
                        <a class='dropdown-item' href='tel:260{$tenant_phone_number}'>Call student</a>
                        <a class='dropdown-item' href='tel:260{$owner_phone_number}'>Call property owner</a>
                      </div>
                    </span>
                  </td>
                </tr>
                ";

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

  </div>
  <footer class="footer footer-transparent d-print-none">
    <div class="container">
      <div class="row text-center align-items-center flex-row-reverse">
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