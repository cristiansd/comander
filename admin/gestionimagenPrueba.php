<?php
if ($_POST['subirBtn']) {
    if ($_FILES['imagen']['type'] == "image/jpeg") {
        if ($_FILES['imagen']['size'] <= 2000000) {
            copy($_FILES['imagen']['tmp_name'], "../archivos/ImagenesAdd/".$_FILES['imagen']['name']);
            $_SESSION['imagen'] = $_FILES['imagen']['name'];
            ?>
        <script>
		opener.document.form1.imagenCategoria.value="<?php echo $_SESSION['imagen']; ?>";
		self.close();
	</script>
<?php
}
}
}
?>

<form id="subirImg" name="subirImg" enctype="multipart/form-data" method="post" action="">
<label for="imagen">Subir imagen:</label>
<input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
<input type="file" name="imagen" id="imagen" />
<input type="submit" name="subirBtn" id="subirBtn" value="Subir imagen" />
</form>