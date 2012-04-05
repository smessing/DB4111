<?php 
  include("../static/php/header.php"); 
?>
<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include("../static/php/error.php"); ?>
<?php include("../static/php/message.php"); ?>
<h2>Create an Account</h2>

<form action="create_user.php" method="post" align="center">
E-mail: <input type="text" name="email" /> <br/>
Display Name: <input type="text" name="name"/> <br/>
Password: <input type="password" name="pass" /> <br/>
Password (confirmation): <input type="password" name="cpass" /> <br/>
<input type="submit"/>
</form>

<?php include("../static/php/footer.php"); ?>
</body>
</html>
