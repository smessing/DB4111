<footer>
  <hr noshade/>
  <?php
    if (False === strpos($_SERVER['REQUEST_URI'], 'log_in')) {
      $_SESSION['log_in_redirect'] = $_SERVER['REQUEST_URI'];
    }
    echo "<a href='../main.php'>Main Page</a> | ";
    if (isset($_SESSION['email'])) {
      echo "<a href='../users/log_out.php'>Log Out</a> | ";
    } else {
      echo "<a href='../users/log_in.php'>Log in</a> | ";
      echo "<a href='../users/sign_up.php'>Sign Up</a> | ";
    }
    echo "<a href='http://www.donorschoose.org/'>Donors Choose</a><br/>";
    if (isset($_SESSION['email'])) {
      echo "Logged in as: <a href='../users/profile.php?email=" . $_SESSION['email'] .
           "'>" . $_SESSION['email'] . "</a>";
    }
  ?>
</footer>
