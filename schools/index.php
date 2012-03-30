<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <?php
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

      ini_set('display_errors', 'On');
      $db = 'w4111f.cs.columbia.edu:1521/adb'; 
      $conn = oci_connect("sbm2158", "donorschoose", $db);

      header("Content-type: text/html");
      $stmt = oci_parse($conn, $requestStr);
      oci_execute($stmt, OCI_DEFAULT);
      while($res = oci_fetch_row($stmt)) {
        echo '<h1>' . $res[0] . '</h1>';   
	echo '<h2>Profile</h2>';
	echo '<b>Address</b>: ' . $res[3] . ' ' . $res[4] . ', ' . $res[5] . ', ' . $res[6];
	echo '<br/>';
	echo '<ul class=\'toc\'>';
        echo '<li><span><b>Average Class Size</b></span><span>' . $res[7] . '</span></li>';
	echo '<li><span><b>Poverty Level</b></span><span>' . $res[8] . '</span></li>';
	echo '<li><span><b>Average Math SAT Score</b></span><span>' . $res[9] . '/800';
	echo '<li><span><b>Average Reading SAT Score</b></span><span>' . $res[10] . '/800';
	echo '<li><span><b>Average Writing SAT Score</b></span><span>' . $res[11] . '/800';
        echo '</ul>';	
      }

    }
  ?>
<footer>
  <hr noshade/>
  <a href="../index.html">Main Page</a>
</footer>
</body>
</html>
