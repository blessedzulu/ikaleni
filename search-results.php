<!DOCTYPE html>
<html lang="en">

<head>

  <head>
    <?php
    $level = 1;
    include("./includes/head.php");
    ?>
    <title>Search Results - Properties</title>
  </head>
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
      if (isset($_GET['submit-search'])) {
        $township = $_GET['township'];
        $gender = $_GET['gender'];
        $min_price = $_GET['min-price'];
        $max_price = $_GET['max-price'];

        $results_search = search_listings($township, $gender, $min_price, $max_price);

        $count = mysqli_num_rows($results_search);
      }
      ?>

      <!-- ! Hero Section -->
      <div class="container-fluid px-0 mt-4 mt-lg-5 mb-4 mb-lg-5">
        <div class="d-flex justify-content-center align-items-center flex-column">

          <?php
          $count_text = $count == 0 || $count > 1 ? 'results' : 'result';

          echo "
              <h1 class='h3 text-gray-900 fw-bold text-center mb-3'>
                <span class='number-of-results'>{$count}</span> {$count_text} found
              </h1>
              ";
          ?>

          <p class='text-gray-500 mb-4 text-center'>Didn't find what you were looking for? Search again.</p>

          <!-- ! Search Form -->
          <div class='container d-flex justify-content-center'>
            <form class='bg-white p-2 rounded-2 align-self-stretch align-self-md-center border shadow-lg search-form' action='./search-results.php' method='get'>
              <div class='d-flex flex-column flex-md-row gap-2'>
                <div class='form-floating w-100'>
                  <select class='form-select border-1 rounded-2 bg-transparent' id='township' name='township' aria-label='Search form select township'>
                    <option selected value='Northrise'>Northrise</option>
                    <option value='Kansenshi'>Kansenshi</option>
                  </select>
                  <label for='township' class='fs-4 text-gray-500'>Township</label>
                </div>

                <div class='form-floating w-100'>
                  <select class='form-select border-1 rounded-2 bg-transparent' id='gender' name='gender' aria-label='Search form select gender'>
                    <option selected value='female'>Female</option>
                    <option value='male'>Male</option>
                    <option value='unisex'>Unisex</option>
                  </select>
                  <label for='gender' class='fs-4 text-gray-500'>Gender</label>
                </div>

                <div class='form-floating w-100'>
                  <input type='number' min='0' class='form-control d-inline border-1 rounded-2 bg-transparent' id='min-price' name='min-price' value='0' required>
                  <label for='min-price' class='fs-4 text-gray-500'>Min Price (K)</label>
                </div>

                <div class='form-floating w-100'>
                  <input type='number' min='0' class='form-control d-inline  border-1 rounded-2 bg-transparent' id='max-price' name='max-price' value='1000' required>
                  <label for='max-price' class='fs-4 text-gray-500'>Max Price (K)</label>
                </div>

                <button type='submit' value='submit-search' name='submit-search' class='btn btn-primary px-4 fs-3'>
                  <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-search' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='var(--ikln-white)' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                    <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                    <circle cx='10' cy='10' r='7'></circle>
                    <line x1='21' y1='21' x2='15' y2='15'></line>
                  </svg>
                  Search
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>

      <!-- ! Search Results -->
      <div class="container">
        <div class="row mb-3 mb-lg-4">
          <?php

          if (isset($_GET['submit-search'])) {

            if ($count > 0) {
              while ($row = mysqli_fetch_assoc($results_search)) {

                $id = $row['id'];
                $name = $row['name'];
                $address = $row['address'];
                $township = $row['township'];
                $gender = $row['gender'];
                $price = $row['price_per_month'];
                $capacity = $row['capacity'];
                $vacancies = $row['vacancies'];
                $people_per_room = $row['people_per_room'];
                $description = $row['description'];
                $rules = $row['rules'];
                $features = $row['features'];
                $cover_image = $row['image'];

                $vacancies_text = $vacancies == 0 || $vacancies > 1 ? 'vacancies' : 'vacancy';

                echo "
                <div class='col col-12 col-sm-6 col-md-4 col-lg-3 mb-3'>
                  <div class='card card-sm bg-white shadow hover-shadow'>
                    <div class='ratio ratio-16x9'>
                      <img class='d-block w-100 card-img-top object-cover' alt='Boarding house cover image' src='./assets/img/listings/{$cover_image}'>
                    </div>
                    <div class='card-body'>
                      <div>
                        <h2 class='fs-3 text-gray-700 p-0 pb-2 mb-1'>{$name}</h2>
                        <p class='mb-3 d-flex align-items-center text-gray-500 fs-4 border-bottom pb-2 mb-3'>
                          <svg xmlns='http://www.w3.org/2000/svg' class='icon icon-16 icon-tabler icon-tabler-map-pin me-2' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                            <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                            <circle cx='12' cy='11' r='3'></circle>
                            <path d='M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z'>
                            </path>
                          </svg>
                          <span class='me-1'>{$address},</span><span>{$township}</span>
      
                        </p>
                        <div class='d-flex align-items-baseline gap-1'>
                          <span class='h5'>K{$price}</span>
                          <span class='text-gray-500'>/ month</span>
                        </div>
                        <span class='fw-bold'>{$vacancies}</span><span> {$vacancies_text}</span></p>
                        <a href='./listing.php?listing-id={$id}' class='btn btn-outline-primary w-100'>View Details</a>
                      </div>
                    </div>
                  </div>
                </div>
                ";
              }
            }
          }
          ?>
        </div>

        <!-- ! Pagination -->
        <!-- <div class="d-flex justify-content-lg-center">
            <ul class="pagination">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <polyline points="15 6 9 12 15 18"></polyline>
                  </svg>
                  Prev
                </a>
              </li>
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item">
                <a class="page-link" href="#">
                  Next
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <polyline points="9 6 15 12 9 18"></polyline>
                  </svg>
                </a>
              </li>
            </ul>
          </div> -->
      </div>

    </main>

    <!-- ! Footer -->
    <div class="footer">
      <?php include("./includes/footer.php") ?>
    </div>

  </div>
</body>

</html>