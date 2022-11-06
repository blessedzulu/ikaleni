<?php

$current_year = date('Y');
$footer_company_markup = "
  <div class='col col-12 col-lg-3 me-auto'>
    <p class='fw-bold text-gray-900'>IKALENI</p>
    <p class='text-gray-500 mb-0 fs-4'>Boarding house booking and management system</p>
  </div>
";

function render_footer_index($dashboard_link, $current_year, $footer_company_markup) {
  echo "
    <div class='container'>
      <div class='row mb-4 mb-lg-5 justify-content-lg-between gap-4'>
    
        {$footer_company_markup}
      
        <div class='col col-12 col-lg-4'>
          <ul class='list-inline mb-0 d-flex flex-column gap-2'>
            <li class='list-inline-item text-gray-900 fw-bold'>Account</li>
            <li class='list-inline-item fs-4'><a href='./{$dashboard_link}' class='link'>Dashboard</a></li>
          </ul>
        </div>
      </div>
    
      <div class='text-center'>
        <p class='text-gray-300 fs-4'>Copyright © {$current_year}</p>
      </div>
    </div>
  ";
}

if (!isset($_SESSION['user_id'])) {
  echo "
    <div class='container'>
      <div class='row mb-4 mb-lg-5 justify-content-lg-between gap-4'>
        {$footer_company_markup}
    
        <div class='col col-12 col-lg-4'>
          <ul class='list-inline mb-0 d-flex flex-column gap-2'>
            <li class='list-inline-item text-gray-900 fw-bold'>Account</li>
            <li class='list-inline-item fs-4'><a href='./login.php' class='link'>Log In</a></li>
            <li class='list-inline-item fs-4'><a href='./sign-up.php' class='link'>Sign Up</a></li>
          </ul>
        </div>
      </div>
    
      <div class='text-center'>
        <p class='text-gray-300 fs-4'>Copyright © {$current_year}</p>
      </div>
    </div>
  ";
}

if (isset($_SESSION['user_id'])) {
  if ($_SESSION['account_type'] == 'student') {
    render_footer_index('./student/index.php', $current_year, $footer_company_markup);
  }

  if ($_SESSION['account_type'] == 'property-owner') {
    render_footer_index('./property-owner/index.php', $current_year, $footer_company_markup);
  }

  if ($_SESSION['account_type'] == 'institution-admin') {
    render_footer_index('./institution-admin/index.php', $current_year, $footer_company_markup);
  }
}
