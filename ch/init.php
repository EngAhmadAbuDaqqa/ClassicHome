<?php
  ini_set('display-errors', 'On');
  error_reporting(E_ALL);

  include 'admin/connect.php';

  $sessionUser = '';
  if(isset($_SESSION['user'])) {
    $sessionUser = $_SESSION['user'];
  }

  //Routes

  $tpl  = 'includes/templates/';  // Template directory 
  $lang = 'includes/languages/';
  $func = 'includes/functions/';
  $css  = 'layout/css/';  // Css directory 
  $js   = 'layout/js/';  // Js directory 
  
  include $func . 'functions.php';
  include $tpl  . 'header.php';

  ?>