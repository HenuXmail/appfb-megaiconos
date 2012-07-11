<?php
require_once('config.php');
$facebook = new Facebook($config);

$user_id = $facebook->getUser();

$foto = 'prueba.jpg'; // Enlace a la imagen a subir
$message = 'Photo upload via the PHP SDK!';

?>
<html>
  <head></head>
  <body>

  <?
    if($user_id) {
      try {
        $user_profile = $facebook->api('/me','GET');
        echo "Nombre: " . $user_profile['name'];
		//At the time of writing it is necessary to enable upload support in the Facebook SDK, you do this with the line:
		$facebook->setFileUploadSupport(true);
		  
		//Acrear album
		$album_details = array(
		        'message'=> 'Album prueba',
		        'name'=> 'Album prueba'
		);
		$create_album = $facebook->api('/me/albums', 'post', $album_details);
		  
		//Get album ID of the album you've just created
		$album_uid = $create_album['id'];
		  
		//Upload a photo to album of ID...
		$photo_details = array(
		    'message'=> 'Photo message'
		);
		$file='prueba.jpg'; //Example image file
		$photo_details['image'] = '@' . realpath($file);
		for ($i=0; $i <= 6; $i++) { 
			$upload_photo = $facebook->api('/'.$album_uid.'/photos', 'post', $photo_details);
			echo "<br>foto numero: ".$upload_photo[0];
		}

      } catch(FacebookApiException $e) {
        $login_url = $facebook->getLoginUrl(); 
        echo '<br>Please <a href="' . $login_url . '">login.</a><br>';
        echo($e->getType());
		echo "<br>";
        echo($e->getMessage());
      }   
    } else {

      // No usuario, enlace a login
      $login_url = $facebook->getLoginUrl();
      echo 'Please <a href="' . $login_url . '">login.</a>';

    }

  ?>

  </body>
</html>