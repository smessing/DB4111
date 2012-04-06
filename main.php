<?php include('static/php/header.php'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Team 7 Final Project</title>
    <link rel="stylesheet" href="static/css/map.css" type="text/css" media="screen"/>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDy9NCdMzkcQkBXUDYsKa1xzsdc6IbKq8k&sensor=true" type="text/javascript"></script>
    <!-- NOTE: what comes below was adapated from a Google Maps API tutorial,
               https://developers.google.com/maps/articles/phpsqlajax
               our code for school_xml_generator.php and programs_xml_generator.php
               was also based on this example. -->
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
        shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(40.73, -74.00),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // download school markers:
      downloadUrl("static/php/school_xml_gen.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
	  var address = markers[i].getAttribute("address");
	  var nces = markers[i].getAttribute("nces");
          var html = "<h2><a href=\"schools/profile.php?id=" + nces + "\">" + name + "</a></h2><b>" + address +
		     "</b><br/><br/>";
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            title: name,
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });

      // download after-school program markers:
      downloadUrl("static/php/program_xml_gen.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var aid = markers[i].getAttribute("aid");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var address = markers[i].getAttribute("address");
          var aid = markers[i].getAttribute("aid");
          var html = "<h2><a href=\"programs/profile.php?aid=" + aid + "\">" + name + "</a></h2><b>" + address + "</b><br/><br/>";
          var marker = new google.maps.Marker({
              map: map,
              position: point,
              title: name,
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}

    //]]>
  </script>
  </head>

  <body onload="load()" style="background: grey;">
    <?php include('static/php/message.php'); ?>
    <?php include('static/php/error.php'); ?>
    <div class="title">
     <h1>Help improve NYC education</h1>
    <p>This site was designed to help improve education in New York City. On this site you can look for and donate to projects hosted by <a href="http://www.donorschoose.com/">Donors Choose</a>, a website for teachers to get funding for lesson plans. If you'd rather donate your time, you can browse the maps for after school programs to volunteer with. </p>
     <?php
        if (!isset($_SESSION['email'])) {
          echo "If you have an account, please <a href='users/log_in.php'>log in</a>.<br/>";
          echo "Otherwise, please <a href='users/sign_up.php'>create an account</a>.";
        } else {
          echo "You're logged in as <a href='users/profile.php?email=" . 
               $_SESSION['email'] . "'>" . $_SESSION['email'] . "</a><br/>";
          echo "<a href='users/log_out.php'>Click here to log out</a>.";
        }
     ?>
    </div>
    <div class="query">
    <h2>Project Search</h2>
    <form action="selectSchoolProjects.php" method="post">
      <div align=center>  
      <b>School Poverty Level</b></br>
      <?php
        echo '<input type="checkbox" name="povertyLevel[]" value="low" checked>low</input>';
        echo '<input type="checkbox" name="povertyLevel[]" value="medium" checked>medium</input>';
        echo '<input type="checkbox" name="povertyLevel[]" value="high" checked>high</input>';
      ?> 
      <br><b>Graduation Rate</b></br>
      <?php
         echo '<input type="checkbox" name="gradRate[]" value=" (s.graduationRate<=.25) " checked>0-25%</input>';
        echo '<input type="checkbox" name="gradRate[]" value=" (s.graduationRate > .25 and s.graduationRate <= .5) " checked>25-50%</input>';
        echo '<input type="checkbox" name="gradRate[]" value=" (s.graduationRate > .5 and s.graduationRate <= .75) " checked>50-75%</input>';
        echo '<input type="checkbox" name="gradRate[]" value=" (s.graduationRate > .75) " checked>75-100%</input>';
      ?>
      
      <br><b>Avg. Class Size</b></br>
      <?php
        echo '<input type="checkbox" name="classSize[]" value="s.avgClassSize < 20) " checked>&lt; 20 </input> ';
      unset($_SESSION['class_0']);
        echo '<input type="checkbox" name="classSize[]" value="s.avgClassSize > 20 and s.avgClassSize <= 40) " checked>20 - 40 </input> ';
        echo '<input type="checkbox" name="classSize[]" value="s.avgClassSize > 40) " checked>over 40 </input>';
      ?>
      <br><b>NYC Gov Progress Report Grade</b><br>
      <?php
      if (!isset($_SESSION['progress_a'])) {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'A\'" checked>A</input>';
      } else {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'A\'">A</input>';
        unset($_SESSION['progress_a']);
      }
      if (!isset($_SESSION['progress_b'])) {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'B\'" checked>B</input> ';
      } else {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'B\'" >B</input> ';
        unset($_SESSION['progress_b']);
      }
      if (!isset($_SESSION['progress_c'])) {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'C\'" checked>C</input> ';
      } else {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'C\'">C</input> ';
        unset($_SESSION['progress_c']);
      }
      if (!isset($_SESSION['progress_d'])) {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'D\'" checked>D</input> ';
      } else {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'D\'">D</input> ';
        unset($_SESSION['progress_d']);
      }
      if (!isset($_SESSION['progress_f'])) {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'F\'" checked>F</input> ';
      } else {
        echo '<input type="checkbox" name="progress[]" value="s.progressGrade=\'F\'" checked>F</input> ';
        unset($_SESSION['progress_f']);
      }
      ?> 
      <br>
      <b>Attendance Rates</b><br>
      <?php
      if (!isset($_SESSION['attend_0'])) {
        echo '<input type="checkbox" name="attendance[]" value=" (d.avgAttendance <= .25) " checked>0-25%</input> ';
      } else {
        echo '<input type="checkbox" name="attendance[]" value=" (d.avgAttendance <= .25) " >0-25%</input> ';
        unset($_SESSION['attend_0']);
      }
      if (!isset($_SESSION['attend_25'])) {
        echo '<input type="checkbox" name="attendance[]" value=" (d.avgAttendance > .25 and d.avgAttendance <= .5) " checked>25-50%</input>';
      } else {
        echo '<input type="checkbox" name="attendance[]" value=" (d.avgAttendance > .25 and d.avgAttendance <= .5) ">25-50%</input>';
        unset($_SESSION['attend_25']);
      }
      if (!isset($_SESSION['attend_50'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['attend_50']);
      }
      echo '<input type="checkbox" name="attendance[]" value=" (d.avgAttendance > .5 and d.avgAttendance <= .75) " ' . $checked . '>50-75%</input> ';
      if (!isset($_SESSION['attend_75'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['attend_75']);
      }
      echo '<input type="checkbox" name="attendance[]" value=" (d.avgAttendance > .75) " ' . $checked . '>75-100%</input> ';
      ?>
      <b>Local Residents Receiving Public Assistance</b>
      <br>
      <?php
      if (!isset($_SESSION['assist_0'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['assist_0']);
      }
      echo '<input type="checkbox" name="pubAss[]" value=" (d.percentRecvPublicAsst <= .25) " '.$checked.'>0-25%</input>';
      if (!isset($_SESSION['assist_25'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['assist_25']);
      }
      echo '<input type="checkbox" name="pubAss[]" value=" (d.percentRecvPublicAsst > .25 and d.percentRecvPublicAsst <= .5) " '.$checked.'>25-50%</input>';
      if (!isset($_SESSION['assist_50'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['assist_50']);
      }
      echo '<input type="checkbox" name="pubAss[]" value=" (d.percentRecvPublicAsst > .5 and d.percentRecvPublicAsst <= .75) " '.$checked.'>50-75%</input>';
      if (!isset($_SESSION['assist_75'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['assist_75']);
      }
      echo '<input type="checkbox" name="pubAss[]" value=" (d.percentRecvPublicAsst > .75) " '.$checked.'>75-100%</input>';
      ?>
      <br>
      <b>Borough</b>
      <br>
      <?php
      if (!isset($_SESSION['b_man'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['b_man']);
      }
      echo '<input type="checkbox" name="borough[]" value="Manhattan" '.$checked.'>Manhattan</input> ';
      if (!isset($_SESSION['b_brook'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['b_brook']);
      }
      echo '<input type="checkbox" name="borough[]" value="Brooklyn" '.$checked.'>Brooklyn</input> ';
      if (!isset($_SESSION['b_queens'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['b_queens']);
      }
      echo '<input type="checkbox" name="borough[]" value="Queens" '.$checked.'>Queens</input> ';
      if (!isset($_SESSION['b_bronx'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['b_bronx']);
      }
      echo '<input type="checkbox" name="borough[]" value="The Bronx" '.$checked.'>The Bronx</input> ';
      if (!isset($_SESSION['b_staten'])) {
        $checked = 'checked';
      } else {
        $checked = '';
        unset($_SESSION['b_staten']);
      }
      echo '<input type="checkbox" name="borough[]" value="Staten Island" '.$checked.'>Staten Island</input>';
      ?>
      <br>
      <input type="submit" value="Search">
      </div>
      
    </form>

    </div>
    <div style='display: none;'>
     <?php include('static/php/footer.php'); ?>
    </div>
    <div id="map" style="width: 100%; height: 100%; position: fixed;"></div>
  </body>
</html>
