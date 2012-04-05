<?php
  include("../static/php/header.php");
  include("../static/php/error.php");
  include("../static/php/message.php");
  include("../static/php/time_helper.php");
?>
<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <?php
    $id=$_REQUEST['id'];

    if (empty($id)) {
	echo 'ERROR: Must specify a project id!';
    }

    if (!empty($id)) {

      
      $requestStr= "select p.title, p.subject, t.name, p.shortDescription, " . 
                           "p.expirationDate, p.totalPrice, p.percentFunded, " . 
                           "p.numStudents, p.ncesid, s.name, t.tid " .
                   "from Projects_PROPOSE_AT p, Schools_S_IN_S_HAVE s, " .
                         "addresses a, teachers t " .
                   "where p.pid='" . $id . "' and p.ncesid=s.ncesid " .
                          "and s.latitude=a.latitude and " .
                          "s.longitude=a.longitude and t.tid = p.tid ";
                          
      $countVotesRequestStr = "select count(*) as vcount from vote v where v.pid='" . $id . "'";
      
      $commentsRequestStr = "select c.comments, c.cDate, u.displayName, c.email " . 
                            "from comments_ABOUT c, users u " . 
                            "where c.pid='" . $id . "' and u.email=c.email " . 
                            "order by c.cDate desc";
                            

      $donationsRequestStr = "select u.displayName, u.email " .
                             "from Donations_FUND d, Users u " .
                             "where d.pid='" . $id . "' and d.email=u.email";

      header("Content-type: text/html");
      
      // Connect to DB
      require_once "../static/php/db.php";
      require_once "../static/php/project_helper.php";
       
      // get vote count for this project
      $voteCountStmt = oci_parse($conn, $countVotesRequestStr);
      oci_execute($voteCountStmt);
      
      $vc = 0;
      if($tempCount = oci_fetch_row($voteCountStmt)) {
        $vc = intval($tempCount[0]); // cast to into
      }
          
      
      // make request for donations
      $donationsStmt = oci_parse($conn, $donationsRequestStr);
      oci_execute($donationsStmt);
      $donCount = 0;
      
      
      // make main request on project
      $stmt = oci_parse($conn, $requestStr);
      oci_execute($stmt);
            
            
      $res = oci_fetch_row($stmt); 

        // HEADER SECTION
        // p.title (# votes)
        // pluralize votes if votes != 1

        if ($vc == 1) {
          
          echo "<h1>" . $res[0] . " (" . number_format($vc, 0, "", ",") . " vote)</h1>\n";
        }
        else {
          echo "<h1>" . $res[0] . " (" . number_format($vc, 0, "", ",") . " votes)</h1>\n";
        }

        // p.shortDescription
        echo "<p>" . $res[3] . "</p>\n"; 
        
        // VOTE BUTTON
        if (isset($_SESSION['email'])) {
        echo "<form action=\"vote.php\" method=\"post\">\n";   
        echo "<input type=\"hidden\" name=\"pid\" value=\"" . $id . "\"/>\n";
        echo "<input type=\"hidden\" name=\"tid\" value=\"" . $res[10] . "\"/>\n"; 
        echo "<center><input class=\"button\" value =\"Vote for this project\" type=\"submit\" /></center>\n";
        echo "</form>\n";
        }

        // PROJECT OVERVIEW SECTION
        echo "<h2>Project Overview</h2>\n"; 
        echo "<ul class ='toc'>\n";

        // t.name
        echo "<li><span><b>Teacher: </b></span><span><a href=\"../teachers/index.php?id=" . $res[10] . "\">" . $res[2] . "</a></span></li>\n";
        // s.name
        echo "<li><span><b>School: </b></span><span><a href=\"../schools/index.php?id=" . $res[8] . "\">" . $res[9] . "</a></span></li>\n";

        // p.subject, if there is one
        if(!empty($res[1])) {
           echo "<li><span><b>Subject: </b></span><span>" . $res[1] . "</span></li>\n";
        }
        
        // p.numStudents
        echo "<li><span><b>Number of Students: </b></span><span>" . $res[7] . "</span></li>\n"; 
        echo "</ul>\n";

        // FUNDING SECTION 
        echo "<h2>Funding</h2>\n"; 
        echo "<ul class ='toc'>\n";
    
        // p.percentFunded
        // red font if funding below 15%
        $percentFunded = getPercentFunded($id, $conn);
        if($percentFunded < 0.15) {
          echo "<li><span><b>Percent Funded: </b></span><span><font color=\"red\">" .  number_format($percentFunded*100,0,".","") . "%</font></span></li>\n"; }
        else {
          echo "<li><span><b>Percent Funded: </b></span><span>" .  number_format($percentFunded*100,0,".","") . "%</span></li>\n"; }

        // p.totalPrice
        $totalPriceFormatted = "$".number_format($res[5], 2, '.', ',');
        echo "<li><span><b>Total Funding Requested: </b></span><span>" . $totalPriceFormatted . "</span></li>\n"; 
        // p.expirationDate
        echo "<li><span><b>Last Day to Donate: </b></span><span>" . $res[4] . "</span></li>\n"; 

        echo "</ul>\n";
        
        // List all donators
        $donCount = 0;
        while($donRes = oci_fetch_row($donationsStmt)) {
          $donCount = $donCount + 1;
          
          // if first, put header and <p> tag
          if($donCount == 1) {
            echo "<h3>Donators</h3>\n"; 
            echo "<p>";
          }
            
          // if not the first one, put comma after last one
          else {
            echo ", ";}
          // then list display name
          echo "<a href=\"../users/profile.php?email=" . $donRes[1] . "\"> " . $donRes[0] . "</a>";
        }
        // if there were any donators, close out the <p> tag
        if($donCount != 0) {
          echo "<p>";
        }
          
      
      // MAKE A DONATION
      if(isset($_SESSION['email'])) {
      
        echo "<h3>Please Donate</h3>";
        echo "<form action=\"donate.php\" method=\"post\">\n";
        echo "Amount: <input type=\"text\" name=\"donation\" />\n";
        echo "<input value=\"donate!\" type=\"submit\" />\n";
        echo "<input type=\"hidden\" name=\"pid\" value=\"" . $id . "\"/>";
        echo "<input type=\"hidden\" name=\"tid\" value=\"" . $res[10] . "\"/>"; 
        echo "</form>\n";
        
      }
      else {
        echo "<p>Please <a href='../users/log_in.php'>log in</a> to make a donation.</p>";
      }

      
              
      // PROJECT FEEDBACK SECTION
      echo "<h2>Project Feedback</h2>\n";
      
      
      // AREA TO MAKE A COMMENT
      if (isset($_SESSION['email'])) {
        echo "<form action=\"comment.php\" method=\"post\">\n";
        echo "<textarea cols=\"75\" rows=\"5\" name =\"userComment\">\n";
        echo "Leave feedback about the project.";        
        echo "</textarea>\n";
        echo "<br><br>\n";
        echo "<input type=\"hidden\" name=\"pid\" value=\"" . $id . "\"/>\n";
        echo "<input type=\"hidden\" name=\"tid\" value=\"" . $res[10] . "\"/>\n"; 
        echo "<input value =\"comment\" type=\"submit\" />\n";
        echo "</form>\n";
      }
      else {
        echo "<p>Please <a href='../users/log_in.php'>log in</a> to leave project feedback.</p>\n";
      }
      
      
      
      // make request for comments
      $commentStmt = oci_parse($conn, $commentsRequestStr);
      oci_execute($commentStmt);
            
      $commCount = 0;
      while($commRes = oci_fetch_row($commentStmt)) {
        $commCount = $commCount + 1;
        
        // if first comment, put the header on the section
        if($commCount == 1) {
          echo "<h3>User Comments</h3>\n";
        }
        
        echo "<p>\"" . $commRes[0] . "\"\n" . 
             "</br>" .
             "-<a href='../users/profile.php?email=" . $commRes[3] . "'>" . $commRes[2] . "</a>" .
             ", " . time2date($commRes[1]) . 
             "</p>";
      }
         

      // cleanup
      oci_close($conn);
    }
  ?>
<?php include("../static/php/footer.php"); ?>
</body>
</html>
