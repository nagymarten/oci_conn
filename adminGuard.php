<?php
  session_start();

  $publicPages = [
    '/oci_conn/books/list',
    '/oci_conn/stores/list',
    '/oci_conn/review/list',
    '/oci_conn/home',
    'oci_conn/login',
    'oci_conn/registration',
    '/oci_conn/basket/list',
    '/oci_conn/statistics',
    '/oci_conn/statistics/list',
    '/oci_conn/statistics/stats/best_customer.php',
    '/oci_conn/statistics/stats/best_genre.php',
 ];

  $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
  $current_page = basename($_SERVER['PHP_SELF'], '.php');
  $locationname =  $uri . '/' . $current_page;

  $isAdmin = isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'Y';

  if ( !$isAdmin && !in_array($locationname, $publicPages) ) {
    $host  = $_SERVER['HTTP_HOST'];
    header("Location: http://$host/oci_conn/home.php");
  }

  // Check if the token exists in the session
  if (!isset($_SESSION['token'])) {
      // Redirect unauthenticated users to the login page
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/login.php");
      exit();
  }

  // Function to verify token (pseudo-code)
  function verifyToken($token) {
      //TODO
      return true;
  }

  // Verify the token
  if (!verifyToken($_SESSION['token'])) {
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/login.php");
      exit();
  }
  // Sign out functionality
  if (isset($_POST['signout'])) {
      // Unset all session variables
      session_unset();
      // Destroy the session
      session_destroy();
      // Redirect to login page
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'mypage.php';
      header("Location: http://$host/oci_conn/login.php");
  exit();
  }

?>