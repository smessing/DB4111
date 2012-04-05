<?php include('../static/php/header.php'); ?>
<html>
<head>
  <link href='../code/css/style.css' rel='stylesheet' type='text/css'/>
</head>
<body>
<?php include('../static/php/message.php'); ?>
<?php include('../static/php/error.php'); ?>
<?php
  require_once "../static/php/db.php";
  // get project data:
  $id = $_REQUEST['aid'];
 
  if (empty($id)) {
    header('Location:../index.php?error=program_id');
    exit;
  }
 
  $requestStr = "select a.name, a.programType, a.agencyName, a.organizationName, " .
                "a.elementaryLevel, a.middleSchoolLevel, a.highSchoolLevel, " .
                "a.organizationPhoneNumber, a.latitude, a.longitude " .
                "from after_school_programs_a_have a " .
                "where a.aid='" . $id . "'";
  $program = getOneRow($requestStr, $conn);
  $requestStr = "select a.streetNumber, a.streetName, a.zipcode, a.bName " .
                "from addresses a " .
                "where a.latitude='" . $program[8] . "' and a.longitude='" .
                $program[9] . "'";
  $address = getOneRow($requestStr, $conn);

  if (empty($program) || empty($address)) {
    header('Location:../index.php?error=critical');
    exit;
  }

  echo '<h1>' . $program[0] . '</h1>';
  echo "<h2>Profile</h2>\n";
  echo '<b>Address</b>: ' . $address[0] . " " . $address[1] . ", " . $address[3] .
       " " . $address[2] . "<br/>";
  echo "<b>Phone Number</b>: " . $program[7] . "<br/>";
  echo "<ul class='toc'>\n";
  echo "<li><span><b>Program Type</b></span><span>" . $program[1] . "</span></li>\n";
  echo "<li><span><b>Agency Name</b></span><span>" . $program[2] . "</span></li>\n";
  echo "<li><span><b>Organization Name</b></span><span>" . $program[3] . "</span></li>\n";

  // check if we have enrollment information:
  if ($program[4] == 'T' || $program[5] == 'T' || $program[6] == 'T') {
    echo "<h2>Enrollment</h2>\n";
    echo "<div align='center'>";
    if ($program[4] == 'T') {
      echo "Elementary School (5-10 yrs)";
    }
    if ($program[5] == 'T') {
      echo " Middle School (11-14 yrs) ";
    }
    if ($program[6] == 'T') {
      echo "High School (14-20 yrs)";
    }
    echo "</div>";
  }
  
  include('../static/php/footer.php');
?>

</body>
</html>
