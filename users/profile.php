<?php include("../static/php/header.php"); ?>
<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
  <title><?php echo $_REQUEST['email']; ?></title>
</head>
<body>
<?php
  if (!isset($_REQUEST['email'])) {
    header('Location:../main.php');
    exit;
  } 
?>
<?php
    include("../static/php/error.php");
    include("../static/php/message.php");
    require_once '../static/php/db.php';
    require_once '../static/php/sanitize.php';
    $email = $_REQUEST['email'];
    $requestStr = "select u.email, u.displayname from users u where u.email='" . 
                  $email . "'";
    $user = getOneRow($requestStr, $conn);
    echo "<h1>" . $user[1] . " (user)</h1>";
    echo "<h2>" . $user[0] . "</h2>";
 
    // get donations if any:
    $requestStr = "select d.pid from donations_fund d where d.email='" .
                   $email . "'";

    $donations = getMultipleRows($requestStr, $conn); 

    if (sizeof($donations['PID']) > 0) {
      echo "<h3>Donations (" . sizeof($donations['PID']) . " total)</h3>";
      echo "<div class='wrapper'><ul>";
      foreach($donations['PID'] as $proj) {
        $requestStr = "select p.title from projects_propose_at p where p.pid='" .
                      $proj . "'";
        $title = getOneRow($requestStr, $conn);
        echo "<li><a href='../projects/profile.php?id=" . $proj . "'>" . $title[0] .
             "</a></li>";
      }
      echo "</ul><br/></div>";
    }

    // get votes if any:
    $requestStr = "select v.pid from vote v where v.email='" . $email . "'";
    $votes = getMultipleRows($requestStr, $conn);

    if (sizeof($votes['PID']) > 0) {
      echo "<h3>Votes (" . sizeof($votes['PID']) . " total)</h3>";
      echo "<div class='wrapper'><ul>";
      foreach($votes['PID'] as $proj) {
        $requestStr = "select p.title from projects_propose_at p where p.pid='" .
                      $proj . "'";
        $title = getOneRow($requestStr, $conn);
        echo "<li><a href='../projects/profile.php?id=" . $proj . "'>" . $title[0] .
             "</a></li> ";
      }
      echo "</ul><br/></div>";
    }

    // get donations if any:
    $requestStr = "select c.pid, c.comments from comments_about c where c.email='" .
                  $email . "'";
    $comments = getMultipleRows($requestStr, $conn);

    if (sizeof($comments['PID']) > 0 ) {
      echo "<h3>Comments (" . sizeof($comments['PID']) . " total)</h3>";
      $count = 0;
      foreach ($comments['PID'] as $proj) {
        $requestStr = "select p.title from projects_propose_at p where p.pid='" .
                      $proj . "'";
        $title = getOneRow($requestStr, $conn);
        echo "<h4><a href='../projects/profile.php?id=" . $proj . "'>" . $title[0] .
             "</a></h4>"; 
        echo "<p><blockquote><i>\"" . $comments['COMMENTS'][$count] . "\"</i></blockquote></p>";
        $count = $count + 1;
      }
    }
?>
<?php include("../static/php/footer.php"); ?>
</body>
</html>
