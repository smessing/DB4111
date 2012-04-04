<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <?php
    require_once "../static/php/connection.php";
    $id=$_REQUEST['id'];

    if (empty($id)) {
	echo 'ERROR: Must specify a school id!';
    }

    if (!empty($id)) {

      $requestStr= "select s.name, s.latitude, s.longitude, a.streetNumber, " .
                           "a.streetname, a.zipcode, a.bname, s.avgclasssize, " .
                           "s.povertylevel, s.avgmathsatscore, s.avgreadingsatscore, " .
                           "s.avgwritingsatscore, s.graduationrate, s.percentapabove2, s.ncesid " .
                   "from schools_s_in_s_have s, addresses a " .
                   "where s.latitude=a.latitude and s.longitude=a.longitude " .
                           "and s.ncesid=" . $id;

      // Connect to DB

      header("Content-type: text/html");
      $stmt = oci_parse($conn, $requestStr);
      oci_execute($stmt, OCI_DEFAULT);
      while($res = oci_fetch_row($stmt)) {
        echo '<h1>' . $res[0] . "</h1>\n";   
	echo "<h2>Profile</h2>\n";
	echo '<b>Address</b>: ' . $res[3] . ' ' . $res[4] . ', ' . $res[5] . ', ' . $res[6] . "\n";
	echo "<br/>\n";
	echo "<ul class='toc'>\n";
        echo '<li><span><b>Average Class Size</b></span><span>' . number_format($res[7] * 100, 0, ".", "") . " Students</span></li>\n";
	echo '<li><span><b>Poverty Level</b></span><span>' . $res[8] . "</span></li>\n";
	echo '<li><span><b>Average Math SAT Score</b></span><span>' . $res[9] . "/800</span></li>\n";
	echo '<li><span><b>Average Reading SAT Score</b></span><span>' . $res[10] . "/800</span></li>\n";
	echo '<li><span><b>Average Writing SAT Score</b></span><span>' . $res[11] . "/800</span></li>\n";
	echo '<li><span><b>Graduation Rate</b></span><span>' . number_format($res[12] * 100, 0, ".", "") . "%</span></li>\n";
	echo '<li><span><b>Percent of AP Scores Above 2</b></span><span>' . number_format($res[13] * 100, 0, ".", "") . "%</span></li>\n";
        echo "</ul>\n";	
      }

      echo "<h2>Projects</h2>\n";

      $requestStr = "select p.pid, p.fundURL, p.fundingStatus, p.fulfillmentTrailer," .
                           "p.expirationDate, p.totalPrice, p.title, p.subject, p.shortDescription," .
                           "p.proposalURL, p.percentFunded, p.imageURL, p.numStudents, p.tid, p.ncesID " .
                    "from projects_propose_at p " .
                    "where p.ncesID=" . $id;
      $stmt = oci_parse($conn, $requestStr);
      oci_execute($stmt, OCI_DEFAULT);
      echo "<ul>\n";
      while($res = oci_fetch_row($stmt)) {
       // check if project is less than 5% funded:
       echo "<li><b><a href='../projects/index.php?id=" . $res[0] . "'>" . $res[6] . "</a></b>";
       if ($res[10] < 0.15) {
         echo  " (<font color='red'>". number_format($res[10]*100, 0, ".", "") . "% Funded</font>)";
       } else {
         echo " (". number_format($res[10]*100, 0, ".", "") . "% Funded)";  
       }
         echo "<ul class='toc'>\n";
           echo "<li><span><b>Expiration Date</b></span><span>" . $res[4] . "</span></li>\n";          
           echo "<li><span><b>Number of Students Involved</b></span><span>" . $res[12] . "</span></li>\n";
           if (!empty($res[7])) {
             echo "<li><span><b>Subject</b></span><span>" . str_replace("  ", " & ", $res[7]) . "</span></li>\n";
           }
         echo "</ul>\n";
       echo "</li>\n";
      }
      echo "</ul>\n";
    }
    
    // cleanup
    oci_close($conn);
  ?>
<?php include("../static/php/footer.php"); ?>
</body>
</html>
