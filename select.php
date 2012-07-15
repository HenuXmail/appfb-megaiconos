<?php

/**
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008-2009 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 */

$url 	= $_POST['url'];

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		
		<script src="../js/jquery.min.js"></script>
		<script src="../js/jquery.Jcrop.js"></script>
		
		
		<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
		<link type="text/css" href="css/estilos.css" REL=StyleSheet>

		<script language="Javascript">

			$(function(){

				$('#cropbox').Jcrop({
					aspectRatio: 1,
					onSelect: updateCoords,
					boxWidth: 450, 
					boxHeight: 400
				});

			});

			function updateCoords(c)
			{
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

		</script>

	</head>

	<body>

		<div class="contenedor ">

			<h4>Seleccione area de corte:</h4>
	
			<!-- This is the image we're attaching Jcrop to -->
			<img src="<?php echo $url ?>" id="cropbox">
			<!-- This is the form that our event handler fills -->
			<form action="crop.php" method="post" onsubmit="return checkCoords();">
				<input type="hidden" id="x" name="x" />
				<input type="hidden" id="y" name="y" />
				<input type="hidden" id="w" name="w" />
				<input type="hidden" id="h" name="h" />
				<input type='hidden' value='<?php echo $url ?>' id='url' name='url'/>
				<div class="form-actions">
						<input type="submit" class="submit btn btn-primary" value="Siguiente">
					</div>
			</form>
		</div>
	</body>

</html>
