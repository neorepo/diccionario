<?php

require_once '../includes/bootstrap.php';

$data = getWordById();

$message = 'Lo sentimos, no pudimos eliminar el registro.';
$class = 'danger';
if ( delete( $data['id'] ) ) {
    $message = 'Eliminado correctamente.';
    $class = 'success';
}

Flash::addFlash($message, $class);
header('Location: index.php');
exit;