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
							//onChange : showCoords,
							onSelect : updateCoords,
							//onRelease : clearCoords,
							aspectRatio : 1,
							//boxWidth : 500
							boxWidth: 450, 
							boxHeight: 400
						});
					}

				});
				function updateCoords(c)
				{
					$('#x').val(c.x);
					$('#y').val(c.y);
					$('#w').val(c.w);
					$('#h').val(c.h);
				};
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
				</form>
				
				<form action="cut.php" method="post">
					<div id='preview'></div>
					
					<div class="form-actions">
						<input type="submit" class="submit btn btn-primary">
					</div>
					<!--        Coordenadas JCrop-->
		
					<input type="hidden" id="x" name="x" />
					<input type="hidden" id="y" name="y" />
					<input type="hidden" id="w" name="w" />
					<input type="hidden" id="h" name="h" />
				</form>
				
				
				
			</div>
	</body>
</html>
