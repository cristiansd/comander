<?php

if (isset($_GET['borraest'])) {
    setcookie("establecimiento", "", time() - 3600);
}
header("Location: loginRecepcion.php");

