<?php
  include("../static/php/header.php");
  require_once "../static/php/db.php";

  
  // catch variables from form and get date
  
  $commentString = $_POST['userComment'];
  $pid = $_POST['pid'];
  $tid = $_POST['tid'];
  $today = time(); 
  
  var_dump($today);
  
  // check if we're already logged in:
  if (0 == isset($_SESSION['email'])) {
    header("Location:profile.php?error=not_logged_in_comment");
    exit;
  }
  else {
    $email = $_SESSION['email'];
  }
  
  
  // ***TO DO: sanitize input
  
  
  // construct insert statement
  $insertString = "insert into comments_ABOUT (tid, pid, comments, cDate, email) " . 
                  "values ('" . $tid . "', '" . $pid . "', '" . $commentString . "', '" . $today . "', '" . $email . "')";
  //var_dump($insertString);
  // insert
  insert($insertString, $conn);
  
  header("Location:profile.php?id=" . $pid . "&msg=commented");
  
  
  
?>

