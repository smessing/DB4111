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
                          "s.longitude=a.longitude and t.tid = p.tid";

      // Connect to DB

      ini_set('display_errors', 'On');
      $db = 'w4111f.cs.columbia.edu:1521/adb'; 
      $conn = oci_connect("sbm2158", "donorschoose", $db);

      header("Content-type: text/html");
      $stmt = oci_parse($conn, $requestStr);
      oci_execute($stmt, OCI_DEFAULT);
      while($res = oci_fetch_row($stmt)) {
        echo "<h1>" . $res[0] . "</h1>\n"; // p.title
        echo "<h2>Project Overview</h2>\n"; 
        echo "<ul class ='toc'>\n";
        echo "<li><span><b>Teacher: </b></span><span>" . $res[2] . "</span></li>\n"; // t.name
        echo "<li><span><b>School: </b></span><span><a href=\"../schools/index.php?id=" . $res[8] . "\">" . $res[9] . "</a></span></li>\n"; // s.name
        if(!empty($res[1])) {
           echo "<li><span><b>Subject: </b></span><span>" . $res[1] . "</span></li>\n"; // p.subject
        }
        echo "<li><span><b>Project Description: </b></span><span>" . $res[3] . "</span></li>\n"; // p.shortDescription
        echo "<li><span><b>Number of Students: </b>" . $res[7] . "</span></li>\n"; // p.numStudents
        echo "</ul>\n";
        echo "<h2>Funding</h2>\n"; 
        echo "<ul class ='toc'>\n";
        // red font if funding below 15%
        if($res[6] < 0.15) {
           echo "<li><span><b>Percent Funded: </b></span><span><font color=\"red\">" .  number_format($res[6]*100,0,".","") . "%</font></span></li>\n"; // p.percentFunded
        } else {
           echo "<li><span><b>Percent Funded: </b></span><span>" .  number_format($res[6]*100,0,".","") . "%</span></li>\n"; // p.percentFunded
        }
        echo "<li><span><b>Total Funding Requested: </b></span><span>$" . $res[5] . "</span></li>\n"; // p.totalPrice
        echo "<li><span><b>Last Day to Donate: </b></span><span>" . $res[4] . "</span></li>\n"; // p.expirationDate
        echo "</ul>\n";
      }

      // cleanup
      oci_close($conn);
    }
  ?>
<footer>
  <hr noshade/>
  <a href="../index.html">Main Page</a>
</footer>
</body>
</html>
