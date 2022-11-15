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
              header('Location: ./login.php?checkpoint=wrong-password');
            }
          }

          // ? Email address not in use
          if ($count == 0) {
            render_alert('danger', 'Login failed', 'No account found for that email. ', './sign-up.php', 'Sign up here.');
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

  if (isset($_GET['checkpoint']) && $_GET['checkpoint'] == 'wrong-password') {
    render_alert('danger', 'Login failed', 'Wrong password. Please try again.');
  }

  if (isset($_GET['checkpoint']) && $_GET['checkpoint'] == 'no-access') {
    render_alert('warning', 'Page inaccessible', 'You do not have permission to access that page.');
  }

  if (isset($_GET['checkpoint']) && $_GET['checkpoint'] == 'not-logged-in' && !isset($_SESSION['user_id'])) {
    render_alert('warning', 'You are not logged in', 'Log in or sign up for an account to continue.');
  }

  if (isset($_GET['referrer']) == 'new-account') {
    render_alert('success', 'Account created successfully', 'Log into your new account to continue.');
  }
  ?>
</body>

</html>