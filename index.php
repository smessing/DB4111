<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Team 7 Final Project</title>
    <link rel="stylesheet" href="code/css/map.css" type="text/css" media="screen"/>
    <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDy9NCdMzkcQkBXUDYsKa1xzsdc6IbKq8k&sensor=true" type="text/javascript"></script>
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
          var html = "<h2><a href=\"schools/index.php?id=" + nces + "\">" + name + "</a></h2><b>" + address +
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
     <p>This site was designed to help improve education in New York City.</p>
    </div>
    <div id="map" style="width: 100%; height: 100%; position: fixed;"></div>
  </body>
</html>
