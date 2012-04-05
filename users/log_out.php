<?php
  include("../static/php/header.php");
  if (isset($_SESSION['email'])) {
    session_destroy();
  }
  if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location:" . $_SERVER['HTTP_REFERER'] . '&msg=logout');
  } else {
    header("Location:../index.php?msg=logout");
  }
  exit;

?>
