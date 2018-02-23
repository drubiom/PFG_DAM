<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Smart Mirror-Images</title>
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://www.w3schools.com/lib/w3.js"></script>
	</head>
	<?php
	if ($_POST['subirBtn']) {
		if ($_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png") {
			if ($_FILES['imagen']['size'] <= 2000000) {
			$nombre = "img/";
			$nombre .= $_FILES['imagen']['name'];
			copy($_FILES['imagen']['tmp_name'], $nombre);
			}
			else {echo '<script type="text/javascript">alert("Error, Archivo muy grande.");</script>';}
		}
		else{
		echo '<script type="text/javascript">alert("Error, formato no valido");</script>';  
		}
	}
	?>
	<body>
		<div w3-include-html="header.html"></div> 
		<div class="topnav" id="myTopnav">
				<a href="index.html">Home</a>
				<a href="colors.html">Colors</a>
				<a href="text.html">Text</a>
				<a href="images.php" class="active">Image</a>
				<a href="weather.html">Weather</a>
				<a href="clock.html">Clock</a>
				<a href="javascript:void(0);" class="icon" onclick="myFunction()">&#9776;</a>
		</div>
		<div id="images">
			Aquí podrás elegir o enviar una imagen para mostrar en el espejo.
			<form id="subirImg" name="subirImg" enctype="multipart/form-data" method="post" action="">
				<label for="imagen">Subir imagen:</label>
				<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
				<input type="file" name="imagen" id="imagen" />
				<input type="submit" name="subirBtn" id="subirBtn" value="Subir imagen" />
			</form>
			<?php
				$directory="img";
				$dirint = dir($directory);
				while (($archivo = $dirint->read()) !== false)
				{
					if (eregi("gif", $archivo) || eregi("jpg", $archivo) || eregi("png", $archivo)){
						echo '<img src="'.$directory."/".$archivo.'" width=100px>'."\n";
					}
				}
				$dirint->close();
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
