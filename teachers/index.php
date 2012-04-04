<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <?php
    $id=$_REQUEST['id'];

    if (empty($id)) {
	echo 'ERROR: Must specify a teacher id!';
    }

    if (!empty($id)) {
      
      header("Content-type: text/html");
      
      // Connect to DB
      require_once "../static/php/db.php";
      require_once "../static/php/project_helper.php"; 
      
      
      // gets names of teachers
      $teacherNameRequestStr = "select t.name from Teachers t where t.tid='" . $id . "'";
      
      // gets project names and descriptions for this teacher
      $projectRequestStr = "select p.pid, p.title, p.shortDescription " . 
                           "from Projects_PROPOSE_AT p " . 
                           "where p.tid='" . $id . "'";
                           
           
      // execute the queries
      $teacherNameStmt = oci_parse($conn, $teacherNameRequestStr);
      oci_execute($teacherNameStmt);
      
      $projectStmt = oci_parse($conn, $projectRequestStr);
      oci_execute($projectStmt);
      
      // HEADER
      $res = oci_fetch_row($teacherNameStmt);
      // t.name
      echo "<h1>" . $res[0] . " (teacher)</h1>\n";
      
      // PROJECTS
      $linkToProjects = "../projects/index.php?id=";
      echo "<h2>Projects</h2>\n";
      
      while($res = oci_fetch_row($projectStmt)) {
        // name of project with link
        echo "<dl>\n";
          echo "<dt><b><a href='" . $linkToProjects . $res[0] . "'>" . $res[1] . "</a></b>";
          
          $percentFunded = getPercentFunded($res[0], $conn);
          if ($percentFunded < 0.15) {
            echo  " (<font color='red'>". number_format($percentFunded*100, 0, ".", "") . "% Funded</font>)"; }
          echo " </dt>\n";
          // project description
          echo "<dt>" . $res[2] . "</dt>"; 
        echo "</dl>";
      }
    }

    
    // cleanup
    oci_close($conn);
  ?>
<?php include("../static/php/footer.php"); ?>
</body>
</html>
      
      
      
      
      
      
      
      
      
      
