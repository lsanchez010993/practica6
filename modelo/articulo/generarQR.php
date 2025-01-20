<?php
use chillerlan\QRCode\QRCode;

function generarQR($url) {
    return (new QRCode)->render($url);
}

?>