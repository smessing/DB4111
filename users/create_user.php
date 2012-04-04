<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<?php
  echo "DEBUG INFO<br/>";
  echo "email: " . $_POST['email'] . "<br/>";
  echo "name: " . $_POST['name'] . "<br/>";
  echo "pass: " . $_POST['pass'] . "<br/>";
  echo "cpass: " . $_POST['cpass'] . "<br/>";

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

  // now, check if username is already taken:

  ini_set('display_errors', 'On');
  $db = 'w4111f.cs.columbia.edu:1521/adb'; 
  $conn = oci_connect("sbm2158", "donorschoose", $db);

  $requestStr = "select * from users u where u.email=" . $email;
  $stmt = oci_parse($conn, $requestStr);
  oci_execute($stmt, OCI_DEFAULT);

?>

</body>
</html>
