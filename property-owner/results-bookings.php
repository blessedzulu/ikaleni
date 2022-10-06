<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  ?>
  <title>Search Results - Property Bookings</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <header class="navbar navbar-expand-md navbar-light">
    <?php include("../includes/navigation.php") ?>
  </header>

  <div class="page">
    <div class="page-wrapper">
      <div class="page-body">

        <!-- ! Search results -->
        <div class="container mb-3 mb-lg-4">
          <div class="row g-2 align-items-center mb-3">
            <div class="col">
              <h2 class="h6">Search Results</h2>
            </div>
          </div>

          <div class="row">

            <div class="col-12">
              <div class="alert alert-success" role="alert">
                Your search returned 3 bookings
              </div>
            </div>

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

                      <tr>
                        <td data-label="#">1</td>
                        <td data-label="Tenant Name">Philip Bwalya</td>
                        <td data-label="Date Created">22 September 2022</td>
                        <td data-label="Rent Due Date">-</td>
                        <td class="text-warning" data-label="Status">Pending</td>
                        <td class="text-xl-end">
                          <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top d-inline-block" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="#">Approve booking</a>
                              <a class="dropdown-item" href="#">Contact tenant</a>
                            </div>
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td data-label="#">2</td>
                        <td data-label="Tenant Name">Philip Chinyanta</td>
                        <td data-label="Date Created">23 October 2022</td>
                        <td data-label="Rent Due Date">-</td>
                        <td class="text-warning" data-label="Status">Pending</td>
                        <td class="text-xl-end">
                          <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top d-inline-block" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="#">Approve booking</a>
                              <a class="dropdown-item" href="#">Contact tenant</a>
                            </div>
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td data-label="#">2</td>
                        <td data-label="Tenant Name">Philip Mpukuta</td>
                        <td data-label="Date Created">24 November 2022</td>
                        <td data-label="Rent Due Date">24 December 2022</td>
                        <td class="text-success" data-label="Status">Approved</td>
                        <td class="text-xl-end">
                          <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top d-inline-block" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="#">Approve booking</a>
                              <a class="dropdown-item" href="#">Contact tenant</a>
                            </div>
                          </span>
                        </td>
                      </tr>
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