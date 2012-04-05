<?php
// check for errors on this page, print helpful error messages:
if (!empty($_REQUEST['error'])) {
  $error = $_REQUEST['error'];
  echo "<div class=error><p>";
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
  } else if ($error == 'invalid_donation') {
    echo "Donation must be a valid dollar amount.";   
  } else if ($error == 'nonexistent') {
    echo "E-mail wasn't found! Please try again, or <a href='sign_up.php'>register</a>.";
  } else if ($error == 'loggedin') {
    echo "You're already logged in!";
  } else if ($error == 'not_logged_in_donation') {
    echo "You must be logged in to make a donation.";
  } else if ($error == 'not_logged_in_comment') {
    echo "You must be logged in to leave feedback.";
  } else if ($error == 'program_id') {
    echo "Must specify a program id!";
  } else if ($error == 'already_voted') {
    echo "You can only vote once per project.";
  }
  echo "</p></div>";
}

?>
