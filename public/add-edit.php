<?php

require_once '../includes/bootstrap.php';

$data = null;
$errors = [];

$action = array_key_exists('id', $_GET);

if ($action) {
    $data = getWordById();
    $_SESSION['id'] = $data['id'];
} else {
    $data = [
        'id' => '',
        'palabra' => '',
        'significado' => '',
        'ejemplo' => ''
    ];
}

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

    if ( empty($_POST['palabra']) ) {
        $errors['palabra'] = 'Completa este campo.';
    } else {
        $data['palabra'] = escape( $_POST['palabra'] );

        if( isset( $_SESSION['id'] ) ) {
            $rows = ifWordExists( $data['palabra'], $_SESSION['id'] );
        } else {
            $rows = ifWordExists( $data['palabra'] );
        }

        if ( count($rows) == 1 ) {
            $errors['palabra'] = 'Esta palabra ya se encuentra registrada.';
        }
    }

    if ( empty($_POST['significado']) ) {
        $errors['significado'] = 'Completa este campo.';
    } else {
        $data['significado'] = escape( $_POST['significado'] );
    }

    if ( !empty($_POST['ejemplo']) ) {
        $data['ejemplo'] = escape( $_POST['ejemplo'] );
    }

    // Si no hay errores
    if ( empty($errors) ) {

        $message = 'Lo sentimos, no pudimos guardar el registro.';
        $class = 'danger';

        if ( save( $data ) ) {
            $message = 'Guardado correctamente.';
            $class = 'success';
            
            $_SESSION = [];
        }
        Flash::addFlash($message, $class);
        header('Location: index.php');
        exit;
    }
}

$flashes = null;
if ( Flash::hasFlashes() ) {
    $flashes = Flash::getFlashes();
}
$template = '../views/add-edit.html';

$title = $action ? 'Editar' : 'Agregar';
require_once '../views/base.html';

function save($data) {
    $data['id'] = $_SESSION['id'] ?? null;
    if ($data['id'] === null) {
        return insert($data);
    }
    return update($data);
}