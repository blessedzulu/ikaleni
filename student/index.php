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

        <!-- ! My Bookings -->
        <div class="container mb-3 mb-lg-4">
          <div class="row g-2 align-items-center mb-3">
            <div class="col">
              <h2 class="h6">My Bookings</h2>
            </div>
            <!-- Section actions -->
            <div class="col-12 col-sm-auto ms-auto d-print-none">
              <div class="btn-list">
                <a href="#" class="btn btn-primary">
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
              exit();
            }
            ?>

            <div class="col-12">
              <div class="card">
                <div class="table mb-0">
                  <table class="table table-mobile-xl card-table table-vcenter">
                    <thead>
                      <tr>
                        <th>BH Name</th>
                        <th>BH Address</th>
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
                            <td data-label='BH Name'>{$listing_name}</td>
                            <td data-label='BH Address'>{$listing_address}, {$listing_township}</td>
                            <td data-label='Date Created'>{$booking_date_formated}</td>
                            <td data-label='Rent Due'>-</td>
                            <td class='text-warning' data-label='Status'>{$booking_status}</td>
                            <td class='text-xl-end'>
                              <span class='dropdown'>
                                <button class='btn dropdown-toggle align-text-top d-inline-block' data-bs-toggle='dropdown'>Actions</button>
                                <div class='dropdown-menu dropdown-menu-end'>
                                  <a class='dropdown-item' href='#'>
                                    Call Property Owner
                                  </a>
                                  <a class='dropdown-item' href='#'>
                                    Cancel Booking
                                  </a>
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
                <li class="list-inline-item"><a href="../index.php" class="link-secondary">Find Accommodation</a>
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