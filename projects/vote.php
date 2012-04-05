<?php
  include("../static/php/header.php");
  require_once "../static/php/db.php";
  
  
  $pid = $_POST['pid'];
  $tid = $_POST['tid'];
  $today = date("d-M-y"); 
  
  // check if we're already logged in:
  if (0 == isset($_SESSION['email'])) {
    header("Location:index.php?error=not_logged_in_comment");
    exit;
  }
  else {
    $email = $_SESSION['email'];
  }
  
  // test if they have already voted
  $votedQueryStr = "select * from vote v where v.pid='" . $pid . "' and v.email='" . $email . "'";
  $resp = getOneRow($votedQueryStr, $conn);
  //var_dump(empty($resp[0]));
  if(!empty($resp[0])) {
    header("Location:index.php?id=" . $pid . "&error=already_voted");
    exit;
  }
  
  $insertString = "insert into vote " . 
                  "(vDate, tid, pid, email) " . 
                  "values " .
                  "('" . $today . "', '" . $tid . "', '" . $pid . "', '" . $email . "')";
  
  //var_dump($insertString);
  insert($insertString, $conn);
  
  header("Location:index.php?id=" . $pid . "&msg=voted");

?>
  
