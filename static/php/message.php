<?php
// check for messages on this page, print those message:
if (!empty($_REQUEST['msg'])) {
  $msg = $_REQUEST['msg'];
  echo "<div class=message><p>";
  if ($msg == 'welcome') {
    echo "Welcome to the site!";
  }

  echo "</p></div>";
}
?>
