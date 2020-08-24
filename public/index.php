<?php
$time = microtime(true);
require_once '../includes/bootstrap.php';

$words = getAllWords();

$_SESSION = [];
session_destroy();

$flashes = null;
if ( Flash::hasFlashes() ) {
    $flashes = Flash::getFlashes();
}
$template = '../views/index.html';

require_once '../views/base.html';
$time = microtime(true) - $time;
// print 'Reporte generado en ' . round($time) . ' segundos.';