<?php
$url_prefix;
if ($level == 1) $url_prefix = './';
if ($level == 2) $url_prefix = '../';

if (isset($_SESSION['email'])) {
  $initials = substr($_SESSION['first_name'], 0, 1) . substr($_SESSION['last_name'], 0, 1);

  if ($_SESSION['account_type'] == "student") {
    echo "
      <div class='container'>
        <h1 class='navbar-brand d-none-navbar-horizontal pe-0 pe-md-3'>
        <a href='{$url_prefix}index.php' class='fw-bold mb-0 nav-link'>IKALENI</a>
        </h1>
        <div class='navbar-nav flex-row order-md-last'>
          <div class='nav-item dropdown'>
            <a href='#' class='nav-link d-flex lh-1 text-reset p-0 align-items-center' data-bs-toggle='dropdown' aria-label='Open user menu' aria-expanded='false'>
              <span class='avatar rounded-circle' style='background-image: url()'>{$initials}</span>
              <span class='d-none d-sm-inline ms-2'>{$_SESSION['first_name']} {$_SESSION['last_name']}</span>
            </a>
            <div class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
              <a href='{$url_prefix}{$_SESSION['account_type']}/index.php' class='dropdown-item'>Dashboard</a>
              <div class='dropdown-divider'></div>
              <span class='dropdown-item text-uppercase small text-gray-500 fs-6'>Accommodation</span>
              <a href='{$url_prefix}index.php' class='dropdown-item'>Find Accommodation</a>
              <div class='dropdown-divider'></div>
              <span class='dropdown-item text-uppercase small text-gray-500 fs-6'>Account</span>
              <a href='#' class='dropdown-item'>Edit Profile</a>
              <a href='{$url_prefix}logout.php' class='dropdown-item'>Logout</a>
            </div>
          </div>
        </div>
      </div>
    ";
  }

  if ($_SESSION['account_type'] == "property-owner") {
    echo "
      <div class='container'>
        <h1 class='navbar-brand d-none-navbar-horizontal pe-0 pe-md-3'>
        <a href='{$url_prefix}index.php' class='fw-bold mb-0 nav-link'>IKALENI</a>
        </h1>
        <div class='navbar-nav flex-row order-md-last'>
          <div class='nav-item dropdown'>
            <a href='#' class='nav-link d-flex lh-1 text-reset p-0 align-items-center' data-bs-toggle='dropdown' aria-label='Open user menu' aria-expanded='false'>
              <span class='avatar rounded-circle' style='background-image: url()'>{$initials}</span>
              <span class='d-none d-sm-inline ms-2'>{$_SESSION['first_name']} {$_SESSION['last_name']}</span>
            </a>
            <div class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
              <a href='{$url_prefix}{$_SESSION['account_type']}/index.php' class='dropdown-item'>Dashboard</a>
              <div class='dropdown-divider'></div>
              <span class='dropdown-item text-uppercase small text-gray-500 fs-6'>Properties</span>
              <a href='{$url_prefix}{$_SESSION['account_type']}/my-properties.php' class='dropdown-item'>My Properties</a>
              <a href='{$url_prefix}{$_SESSION['account_type']}/create-listing.php' class='dropdown-item'>List a Property</a>
              <div class='dropdown-divider'></div>
              <span class='dropdown-item text-uppercase small text-gray-500 fs-6'>Account</span>
              <a href='#' class='dropdown-item'>Edit Profile</a>
              <a href='{$url_prefix}logout.php' class='dropdown-item'>Logout</a>
            </div>
          </div>
        </div>
      </div>
    ";
  }

  if ($_SESSION['account_type'] == "institution-admin") {
    echo "
      <div class='container'>
        <h1 class='navbar-brand d-none-navbar-horizontal pe-0 pe-md-3'>
        <a href='{$url_prefix}index.php' class='fw-bold mb-0 nav-link'>IKALENI</a>
        </h1>
        <div class='navbar-nav flex-row order-md-last'>
          <div class='nav-item dropdown'>
            <a href='#' class='nav-link d-flex lh-1 text-reset p-0 align-items-center' data-bs-toggle='dropdown' aria-label='Open user menu' aria-expanded='false'>
              <span class='avatar rounded-circle' style='background-image: url()'>{$initials}</span>
              <span class='d-none d-sm-inline ms-2'>{$_SESSION['first_name']} {$_SESSION['last_name']}</span>
            </a>
            <div class='dropdown-menu dropdown-menu-end dropdown-menu-arrow'>
              <a href='{$url_prefix}{$_SESSION['account_type']}/index.php' class='dropdown-item'>Dashboard</a>
              <div class='dropdown-divider'></div>
              <span class='dropdown-item text-uppercase small text-gray-500 fs-6'>Account</span>
              <a href='{$url_prefix}logout.php' class='dropdown-item'>Logout</a>
            </div>
          </div>
        </div>
      </div>
    ";
  }
} else {
  echo "
    <div class='container'>
      <button class='navbar-toggler order-1' type='button' data-bs-toggle='collapse' data-bs-target='#navbar-menu'>
        <span class='navbar-toggler-icon'></span>
      </button>
      <h1 class='navbar-brand d-none-navbar-horizontal pe-0 pe-md-3'>
        <a href='{$url_prefix}index.php' class='fw-bold mb-0 nav-link'>IKALENI</a>
      </h1>
      <div class='collapse navbar-collapse' id='navbar-menu'>
        <div class='d-flex flex-column flex-md-row justify-content-end flex-fill align-items-stretch align-items-md-center'>
          <ul class='navbar-nav'>
            <li class='nav-item'>
              <a class='nav-link' href='{$url_prefix}login.php'>Log In</a>
            </li>
            <li class='nav-item'>
              <a class='nav-link' href='{$url_prefix}sign-up.php'>Sign Up</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    ";
}
