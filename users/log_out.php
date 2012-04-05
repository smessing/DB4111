<?php
  include("../static/php/header.php");
  if (isset($_SESSION['email'])) {
    session_destroy();
  }
  if (isset($_SERVER['HTTP_REFERER'])) {
    if (False === strpos($_SERVER['HTTP_REFERER'],"?")) {
      header("Location:" . $_SERVER['HTTP_REFERER'] . '?msg=logout');
    }
    else {
      header("Location:" . $_SERVER['HTTP_REFERER'] . '&msg=logout');
    }
  } else {
    header("Location:../main.php?msg=logout");
  }
  exit;

?>
