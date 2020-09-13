<?php

abstract class BaseDao {

    private static $conn = null;

    public function __destruct() {
        // close db connection
        self::$conn = null;
    }

    protected final function getDb() {

        if (self::$conn !== null) {
            return self::$conn;
        }

		// tratar de conectarse a la base de datos
        try {
            $config = Config::getConfig('sqlite');
            self::$conn = new PDO($config['dsn'], $config['username'], $config['password'], array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                // PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
        } catch (PDOException $e) {
            trigger_error('Could not connect to database:' . $e->getMessage(), E_USER_ERROR);
            exit;
        }
        
		// devolvemos la instancia de la clase PDO
		return self::$conn;
	}

    abstract protected function insert(Palabra $data);
    abstract protected function update(Palabra $data);
    abstract protected function delete($id);
    abstract protected function findById($id);
    abstract protected function getAll();
}