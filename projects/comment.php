<?php
  include("../static/php/header.php");
  require_once "../static/php/db.php";
?>
<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php
  
  // catch variables from form and get date
  echo "<p>test</p>";
  
  $commentString = $_POST['userComment'];
  $pid = $_POST['pid'];
  $tid = $_POST['tid'];
  $today = date("d-M-y"); 
  
  var_dump($today);
  
  // check if we're already logged in:
  if (0 == isset($_SESSION['email'])) {
    header("Location:index.php?error=not_logged_in_comment");
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
  
  header("Location:index.php?id=" . $pid . "&msg=commented");
  
  
//  INSERT INTO Comments_ABOUT
//  (tid, pid, comments, cDate, email)
//  VALUES
//  ('a89af066d9553a4aff50b0dc5c3650ea','83e5cc1b9c24f749b19e923cfd082faa','I hate this project\!','24-apr-11','clarence@fun.com' );
  
  
  
  
?>
</body>
</html>
