<?php

function parseToXML($htmlStr) {
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quotl',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;

}

function generateXML($requestStr) {

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
		echo 'name="' . parseToXML($res[1]) . '" ';
		echo 'lat="' . $res[12] . '" ';
		echo 'lng="' . $res[13] . '" ';
		echo '/>';
	}

	// Cleanup

	oci_close($conn);
	echo '</markers>';

}

// test function:
generateXML("select * from schools_s_in_s_have");

?>
