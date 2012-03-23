<?php

function parseToXML($htmlStr) {
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quotl',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;

}

function generateSchoolXML() {

	$requestStr = "select s.name, s.latitude, s.longitude, a.streetNumber, " .
			"a.streetname, a.zipcode, a.bname " .
			"from schools_s_in_s_have s, addresses a " .
			"where s.latitude=a.latitude and s.longitude=a.longitude";

	// Connect to DB

	ini_set('display_errors', 'On');
	$db = "w4111f.cs.columbia.edu:1521/adb";
	$conn = oci_connect("sbm2158", "donorschoose", $db);

	header("Content-type: text/xml");
	echo '<markers>';

	// Prepare and execute SQL statement

	$stmt = oci_parse($conn, $requestStr);
	oci_execute($stmt, OCI_DEFAULT);
	while($res = oci_fetch_row($stmt)) {
		echo '<marker ';
		echo 'name="' . parseToXML($res[0]) . '" ';
		echo 'lat="' . $res[1] . '" ';
		echo 'lng="' . $res[2] . '" ';
		echo 'address="' . $res[3] . " " . $res[4] . ", " 
			. $res[5] . ", " . $res[6] . '" ';
		echo '/>';
	}

	// Cleanup

	oci_close($conn);
	echo '</markers>';

}

// test function:
generateSchoolXML();

?>
