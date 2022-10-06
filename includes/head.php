<?php
$url_prefix;
if ($level == 1) $url_prefix = './';
if ($level == 2) $url_prefix = '../';

include($url_prefix . 'globals/variables.php');
include($url_prefix . 'functions/functions.php');
session_start();
?>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Styles -->
<link rel="stylesheet" href="<?= $url_prefix . 'assets/css/base.css' ?>">
<link rel="stylesheet" href="<?= $url_prefix . 'assets/css/style.css' ?>">

<!-- Scripts -->
<script src="<?= $url_prefix . 'assets/js/base.js' ?>" defer></script>