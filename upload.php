<html>
	<head>
		<script src="js/bootstrap.js"></script>
		<script src="js/jquery-1.7.2.min.js"></script>
		<script src="js/jquery.Jcrop.min.js"></script>
		<script type="text/javascript" src="js/jquery.form.js"></script>

		<link type="text/css" href="css/bootstrap.min.css" REL=StyleSheet>
		<link type="text/css" href="css/jquery.Jcrop.css" REL=StyleSheet>
		<link type="text/css" href="css/estilos.css" REL=StyleSheet>

		<script>
			//Verificamos la extension del archivo seleccionado
			$(document).ready(function() {

				//1 - Cargar la imagen en el DIV verificando su extensión antes
				$('#photoimg').live('change', function() {
					var ext = $('.imagen').val().split('.').pop().toLowerCase();
					if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
						alert('Seleccione una imagen -> (gif,png,jpg,jpeg)');
						return false;
					} else//El archivo tiene extension de imagen
					{
						//Cargar el div con la imagen subida
						$("#preview").html('');
						$("#preview").html('<img src="img/loader.gif" alt="Uploading...."/>');
						$("#form-imagen").ajaxForm({
							target : '#preview'
						}).submit();
					}
				});
			});
		</script>
	</head>
	<body>
			<div class="contenedor ">
			<h4>Selecciona una imagen:</h4>
			
				<form action="img-process.php" id="form-imagen" method="post" enctype="multipart/form-data" >
					<input type="file" class="imagen" id="photoimg" name="photoimg">
				</form>
				<?php //se procede a la pagina de seleccion del area de recorte ?>
				<form action="select.php" method="post">
					<div id='preview'></div>	
					
					<div class="form-actions">
						<input type="submit" class="submit btn btn-primary">
					</div>
				</form>
				
				
				
			</div>
	</body>
</html>
