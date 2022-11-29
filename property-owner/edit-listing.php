<?php ob_start() ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  $level = 2;
  include("../includes/head.php");
  check_page_access('property-owner');
  ?>
  <title>Update Listing</title>
</head>

<body class="border-top-wide border-primary d-flex flex-column">
  <header class="navbar navbar-expand-md navbar-light">
    <?php include("../includes/navigation.php") ?>
  </header>

  <div class="">
    <div class="container-narrow py-4 mt-4">

      <!-- Form Handler -->
      <?php
      // Variables
      $listing_id;
      $bookings;
      $capacity;
      $vacancies;

      // ? User input
      $new_name = $new_cover_image = $new_address = $new_township = $new_gender = $new_price = $new_capacity = $new_people_per_room = $new_description = $new_rules = "";

      // ? Input errors
      $name_error = $cover_image_error = $address_error = $township_error = $gender_error = $price_error = $capacity_error = $people_per_room_error = $description_error = $rules_error = "";

      $name_error_class = $cover_image_error_class = $address_error_class = $township_error_class = $gender_error_class = $price_error_class = $capacity_error_class = $people_per_room_error_class = $description_error_class = $rules_error_class = "";

      $errors_present = false;

      if (!isset($_GET['listing-id'])) {
        header('Location: ./index.php');
        ob_end_flush();
      }

      if (isset($_GET['listing-id'])) {
        $listing_id = $_GET['listing-id'];

        // ? Get listing details
        $result_listing = get_listing($listing_id);
        $row_listing = mysqli_fetch_assoc($result_listing);
        $count = mysqli_num_rows($result_listing);
        $owner_id = $row_listing['owner_id'];

        // ? Redirect if listing doest not exist
        if ($count == 0 || $_SESSION['user_id'] != $owner_id) {
          header('Location: ./index.php');
          ob_end_flush();
        }

        $name = $row_listing['name'];
        $address = $row_listing['address'];
        $township = $row_listing['township'];
        $gender = $row_listing['gender'];
        $price = $row_listing['price_per_month'];
        $capacity = $row_listing['capacity'];
        $vacancies = $row_listing['vacancies'];
        $people_per_room = $row_listing['people_per_room'];
        $description = $row_listing['description'];
        $rules = $row_listing['rules'];
        $bookings = $capacity - $vacancies;
      }

      // ? Update listing
      if (isset($_POST['update-listing'])) {
        // Basic Attributes
        $new_name = sanitise_input($_POST['name']);
        $new_address = sanitise_input($_POST['address']);
        $new_township = sanitise_input($_POST['township']);
        $new_gender = sanitise_input($_POST['gender']);
        $new_price = sanitise_input($_POST['price']);
        $new_capacity = sanitise_input($_POST['capacity']);
        $new_people_per_room = sanitise_input($_POST['people-per-room']);
        $new_description = mysqli_real_escape_string(connect(), $_POST['description']);
        $new_rules = mysqli_real_escape_string(connect(), $_POST['rules']);

        // Cover Image
        $new_cover_image = $_FILES["cover-image"]["name"];
        $new_cover_image_temp = $_FILES["cover-image"]["tmp_name"];


        // ? Handle features
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
        if (empty($new_name)) {
          $name_error = "Name must not be empty";
          $name_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!preg_match("/^[a-zA-Z ']*$/", $new_name)) {
          $name_error = "Name must only contain letters and spaces";
          $name_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Cover image
        // Is empty
        if (empty($new_cover_image)) {
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
        if (empty($new_address)) {
          $address_error = "Address must not be empty";
          $address_error_class = "is-invalid";
          $errors_present = true;
        }

        // Valid characters
        if (!preg_match("/^[a-zA-Z0-9 ']*$/", $new_address)) {
          $address_error = "Address must only contain letters, spaces and numbers";
          $address_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Price per month
        // Numeric characters
        if (!preg_match('/^[0-9]+$/', $new_price)) {
          $price_error = "Price must be a number";
          $price_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($new_price)) {
          $price_error = "Price must not be empty or less than K1";
          $price_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Capacity
        // Numeric characters
        if (!preg_match('/^[0-9]+$/', $new_capacity)) {
          $capacity_error = "Capacity must be a number";
          $capacity_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($new_capacity)) {
          $capacity_error = "Capacity must not be empty or less than 1";
          $capacity_error_class = "is-invalid";
          $errors_present = true;
        }

        $new_vacancies = $new_capacity - $bookings;

        if ($new_capacity - $bookings < 0) {
          $capacity_error = "Capacity must not be less than number of active bookings";
          $capacity_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? People per room
        // Numeric characters
        if (!preg_match('/^[0-9]+$/', $new_people_per_room)) {
          $people_per_room_error = "People per room must be a number";
          $people_per_room_error_class = "is-invalid";
          $errors_present = true;
        }

        // Greater than capacity
        if ($new_people_per_room > $new_capacity) {
          $people_per_room_error = "People per room must not be greater than capacity";
          $people_per_room_error_class = "is-invalid";
          $errors_present = true;
        }

        // Is empty
        if (empty($new_people_per_room)) {
          $people_per_room_error = "People per room must not be empty or less than 1";
          $people_per_room_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Description
        // Is empty
        if (empty($new_description)) {
          $description_error = "Description must not be empty";
          $description_error_class = "is-invalid";
          $errors_present = true;
        }

        // ? Rules
        // Is empty
        if (empty($new_rules)) {
          $rules_error = "Rules must not be empty";
          $rules_error_class = "is-invalid";
          $errors_present = true;
        }

        if (!$errors_present) {
          // ? Update listing
          move_uploaded_file($new_cover_image_temp, "../assets/img/listings/{$new_cover_image}");
          $result_update_booking = update_listing($listing_id, $new_name, $new_address, $new_township, $new_gender, $new_price, $new_capacity, $new_vacancies, $new_people_per_room, $new_description, $new_rules, $new_cover_image, $features_str);

          if (!empty($result_update_booking)) {
            render_alert('success', 'Listing updated successfully', 'View the updated listing on ', './index.php', 'your dashboard.');
          }
        }

        if ($errors_present) {
          render_alert('danger', 'Failed to update listing', 'Fix the errors shown and try again');
        }
      }
      ?>

      <form class="card card-md bg-white" action="" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <h2 class="h5 text-center mb-4">Update Your Property Listing</h2>

          <div class="mb-3">
            <label class="form-label required">Boarding House Name</label>
            <input type="text" class="form-control <?= $name_error_class ?>" value="<?= $new_name ?>" name="name" placeholder="ZUCT Boarding House" required>
            <div class="mt-1 fs-5 text-danger"><?= $name_error ?></div>
          </div>
          <div class="mb-3">
            <div class="form-label">Boarding House Cover Image</div>
            <input type="file" name="cover-image" class="form-control <?= $cover_image_error_class ?>" required>
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
            <input type="text" class="form-control <?= $address_error_class ?>" value="<?= $new_address ?>" name="address" placeholder="5 James Phiri Road" required>
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
              <input type="number" min="1" class="form-control <?= $price_error_class ?>" value="<?= $new_price ?>" name="price" placeholder="500" required>
            </div>
            <div class="mt-1 fs-5 text-danger"><?= $price_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Boarding House Capacity</label>
            <input type="number" min="1" class="form-control <?= $capacity_error_class ?>" value="<?= $new_capacity ?>" name="capacity" placeholder="50" required>
            <div class="mt-1 fs-5 text-danger"><?= $capacity_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label required">People per Room</label>
            <input type="number" min="1" class="form-control <?= $people_per_room_error_class ?>" value="<?= $new_people_per_room ?>" name="people-per-room" placeholder="2" required>
            <div class="mt-1 fs-5 text-danger"><?= $people_per_room_error ?></div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="description">Boarding House Description</label>
            <textarea id="description" rows="5" name="description" class="form-control <?= $description_error_class ?>" required placeholder="Information about the boarding house, its unique selling points, the rooms, and why students would want to stay here"><?= $new_description ?></textarea>
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
            <textarea rows="5" name="rules" class="form-control <?= $rules_error_class ?>" placeholder="Information about curfew, guests and other rules that tenants should observe" required><?= $new_rules ?></textarea>
            <div class="mt-1 fs-5 text-danger"><?= $rules_error ?></div>
          </div>
          <div class="form-footer">
            <button type="submit" name="update-listing" class="btn btn-primary w-100">Update Listing</button>
          </div>
        </div>
      </form>

    </div>
  </div>

</body>

</html>