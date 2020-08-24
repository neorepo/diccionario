<?php

/**
 * Devuelve true si el string contiene un caracter numérico positivo
 * false en caso contrario.
 */
function isPositiveInt($n) {
    if( get_int($n) ) {
        $n = (int) $n;
        if($n > 0) {
            return true;
        }
    }
    return false;
}

/**
 * Válida un string con caracteres númericos.
 */
function get_int($n) {
    if ($n != null) {
        // Si es un caracter numérico entero
        if ( preg_match('/^[+-]?\d+$/', $n) ) {
            return true;
        }
    }
    return false;
}

/**
 * Devuelve la palabra por el identificador 'id' que se encuentra en la URL.
 */
function getWordById() {
    $id = null;
    try {
        $id = getUrlParam('id');
    } catch (\Throwable $th) {
        trigger_error('No se proporcionó un identificador de palabra.', E_USER_ERROR);
    }
    if ( !is_numeric($id) ) {
        trigger_error('Se proporcionó un identificador de palabra no válido.', E_USER_ERROR);
    }
    $rows = findById($id);
    if ( count($rows) == 0 ) {
        trigger_error('Se proporcionó un identificador de palabra desconocido.', E_USER_ERROR);
    }
    return $rows[0];
}

/**
 * Obtener el valor del parámetro URL.
 */
function getUrlParam($name) {
    if ( !array_key_exists($name, $_GET) ) {
        trigger_error('Parámetro URL ' . $name . ' no encontrado.', E_USER_ERROR);
    }
    return $_GET[$name];
}

/**
 * Escapa caracteres extraños
 */
function escape($data) {
    return htmlspecialchars( stripslashes( trim($data) ) );
}

// Persistencia

/**
 * Encuentra palabra por identificador.
 */
function findById($id) {
    return Db::query('SELECT * FROM palabras WHERE id = ?;', $id);
}

/**
 * 
 */
function delete($id) {
    /**
     * Habilitamos la eliminación ON DELETE CASCADE
     * para base de datos SQLite, siempre que la sentencia sql sea DELETE
     */
    // Db::getInstance()->exec('PRAGMA foreign_keys = ON ;');
    $q = 'UPDATE palabras SET deleted = 1 WHERE id = ?;';
    return Db::query($q, $id);
}

/**
 * Recupera todos los registros de la tabla palabras
 */
function getAllWords() {
    return Db::query('SELECT * FROM palabras WHERE deleted = 0 ORDER BY palabra; ');
}

/**
 * Inserta un nuevo registro en la tabla palabras
 */
function insert($data) {
    $q = 'INSERT INTO palabras (palabra, significado, ejemplo) VALUES(?, ?, ?);';
    return Db::query($q, $data['palabra'], $data['significado'], $data['ejemplo']);
}

/**
 * Actualiza los campos de un registro en la tabla palabras
 */
function update($data) {
    $q = 'UPDATE palabras set palabra = ?, significado = ?, ejemplo = ? WHERE id = ?;';
    return Db::query($q, $data['palabra'], $data['significado'], $data['ejemplo'], $data['id']);
}

/**
 * Verifica si la palabra ya existe en la base de datos o si es distinta de la
 * palabra que se está editando en el momento
 */
function ifWordExists($palabra, $id = null) {
    if($id) {
        $rows = Db::query('SELECT id FROM palabras WHERE palabra = ? AND id != ?;', $palabra, $id);
    } else {
        $rows = Db::query('SELECT id FROM palabras WHERE palabra = ?;', $palabra);
    }
    return $rows;
}