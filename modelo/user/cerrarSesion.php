<?php
require_once __DIR__ .'../../../modelo/user/tokenInicioSesion.php';
session_start();
cerrarSesion();

session_unset();
session_destroy();
header("Location: ../../index.php");
exit();
