<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  check_page_access('property-owner');
  ?>
  <title>Add Listing</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <header class="navbar navbar-expand-md navbar-light">
    <?php include("../includes/navigation.php") ?>
  </header>

  <div class="">
    <div class="container-narrow py-4 mt-4">

      <!-- Form Handler -->
      <?php
      // ? User input
      $name = $cover_image = $address = $township = $gender = $price = $capacity = $people_per_room = $description = $rules = "";

      // ? Input errors
      $name_error = $cover_image_error = $address_error = $township_error = $gender_error = $price_error = $capacity_error = $people_per_room_error = $description_error = $rules_error = "";

      $name_error_class = $cover_image_error_class = $address_error_class = $township_error_class = $gender_error_class = $price_error_class = $capacity_error_class = $people_per_room_error_class = $description_error_class = $rules_error_class = "";

      $errors_present = false;

      if (isset($_POST['submit-listing'])) {
        // Basic Attributes
        $name = sanitise_input($_POST['name']);
        $address = sanitise_input($_POST['address']);
        $township = sanitise_input($_POST['township']);
        $gender = sanitise_input($_POST['gender']);
        $price = sanitise_input($_POST['price']);
        $capacity = sanitise_input($_POST['capacity']);
        $people_per_room = sanitise_input($_POST['people-per-room']);
        $description = stripslashes(mysqli_real_escape_string(connect(), $_POST['description']));
        $rules = stripslashes(mysqli_real_escape_string(connect(), $_POST['rules']));

        // Cover image
        $cover_image = $_FILES["cover-image"]["name"];
        $cover_image_temp = $_FILES["cover-image"]["tmp_name"];

        // Features
        $features_str = '';
        $features_arr = [];

        $result_features = get_all_features();
        $row = mysqli_fetch_assoc($result_features);
        $features = $row['features'];
        $features = explode(',', $features);

        foreach ($features as $feature) {
          if (isset($_POST['feature-' . hyphenate_string($feature)])) {
            array_push($features_arr, $feature);
          }
        }

        $features_str = implode(',', $features_arr);

        // ? Form Validation
        // ? Listing name
        // Is empty
        if (empty($name)) {
          $name_error = "Name must not be empty";
          $name_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!preg_match("/^[a-zA-Z ']*$/", $name)) {
          $name_error = "Name must only contain letters and spaces";
          $name_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Cover image
        // Is empty
        if (empty($cover_image)) {
          $cover_image_error = "Cover image must not be empty";
          $cover_image_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!str_ends_with($cover_image, strtolower('.jpg')) && !str_ends_with($cover_image, strtolower('.jpeg')) && !str_ends_with($cover_image, strtolower('.png'))) {
          $cover_image_error = "Cover image must be a JPG or PNG image file";
          $cover_image_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Listing address
        // Is empty
        if (empty($address)) {
          $address_error = "Address must not be empty";
          $address_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!preg_match("/^[a-zA-Z0-9 ']*$/", $address)) {
          $address_error = "Address must only contain letters, spaces and numbers";
          $address_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Price per month
        // Numeric characters
        if (!preg_match('/^[0-9]+$/', $price)) {
          $price_error = "Price must be a number";
          $price_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($price)) {
          $price_error = "Price must not be empty or less than K1";
          $price_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Capacity
        // Numeric characters
        if (!preg_match('/^[0-9]+$/', $capacity)) {
          $capacity_error = "Capacity must be a number";
          $capacity_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($capacity)) {
          $capacity_error = "Capacity must not be empty or less than 1";
          $capacity_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? People per room
        // Numeric characters
        if (!preg_match('/^[0-9]+$/', $people_per_room)) {
          $people_per_room_error = "People per room must be a number";
          $people_per_room_error_class = "is-invalid";
          $errors_present = true;
        }

        // Greater than capacity
        if ($people_per_room > $capacity) {
          $people_per_room_error = "People per room cannot be greater than capacity";
          $people_per_room_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($people_per_room)) {
          $people_per_room_error = "People per room must not be empty or less than 1";
          $people_per_room_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Description
        // Is empty
        if (empty($description)) {
          $description_error = "Description must not be empty";
          $description_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Rules
        // Is empty
        if (empty($rules)) {
          $rules_error = "Rules must not be empty";
          $rules_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Process input
        if (!$errors_present) {
          // Upload cover image
          move_uploaded_file($cover_image_temp, "../assets/img/listings/{$cover_image}");

          // Add Listing to Database
          $result_create_listing = create_listing($_SESSION['user_id'], $name, $address, $township, $gender, $price, $capacity, $people_per_room, $description, $rules, $cover_image, $features_str);
        }

        // ? Show error alert
        if ($errors_present) {
          render_alert('danger', 'Failed to create listing', 'Fix the errors shown and try again');
        }
      }
      ?>

      <form class="card card-md bg-white" action="./create-listing.php" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <h2 class="h5 text-center mb-4">Add a Property Listing</h2>

          <div class="mb-3">
            <label class="form-label required">Boarding House Name</label>
            <input type="text" class="form-control <?= $name_error_class ?>" placeholder="ZUCT Boarding House" name="name" value="<?= $name ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $name_error ?></div>
          </div>
          <div class="mb-3">
            <div class="form-label">Boarding House Cover Image</div>
            <input type="file" name="cover-image" class="form-control <?= $cover_image_error_class ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $cover_image_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Township</label>
            <select class="form-select" name="township">
              <option value="Northrise">Northrise</option>
              <option value="Kansenshi">Kansenshi</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">Address</label>
            <input type="text" class="form-control <?= $address_error_class ?>" placeholder="5 James Phiri Road" name="address" value="<?= $address ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $address_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Target Gender</label>
            <select class="form-select" name="gender">
              <option value="Female">Female</option>
              <option value="Male">Male</option>
              <option value="Unisex">Unisex</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label required">Price per Month</label>
            <div class="input-group mb-2">
              <span class="input-group-text">ZMK</span>
              <input type="number" min="1" class="form-control <?= $price_error_class ?>" placeholder="500" name="price" value="<?= $price ?>" required>
            </div>
            <div class="mt-1 fs-5 text-danger"><?= $price_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Boarding House Capacity</label>
            <input type="number" min="1" class="form-control <?= $capacity_error_class ?>" placeholder="50" name="capacity" value="<?= $capacity ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $capacity_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">People per Room</label>
            <input type="number" min="1" class="form-control <?= $people_per_room_error_class ?>" placeholder="2" name="people-per-room" min="1" value="<?= $people_per_room ?>" required>
            <div class="mt-1 fs-5 text-danger"><?= $people_per_room_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="description">Boarding House Description</label>
            <textarea id="description" rows="5" name="description" class="form-control <?= $description_error_class ?>" required placeholder="Information about the boarding house, its unique selling points, the rooms, and why students would want to stay here"><?= $description ?></textarea>
            <div class="mt-1 fs-5 text-danger"><?= $description_error ?></div>
          </div>

          <div class="mb-3">
            <label class="form-label">Boarding House Features</label>
            <span class="text-gray-500 fs-5 mb-3 d-inline-block">Select all services offered to all tenants at this boarding house</span>
            <div class="form-selectgroup">
              <?php
              $result_features = get_all_features();

              $row = mysqli_fetch_assoc($result_features);
              $features = $row['features'];

              $features = explode(',', $features);

              foreach ($features as $feature) {
                $feature_input_name = 'feature-' . hyphenate_string($feature);

                echo "
                  <label class='form-selectgroup-item'>
                    <input type='checkbox' name='{$feature_input_name}' value='{$feature}' class='form-selectgroup-input'>
                    <span class='form-selectgroup-label rounded-pill'>{$feature}</span>
                  </label>
                ";
              }
              ?>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Boarding House Rules</label>
            <textarea rows="5" name="rules" class="form-control <?= $rules_error_class ?>" placeholder="Information about curfew, guests and other rules that tenants should observe" required><?= $rules ?></textarea>
            <div class="mt-1 fs-5 text-danger"><?= $rules_error ?></div>
          </div>
          <div class="form-footer">
            <button type="submit" name="submit-listing" class="btn btn-primary w-100">Create Listing</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <?php
  if (isset($_POST['submit-listing']) && !empty($result_create_listing)) {
    render_alert('success', 'Property listed successfully', 'View your listings on ', './index.php', 'your dashboard.');
  }
  ?>
</body>

</html>