<? include('../static/php/header.php'); ?>
<html>
<head>
  <link href='../code/css/style.css' rel='stylesheet' type='text/css'/>
</head>
<body>

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


  var_dump($program);
?>

</body>
</html>
