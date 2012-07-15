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

						//Activamos Jcrop en el div
						$('#preview').Jcrop({
							onChange : showCoords,
							onSelect : showCoords,
							onRelease : clearCoords,
							aspectRatio : 4 / 4
							//boxWidth : 500
						});
					}

				});

				//Mostrar coordenadas JCrop
				function showCoords(c) {
					$('#x1').val(c.x);
					$('#y1').val(c.y);
					$('#x2').val(c.x2);
					$('#y2').val(c.y2);
					$('#w').val(c.w);
					$('#h').val(c.h);
				};

				function clearCoords() {
					$('#coords input').val('');
				};
			});
		</script>
	</head>
	<body>
			<div class="contenedor ">
			<h4>Selecciona una imagen:</h4>
			
				<form action="img-process.php" id="form-imagen" method="post" enctype="multipart/form-data" >
					<input type="file" class="imagen" id="photoimg" name="photoimg">
					<br>
					<div id='preview' style="width:450px; height:300px; position: relative; overflow: hidden; "></div>
					
					<div class="form-actions">
						<input type="submit" class="submit btn btn-primary">
					</div>
					
				</form>

				<!--        Coordenadas JCrop-->
				<input type="hidden" size="4" id="x1" name="x1" />
				<input type="hidden" size="4" id="y1" name="y1" />
				<input type="hidden" size="4" id="x2" name="x2" />
				<input type="hidden" size="4" id="y2" name="y2" />
				<input type="hidden" size="4" id="w" name="w" />
				<input type="hidden" size="4" id="h" name="h" />
			</div>
	</body>
</html>
