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


function generateProgramXML($conn) {
  $requestStr = "select a.aid, a.name, a.organizationPhoneNumber, " .
                "a.latitude, a.longitude, ad.streetNumber, ad.streetName, " .
                "ad.zipcode, ad.bName " .
                "from after_school_programs_a_have a, addresses ad " .
                "where a.latitude=ad.latitude and a.longitude=ad.longitude";
  $programs = getMultipleRows($requestStr, $conn);
  $count = 0;
  echo "<markers>";
  foreach($programs['AID'] as $prog) {
    echo "<marker ";
    echo "name='" . $programs['NAME'][$count] . "' ";  
    echo "phone='" . $programs['ORGANIZATIONPHONENUMBER'][$count] . "' ";
    echo "lat='" . $programs['LATITUDE'][$count] . "' ";
    echo "lng='" . $programs['LONGITUDE'][$count] . "' ";
    echo "address='" . $programs['STREETNUMBER'][$count] . " " .
                       $programs['STREETNAME'][$count] . ", " .
                       $programs['BNAME'][$count] . " " .
                       $programs['ZIPCODE'][$count] . "' ";
    echo "aid='" . $prog . "' ";
    echo "type='program'";
    echo "/>";
    $count = $count + 1;
  }
  // cleanup
  
  echo "</markers>";
  

}

// test function:
generateProgramXML($conn);

?>
