<html>
    <head>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-1.7.2.min.js"></script>
        <link type="text/css" href="css/bootstrap.min.css" REL=StyleSheet>
        
        <script>
            //Verificamos la extensión del archivo seleccionado
            $(document).ready(function()
            {
                $('.submit').click(function(){
                    var ext = $('.imagen').val().split('.').pop().toLowerCase();
                    if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) 
                    {
                        alert('invalid extension!');
                        return false;
                    }
                });
            });
        </script>
    </head>
    <body>
        <center>
        <h4>Selecciona una imagen:</h4>
        <form action="#">
        <input type="file" class="imagen">
        <br><input type="submit" class="submit btn btn-primary">
        </form>
        </center>
    </body>
</html>
