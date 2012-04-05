<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
  require_once "../static/php/db.php";
  /*
  echo "DEBUG INFO<br/>";
  echo "email: " . $_POST['email'] . "<br/>";
  echo "name: " . $_POST['name'] . "<br/>";
  echo "pass: " . $_POST['pass'] . "<br/>";
  echo "cpass: " . $_POST['cpass'] . "<br/>";
  */
  $email = $_POST['email'];
  $name = $_POST['name'];
  $pass = $_POST['pass'];
  $cpass = $_POST['cpass'];
  $regex = "/^[a-zA-Z0-9\._\-\+]+@[a-zA-Z0-9\._\-]+\.[a-zA-Z]{2,4}$/";

  // check that e-mail is valid e-mail:
  if (0 == preg_match($regex, $email)) {
    header("Location:sign_up.php?error=email");
    exit;
  }

  // check that pass == cpass:
  
  if (!($pass === $cpass)) {
    header("Location:sign_up.php?error=pass");
    exit;
  }

  // check that name isn't empty:
  if (empty($name)) {
    header("Location:sign_up.php?error=name");
    exit;
  }

  // check that pass isn't empty:
  if (empty($pass)) {
    header("Location:sign_up.php?error=pass");
    exit;
  }

  // check that pass is >= 5 chars long:
  if (strlen($pass) < 5) {
    header("Location:sign_up.php?error=short_pass");
    exit;
  }

  // now, check if email is already taken:

  $requestStr = "select * from users u where u.email=" . "'" . $email . "'";
  $user = getOneRow($requestStr, $conn);
  if (!empty($user[0])) {
    header("Location:sign_up.php?error=used");
    exit;
  }

  // if we're here, then email isn't taken, time to insert:

  // first, compute salt:
  $salt = $name . date('Y-m-d-h-s');
  // then, hash salted password:
  $hashed_pass = hash('md5', $pass . $salt);
  $requestStr = "insert into users" .
                "(email, displayName, password, passwordSalt)" .
                " values " .
                "('" . $email . "','" . $name . "','" . $hashed_pass . "','" . 
                       $salt . "')";
  $stmt = oci_parse($conn, $requestStr);
  if (oci_execute($stmt)) {
    oci_close($conn);
    oci_commit($conn);
    header("Location:log_in.php?msg=welcome");
    exit;
  } else {
    oci_close($conn);
    header("Location:sign_up.php?error=critical");
    exit;
  }
?>

</body>
</html>
