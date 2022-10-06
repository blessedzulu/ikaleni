<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 1;
  include("./includes/head.php");
  ?>
  <title>Log In</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <header class="navbar navbar-expand-md navbar-light">
    <?php include("./includes/navigation.php") ?>
  </header>

  <div class="">
    <div class="container-tight py-4 mt-4">
      <!-- Form Handler -->
      <?php
      if (isset($_GET['log-in'])) {
        if (isset($_GET['email']) && isset($_GET['password'])) {
          $conn = connect();

          $email = $_GET['email'];
          $password = $_GET['password'];

          $user_result = get_user_by_email($email);
          $count = mysqli_num_rows($user_result);

          if ($count != 0) {
            while ($row = mysqli_fetch_assoc($user_result)) {
              $user_id = $row['id'];
              $first_name = $row['first_name'];
              $last_name = $row['last_name'];
              $account_type = $row['account_type'];
              $email = $row['email'];
              $phone_number = $row['phone_number'];
              $hash = $row['password'];
            }

            if ($password_correct = password_verify($password, $hash)) {
              authenticate($user_id, $account_type, $first_name, $last_name, $email, $phone_number);
            };
          }
        }
      }
      ?>

      <form class="card card-md" action="./login.php" method="get">
        <div class="card-body">
          <h2 class="h5 text-center mb-4">Login to your account</h2>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control" placeholder="Enter email" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Password</label>
            <div class="input-group input-group-flat">
              <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
          </div>

          <!-- <div class="">
              <a href="./forgot-password.php">I forgot my password</a>
            </div> -->
          <!-- <div class="mb-2">
              <label class="form-check">
                <input type="checkbox" class="form-check-input">
                <span class="form-check-label">Remember me on this device</span>
              </label>
            </div> -->
          <div class="form-footer">
            <button type="submit" name="log-in" class="btn btn-primary w-100">Log In</button>
          </div>
        </div>
      </form>
      <div class="text-center text-gray-500 mt-3">
        Don't have an account? <a href="./sign-up.php" tabindex="-1">Sign up</a>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <?php include("./includes/footer.php") ?>
  </div>

  <?php
  if (isset($_GET['log-in']) && empty($password_correct)) {
    echo
    "<div class='position-fixed end-0 top-0 mt-5 mx-3'>
      <div class='alert alert-danger alert-dismissible me-3' role='alert'>
          <div class='d-flex'>
            <div>
              <svg xmlns='http://www.w3.org/2000/svg' class='icon alert-icon' width='24' height='24' viewBox='0 0 24 24'
                stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
                <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
                <path d='M5 12l5 5l10 -10'></path>
              </svg>
            </div>
            <div>
              <h4 class='alert-title'>Wrong login details</h4>
              <div class='text-danger fs-5'>Try to login again</div>
            </div>
          </div>
          <a class='btn-close' data-bs-dismiss='alert' aria-label='close'></a>
        </div>
    </div>";
  }
  ?>
</body>

</html>