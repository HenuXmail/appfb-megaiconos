appfb-megaiconos
================

Mini aplicacion que transforma cualquier imagen a mega-iconos para facebook

@JotaMiller
@kerosene

Instalacion
================
Para utilizar la aplizacion se necesita un archivo en el directorio raiz llamado "config.php" que por razones de 
seguridad es ignorado desde el archivo .gitignore :)

Basicamente contiene el siguiente codigo php:
<pre>
<code>
require_once("facebook/facebook.php");

$config = array();
$config['appId'] = 'APP ID';
$config['secret'] = ' SECRET CODE';
$config['fileUpload'] = true; // optional
</code>
</pre>