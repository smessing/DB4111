<?php
  include("static/php/header.php");
  
 
  
  $povertyLevel = $_POST['povertyLevel'];
  $n = count($povertyLevel);

  // if empty, set to empty string
  if ($n == 0) {
    $povertyTable = "";
  } 
  else {
    $povertyTable = "(select s.ncesid from schools_s_in_s_have s where ";
    $whereTemp = "";
    
    $whereCounter = 0;
    for ($i=0; $i<$n; $i++) {

      $whereCounter = $whereCounter + 1;
      
      // append "and" if we are not on the first item
      if ($whereCounter != 1) {
        $whereTemp .= " or ";
      }
      $_SESSION['poverty_' . $povertyLevel[$i]] = True;
      $whereTemp .= " s.povertyLevel='" . $povertyLevel[$i] . "' ";
    }
    $povertyTable .=  $whereTemp . ")";
    $subQueryArr[] = $povertyTable;
    //echo $povertyTable . "\n\n";
      
  }
  
  // gradRate table query
  
  $gradRate = $_POST['gradRate'];
  $n = count($gradRate);

  
  // of empty, set to empty string
  if ($n == 0)
    $gradeRateTable = "";
  else {
    $gradRateTable = "(select s.ncesid from schools_s_in_s_have s where ";
    $whereTemp = "";
    $whereCounter = 0;
    
    for($i=0; $i<$n; $i++) {
      $whereCounter++;
      if($whereCounter != 1) {
        $whereTemp .= " or ";
      }
      
      $whereTemp .=  $gradRate[$i];
      if (0 < strpos($gradRate[$i], '(s.graduationRate<=.25)')) {
        $_SESSION['grad_zero'] = True;
      } else if (0 < strpos($gradRate[$i], 's.graduationRate > .25')) {
        $_SESSION['grad_25'] = True;
      } else if (0 < strpos($gradRate[$i], 's.graduationRate > .5')) {
        $_SESSION['grad_50'] = True; 
      } else if (0 < strpos($gradRate[$i], 's.graduationRate > .75')) {
        $_SESSION['grad_75'] = True;
      }
    }
    $gradRateTable .= $whereTemp . ") ";
    $subQueryArr[] = $gradRateTable;
    //echo $gradRateTable . "\n\n";
    
  }
  
  // classSize table query
  
  $classSize = $_POST['classSize'];
  $n = count($classSize);

  
  // of empty, set to empty string
  if ($n == 0)
    $classSizeTable = "";
  else {
    $classSizeTable = "(select s.ncesid from schools_s_in_s_have s where ";
    $whereTemp = "";
    $whereCounter = 0;
    
    for($i=0; $i<$n; $i++) {
      $whereCounter++;
      if($whereCounter != 1) {
        $whereTemp .= " or ";
      }
      
      $whereTemp .=  " (100*". $classSize[$i] ;
      if (0 < strpos($classSize[$i], 's.avgClassSize < 20')) {
         $_SESSION['class_0'] = True;
      } else if (0 < strpos($classSize[$i], 's.avgClassSize > 20')) {
         $_SESSION['class_20'] = True;
      } else if (0 < strpos($classSize[$i], 's.avgClassSize > 40')) {
         $_SESSION['class_40'] = True;
      }
    }
    $classSizeTable .= $whereTemp . ") ";
    $subQueryArr[] = $classSizeTable;
    //echo $classSizeTable . "\n\n";
    
  }
  
  // progress table query
  
  $progress = $_POST['progress'];
  $n = count($progress);

  
  // of empty, set to empty string
  if ($n == 0)
    $progressTable = "";
  else {
    $progressTable = "(select s.ncesid from schools_s_in_s_have s where ";
    $whereTemp = "";
    $whereCounter = 0;
    
    for($i=0; $i<$n; $i++) {
      $whereCounter++;
      if($whereCounter != 1) {
        $whereTemp .= " or ";
      }
      
      $whereTemp .=  $progress[$i];
    }
    $progressTable .= $whereTemp . ") ";
    $subQueryArr[] = $progressTable;
    //echo $progressTable . "\n\n";
    
  }

  $attendance = $_POST['attendance'];
  $n = count($attendance);
  
  if ($n == 0)
    $attendanceTable = "";
  else {
    $attendanceTable = "(select s.ncesid from schools_s_in_s_have s, districts_d_in d where ";
    $whereTemp = "";
    $whereCounter = 0;
    
    for($i=0; $i<$n; $i++) {
      $whereCounter++;
      if($whereCounter != 1) {
        $whereTemp .= " or ";
      }
      
      $whereTemp .= $attendance[$i];
    }
    $attendanceTable .= $whereTemp . " and s.dnumber=d.dnumber )"; 
    $subQueryArr[] = $attendanceTable;
    //echo $attendanceTable;
  }
  
  /*
  INSERT INTO Districts_D_IN
(avgAttendance, percentRecvPublicAsst, dNumber, bName)
  */
  $pubAss = $_POST['pubAss'];
  $n = count($pubAss);
  
  if ($n == 0)
    $pubAssTable = "";
  else {
    $pubAssTable = "(select s.ncesid from schools_s_in_s_have s, districts_d_in d where ";
    $whereTemp = "";
    $whereCounter = 0;
    
    for($i=0; $i<$n; $i++) {
      $whereCounter++;
      if($whereCounter != 1) {
        $whereTemp .= " or ";
      }
      
      $whereTemp .= $pubAss[$i];
    }
    $pubAssTable .= $whereTemp . " and s.dnumber=d.dnumber )"; 
    $subQueryArr[] = $pubAssTable;
    //echo $pubAssTable;
  }
  //var_dump($subQueryArr);
  
  $borough = $_POST['borough'];
  $n = count($borough);
  
  // select s.ncesid from schools_s_in_s_have s, districts_d_in d, boroughs b
  // where b.bName='manhattan' or b.bName='brooklyn' and s.dNumber=d.dNumber and d.bName=b.bName
  
  if ($n == 0)
    $boroughTable = "";
  else {
    $boroughTable = "(select s.ncesid from schools_s_in_s_have s, addresses a where (";
    $whereTemp = "";
    $whereCounter = 0;
    
    for($i=0; $i<$n; $i++) {
      $whereCounter++;
      if($whereCounter != 1) {
        $whereTemp .= " or ";
      }
      
      $whereTemp .= "a.bName = '" . $borough[$i] . "' ";
    }
    $boroughTable .= $whereTemp . " ) and s.latitude=a.latitude and s.longitude=a.longitude )"; 
    $subQueryArr[] = $boroughTable;
    //echo $boroughTable;
  }
  

  // BUILD FULL QUERY
  // if all unchecked
  if(!isset($subQueryArr[0])) {
    $fullQueryStr = "select s2.name, s2.latitude, s2.longitude, a.streetNumber, " .
                    "a.streetname, a.zipcode, a.bname, s2.avgclassSize, " .
                    "s2.povertylevel, s2.avgmathsatscore, s2.avgreadingsatscore, " .
                    "s2.avgwritingsatscore, s2.graduationrate, s2.percentapabove2, ".
                    "s2.ncesid " .
                    "from schools_s_in_s_have s2, addresses a ".
                    "where s2.latitude=a.latitude and s2.longitude=a.longitude ";
  } 
  else {
  
    $tableNames = array('first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth');
    $queryStr = "select unique s.ncesid from schools_s_in_s_have s ";
    for($i=0; $i<count($subQueryArr); $i++) {
      $queryStr .= " , " . $subQueryArr[$i] . " " . $tableNames[$i] . " ";
    }
  
    $queryStr .= "where s.ncesid=first.ncesid ";
    for($i=1; $i<count($subQueryArr); $i++) {
      $queryStr .= "and " . $tableNames[$i-1] . ".ncesid=" . $tableNames[$i] . ".ncesid ";
    }
  
    $fullQueryStr = "select s2.name, s2.latitude, s2.longitude, a.streetNumber, " .
                    "a.streetname, a.zipcode, a.bname, s2.avgclassSize, " .
                    "s2.povertylevel, s2.avgmathsatscore, s2.avgreadingsatscore, " .
                    "s2.avgwritingsatscore, s2.graduationrate, s2.percentapabove2, ".
                    "s2.ncesid " .
                    "from schools_s_in_s_have s2, addresses a ".
                    "where s2.latitude=a.latitude and s2.longitude=a.longitude " .
                    "and s2.ncesid in (" . $queryStr . ")";
    }
                   
  $_SESSION['searchQuery'] = $fullQueryStr;
   
  header("location: main.php");
  //header("location: static/php/school_xml_gen.php");
          
  //echo $fullQueryStr;   
      

?>  



