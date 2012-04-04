<footer>
  <hr noshade/>
  <?php
    echo "<a href='../index.php'>Main Page</a> | ";
    if (isset($_SESSION['email'])) {
      echo "<a href='log_out.php'>Log Out</a> | ";
    } else {
      echo "<a href='log_in.php'>Log in</a> | ";
      echo "<a href='sign_up.php'>Sign Up</a> | ";
    }
    echo "<a href='http://www.donorschoose.org/'>Donors Choose</a><br/>";
    if (isset($_SESSION['email'])) {
      echo "Logged in as: <a href='profile.php?email=" . $_SESSION['email'] .
           "'>" . $_SESSION['email'] . "</a>";
    }
  ?>
</footer>
