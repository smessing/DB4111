<?php
 include('../static/php/header.php');
?>
<html>
<head>
  <link href="../static/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php include('../static/php/error.php'); ?>
<?php include('../static/php/message.php'); ?>
  <?php
    require_once "../static/php/db.php";
    require_once "../static/php/project_helper.php";
    $id=$_REQUEST['id'];

    if (empty($id)) {
	echo 'ERROR: Must specify a school id!';
    }

    if (!empty($id)) {
      $requestStr= "select s.name, s.latitude, s.longitude, a.streetNumber, " .
                           "a.streetname, a.zipcode, a.bname, s.avgclasssize, " .
                           "s.povertylevel, s.avgmathsatscore, s.avgreadingsatscore, " .
                           "s.avgwritingsatscore, s.graduationrate, " .
                           "s.percentapabove2, s.ncesid, s.dnumber " .
                   "from schools_s_in_s_have s, addresses a " .
                   "where s.latitude=a.latitude and s.longitude=a.longitude " .
                           "and s.ncesid=" . $id;

      $res = getOneRow($requestStr, $conn);
      $requestStr = "select d.avgAttendance, d.percentRecvPublicAsst, d.dNumber " .
                    "from districts_d_in d " .
                    "where d.dnumber='" . $res[15] . "'";
      $district = getOneRow($requestStr, $conn);
      header("Content-type: text/html");
        echo '<h1>' . $res[0] . "</h1>\n";   
	echo "<h2>Profile</h2>\n";
	echo '<b>Address</b>: ' . $res[3] . ' ' . $res[4] . 
             ', ' . $res[5] . ', ' . $res[6] . "\n";
	echo "<br/>\n";
        echo "<b>School District</b>: " . $district[2] . "\n";
	echo "<ul class='toc'>\n";
        echo '<li><span><b>Average Class Size</b></span><span>' . 
             number_format($res[7] * 100, 0, ".", "") . " Students</span></li>\n";
	echo '<li><span><b>Poverty Level</b></span><span>' . $res[8] . "</span></li>\n";
	echo '<li><span><b>Average Math SAT Score</b></span><span>' . 
             $res[9] . "/800</span></li>\n";
	echo '<li><span><b>Average Reading SAT Score</b></span><span>' . 
             $res[10] . "/800</span></li>\n";
	echo '<li><span><b>Average Writing SAT Score</b></span><span>' . 
             $res[11] . "/800</span></li>\n";
	echo '<li><span><b>Graduation Rate</b></span><span>' . 
             number_format($res[12] * 100, 2, ".", "") . "%</span></li>\n";
	echo '<li><span><b>Percent of AP Scores Above 2</b></span><span>' . 
             number_format($res[13] * 100, 2, ".", "") . "%</span></li>\n";
        echo "<li><span><b>Percent of Local Residences Recieveing Public Assitance</b> " .
             "(District Level)</span><span>" . 
             number_format($district[1] * 100, 2, ".", "") .
             "%</span></li>\n";
        echo "<li><span><b>Average Attendance Rate</b> (District Level)</span>" .
             "<span>" . number_format($district[0] * 100, 2, ".", "") .
             "%</span></li>\n";

        echo "</ul>\n";	

      echo "<h2>Projects</h2>\n";

      $requestStr = "select p.pid, p.fundURL, p.fundingStatus, p.fulfillmentTrailer," .
                           "p.expirationDate, p.totalPrice, p.title, p.subject, " .
                           "p.shortDescription," .
                           "p.proposalURL, p.percentFunded, p.imageURL, p.numStudents, " .
                           "p.tid, p.ncesID " .
                    "from projects_propose_at p " .
                    "where p.ncesID=" . $id;
      $stmt = oci_parse($conn, $requestStr);
      oci_execute($stmt);
      echo "<ul>\n";
      while($res = oci_fetch_row($stmt)) {
       // check if project is less than 5% funded:
       echo "<li><b><a href='../projects/profile.php?id=" . $res[0] . "'>" . $res[6] . 
            "</a></b>";
       $percentFunded = getPercentFunded($res[0], $conn);
       if ($percentFunded < 0.15) {
         echo  " (<font color='red'>". number_format($percentFunded*100, 2, ".", "") . 
               "% Funded</font>)";
       } else {
         echo " (". number_format($percentFunded*100, 2, ".", "") . "% Funded)";  
       }
         echo "<ul class='toc'>\n";
           echo "<li><span><b>Expiration Date</b></span><span>" . $res[4] . 
                "</span></li>\n";          
           echo "<li><span><b>Number of Students Involved</b></span><span>" . 
                $res[12] . "</span></li>\n";
           if (!empty($res[7])) {
             echo "<li><span><b>Subject</b></span><span>" . 
             str_replace("  ", " & ", $res[7]) . "</span></li>\n";
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
