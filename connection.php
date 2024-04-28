<?php
  include 'connectToDb.php';

  $conn = getDbConnection();

  if ( $conn ) {
    echo 'Connected to db successfully.';
  } else {
    echo 'Couldn\'t create to the db...';
  }
?>