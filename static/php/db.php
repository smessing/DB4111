<?php

  ini_set('display_errors', 'On');
  $db = 'w4111f.cs.columbia.edu:1521/adb';
  $conn = oci_connect("sbm2158", "donorschoose", $db);

  function getOneRow($requestStr, $conn) {
    $stmt = oci_parse($conn, $requestStr);
    oci_execute($stmt);
    $resp = oci_fetch_row($stmt);
    return $resp;
  }

  function getMultipleRows($requestStr, $conn) {
    $stmt = oci_parse($conn, $requestStr);
    oci_execute($stmt);
    oci_fetch_all($stmt, $resp);
    return $resp;
  }
  
  function insert($requestStr, $conn) {
    $stmt = oci_parse($conn, $requestStr);
    oci_execute($stmt);
    oci_commit($conn);
  }

?>
