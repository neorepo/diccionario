<?php

final class PalabraMapper {

    private function __construct() {
    }

    public static function map(Palabra $palabra, array $properties) {
        if (array_key_exists('id', $properties)) {
            $palabra->setId($properties['id']);
        }
        if (array_key_exists('palabra', $properties)) {
            $palabra->setPalabra( Utils::escape( $properties['palabra'] ) );
        }
        if (array_key_exists('significado', $properties)) {
            $palabra->setSignificado( Utils::escape( $properties['significado'] ) );
        }
        if (array_key_exists('ejemplo', $properties)) {
            $palabra->setEjemplo( Utils::escape( $properties['ejemplo'] ) );
        }
        if (array_key_exists('deleted', $properties)) {
            $palabra->setDeleted($properties['deleted']);
        }
    }

    private static function createDateTime($input) {
        return DateTime::createFromFormat('Y-n-j H:i:s', $input);
    }

}
