<?php 
  include("../static/php/header.php") 
?>
<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
  <title>Log In</title>
</head>
<body>

<?php include("../static/php/message.php"); ?>
<?php include("../static/php/error.php"); ?>

<h2>Log in</h2>

<form action="log_in_user.php" method="post" align="center">
E-mail: <input type="text" name="email" /> <br/>
Password: <input type="password" name="pass" /> <br/>
<input type="submit"/>
</form>

<?php include("../static/php/footer.php"); ?>
</body>
</html>
