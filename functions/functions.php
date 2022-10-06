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

function authenticate($user_id, $account_type, $first_name, $last_name, $email, $phone_number) {
  ob_start();
  session_start();

  $_SESSION['user_id'] = $user_id;
  $_SESSION['account_type'] = $account_type;
  $_SESSION['first_name'] = $first_name;
  $_SESSION['last_name'] = $last_name;
  $_SESSION['phone_number'] = $phone_number;
  $_SESSION['email'] = $email;

  if ($account_type == 'student') {
    header("location: student/index.php");
    exit;
  }
  if ($account_type == 'property-owner') {
    header("location: property-owner/index.php");
    exit;
  }
  if ($account_type == 'institution-admin') {
    header("location: institution-admin/index.php");
    exit;
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

function create_booking($tenant_id, $boarding_house_id) {
  $conn = connect();
  $query = "INSERT INTO bookings(tenant_id, boarding_house_id, date_created, date_approved, status)";
  $query .= " VALUES ($tenant_id, $boarding_house_id, NOW(), '-', 'Pending')";
  return query_db($conn, $query);
}

function get_all_bookings() {
  $conn = connect();
  $query = "SELECT * FROM bookings";
  return query_db($conn, $query);
}

function get_property_bookings($property_id) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE boarding_house_id = '$property_id'";
  return query_db($conn, $query);
}

function get_user_bookings($user_id) {
  $conn = connect();
  $query = "SELECT * FROM bookings WHERE tenant_id = $user_id";
  return query_db($conn, $query);
}

function hyphenate_string($string) {
  $string = strtolower($string);
  $string = trim($string);
  $string = str_replace(' ', '-', $string);
  return $string;
}
