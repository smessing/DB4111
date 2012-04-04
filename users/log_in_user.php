<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
<head>
<body>

<?php
  require_once "../static/php/db.php";
  $submitted_email = $_POST['email'];
  $submitted_pass = $_POST['pass'];

  echo "DEBUG INFO";
  echo "<br/>";
  echo "---submitted_email" . var_dump($submitted_email);
  echo "<br/>";
  echo "---submitted_pass" . var_dump($submitted_pass);
  echo "<br/>";
  
  $regex = "/^[a-zA-Z0-9\._\-\+]+@[a-zA-Z0-9\._\-]+\.[a-zA-Z]{2,4}$/";

  // check that e-mail is valid e-mail:
  if (0 == preg_match($regex, $submitted_email)) {
    header("Location:log_in.php?error=email");
    exit;
  }

  // check that user exists:
  $requestStr = "select u.email, u.passwordsalt, u.password " .
                "from users u " .
                "where u.email='" . $submitted_email . "'"; 
  $user = getOneRow($requestStr, $conn);

  if (empty($user)) {
    header("Location:log_in.php?error=nonexistent");
    exit;
  }
 
  // validate user:
  $hashed_password = hash('md5', $submitted_pass . $user[1]); 

  if ($hashed_password == $user[2]) {
    session_start();
    $_SESSION['email'] = $user[0]; 
    header("Location:../index.php?msg=loggedin");
    exit;
  } else {
    header("Location:log_in.php?error=invalid_pass");
    exit;
  }

?>


</body>
</html>
