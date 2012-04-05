<?php

require_once 'db.php';
header("Content-type: text/xml");

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
			"a.streetname, a.zipcode, a.bname, s.avgclasssize, " .
			"s.povertylevel, s.avgmathsatscore, s.avgreadingsatscore, " .
			"s.avgwritingsatscore, s.graduationrate, s.percentapabove2, s.ncesid " .
			"from schools_s_in_s_have s, addresses a " .
			"where s.latitude=a.latitude and s.longitude=a.longitude";

	// Connect to DB

	ini_set('display_errors', 'On');
	$db = "w4111f.cs.columbia.edu:1521/adb";
	$conn = oci_connect("sbm2158", "donorschoose", $db);

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

	oci_close($conn);

}

function generateProgramXML($conn) {
  $requestStr = "select a.aid, a.name, a.organizationPhoneNumber, " .
                "a.latitude, a.longitude, ad.streetNumber, ad.streetName, " .
                "ad.zipcode, ad.bName " .
                "from after_school_programs_a_have a, addresses ad " .
                "where a.latitude=ad.latitude and a.longitude=ad.longitude";
  $programs = getMultipleRows($requestStr, $conn);
  $count = 0;
  foreach($programs['AID'] as $prog) {
    echo "<marker ";
    echo "name='" . $programs['NAME'][$count] . "' ";  
    echo "phone='" . $programs['ORGANIZATIONPHONENUMBER'][$count] . "' ";
    echo "latitude='" . $programs['LATITUDE'][$count] . "' ";
    echo "longitude='" . $programs['LONGITUDE'][$count] . "' ";
    echo "address='" . $programs['STREETNUMBER'][$count] . " " .
                       $programs['STREETNAME'][$count] . ", " .
                       $programs['BNAME'][$count] . " " .
                       $programs['ZIPCODE'][$count] . "' ";
    echo "type='program'";
    echo "/>";
    $count = $count + 1;
  }
  // cleanup
  
  echo "</markers>";
  

}

// test function:
generateSchoolXML();
generateProgramXML($conn);

?>
