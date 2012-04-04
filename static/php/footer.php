<footer>
  <hr noshade/>
  <a href="../index.php">Main Page</a> | <a href="../users/sign_up.php">Sign Up</a> | <a href="../users/log_in.php">Log In</a> | <a href="http://www.donorschoose.org/">Donors Choose</a><br/>
  <?php
    if (isset($_SESSION['email'])) {
      echo "Logged in as: <a href='profile.php?email=" . $_SESSION['email'] .
           "'>" . $_SESSION['email'] . "</a>";
    }
  ?>
</footer>
