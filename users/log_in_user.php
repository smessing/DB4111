<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
<head>
<body>

<?php
  require_once "../static/php/connection.php";
  $submitted_email = $_POST['email'];
  $submitted_pass = $_POST['pass'];

  echo "DEBUG INFO";
  echo "<br/>";
  echo "---submitted_email" . var_dump($submitted_email);
  echo "<br/>";
  echo "---submitted_pass" . var_dump($submitted_pass);
  
  $regex = "/^[a-zA-Z0-9\._\-\+]+@[a-zA-Z0-9\._\-]+\.[a-zA-Z]{2,4}$/";

  // check that e-mail is valid e-mail:
  if (0 == preg_match($regex, $submitted_email)) {
    header("Location:log_in.php?error=email");
    exit;
  }
  
?>


</body>
</html>
