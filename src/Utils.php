<?php

final class Utils {

    public static function redirect($page, array $params = []) {
        header('Location: ' . self::createLink($page, $params));
        die();
    }

    public static function createLink($page, array $params = []) {
        unset($params['page']);
        return 'index.php?' .http_build_query(array_merge(['page' => $page], $params));
    }

    public static function getUrlParam($name) {
        if (!array_key_exists($name, $_GET)) {
            throw new NotFoundException('URL parameter "' . $name . '" not found.');
        }
        return $_GET[$name];
    }

    public static function getPalabraByGetId() {
        $id = null;
        try {
            $id = self::getUrlParam('id');
        } catch (Exception $ex) {
            throw new NotFoundException('No se ha proporcionado un identificador de Palabra.');
        }
        if (!is_numeric($id)) {
            throw new NotFoundException('Se ha proporcionado un identificador de Palabra inválido.');
        }
        $dao = new PalabraDao();
        $palabra = $dao->findById($id);
        if ($palabra === null) {
            throw new NotFoundException('Se ha proporcionado un identificador de Palabra desconocido.');
        }
        return $palabra;
    }

    public static function existePalabra($palabra) {
        $dao = new PalabraDao();
        return $dao->findByPalabra($palabra);
    }

    public static function escape($data) {
        return htmlspecialchars( stripslashes( trim($data) ), ENT_QUOTES);
    }
}