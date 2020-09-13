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