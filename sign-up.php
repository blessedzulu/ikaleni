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
      // ? User input
      $account_type = $first_name = $last_name = $email = $password = $confirm_password = $phone_number = "";

      // ? Input errors
      $password_error = $first_name_error = $last_name_error = $email_error = $phone_number_error = "";
      $password_error_class = $first_name_error_class = $last_name_error_class = $email_error_class = $phone_number_error_class = "";
      $errors_present = false;

      if (isset($_POST['sign-up'])) {
        // ? Read user input
        $account_type = sanitise_input($_POST['account-type']);
        $first_name = sanitise_input($_POST['first-name']);
        $last_name = sanitise_input($_POST['last-name']);
        $email = sanitise_input($_POST['email']);
        $password = sanitise_input($_POST['password']);
        $confirm_password = sanitise_input($_POST['confirm-password']);
        $phone_number = sanitise_input($_POST['phone-number']);

        // ? Check if email is already in use
        $result_user_by_email = get_user_by_email($email);

        if (mysqli_num_rows($result_user_by_email) > 0) {
          $email_error = "Email already in use";
          $email_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Validate user input
        // ? First name
        // Is empty
        if (empty($first_name)) {
          $first_name_error = "First name must not be empty";
          $first_name_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!preg_match("/^[a-zA-Z-']*$/", $first_name)) {
          $first_name_error = "First name must only contain letters";
          $first_name_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Last name
        // Is empty
        if (empty($last_name)) {
          $last_name_error = "Last name must not be empty";
          $last_name_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!preg_match("/^[a-zA-Z-']*$/", $last_name)) {
          $last_name_error = "Last name must only contain letters";
          $last_name_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Email address
        // Is empty
        if (empty($email)) {
          $email_error = "Email must not be empty";
          $email_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $email_error = "Email address \"" . $email . "\" is invalid";
          $email_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Phone number
        // Wrong format
        if (!str_starts_with($phone_number, '97') && !str_starts_with($phone_number, '96') && !str_starts_with($phone_number, '95') && !str_starts_with($phone_number, '77') && !str_starts_with($phone_number, '76') && !str_starts_with($phone_number, '75')) {
          $phone_number_error = "Phone number \"+260 " . $phone_number . "\" is invalid";
          $phone_number_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!preg_match('/^[0-9]+$/', $phone_number)) {
          $phone_number_error = "Phone number must only contain numbers";
          $phone_number_error_class = "is-invalid";
          $errors_present = true;
        }

        // Correct length
        if (strlen($phone_number) != 9) {
          $phone_number_error = "Phone number must be 9 characters long";
          $phone_number_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($phone_number)) {
          $phone_number_error = "Phone number must not be empty";
          $phone_number_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Password/s
        // Is too short
        if (strlen($password) < 8 || strlen($confirm_password) < 8) {
          $password_error = "Password must be at least 8 characters long";
          $password_error_class = "is-invalid";
          $errors_present = true;
        }

        // Passwords do not match
        if ($password != $confirm_password) {
          $password_error = "Passwords do not match";
          $password_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($password) || empty($confirm_password)) {
          $password_error = "Password must not be empty";
          $password_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Create new user
        if (!$errors_present) {
          // ? Process password
          $hash = password_hash($password, PASSWORD_DEFAULT);

          // ? Create user
          $result_create_account = create_user($account_type, $first_name, $last_name, $email, $hash, $phone_number);
          $_SESSION['status'] = "create-account-success";
          header('Location: ./login.php');
          ob_end_flush();
        }

        // ? Show error alert 
        if ($errors_present) {
          render_alert('danger', 'Sign up failed', 'Fix the errors try again');
        }
      }
      ?>

      <form class="card card-md" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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
            <input type="text" class="form-control <?= $first_name_error_class ?>" placeholder="Enter first name" name="first-name" value="<?= $first_name ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $first_name_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Last Name</label>
            <input type="text" class="form-control <?= $last_name_error_class ?>" placeholder="Enter last name" name="last-name" value="<?= $last_name ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $last_name_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Email</label>
            <input type="email" class="form-control <?= $email_error_class ?>" placeholder="Enter email" name="email" value="<?= $email ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $email_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Phone Number</label>
            <div class="input-group mb-2">
              <span class="input-group-text">+260</span>
              <input type="tel" maxlength="9" class="form-control rounded-end <?= $phone_number_error_class ?>" placeholder="Enter phone number" name="phone-number" value="<?= $phone_number ?>" required>
            </div>
            <div class="mt-1 fs-5 text-danger"><?= $phone_number_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Password</label>
            <input type="password" class="form-control <?= $password_error_class ?>" placeholder="Password" name="password" required>
            <div class="mt-1 fs-5 text-danger"><?= $password_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Confirm Password</label>
            <input type="password" class="form-control <?= $password_error_class ?>" placeholder="Confirm password" name="confirm-password" required>
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