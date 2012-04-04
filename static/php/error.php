<?php
// check for errors on this page, print helpful error messages:
if (!empty($_REQUEST['error'])) {
  $error = $_REQUEST['error'];
  echo "<div class=error><p><font color='red'>";
  if ($error == 'critical') {
    echo "An internal error has occurred, please contact sys admin!";
  } else if ($error == 'email') {
    echo "Please enter a valid e-mail.";
  } else if ($error == 'used') {
    echo "E-mail is already registered!";
  } else if ($error == 'name') {
    echo "Please enter a valid user name.";
  } else if ($error == 'pass') {
    echo "Password fields must match.";
  } else if ($error == 'invalid_pass') {
    echo "Invalid password/username pair.";
  } else if ($error == 'short_pass') {
    echo "Password is too short! Must be at least 5 chars.";
  } 
  echo "</font></p></div>";
}

?>
