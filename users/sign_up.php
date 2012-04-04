<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h2>Create an Account</h2>

<form action="create_user.php" method="post" align="center">
<?php
  if ($_REQUEST['error'] == 'email') {
    echo "<font color='red'>Please enter a valid e-mail.</font><br/>";
  }
  if ($_REQUEST['error'] == 'used') {
    echo "<font color='red'>E-mail is already registered!</font><br/>";
  }
?>
E-mail: <input type="text" name="email" /> <br/>
<?php
  if ($_REQUEST['error'] == 'name') {
    echo "<font color='red'>Please enter a valid user name.</font><br/>";
  }
?>
Display Name: <input type="text" name="name"/> <br/>
<?php
  if ($_REQUEST['error'] == 'pass') {
     echo "<font color='red'>Password fields must match.</font><br/>";
  }
  if ($_REQUEST['error'] == 'short_pass') {
    echo "<font color='red'>Password is too short! Must be at least 5 chars.</font><br/>";
  }
?>
Password: <input type="password" name="pass" /> <br/>
Password (confirmation): <input type="password" name="cpass" /> <br/>
<input type="submit"/>
</form>

<?php include("../static/php/footer.php"); ?>
</body>
</html>
