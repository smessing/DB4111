<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
  <title>Log In</title>
</head>
<body>

<?php 
  if ($_REQUEST['msg'] == 'welcome') {
    echo '<div class="header">';
    echo '<p>Welcome to the site!</p>';
    echo '</div>';
  }
?>
<h2>Log in</h2>

<form action="log_in_user.php" method="post" align="center">
E-mail: <input type="text" name="email" /> <br/>
Password: <input type="password" name="pass" /> <br/>
<input type="submit"/>
</form>

<?php include("../static/php/footer.php"); ?>
</body>
</html>
