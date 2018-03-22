<?php
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Subir Imagen</title>
    <link rel="shortcut icon" href="../imagenes/comanderFavicon.ico">
</head>
    <body>
        <?php
            
            //redimensionar_jpeg($nombre_archivo, $nombre_archivo, 30, 30, 80);
           if ((isset($_POST["enviado"])) && ($_POST["enviado"] == "form1")) {
            $nombre_archivo = $_FILES['userfile']['name'];
            // Verificamos si el tipo de archivo es un tipo de imagen permitido.
            // y que el tamaño del archivo no exceda los 16MB
            $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
            $limite_kb = 16384;

            //if (in_array($_FILES['userfile']['type'], $permitidos) && $_FILES['userfile']['size'] <= $limite_kb * 1024)
            

            // Archivo temporal
            $imagen_temporal = $_FILES['userfile']['tmp_name'];

            // Tipo de archivo
            $tipo = $_FILES['userfile']['type'];

            // Leemos el contenido del archivo temporal en binario.
            /*$fp = fopen($imagen_temporal, 'r+b');
            $data = fread($fp, filesize($imagen_temporal));
            fclose($fp);*/
            //Podríamos utilizar también la siguiente instrucción en lugar de las 3 anteriores.
             $data=file_get_contents($imagen_temporal);

            // Escapamos los caracteres para que se puedan almacenar en la base de datos correctamente.
            $data = mysql_escape_string($data);
            
            $_SESSION['imagen'] = $data;

            

           // redimensionar_jpeg($nombre_archivo, $nombre_archivo, 30, 30, 80);
            copy($_FILES['userfile']['tmp_name'], "../archivos/imagenesAdd/".$nombre_archivo);	
	?>
        <script>
		opener.document.form1.imagenCategoria.value="<?php echo $nombre_archivo; ?>";
		self.close();
	</script>
        <?php
        } else {?>
        <form action="gestionimagen.php" method="post" enctype="multipart/form-data" id="form1">

            <p>
                <input name="userfile" type="file" />
            </p>
            <p>
                <input type="submit" name="button" id="button" value="Subir Imagen" />
            </p>
            <input type="hidden" name="enviado" value="form1" />
        </form>
        <?php  }?>
    </body>
</html>