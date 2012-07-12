<html>
    <head>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-1.7.2.min.js"></script>
        <script src="js/jquery.Jcrop.min.js"></script>
        <script type="text/javascript" src="js/jquery.form.js"></script>
        <link type="text/css" href="css/bootstrap.min.css" REL=StyleSheet>
        
        <script>
            //Verificamos la extensión del archivo seleccionado
            $(document).ready(function()
            {
                
                //1 - Cargar la imagen en el DIV verificando su extensión antes
                $('#photoimg').live('change', function()	
                { 
                    var ext = $('.imagen').val().split('.').pop().toLowerCase();
                    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
                    {
                        alert('Seleccione una imagen -> (gif,png,jpg,jpeg)');
                        return false;
                    }
                    else //El archivo tiene extension de imagen
                    {
                        //Cargar el div con la imagen subida
                        $("#preview").html('');
                        $("#preview").html('<img src="img/loader.gif" alt="Uploading...."/>');
                        $("#form-imagen").ajaxForm(
                        {
                            target: '#preview'
                        }).submit();   
                        
                        //Activamos Jcrop en el div
                        $('#preview').Jcrop();
                    }
                    
                    
                });
            });
        </script>
    </head>
    <body>
        <center>
        <h4>Selecciona una imagen:</h4>
        <form action="img-process.php" id="form-imagen" method="post" enctype="multipart/form-data" >
            <input type="file" class="imagen" id="photoimg" name="photoimg"><br>
            <div id='preview' style="width:400px; height:400px;"></div>
            <input type="submit" class="submit btn btn-primary">
        </form>
        </center>
    </body>
</html>
