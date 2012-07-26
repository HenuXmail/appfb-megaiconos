<?php

/**
 * Recorte de imagenes y mini-imagenes, tambien es el encargado de subir las
 * imagenes a facebook y devolver los IDs correspondientes
 * 
 * @copyright sitioweb3.com
 * @author Jmiller
 * @author kerosene
 */
// Configuracio base de Facebook
require_once('config2.php');
//
$facebook = new Facebook($config);

$access_token = 'AAACabjpexIsBAA9ipxZBywiC0alO4RMjaZCJ1HanTym9bp5nbRoSI6ZAqQQdEKCzG78VWgyuru1xoFaxq6Ysi2fSf7LmLYnJZBJDZBYXtKGp3zGaxZClkW';


$params = array('access_token' => $access_token);
$fanpage = '322216194534877';
$album_id = '322218011201362';


                    
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	//TODO crear validaciones correspondientes
	
	$src 	= 	$_POST['url'];
	$x		=	$_POST['x'];
	$y		=	$_POST['y'];
	$w		=	$_POST['w'];
	$h		=	$_POST['h'];
	
	//Se recorta la imagen del usuario 90x90
	$imagen	=	recortar_imagen($src, 'henux', $x, $y, $h, $w);
	//Se crean las miniaturas en base al recorte anteriorna
	$imagenes = crear_miniatura($imagen, 15, 15, 6, 6, 'henux');

        //$user = $facebook->getUser();
        
	if (1==1) 
        {
		try {
                    
                    
                    
                    $accounts = $facebook->api('/yorsh.0.0/accounts', 'GET', $params);
                    
                    foreach($accounts['data'] as $account) 
                    {
                        if( $account['id'] == $fanpage || $account['name'] == $fanpage )
                        {
                        $fanpage_token = $account['access_token'];
                        }
                    }
			
			$lista_imagenes = array();
			//$user_profile = $facebook->api('/me','GET');
	        //echo "Nombre: " . $user_profile['name'];
			$facebook->setFileUploadSupport(true);
			
			//Subimos la foto al album con ID...
//			$photo_details = array(
//			    'message'=> 'Photo message',
//			    "access_token" => $access_token
//			);
//			foreach ($imagenes as $item) {
//				$file= $item; 
//				$photo_details['image'] = '@' . realpath($file);
//				$img_upload = $facebook->api('322216194534877/photos', 'post', $photo_details);
//				$lista_imagenes[] = $img_upload['id'];
//			}
//                        
                        //LA FORMA DE LA PAGINA
                        $IDS_emoticon_full = '';
                        $contador_saltolinea = 0;
                        foreach ($imagenes as $item) 
                        {
                            $file= $item; 
                            $args = array(
                                'message' => 'This photo was uploaded via MegaIcons',
                                'image' => '@' . realpath($file),
                                //'is_published' => 1,
                                //'aid' => $album_id,
                                'no_story' => 1,
                                'access_token' => $fanpage_token
                                );
                            
                            //$photo = $facebook->api($album_id . '/photos', 'post', $args);
                            $photo = $facebook->api('MegaiconosFP/photos', 'post', $args);
                            if( is_array( $photo ) && !empty( $photo['id'] ) )
                            {
                                $contador_saltolinea++;
                                if ($contador_saltolinea==7)
                                {
                                    //FALTA EL SALTO DE LINEA AHI
                                    $IDS_emoticon_full = $IDS_emoticon_full.'<br>';
                                    $contador_saltolinea = 1;
                                }
                                $IDS_emoticon_full = $IDS_emoticon_full."[[".$photo['id']."]]";
                            }
                        }
                         //FIN
                        
		}catch(FacebookApiException $e) 
                {
                    $login_url = $facebook->getLoginUrl(); 
                    echo '<br>Please <a href="' . $login_url . '">login.</a><br>';
                    echo($e->getType());
                            echo "<br>";
                    echo($e->getMessage());
                }   
	}
        else 
        {
            echo "entro al else";
        }	
}
?>

<div class="contenedor">
	<p>Imagen original</p>
	<img src="<?php echo $imagenes[0] ?>" />
	<p>Imagen creada con los recortes de 15x15</p>
	<?php
	for ($i=1; $i <= 36; $i++) {
		if ($i == 7 || $i == 13 || $i == 19 || $i == 25 || $i == 31) {
			echo "<br>";
		} 
		echo "<img src='".$imagenes[$i]."' />";
	}
	?>
	<p>Lista de imagenes IDs</p>
	<?php echo ($IDS_emoticon_full); ?>
	
</div>

<?php
/**
 * Funcrion que recorta la imagen seleccionada por el usuario
 *
 * @return string URL de la imagen recortada
 * @param string URL de la imagen original
 * @author  Jmiller
 */
function recortar_imagen($url,$usuario,$x,$y,$h,$w) {
	
	//TODO Eliminar imagenes en memoria
	$targ_w = $targ_h = 90;
	$jpeg_quality = 90;
	$nombre	=	time().$usuario;
	
	$origen = imagecreatefromjpeg($url);
	$destino = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($destino,$origen,0,0,$x,$y,
							$targ_w,$targ_h,$w,$h);

	//header('Content-type: image/jpeg');
	imagejpeg($destino,'iconos/'.$nombre.'.jpg',$jpeg_quality);
	
	return 'iconos/'.$nombre.'.jpg';
}

/**	
 * Funcion que crea y devuelve miniaturas de una imagen
 * 
 * Devuelve un array con la informacion de las imagenes creadas, como primer
 * valor, se encuentra la imagen original para ser usada a modo de 'preview' y
 * las demás imagenes corresponden a los recortes de la imagen
 * 
 * @author Jmiller
 * @param string $url direccion de la imagen a recortar
 * @param integer $ancho Tamaño del ancho de las miniaturas
 * @param integer alto $alto de las miniaturas
 * @param integer $c_horizontal	Cantidad de miniaturas a recortar horizontalmente
 * @param integer $c_vertical Cantidad de miniaturas a recortar verticalmente
 * @param string $usuario Codigo de usuario a agregar a las imagenes
 * @return array primer valor es la imagen principal, y los demás, las urls de las miniaturas creadas
 */
function crear_miniatura($url, $ancho, $alto, $c_horizontal, $c_vertical, $usuario){
	
	//TODO Eliminar imagenes en memoria
	$jpeg_quality = 90;
	$nombre		=	time().$usuario;
	
	$origen 	= imagecreatefromjpeg($url);
	$destino 	= ImageCreateTrueColor( $ancho, $alto );
	
	$imagenes 	= array();
	$imagenes[] = $url;
	$contador	= 0;
	$avance_x	= 0;
	$avance_y	= 0;
	for ($i=0; $i < $c_vertical; $i++) {
		//Reiniciamos el contador a 0 para comenzar desde la primera columna
		$avance_x = 0; 
		for ($j=0; $j < $c_horizontal; $j++) {
			$contador++; 
			//Se saca la porcion de la imagen (recortamos)
			imagecopy($destino, $origen, 0, 0, $avance_x, $avance_y, $ancho, $alto);
			//Se guarda la imagen previamente recortada
			imagejpeg($destino,'iconos/'.$nombre.'-'.$contador.'.jpg',$jpeg_quality);
			// Guardamos la imagen en el array para obtenerla mas tarde
			$imagenes[] = 'iconos/'.$nombre.'-'.$contador.'.jpg';
			//Avanzamos para recortar el cuadrado del costado derecho
			$avance_x = $avance_x + 15;
		}
		//Avanzamos para pasar a la fila siguiente
		$avance_y = $avance_y + 15;
	}
	return $imagenes;
}
