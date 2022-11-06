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
        $conn = connect();

        // Basic Attributes
        $new_name = mysqli_real_escape_string($conn, $_POST['name']);
        $new_address = mysqli_real_escape_string($conn, $_POST['address']);
        $new_township = mysqli_real_escape_string($conn, $_POST['township']);
        $new_gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $new_price = mysqli_real_escape_string($conn, $_POST['price']);
        $new_capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
        $new_people_per_room = mysqli_real_escape_string($conn, $_POST['people-per-room']);
        $new_description = mysqli_real_escape_string($conn, $_POST['description']);
        $new_rules = mysqli_real_escape_string($conn, $_POST['rules']);

        // Cover Image
        $new_cover_image = $_FILES["cover-image"]["name"];
        $new_cover_image_temp = $_FILES["cover-image"]["tmp_name"];

        move_uploaded_file($new_cover_image_temp, "../assets/img/listings/{$new_cover_image}");

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

        // ? Checks
        // Update vacancies
        $new_vacancies = $new_capacity - $bookings;

        if ($new_capacity - $bookings < 0) {
          render_alert('danger', 'Listing update failed', 'The new capacity should not be less than the </br> number of active bookings (' . $bookings . ').');
        } else {
          // ? Update listing
          $result_update_booking = update_listing($listing_id, $new_name, $new_address, $new_township, $new_gender, $new_price, $new_capacity, $new_vacancies, $new_people_per_room, $new_description, $new_rules, $new_cover_image, $features_str);

          if (!empty($result_update_booking)) {
            render_alert('success', 'Property updated successfully', 'View your updated listing on ', './index.php', 'your dashboard.');
          }
        }
      }
      ?>

      <form class="card card-md bg-white" action="" method="post" enctype="multipart/form-data">
        <div class="card-body">
          <h2 class="h5 text-center mb-4">Update Your Property Listing</h2>

          <div class="mb-3">
            <label class="form-label required">Boarding House Name</label>
            <input type="text" class="form-control" value="<?= $name ?>" name="name" placeholder="ZUCT Boarding House" required>
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
            <input type="text" class="form-control" value="<?= $address ?>" name="address" placeholder="5 James Phiri Road" required>
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
              <input type="number" min="0" class="form-control" value="<?= $price ?>" name="price" placeholder="500" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label required">Boarding House Capacity</label>
            <input type="number" class="form-control" value="<?= $capacity ?>" name="capacity" placeholder="50" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">People per Room</label>
            <input type="number" class="form-control" value="<?= $people_per_room ?>" name="people-per-room" placeholder="2" required>
          </div>
          <div class="mb-3">
            <label class="form-label" for="description">Boarding House Description</label>
            <textarea id="description" rows="5" name="description" class=" form-control" required placeholder="Information about the boarding house, its unique selling points, the rooms, and why students would want to stay here"><?= $description ?></textarea>
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
            <textarea rows="5" name="rules" class="form-control" placeholder="Information about curfew, guests and other rules that tenants should observe" required><?= $rules ?></textarea>
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