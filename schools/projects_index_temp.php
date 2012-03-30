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
		  "from schools_s_in_s_have s " .
                  "where s.ncesid=" . $id;

    // Connect to DB

    ini_set('display_errors', 'On');
    $db = 

    echo $id;
  ?>
<h2>Test</h2>
</body>
</html>
