<?php


  require_once 'sanitize.php';
  ini_set('display_errors', 'On');
  $db = 'w4111f.cs.columbia.edu:1521/adb';
  $conn = oci_connect("sbm2158", "donorschoose", $db);

  function getOneRow($requestStr, $conn) {
    $stmt = oci_parse($conn, $requestStr);
    oci_execute($stmt);
    $resp = oci_fetch_row($stmt);
    // sanitize the resp of any HTML chars:
    for ($i = 0; $i < sizeof($resp); $i++) {
      $resp[$i] = sanitizeHTML(unsanitize($resp[$i]));
    }
    return $resp;
  }

  function getMultipleRows($requestStr, $conn) {
    $stmt = oci_parse($conn, $requestStr);
    oci_execute($stmt);
    oci_fetch_all($stmt, $resp);
    foreach($resp as $key => $value) {
      for ($i = 0; $i < sizeof($value); $i++) {
        $value[$i] = sanitizeHTML(unsanitize($value[$i]));
      }
      $resp[$key] = $value;
    }
    return $resp;
  }

?>
