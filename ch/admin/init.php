<?php

  include 'connect.php';

  //Routes

  $tpl = 'includes/templates/';  // Template directory 
  $lang = 'includes/languages/';
  $func = 'includes/functions/';
  $css = 'layout/css/';  // Css directory 
  $js = 'layout/js/';  // Js directory 
  
  include $func . 'functions.php';
  include $lang . 'english.php';
  include $tpl . 'header.php';


  if (!isset($noNavbar)) {

    include $tpl . 'navbar.php';

  }

  ?>