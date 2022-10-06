<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
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
              <h2 class="h6">Search Results</h2>
            </div>

          </div>

          <div class="row">
            <div class="col-12">
              <!-- ! Search Students -->
              <form method="post" action="./results-students.php">
                <div class="input-icon mb-3">
                  <input type="search" value="" class="form-control form-control-rounded" placeholder="Search by student name or ID…">
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
              <div class="alert alert-warning" role="alert">
                Your search returned 2 results
              </div>
            </div>

            <div class="col-12">
              <div class="card">
                <div class="table mb-0">
                  <table class="table table-mobile-xl card-table table-vcenter">
                    <thead>
                      <tr>
                        <th></th>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Boarding House Name</th>
                        <th>Boarding House Address</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <span class="avatar avatar-md rounded-circle" style="background-image: src();">BZ</span>
                        </td>
                        <td data-label="Student Name">Blessed Zulu</td>
                        <td data-label="BH Name">Persia Chibesa Boarding House</td>
                        <td data-label="BH Address">5 James Phiri Road, Northrise</td>
                        <td class="text-xl-end">
                          <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top d-inline-block" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="#">Contact student</a>
                              <a class="dropdown-item" href="#">Contact property owner</a>
                            </div>
                          </span>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <span class="avatar avatar-md rounded-circle" style="background-image: src();">DC</span>
                        </td>
                        <td data-label="Student Name">Derick Chinyanta</td>
                        <td data-label="BH Name">Arthur Davison Boarding House</td>
                        <td data-label="BH Address">5 Mwati Yamvwa Drive, Northrise</td>
                        <td class="text-xl-end">
                          <span class="dropdown">
                            <button class="btn dropdown-toggle align-text-top d-inline-block" data-bs-toggle="dropdown">Actions</button>
                            <div class="dropdown-menu dropdown-menu-end">
                              <a class="dropdown-item" href="#">Contact student</a>
                              <a class="dropdown-item" href="#">Contact property owner</a>
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