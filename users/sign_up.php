<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h2>Create an Account</h2>

<form action="create_user.php" method="post" align="center">
E-mail: <input type="text" name="email" /> <br/>
Display Name: <input type="text" name="name"/> <br/>
Password: <input type="password" name="pass" /> <br/>
Password (confirmation): <input type="password" name="pass" /> <br/>
<input type="submit"/>
</form>

<?php include("../static/php/footer.php"); ?>
</body>
</html>
