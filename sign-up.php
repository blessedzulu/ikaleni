<?php ob_start() ?>

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

        // ? Read user details
        $account_type = $_POST['account-type'];
        $first_name = mysqli_real_escape_string($conn, $_POST['first-name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last-name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $phone_number = mysqli_real_escape_string($conn, $_POST['phone-number']);

        // ? Check if email is already in use
        $result_by_email = get_user_by_email($email);

        if (mysqli_num_rows($result_by_email) > 0) {
          render_alert('danger', 'Sign up failed', 'Email already in use. ', './login.php', 'Log in here.');
        }

        if (mysqli_num_rows($result_by_email) == 0) {
          // ? Process password
          $hash = password_hash($password, PASSWORD_DEFAULT);

          // ? Create user
          $result_create_account = create_user($account_type, $first_name, $last_name, $email, $hash, $phone_number);
          header('Location: ./login.php?referrer=new-account');
          ob_end_flush();
        }
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
</body>

</html>