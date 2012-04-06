<?php
  include("../static/php/header.php");
  require_once "../static/php/db.php";
  
  
  $amountString = $_POST['donation'];
  $pid = $_POST['pid'];
  $tid = $_POST['tid'];
  $today = date("d-M-y"); 
  
  
  // check if we're already logged in:
  if (0 == isset($_SESSION['email'])) {
    header("Location:profile.php?error=not_logged_in_donation");
    exit;
  }
  
  // check if its a valid donation value
  $currencyRegex = "/^[0-9]+(?:\.[0-9]+)?$/im";
  if (0 == preg_match($currencyRegex, $amountString)) {
    header("Location:profile.php?id=" . $pid . "&error=invalid_donation");
    exit;
  }
  
  // query to get the largest current did value to set this one to one larger
  $maxDidQuery = "select max(d.did) as maxDid from Donations_FUND d";
  
  // make query
  $maxDidStmt = oci_parse($conn, $maxDidQuery);
  oci_execute($maxDidStmt);
  if($res = oci_fetch_row($maxDidStmt)) 
    $maxDid = $res[0]; // set maxDid to result
  else
    $maxDid = 0; // if no donations, set maxDid to 0
  
  $currentDid = $maxDid + 1;
  
  // insert donation into table
  $donateInsertionStr =  "insert into Donations_FUND " .
                         "(tid, pid, amount, donationDate, email, did) " . 
                         "VALUES " . 
                         "('" . $tid . "', '" . $pid . "', " . $amountString . ", '" . $today . "', " .
                         "'" . $_SESSION['email'] . "', " . $currentDid . ")";
  
  insert($donateInsertionStr, $conn);
  header("Location:profile.php?id=" . $pid . "&msg=donated");
  
                         
?>
  

