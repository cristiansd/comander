<?php
if (!isset($_SESSION)) {
  session_start();
}
require_once('sending_push.php');
envioGCM(1, "PRUEBA", "12");


