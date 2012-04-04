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

  
?>


</body>
</html>
