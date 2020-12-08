<?php

final class PalabraMapper {

    private function __construct() {
    }

    public static function map(Palabra $palabra, array $properties) {
        if (array_key_exists('id', $properties)) {
            $palabra->setId($properties['id']);
        }
        $palabra->setPalabra( Utils::escape( $properties['palabra'] ) );
        $palabra->setSignificado( Utils::escape( $properties['significado'] ) );
        $palabra->setEjemplo( Utils::escape( $properties['ejemplo'] ) );
        // if (array_key_exists('palabra', $properties)) {
        // }
        // if (array_key_exists('significado', $properties)) {
        // }
        // if (array_key_exists('ejemplo', $properties)) {
        // }
        if (array_key_exists('deleted', $properties)) {
            $palabra->setDeleted($properties['deleted']);
        }
    }

    private static function createDateTime($input) {
        return DateTime::createFromFormat('Y-n-j H:i:s', $input);
    }

}
