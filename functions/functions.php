<?php
// Connect to database
function connect() {
  $user = "root";
  $password = "";
  $host = "localhost";
  $db = "ikaleni";

  // Return connection
  if (!$connection = mysqli_connect($host, $user, $password, $db)) {
    return die("Database connection failed.");
  }

  return $connection;
}

function query_db($connection, $query) {
  if (!$result = mysqli_query($connection, $query)) {
    return die("Database query failed.");
  }

  return $result;
}

function create_user($account_type, $first_name, $last_name, $email, $password, $phone_number) {
  $conn = connect();

  $query = "INSERT INTO users(account_type, first_name, last_name, email, password, phone_number) 
            VALUES('$account_type', '$first_name', '$last_name', '$email', '$password', '$phone_number')";

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

function authenticate($user_id, $account_type, $first_name, $last_name, $email, $phone_number, $location) {
  ob_start();
  session_start();

  $_SESSION['user_id'] = $user_id;
  $_SESSION['account_type'] = $account_type;
  $_SESSION['first_name'] = $first_name;
  $_SESSION['last_name'] = $last_name;
  $_SESSION['phone_number'] = $phone_number;
  $_SESSION['email'] = $email;

  if (!empty($location)) {
    header('Location: ' . $location);
    exit;
  }



  if ($account_type == 'student') {
    header('Location: student/index.php');
  }
  if ($account_type == 'property-owner') {
    header('Location: property-owner/index.php');
  }
  if ($account_type == 'institution-admin') {
    header('Location: institution-admin/index.php');
  }

  ob_end_flush();
}

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

function update_vacancies($operation, $boarding_house_id) {
  $conn = connect();

  if ($operation == "decrease") {
    $query = "UPDATE listings SET vacancies = vacancies - 1 WHERE vacancies > 0 AND id = $boarding_house_id";
    return query_db($conn, $query);
  }

  if ($operation == "increase") {
    $query = "UPDATE listings SET vacancies = vacancies + 1 WHERE vacancies < capacity AND id = $boarding_house_id";
    return query_db($conn, $query);
  }
};

function create_booking($tenant_id, $boarding_house_id) {
  $conn = connect();
  $query = "INSERT INTO bookings(tenant_id, boarding_house_id, date_created, date_approved, status)";
  $query .= " VALUES ($tenant_id, $boarding_house_id, NOW(), '-', 'Pending')";
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
  $query = "DELETE FROM bookings WHERE id = '$booking_id'";
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
    header('Location: ../login.php?checkpoint=no-access');
    ob_end_flush();
  }
}

// ? UI Rendering Functions
function render_alert($type, $title, $message = '', $href = '#', $link_text = '') {
  echo
  "<div class='position-fixed end-0 top-0 mt-5 mx-3'>
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
