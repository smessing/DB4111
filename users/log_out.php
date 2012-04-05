<?php
  include("../static/php/header.php");
  if (isset($_SESSION['email'])) {
    session_destroy();
  }
  header("Location:../index.php?msg=logout");
  exit;

?>
