<?php ob_start() ?>

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
  <?php
  // ? Status Alerts
  if (isset($_SESSION['status'])) {

    if ($_SESSION['status'] == 'not-logged-in') {
      render_alert('warning', 'You are not logged in', 'Log in or sign up for an account to continue.');
    }

    if ($_SESSION['status'] == 'invalid-account-type') {
      render_alert('danger', 'Login failed', 'The account type is invalid. Try again or ', './sign-up.php', 'Create a new account.');
    }

    if ($_SESSION['status'] == 'no-access') {
      render_alert('danger', 'Page inaccessible', 'You do not have permission to access that page.');
    }

    if ($_SESSION['status'] == 'create-account-success') {
      render_alert('success', 'Account created successfully', 'Continue to your account by ', './login.php', 'logging in.');
    }

    unset($_SESSION['status']);
    unset($_SESSION['status-message']);
  }
  ?>

  <header class="navbar navbar-expand-md navbar-light">
    <?php include("./includes/navigation.php") ?>
  </header>

  <div class="">
    <div class="container-tight py-4 mt-4">
      <!-- Form Handler -->
      <?php
      // ? User input
      $email = $password = "";

      // ? Input errors
      $password_error = $email_error = $phone_number_error = "";
      $password_error_class = $email_error_class  = "";
      $errors_present = false;

      if (isset($_GET['log-in'])) {
        if (isset($_GET['email']) && isset($_GET['password'])) {
          $email = sanitise_input($_GET['email']);
          $password = sanitise_input($_GET['password']);

          $result_user = get_user_by_email($email);
          $count = mysqli_num_rows($result_user);

          if ($count > 0) {
            $row_user = mysqli_fetch_assoc($result_user);
            $user_id = $row_user['id'];
            $first_name = $row_user['first_name'];
            $last_name = $row_user['last_name'];
            $account_type = $row_user['account_type'];
            $email = $row_user['email'];
            $phone_number = $row_user['phone_number'];
            $hash = $row_user['password'];

            // ? Authenticaton & authorisation
            if ($password_correct = password_verify($password, $hash)) {
              authorise_user($user_id, $account_type, $first_name, $last_name, $email, $phone_number);
            }

            if (!$password_correct) {
              $password_error = "Wrong password.";
              $password_error_class = "is-invalid";
              $errors_present = true;
            }
          }

          // ? Email address not in use
          if ($count == 0) {
            $email_error = "Email is not in use. Create a new account.";
            $email_error_class = "is-invalid";
            $errors_present = true;
          }

          if ($errors_present) {
            render_alert('danger', 'Login failed', 'Fix the errors and try again.');
          }
        }
      }
      ?>

      <form class="card card-md" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get">
        <div class="card-body bg-white">
          <h2 class="h5 text-center mb-4">Login to your account</h2>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control <?= $email_error_class ?>" placeholder="Enter email" name="email" value="<?= $email ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $email_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Password</label>
            <input type="password" class="form-control <?= $password_error_class ?>" placeholder="Password" name="password" required>
            <div class="mt-1 fs-5 text-danger"><?= $password_error ?></div>
          </div>

          <div class="">
            <button type="submit" name="log-in" class="btn btn-primary w-100">Log In</button>
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
        </div>
      </form>
      <div class="text-center text-gray-500 mt-3">
        Don't have an account? <a href="./sign-up.php" tabindex="-1">Sign up</a>
      </div>
    </div>

    <!-- Footer -->
    <div class="footer">
      <?php include("./includes/footer.php") ?>
    </div>
</body>

</html>