<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 1;
  include("./includes/head.php");
  ?>
  <title>Sign Up</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <header class="navbar navbar-expand-md navbar-light">
    <?php include("./includes/navigation.php") ?>
  </header>

  <div class="">
    <div class="container-tight py-4 mt-4">

      <!-- Form Handler -->
      <?php
      if (isset($_POST['sign-up'])) {
        $conn = connect();

        $account_type = $_POST['account-type'];
        $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone-number']);

        // Process password
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $result = create_user($account_type, $first_name, $last_name, $email, $hash, $phone_number);
      }
      ?>

      <form class="card card-md" action="./sign-up.php" method="post">
        <div class="card-body">
          <h2 class="h5 text-center mb-4">Sign Up For an Account</h2>

          <div class="mb-4 text-center">
            <label class="form-label fw-bold fs-3">Sign Up As</label>
            <div class="form-selectgroup">
              <label class="form-selectgroup-item">
                <input type="radio" name="account-type" value="student" class="form-selectgroup-input" checked>
                <span class="form-selectgroup-label">Student</span>
              </label>
              <label class="form-selectgroup-item">
                <input type="radio" name="account-type" value="property-owner" class="form-selectgroup-input">
                <span class="form-selectgroup-label">Property Owner</span>
              </label>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label required">First Name</label>
            <input type="text" class="form-control" placeholder="Enter first name" name="first-name" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Last Name</label>
            <input type="text" class="form-control" placeholder="Enter last name" name="last-name" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control" placeholder="Enter email" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Phone Number</label>
            <div class="input-group mb-2">
              <span class="input-group-text">+260</span>
              <input type="tel" maxlength="9" class="form-control" placeholder="Enter phone number" name="phone-number" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Password</label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
          </div>
          <!-- <div class="mb-3">
              <label class="form-check">
                <input type="checkbox" class="form-check-input">
                <span class="form-check-label">I agree to the <a href="./terms-of-service.php" tabindex="-1">terms of
                    use</a>.</span>
              </label>
            </div> -->
          <div class="form-footer">
            <button type="submit" name="sign-up" class="btn btn-primary w-100">Sign Up</button>
          </div>
        </div>
      </form>
      <div class="text-center text-muted mt-3">
        Already have an account? <a href="./login.php" tabindex="-1">Log in</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <?php include("./includes/footer.php") ?>
  </div>

  <?php
  if (isset($_POST['sign-up']) && $result) {
    echo
    "<div class='position-fixed end-0 top-0 mt-5 mx-3'>
      <div class='alert alert-success alert-dismissible me-3' role='alert'>
          <div class='d-flex'>
            <div>
              <svg xmlns='http://www.w3.org/2000/svg' class='icon alert-icon' width='24' height='24' viewBox='0 0 24 24'
                stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                <path d='M5 12l5 5l10 -10'></path>
              </svg>
            </div>
            <div>
              <h4 class='alert-title'>Account creation successful</h4>
              <div class='text-gray-500 fs-5'><a href='./login.php' class='link link-success'>Log in</a> into your new account</div>
            </div>
          </div>
          <a class='btn-close' data-bs-dismiss='alert' aria-label='close'></a>
        </div>
    </div>";
  }
  ?>
</body>

</html>