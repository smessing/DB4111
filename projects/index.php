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
                           "p.numStudents, p.ncesid, s.name " .
                   "from Projects_PROPOSE_AT p, Schools_S_IN_S_HAVE s, " .
                         "addresses a, teachers t " .
                   "where p.pid='" . $id . "' and p.ncesid=s.ncesid " .
                          "and s.latitude=a.latitude and " .
                          "s.longitude=a.longitude and t.tid = p.tid ";
                          
      $countVotesRequestStr = "select count(*) as vcount from vote v where v.pid='" . $id . "'";
      
      $commentsRequestStr = "select c.comments, c.cDate, u.displayName " . 
                            "from comments_ABOUT c, users u " . 
                            "where c.pid='" . $id . "' and u.email=c.email";

      header("Content-type: text/html");
      
      // Connect to DB
      ini_set('display_errors', 'On');
      $db = 'w4111f.cs.columbia.edu:1521/adb'; 
      $conn = oci_connect("sbm2158", "donorschoose", $db);
      
      // get vote count for this project
      $voteCountStmt = oci_parse($conn, $countVotesRequestStr);
      oci_execute($voteCountStmt, OCI_DEFAULT);
      
      $vc = 0;
      while($tempCount = oci_fetch_row($voteCountStmt)) {
        $vc = $tempCount;
      }
      
      // make main request on project
      $stmt = oci_parse($conn, $requestStr);
      oci_execute($stmt);
            
      while($res = oci_fetch_row($stmt)) {

        // HEADER SECTION
        // p.title
        echo "<h1>" . $res[0] . "</h1>\n";
        // p.shortDescription
        echo "<p>" . $res[3] . "</p>\n"; 

        // PROJECT OVERVIEW SECTION
        echo "<h2>Project Overview</h2>\n"; 
        echo "<ul class ='toc'>\n";

        // t.name
        echo "<li><span><b>Teacher: </b></span><span>" . $res[2] . "</span></li>\n";
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
        if($res[6] < 0.15) {
          echo "<li><span><b>Percent Funded: </b></span><span><font color=\"red\">" .  number_format($res[6]*100,0,".","") . "%</font></span></li>\n"; }
        else {
          echo "<li><span><b>Percent Funded: </b></span><span>" .  number_format($res[6]*100,0,".","") . "%</span></li>\n"; }

        // p.totalPrice
        $totalPriceFormatted = "$".number_format($res[5], 2, '.', ',');
        echo "<li><span><b>Total Funding Requested: </b></span><span>" . $totalPriceFormatted . "</span></li>\n"; 
        // p.expirationDate
        echo "<li><span><b>Last Day to Donate: </b></span><span>" . $res[4] . "</span></li>\n"; 

        echo "</ul>\n";
        
        // PROJECT FEEDBACK SECTION
        echo "<h2>Project Feedback</h2>\n";
        echo "<p><b>Votes: </b>" . number_format($vc,0, "", ",") . "</p>\n";
      }
      
      // make main request on project
      $commentStmt = oci_parse($conn, $commentsRequestStr);
      oci_execute($commentStmt);
            
      $commCount = 0;
      while($commRes = oci_fetch_row($commentStmt)) {
        $commCount = $commCount + 1;
        
        // if first comment, put the header on the section
        if($commCount == 1) {
          echo "<h3>User Comments</h3>";
        }
        
        echo "<p>\"" . $commRes[0] . "\"</br>      -" . $commRes[2] . ", " . $commRes[1] . "</p>";
      }
    

      // cleanup
      oci_close($conn);
    }
  ?>
<?php include("../static/php/footer.php"); ?>
</body>
</html>
