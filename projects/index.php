<html>
<head>
  <link href="../code/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <?php
    $id=$_REQUEST['id'];

    if(empty($id)) {

    }

    $requestStr = "select * " .
		  "from projects_propose_at p " .
                  "where p.pid=" . $id;

    // Connect to DB

    ini_set('display_errors', 'On');
    $db = "w4111f.cs.columbia.edu:1521/adb";
    $conn = oci_connect("sbm2158", "donorschoose", $db);

    


    echo $id;
  ?>
<h2>Test</h2>
</body>
</html>
