<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Smart Mirror-Weather</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://www.w3schools.com/lib/w3.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://l2.io/ip.js?var=my_ip"></script>
	<script type="text/javascript" language="JavaScript" src="http://www.geoplugin.net/javascript.gp"></script>
</head>

<body>
	<script type="text/javascript" language="javascript">// <![CDATA[
		function get_current_position() {
		    document.getElementById("out").innerHTML = "<p>Locating...</p>";
		 
		    var geo_options = {enableHighAccuracy:true, maximumAge:30000, timeout:27000};
		    if (navigator.geolocation) {
		        // geolocation IS available
		        navigator.geolocation.getCurrentPosition(geo_success, geo_error, geo_options);
		    } else {
		        // geolocation IS NOT available
		        geo_is_not_available();  
		    }
		}
		 
		function geo_success(position) {
		    var latitude  = position.coords.latitude;
		    var longitude = position.coords.longitude;
		    var accuracy  = position.coords.accuracy;
		 
		    document.getElementById("out").innerHTML = '<p>Latitude: ' + latitude + '&deg;<br>Longitude: ' + longitude + '&deg;<br>Accuracy: ' + accuracy + ' m</p>';
		 
		    var img = new Image();
		    img.src = "http://maps.google.com/maps/api/staticmap?sensor=false&center=" + latitude + "," + longitude + "&zoom=14&size=600x200&markers=color:blue|label:S|" + latitude + ',' + longitude;
		    document.getElementById("out").appendChild(img);
		}
		 
		function geo_error(error) {
		    document.getElementById("out").innerHTML = '<p>ERROR(' + error.code + '): ' + error.message + '</p>';
		}
		 
		function geo_is_not_available() {
		    var my_status      = geoplugin_status();      // '200'
		    var my_latitude    = geoplugin_latitude();    // '42.814098'
		    var my_longitude   = geoplugin_longitude();   // '-1.6412'
		    var my_city        = geoplugin_city();        // 'Pamplona'
		    var my_region      = geoplugin_region();      // 'Navarre'
		    var my_countryName = geoplugin_countryName(); // 'Spain'
		 
		    if (my_status == 404 ) {
		        // 200 - OK
		        // 206 - Only country data returned, no city values found
		        // 404 - No data found for the IP
		        var error = {
		            code : 404,
		            message : "Error 404 - No data found for the IP"
		        };
		        geo_error(error);
		        return;
		    }
		 
		    var position = {
		        coords : {
		            latitude: my_latitude,
		            longitude: my_longitude
		        },  
		        address : {
		            city: my_city,
		            region: my_region,
		            country: my_countryName
		        }
		    };
		    geo_success(position);
		}
	</script>
	<div w3-include-html="header.html"></div> 
	<div class="topnav" id="myTopnav">
  			<a href="index.html">Home</a>
  			<a href="colors.html">Colors</a>
  			<a href="text.html">Text</a>
  			<a href="images.html">Image</a>
  			<a href="weather.html" class="active">Weather</a>
  			<a href="clock.html">Clock</a>
 			<a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
	</div>
	<div id="weather">
		No te olvides de mirar el tiempo antes de salir de casa.
		<form method="get" action="">
    		<label>
        		Ciudad
    		</label>
    		<input type = "text" name="c">
    		<input type = "submit" value="Mostrar el Tiempo">
		</form>
		 <button id="btnGet" onclick="get_current_position()">Find my location</button>
		<div id="out"></div>
		<?php 
			$html = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$_GET["c"]."&lang=es&units=metric&appid=4405a11655d9f6bd6bf98c4dcb528180");
			$json = json_decode($html);
			$ciudad = $json->name;
			$lat = $json->coord->lat;
			$lon = $json->coord->lon;
			$temp = $json->main->temp;
			$tempmax = $json->main->temp_max;
			$tempmin = $json->main->temp_min;
			$presion = $json->main->pressure;
			$humedad = $json->main->humidity;
			$vel_viento = $json->main->temp;
			$estado_cielo = $json->weather[0]->main;
			$descripcion = $json->weather[0]->description; ?>
		<?php 
			if($_GET["c"]!=null){
				echo "<h3>Ciudad: ".$ciudad." [lat = ".$lat. ", lon = ".$lon. " ]</h3>";
				echo "<b>Estado del cielo: </b>".$estado_cielo."<br>";
				echo "<b>Descripción: </b>".$descripcion."<br>";
				echo "<br>";
				echo "<b>Temperatura: </b>".$temp."  [Máx: ".$tempmax.", Mín: ".$tempmin."]<br>";
				echo "<b>Presión: </b>".$presion."<br>";
				echo "<b>Humedad: </b>".$humedad."<br>";
				echo "<br><br><br><br><br>";
			}	  
		?>
	</div>
	<div w3-include-html="footer.html"></div> 
	<script>
		w3.includeHTML();
	</script> 
	<script type="text/javascript">
		/* Toggle between adding and removing the "responsive" class to topnav when the user clicks on the icon */
		function myFunction() {
		    var x = document.getElementById("myTopnav");
		    if (x.className === "topnav") {
		        x.className += " responsive";
		    } else {
		        x.className = "topnav";
		    }
		} 
	</script>
</body>
</html>