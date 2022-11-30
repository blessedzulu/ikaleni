<?php
// Connect to database
function connect() {
  $user = "id19885043_localhost";
  $password = "j|O*A6&{/+^OpsV}";
  $host = "localhost";
  $db = "id19885043_ikaleni";

  // Return connection
  if (!$connection = mysqli_connect($host, $user, $password, $db)) {
    return die("Database connection failed.");
  }

  return $connection;
}

function query_db($connection, $query) {
  if (!$result = mysqli_query($connection, $query)) {
    return die("Query execution failed.");
  }

  mysqli_close($connection);

  return $result;
}

// ? Users
function create_user($account_type, $first_name, $last_name, $email, $password, $phone_number) {
  $conn = connect();

  $query = "INSERT INTO users(account_type, first_name, last_name, email, password, phone_number)";
  $query .= " VALUES('$account_type', '$first_name', '$last_name', '$email', '$password', '$phone_number')";

  return query_db($conn, $query);
}

function get_user_by_id($user_id) {
  $conn = connect();
  $query = "SELECT * FROM users WHERE id = '$user_id'";
  return query_db($conn, $query);
}

function get_user_by_email($email) {
  $conn = connect();
  $query = "SELECT * FROM users WHERE email = '$email'";

  return query_db($conn, $query);
}

function get_all_users() {
  $conn = connect();
  $query = "SELECT * FROM users";
  return query_db($conn, $query);
}

function authorise_user($user_id, $account_type, $first_name, $last_name, $email, $phone_number) {
  ob_start();
  session_start();

  $_SESSION['user_id'] = $user_id;
  $_SESSION['account_type'] = $account_type;
  $_SESSION['first_name'] = $first_name;
  $_SESSION['last_name'] = $last_name;
  $_SESSION['phone_number'] = $phone_number;
  $_SESSION['email'] = $email;

  if ($account_type == 'student') {
    header('Location: student/index.php');
    exit;
  }
  if ($account_type == 'property-owner') {
    header('Location: property-owner/index.php');
    exit;
  }
  if ($account_type == 'institution-admin') {
    header('Location: institution-admin/index.php');
    exit;
  }

  if ($account_type != 'student' && $account_type != 'property-owner' && $account_type != 'institution-admin') {
    $_SESSION['status'] = 'invalid-account-type';
    header('Location: ./logout.php');
    exit;
  }

  ob_end_flush();
}

// ? Listings & listing features
function get_all_features() {
  $conn = connect();
  $query = "SELECT * FROM listing_features";
  return query_db($conn, $query);
}

function create_listing($owner_id, $name, $address, $township, $gender, $price_per_month, $capacity, $people_per_room, $description, $rules, $cover_image, $features) {
  $conn = connect();

  $query = "INSERT INTO listings(owner_id, name, address, township, gender, price_per_month, capacity, vacancies, people_per_room, description, rules, image, features)";
  $query .= " VALUES($owner_id, '$name', '$address', '$township', '$gender', $price_per_month, $capacity, $capacity, $people_per_room, '$description', '$rules', '$cover_image', '$features');";

  return query_db($conn, $query);
}

function update_listing($listing_id, $name, $address, $township, $gender, $price_per_month, $capacity, $vacancies, $people_per_room, $description, $rules, $cover_image, $features) {
  $conn = connect();

  $query = "UPDATE listings SET name = '$name', address = '$address', township = '$township', gender = '$gender', price_per_month = $price_per_month, capacity = $capacity, vacancies = $vacancies, people_per_room = $people_per_room, description = '$description', rules = '$rules', image = '$cover_image', features = '$features' WHERE id = $listing_id";

  return query_db($conn, $query);
}

function get_listing($listing_id) {
  $conn = connect();
  $query = "SELECT * FROM listings WHERE id = $listing_id";
  return query_db($conn, $query);
}

function get_listings($owner_id) {
  $conn = connect();
  $query = "SELECT * FROM listings WHERE owner_id = $owner_id";
  return query_db($conn, $query);
}


function search_listings($township, $gender, $min_price, $max_price) {
  $conn = connect();
  $query = "SELECT * FROM listings WHERE township = '$township' AND gender = '$gender' AND price_per_month >= $min_price AND price_per_month <= $max_price";

  return query_db($conn, $query);
}

function update_vacancies($operation, $listing_id) {
  $conn = connect();

  if ($operation == "decrease") {
    $query = "UPDATE listings SET vacancies = vacancies - 1 WHERE vacancies > 0 AND id = $listing_id";
    return query_db($conn, $query);
  }

  if ($operation == "increase") {
    $query = "UPDATE listings SET vacancies = vacancies + 1 WHERE vacancies < capacity AND id = $listing_id";
    return query_db($conn, $query);
  }
};

function delete_listing($listing_id) {
  $conn = connect();
  $query = "DELETE FROM listings WHERE id = $listing_id";
  return query_db($conn, $query);
}

// ? Bookings
function create_booking($tenant_id, $listing_id) {
  $conn = connect();
  $query = "INSERT INTO bookings(tenant_id, boarding_house_id, date_created, date_approved, status)";
  $query .= " VALUES($tenant_id, $listing_id, NOW(), NOW(), 'Pending')";
  return query_db($conn, $query);
}

function get_all_bookings() {
  $conn = connect();
  $query = "SELECT * FROM bookings ORDER BY date_created DESC";
  return query_db($conn, $query);
}

function get_all_bookings_by_status($status) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE status = '$status' ORDER BY date_created DESC";
  return query_db($conn, $query);
}

function get_bookings_by_time($duration_ago, $interval) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE date_created < DATE_SUB(NOW(), INTERVAL $duration_ago $interval ) AND status = 'Pending'";
  return query_db($conn, $query);
}

function get_booking($booking_id) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE id = $booking_id";
  return query_db($conn, $query);
}

function get_property_bookings($property_id) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE boarding_house_id = '$property_id' ORDER BY date_created DESC";
  return query_db($conn, $query);
}

function search_property_bookings($property_id, $first_name, $last_name) {
  $conn = connect();
  $search_query = "SELECT *, bookings.id as booking_id FROM bookings JOIN users on bookings.tenant_id = users.id JOIN listings on bookings.boarding_house_id = listings.id WHERE boarding_house_id = $property_id AND (first_name LIKE '$first_name%' OR first_name LIKE '$last_name%' OR last_name LIKE '$last_name%' OR last_name LIKE '$first_name%') ORDER BY users.first_name ASC";

  return query_db($conn, $search_query);
}

function search_bookings_by_status($status, $first_name, $last_name) {
  $conn = connect();
  $search_query = "SELECT *, bookings.id as booking_id FROM bookings JOIN users on bookings.tenant_id = users.id JOIN listings on bookings.boarding_house_id = listings.id WHERE status = '$status' AND (first_name LIKE '$first_name%' OR first_name LIKE '$last_name%' OR last_name LIKE '$last_name%' OR last_name LIKE '$first_name%') ORDER BY users.first_name ASC";

  return query_db($conn, $search_query);
}

function get_user_bookings($user_id) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE tenant_id = $user_id ORDER BY date_created DESC";
  return query_db($conn, $query);
}

function get_user_bookings_at_listing($user_id, $listing_id) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE tenant_id = $user_id AND boarding_house_id = $listing_id";
  return query_db($conn, $query);
}

function delete_booking($booking_id) {
  $conn = connect();
  $query = "DELETE FROM bookings WHERE id = $booking_id";
  return query_db($conn, $query);
}

function approve_booking($booking_id) {
  $conn = connect();
  $query = "UPDATE bookings SET status = 'Approved', date_approved = NOW() WHERE id = $booking_id";
  return query_db($conn, $query);
}

// ? Helper Functions
function hyphenate_string($string) {
  $string = strtolower($string);
  $string = trim($string);
  $string = str_replace(' ', '-', $string);
  return $string;
}

function check_page_access($account_type) {
  if (empty($_SESSION['user_id']) || $_SESSION['account_type'] != $account_type) {
    $_SESSION['status'] = 'no-access';
    header('Location: ../login.php');
    ob_end_flush();
  }
}

function sanitise_input($input) {
  $conn = connect();
  $input = mysqli_real_escape_string($conn, $input);
  $input = trim($input);
  $input = stripslashes($input);

  return $input;
}

function sanitise_long_input($input) {
  $conn = connect();
  $input = mysqli_real_escape_string($conn, $input);
  $input = stripslashes($input);

  return $input;
}

// ? UI Rendering Functions
function render_alert($type, $title, $message = '', $href = '#', $link_text = '') {
  echo "
  <div class='position-fixed end-0 top-0 mt-5 mx-3' style='z-index: 999'>
    <div class='alert alert-{$type} alert-dismissible me-3' role='alert'>
      <div class='d-flex'>
        <div>
          <svg xmlns='http://www.w3.org/2000/svg' class='icon alert-icon' width='24' height='24' viewBox='0 0 24 24'
            stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'>
            <path stroke='none' d='M0 0h24v24H0z' fill='none'></path>
            <path d='M5 12l5 5l10 -10'></path>
          </svg>
        </div>
        <div>
          <h4 class='alert-title'>{$title}</h4>
          <div class='text-gray-500 fs-5'>{$message}<a href='{$href}' class='link link-{$type}'>{$link_text}</a></div>
        </div>
      </div>
      <a class='btn-close' data-bs-dismiss='alert' aria-label='close'></a>
    </div>
  </div>";
}
