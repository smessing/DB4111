<?php

  require_once "db.php";

  function getAmountFunded($pid, $conn) {
    $requestStr = "select sum(d.amount) from donations_fund d where " .
                  "d.pid='" . $pid . "'";
    $resp = getOneRow($requestStr, $conn); 
    if (is_null($resp[0])) {
      $amountFunded = 0.0;
    } else {
      $amountFunded = $fundingResp[0];
    }
    return $amountFunded;
  }

  function getPercentFunded($pid, $conn) {
    $amountFunded = getAmountFunded($pid, $conn);
    $requestStr = "select p.totalprice from projects_propose_at p where " .
                  "p.pid='" . $pid . "'";
    $resp = getOneRow($requestStr, $conn); 
    if (is_null($resp[0])) {
      $percentFunded = 100.0;
    } else {
      $percentFunded = $amountFunded / $resp[0];
    }
    return $percentFunded;
  }

?>
