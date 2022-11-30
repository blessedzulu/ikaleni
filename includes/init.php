<?php
// ? Delete bookings scheduled for cancellation
$duration = 2;
$interval = "HOUR";

$results_bookings = get_bookings_by_time($duration, $interval);

while ($row_booking = mysqli_fetch_assoc($results_bookings)) {
  $booking_id = $row_booking['id'];
  $tenant_id = $row_booking['tenant_id'];
  $listing_id = $row_booking['boarding_house_id'];

  // ? Fetch and store tenant details
  $tenant_id = $row_bookings['tenant_id'];
  $result_tenant = get_user_by_id($tenant_id);
  $row_tenant = mysqli_fetch_assoc($result_tenant);
  $tenant_first_name = $row_tenant['first_name'];
  $tenant_last_name = $row_tenant['last_name'];
  $tenant_email = $row_tenant['email'];

  // ? Fetch and store boarding house details
  $result_listing = get_listing($listing_id);
  $row_listing = mysqli_fetch_assoc($result_listing);
  $listing_name = $row_listing['name'];

  // ? Fetch and store owner details
  $owner_id = $row_listing['owner_id'];
  $result_owner = get_user_by_id($owner_id);
  $row_owner = mysqli_fetch_assoc($result_owner);
  $owner_first_name = $row_owner['first_name'];
  $owner_last_name = $row_owner['last_name'];
  $owner_phone_number = $row_owner['phone_number'];
  $owner_email = $row_owner['email'];

  $result_delete_booking = delete_booking($booking_id);

  if ($result_delete_booking) {
    // ? Mail tenant
    $tenant_msg = "Hello " . $tenant_first_name . ",\n";
    $tenant_msg .= "\nYour booking at " . $listing_name . " was automatically cancelled because it was not approved within " . $duration . " " . strtolower($interval) . "s of being created. Visit Ikaleni to find accommodation and to make another booking.\n";
    $tenant_msg .= "\nWebsite: https://ikaleni.000webhostapp.com/";

    mail($tenant_email, "Booking Automatically Cancelled", $tenant_msg);

    // ? Mail property owner
    $owner_msg = "Hello " . $owner_first_name . ",\n";
    $owner_msg .= "A booking by " . $tenant_first_name . " " . $tenant_last_name . " at your property (" . $listing_name . ") was automatically cancelled because you had not approved it within 48 hours of it being created.\n";
    $owner_msg .= "\nGo to your dashboard to view and manage other bookings.\n";
    $owner_msg .= "\nDashboard: https://ikaleni.000webhostapp.com/property-owner/";

    mail($owner_email, "Booking Automatically Cancelled - " . $listing_name, $owner_msg);
  }
}
