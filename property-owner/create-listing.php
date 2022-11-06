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

      if (isset($_POST['submit-listing'])) {
        $conn = connect();

        // Basic Attributes
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $township = mysqli_real_escape_string($conn, $_POST['township']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
        $people_per_room = mysqli_real_escape_string($conn, $_POST['people-per-room']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $rules = mysqli_real_escape_string($conn, $_POST['rules']);

        // Cover Image
        $cover_image = $_FILES["cover-image"]["name"];
        $cover_image_temp = $_FILES["cover-image"]["tmp_name"];

        move_uploaded_file($cover_image_temp, "../assets/img/listings/{$cover_image}");

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

        // Add Listing to Database
        $result = create_listing($_SESSION['user_id'], $name, $address, $township, $gender, $price, $capacity, $people_per_room, $description, $rules, $cover_image, $features_str);
      }
      ?>

      <form class="card card-md bg-white" action="./create-listing.php" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <h2 class="h5 text-center mb-4">Add a Property Listing</h2>

          <div class="mb-3">
            <label class="form-label required">Boarding House Name</label>
            <input type="text" class="form-control" placeholder="ZUCT Boarding House" name="name" required>
          </div>
          <div class="mb-3">
            <div class="form-label">Boarding House Cover Image</div>
            <input type="file" name="cover-image" class="form-control" required>
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
            <input type="text" class="form-control" placeholder="5 James Phiri Road" name="address" required>
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
              <input type="number" min="0" class="form-control" placeholder="500" name="price" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Boarding House Capacity</label>
            <input type="number" class="form-control" placeholder="50" name="capacity" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">People per Room</label>
            <input type="number" class="form-control" placeholder="2" name="people-per-room" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="description">Boarding House Description</label>
            <textarea id="description" rows="5" name="description" class=" form-control" required placeholder="Information about the boarding house, its unique selling points, the rooms, and why students would want to stay here"></textarea>
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
            <textarea rows="5" name="rules" class="form-control" placeholder="Information about curfew, guests and other rules that tenants should observe" required></textarea>
          </div>
          <div class="form-footer">
            <button type="submit" name="submit-listing" class="btn btn-primary w-100">Create Listing</button>
          </div>
        </div>
      </form>

    </div>
  </div>

  <?php
  if (isset($_POST['submit-listing']) && $result) {
    render_alert('success', 'Property listed successfully', 'View your listings on ', './index.php', 'your dashboard.');
  }
  ?>
</body>

</html>