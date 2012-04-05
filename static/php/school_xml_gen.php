<?php

require_once 'db.php';
include('header.php');
header("Content-type: text/xml");

function parseToXML($htmlStr) {
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quotl',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;

}

function generateSchoolXML($conn) {

        if (isset($_SESSION['searchQuery'])) {
          $requestStr = $_SESSION['searchQuery'];
          unset($_SESSION['searchQuery']);
        } else {

	  $requestStr = "select s.name, s.latitude, s.longitude, a.streetNumber, " .
			"a.streetname, a.zipcode, a.bname, s.avgclasssize, " .
			"s.povertylevel, s.avgmathsatscore, s.avgreadingsatscore, " .
			"s.avgwritingsatscore, s.graduationrate, s.percentapabove2, " .
                        "s.ncesid " .
			"from schools_s_in_s_have s, addresses a " .
			"where s.latitude=a.latitude and s.longitude=a.longitude";

        }

        // Prepare and execute SQL statment:

        $stmt = oci_parse($conn, $requestStr);
	oci_execute($stmt, OCI_DEFAULT);
 
        // Build XML doc:

        echo "<markers>";
	while($res = oci_fetch_row($stmt)) {
		echo '<marker ';
		echo 'name="' . parseToXML($res[0]) . '" ';
		echo 'lat="' . $res[1] . '" ';
		echo 'lng="' . $res[2] . '" ';
		echo 'address="' . $res[3] . " " . $res[4] . ", " 
			. $res[5] . ", " . $res[6] . '" ';
		echo 'avgclasssize="' . $res[7] . '" ';
		echo 'povertylevel="'. parseToXML($res[8]) . '" ';
		echo 'avgmathsat="' . $res[9] . '" ';
		echo 'avgreadingsat="' . $res[10] . '" ';
		echo 'avgwritingsat="' . $res[11] . '" ';
		echo 'graduationrate="' . $res[12] . '" ';
		echo 'percentAPabove2="' . $res[13] . '" ';
		echo 'nces="' . $res[14] . '" ';
                echo "type='school' ";
		echo '/>';
	}

	// Cleanup
        echo "</markers>";
	oci_close($conn);

}
generateSchoolXML($conn);

?>
