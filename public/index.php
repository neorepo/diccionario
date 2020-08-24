<?php
$time = microtime(true);
require_once '../includes/bootstrap.php';

$words = getAllWords();

$flashes = null;
if ( Flash::hasFlashes() ) {
    $flashes = Flash::getFlashes();
}
$template = '../views/index.html';
$title = 'Listado';
require_once '../views/base.html';
$time = microtime(true) - $time;
// print 'Reporte generado en ' . round($time) . ' segundos.';