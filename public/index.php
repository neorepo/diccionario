<?php
$time = microtime(true);
require_once '../includes/bootstrap.php';

$words = getAllWords();

$flashes = null;
if ( Flash::hasFlashes() ) {
    $flashes = Flash::getFlashes();
}

// Eliminamos cualquier variable de sesión
$_SESSION = [];
session_destroy();

$template = '../views/list.html';

require_once '../views/base.html';
$time = microtime(true) - $time;
// print 'Reporte generado en ' . round($time) . ' segundos.';