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

// if ( isset($_GET['id']) ) {
//     print 'Existe el parámetro ID.';
//     if ( isPositiveInt($_GET['id']) ) {
//         print 'El valor Es un caracter numérico positivo.';
//         $data = findById($_GET['id']);
//         if (count($data) == 1) {
//             print 'Si existe la palabra en la DB.';
//         } else {
//             print 'No existe la palabra en la DB.';
//         }
//     } else {
//         print 'El valor No Es un caracter numérico positivo.';
//     }
// } else {
//     print 'No existe el parámetro ID.';
// }