<?php include("../static/php/header.php"); ?>
<html>
<head>
  <link href="../static/css/style.css" rel="stylesheet" type="text/css" />
<head>
<body>

<?php
  require_once "../static/php/db.php";
  require_once "../static/php/sanitize.php";
  $submitted_email = $_POST['email'];
  $submitted_pass = $_POST['pass'];

  /*
  echo "DEBUG INFO";
  echo "<br/>";
  echo "---submitted_email" . var_dump($submitted_email);
  echo "<br/>";
  echo "---submitted_pass" . var_dump($submitted_pass);
  echo "<br/>";
  */

  // check if we're already logged in:
  if (isset($_SESSION['email'])) {
    header("Location:log_in.php?error=loggedin");
    exit;
  }
  
  $regex = "/^[a-zA-Z0-9\._\-\+]+@[a-zA-Z0-9\._\-]+\.[a-zA-Z]{2,4}$/";

  // check that e-mail is valid e-mail:
  if (0 == preg_match($regex, $submitted_email)) {
    header("Location:log_in.php?error=email");
    exit;
  }

  // check that user exists:
  $requestStr = sprintf("select u.email, u.passwordsalt, u.password " .
                        "from users u " .
                        "where u.email='%s'", sanitize($submitted_email)); 
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
    if (isset($_SESSION['log_in_redirect'])) {
      $redirect = $_SESSION['log_in_redirect'];
      unset($_SESSION['log_in_redirect']);
      if (False === strpos($redirect, "?")) {
        header("Location:" . $redirect . '?msg=loggedin');
      } else {
        header("Location:" . $redirect . '&msg=loggedin');
      }
    } else {
      header("Location:../main.php?msg=loggedin");
    }
  } else {
    header("Location:log_in.php?error=invalid_pass");
    exit;
  }

?>


</body>
</html>
