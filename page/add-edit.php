<?php

$palabra = null;
$errors = [];
$title = null;
$action = array_key_exists('id', $_GET);

if ($action) {
    $palabra = Utils::getPalabraByGetId();
} else {
    $palabra = new Palabra();
}

$title = $action ? 'Editar palabra' : 'Agregar palabra';

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    if (array_key_exists('cancelar', $_POST)) {

        if( $palabra->getId() !== null) {
            Utils::redirect('detail', ['id' => $palabra->getId() ]);
        } else {
            Utils::redirect('list');
        }
    }

    $data = [
        'palabra' => $_POST['palabra'],
        'significado' => $_POST['significado'],
        'ejemplo' => $_POST['ejemplo']
    ];

    // map
    PalabraMapper::map($palabra, $data);

    if ( empty( $palabra->getPalabra() ) ) {
        $errors['palabra'] = 'Completa este campo.';
    } else if ( Utils::existePalabra( $palabra ) ) {
        $errors['palabra'] = 'Esta palabra ya se encuentra registrada.';
    }

    if ( empty( $palabra->getSignificado() ) ) {
        $errors['significado'] = 'Completa este campo.';
    }

    // Si no hay errores
    if ( empty($errors) ) {

        $dao = new PalabraDao();
        $palabra = $dao->save($palabra);
        Flash::addFlash('Palabra guardada correctamente.');
        // redirect
        Utils::redirect('detail', ['id' => $palabra->getId()]);
    }
}