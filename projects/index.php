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
        echo "<ul>\n";
        echo "<li><b>Teacher: </b>" . $res[2] . "</li>\n"; // t.name
        echo "<li><b>School: </b><a href=\"../schools/index.php?id=" . $res[8] . "\">" . $res[9] . "</a></li>\n"; // s.name
        if(!empty($res[1])) {
           echo "<li><b>Subject: </b>" . $res[1] . "</li>\n"; // p.subject
        }
        echo "<li><b>Project Description: </b>" . $res[3] . "</li>\n"; // p.shortDescription
        echo "<li><b>Number of Students: </b>" . $res[7] . "</li>\n"; // p.numStudents
        echo "</ul>\n";
        echo "<h2>Funding</h2>\n"; 
        echo "<ul>\n";
        // red font if funding below 15%
        if($res[6] < 0.15) {
           echo "<li><b>Percent Funded: </b><font color=\"red\">" .  number_format($res[6]*100,0,".","") . "%</font></li>\n"; // p.percentFunded
        } else {
           echo "<li><b>Percent Funded: </b>" .  number_format($res[6]*100,0,".","") . "%</li>\n"; // p.percentFunded
        }
        echo "<li><b>Total Funding Requested: </b>$" . $res[5] . "</li>\n"; // p.totalPrice
        echo "<li><b>Last Day to Donate: </b>" . $res[4] . "</li>\n"; // p.expirationDate
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
