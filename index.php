<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 1;
  include("./includes/head.php");
  ?>
  <title>IKALENI - Boarding House Booking & Management System</title>
</head>

<body>
  <div class="page">
    <!-- ! Header & Navigation -->
    <header class="navbar navbar-expand-md navbar-light">
      <?php include("./includes/navigation.php") ?>
    </header>

    <!-- ! Main Content -->
    <main class="page-body mt-0">

      <!-- ! Hero Section -->
      <div class="container-fluid px-0 mb-6 mb-lg-7">
        <div class="px-4 d-flex justify-content-center align-items-center flex-column hero">
          <h1 class="h1 text-white fw-bold text-center mb-4 hero-text mt-4 mt-md-0">Find your ideal boarding house</h1>

          <!-- ! Search Form -->
          <div class="container d-flex justify-content-center">

            <form class="bg-white p-2 rounded-2 align-self-stretch align-self-md-center border shadow-lg search-form" action="./search-results.php" method="get">
              <div class="d-flex flex-column flex-md-row gap-2">
                <div class="form-floating w-100">
                  <select class="form-select border-1 rounded-2 bg-transparent" id="township" name="township" aria-label="Search form select township">
                    <option selected value="Northrise">Northrise</option>
                    <option value="Kansenshi">Kansenshi</option>
                  </select>
                  <label for="township" class="fs-4 text-gray-500">Township</label>
                </div>

                <div class="form-floating w-100">
                  <select class="form-select border-1 rounded-2 bg-transparent" id="gender" name="gender" aria-label="Search form select gender">
                    <option selected value="female">Female</option>
                    <option value="male">Male</option>
                    <option value="unisex">Unisex</option>
                  </select>
                  <label for="gender" class="fs-4 text-gray-500">Gender</label>
                </div>

                <div class="form-floating w-100">
                  <input type="number" min="0" class="form-control d-inline border-1 rounded-2 bg-transparent" id="min-price" name="min-price" value="0" required>
                  <label for="min-price" class="fs-4 text-gray-500">Min Price (K)</label>
                </div>

                <div class="form-floating w-100">
                  <input type="number" min="0" class="form-control d-inline  border-1 rounded-2 bg-transparent" id="max-price" name="max-price" value="1000" required>
                  <label for="max-price" class="fs-4 text-gray-500">Max Price (K)</label>
                </div>

                <button type="submit" value="submit-search" name="submit-search" class="btn btn-primary px-4 fs-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="var(--ikln-white)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <circle cx="10" cy="10" r="7"></circle>
                    <line x1="21" y1="21" x2="15" y2="15"></line>
                  </svg>
                  Search
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>

      <!-- ! Why Use Ikaleni? -->
      <div class="container mb-5 mb-lg-7">
        <div class="d-flex flex-column align-items-center">
          <h2 class="h2 mb-4 mb-lg-5 text-center">Why Use Ikaleni?</h2>

          <div class="row w-100">
            <div class="col col-12 col-lg-4">
              <div class="card border-0 shadow-none">
                <div class="card-body p-4 text-center">
                  <div class="mb-3">
                    <img src="./assets/static/img/convenience-icon.png" height="64" alt="Convenience icon">
                  </div>
                  <h6 class="h6 mb-2">Convenience</h6>
                  <p class="text-gray-500">
                    Find and book a boarding house from anywhere. No agents, no transport costs and no asking around.
                  </p>

                </div>
              </div>
            </div>

            <div class="col col-12 col-lg-4">
              <div class="card border-0 shadow-none">
                <div class="card-body p-4 text-center">
                  <div class="mb-3">
                    <img src="./assets/static/img/security-icon.png" height="64" alt="Security icon">
                  </div>
                  <h6 class="h6 mb-2">Security</h6>
                  <p class="text-gray-500">
                    We directly connect tenants to property owners and take care of every step of the booking process.
                    No scams.
                  </p>

                </div>
              </div>
            </div>

            <div class="col col-12 col-lg-4">
              <div class="card border-0 shadow-none">
                <div class="card-body p-4 text-center">
                  <div class="mb-3">
                    <img src="./assets/static/img/inclusivity-icon.png" height="64" alt="Inclusivity icon">
                  </div>
                  <h6 class="h6 mb-2">Inclusivity</h6>
                  <p class="text-gray-500">
                    We strive to cater to the accomodation needs of every type of student. If your ideal boarding
                    house exists, you'll find it here.
                  </p>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ! Quick Discovery -->
      <div class="container mb-5 mb-lg-7">
        <div class="d-flex flex-column align-items-center">
          <h2 class="h2 mb-4 mb-lg-5 text-center">Quick Discovery</h2>

          <div class="row w-100 justify-content-between align-items-center mb-5">
            <div class="col col-12 col-lg-4 order-last order-lg-0">
              <div class="card border-0 shadow-none">
                <div class="card-body p-0 mt-4 mb-lg-0">

                  <h5 class="h5 mb-3">Female Boarding Houses</h5>
                  <p class="text-gray-500 mb-3">
                    Integer feugiat morbi enim venenatis, eget amet faucibus ultrices sed at mauris sapien arcu,
                    mollis nibh eu pellentesque
                    nulla iaculis venenatis scelerisque risus.
                  </p>
                  <a href="#" class="link">
                    Find Female Boarding Houses
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                      <line x1="13" y1="18" x2="19" y2="12"></line>
                      <line x1="13" y1="6" x2="19" y2="12"></line>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
            <div class="col col-12 col-lg-6">
              <img src="./assets/static/img/placeholder.jpg" alt="Find female boarding houses" class="rounded-4">
            </div>
          </div>

          <div class="row w-100 justify-content-between align-items-center mb-5">
            <div class="col col-12 col-lg-6">
              <img src="./assets/static/img/placeholder.jpg" alt="Find female boarding houses" class="rounded-4">
            </div>
            <div class="col col-12 col-lg-4 order-last order-lg-0">
              <div class="card border-0 shadow-none">
                <div class="card-body p-0 mt-4 mb-lg-0">

                  <h5 class="h5 mb-3">Male Boarding Houses</h5>
                  <p class="text-gray-500 mb-3">
                    Integer feugiat morbi enim venenatis, eget amet faucibus ultrices sed at mauris sapien arcu,
                    mollis nibh eu pellentesque
                    nulla iaculis venenatis scelerisque risus.
                  </p>
                  <a href="#" class="link">
                    Find Male Boarding Houses
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                      <line x1="13" y1="18" x2="19" y2="12"></line>
                      <line x1="13" y1="6" x2="19" y2="12"></line>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="row w-100 justify-content-between align-items-center">
            <div class="col col-12 col-lg-4 order-last order-lg-0">
              <div class="card border-0 shadow-none">
                <div class="card-body p-0 mt-4 mb-lg-0">

                  <h5 class="h5 mb-3">Unisex Boarding Houses</h5>
                  <p class="text-gray-500 mb-3">
                    Integer feugiat morbi enim venenatis, eget amet faucibus ultrices sed at mauris sapien arcu,
                    mollis nibh eu pellentesque
                    nulla iaculis venenatis scelerisque risus.
                  </p>
                  <a href="#" class="link">
                    Find Unisex Boarding Houses
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <line x1="5" y1="12" x2="19" y2="12"></line>
                      <line x1="13" y1="18" x2="19" y2="12"></line>
                      <line x1="13" y1="6" x2="19" y2="12"></line>
                    </svg>
                  </a>
                </div>
              </div>
            </div>
            <div class="col col-12 col-lg-6">
              <img src="./assets/static/img/placeholder.jpg" alt="Find female boarding houses" class="rounded-4">
            </div>
          </div>
        </div>
      </div>

      <!-- ! How It Works? -->
      <div class="container mb-5 mb-lg-7">
        <div class="d-flex flex-column align-items-center">
          <h2 class="h2 mb-4 mb-lg-5 text-center">How it Works</h2>

          <!-- ! For Students -->
          <h4 class="h4 mb-3 mb-lg-4 align-self-start">For Students</h4>

          <div class="row w-100 justify-content-lg-between mb-4 mb-lg-5">
            <div class="col col-12 col-lg-4 d-flex gap-4 mb-5 mb-lg-0 how-it-works-card">
              <span class="how-it-works-number fw-bold text-gray-50">1</span>
              <div class="card border-0 shadow-none">
                <div class="card-body p-0">
                  <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-40 icon-tabler icon-tabler-search" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="var(--ikln-primary-500)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <circle cx="10" cy="10" r="7"></circle>
                      <line x1="21" y1="21" x2="15" y2="15"></line>
                    </svg>
                  </div>
                  <h6 class="h6 mb-2">Search</h6>
                  <p class="text-gray-500">
                    Specify your prefences and find matching boarding houses.
                  </p>
                </div>
              </div>
            </div>

            <div class="col col-12 col-lg-4 d-flex gap-4 mb-5 mb-lg-0 how-it-works-card">
              <span class="how-it-works-number fw-bold text-gray-50">2</span>
              <div class="card border-0 shadow-none">
                <div class="card-body p-0">
                  <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-40 icon-tabler icon-tabler-eye" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="var(--ikln-primary-500)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <circle cx="12" cy="12" r="2"></circle>
                      <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7">
                      </path>
                    </svg>
                  </div>
                  <h6 class="h6 mb-2">Browse</h6>
                  <p class="text-gray-500">
                    Browse our catalogue to find accommodation that meets your needs.
                  </p>
                </div>
              </div>
            </div>

            <div class="col col-12 col-lg-4 d-flex gap-4 mb-5 mb-lg-0 how-it-works-card">
              <span class="how-it-works-number fw-bold text-gray-50">3</span>
              <div class="card border-0 shadow-none">
                <div class="card-body p-0">
                  <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-40 icon-tabler icon-tabler-home-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="var(--ikln-primary-500)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2"></path>
                      <path d="M19 13.488v-1.488h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h4.525"></path>
                      <path d="M15 19l2 2l4 -4"></path>
                    </svg>
                  </div>
                  <h6 class="h6 mb-2">Book</h6>
                  <p class="text-gray-500">
                    Reserve a room or bed space at a boarding house of your choice.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <!-- ! For Property Owners -->
          <h4 class="h4 mb-3 mb-lg-4 align-self-start">For Property Owners</h4>

          <div class="row w-100 justify-content-lg-between mb-4 mb-lg-5">
            <div class="col col-12 col-lg-4 d-flex gap-4 mb-5 mb-lg-0 how-it-works-card">
              <span class="how-it-works-number fw-bold text-gray-50">1</span>
              <div class="card border-0 shadow-none">
                <div class="card-body p-0">
                  <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-40 icon-tabler icon-tabler-home-plus" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="var(--ikln-primary-500)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M19 12h2l-9 -9l-9 9h2v7a2 2 0 0 0 2 2h5.5"></path>
                      <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2"></path>
                      <path d="M16 19h6"></path>
                      <path d="M19 16v6"></path>
                    </svg>
                  </div>
                  <h6 class="h6 mb-2">List Property</h6>
                  <p class="text-gray-500">
                    Add your property and get discovered by potential tenants.
                  </p>
                </div>
              </div>
            </div>

            <div class="col col-12 col-lg-4 d-flex gap-4 mb-5 mb-lg-0 how-it-works-card">
              <span class="how-it-works-number fw-bold text-gray-50">2</span>
              <div class="card border-0 shadow-none">
                <div class="card-body p-0">
                  <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-40 icon-tabler icon-tabler-checklist" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="var(--ikln-primary-500)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8"></path>
                      <path d="M14 19l2 2l4 -4"></path>
                      <path d="M9 8h4"></path>
                      <path d="M9 12h2"></path>
                    </svg>
                  </div>
                  <h6 class="h6 mb-2">Approve Bookings</h6>
                  <p class="text-gray-500">
                    Approve or deny bookings as you see fit. You're in control.
                  </p>
                </div>
              </div>
            </div>

            <div class="col col-12 col-lg-4 d-flex gap-4 mb-5 mb-lg-0 how-it-works-card">
              <span class="how-it-works-number fw-bold text-gray-50">3</span>
              <div class="card border-0 shadow-none">
                <div class="card-body p-0">
                  <div class="mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-40 icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="var(--ikln-primary-500)" fill="none" stroke-linecap="round" stroke-linejoin="round">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                      <circle cx="9" cy="7" r="4"></circle>
                      <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                      <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                      <path d="M21 21v-2a4 4 0 0 0 -3 -3.85"></path>
                    </svg>
                  </div>
                  <h6 class="h6 mb-2">Manage Bookings</h6>
                  <p class="text-gray-500">
                    Keep track of all the relevant information about your tenants.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ! Call-to-Action -->
      <div class="container">
        <div class="d-flex flex-column align-items-center mb-5">

          <div class="row w-100 justify-content-between align-items-center">
            <div class="col">
              <div class="card border-0 shadow-lg cta-card cta-card-home rounded-4">
                <div class="card-body text-center p-3 p-lg-5">
                  <h2 class="h2 mb-3 text-white">Get Started</h2>
                  <p class="text-white mb-3">
                    Log in or sign up to book a boarding house or list your property.
                  </p>
                  <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center gap-2 gap-lg-3">
                    <a href="./login.php" class="btn btn-primary">Sign Up</a>
                    <a href="./sign-up.php" class="btn btn-light">Log In</a>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </div>
    </main>

    <!-- ! Footer -->
    <div class="footer">
      <?php include("./includes/footer.php") ?>
    </div>

  </div>
</body>

</html>