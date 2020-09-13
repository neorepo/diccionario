<?php

class PalabraDao extends BaseDao {

    private $conn = null;
	
	public function __construct() {
		$this->conn = $this->getDb();
	}

    public function findById($id) {
        $row = $this->query('SELECT * FROM palabras WHERE deleted = 0 AND id = ' . (int) $id)->fetch();
        if (!$row) {
            return null;
        }
        $palabra = new Palabra();
        PalabraMapper::map($palabra, $row);
        return $palabra;
    }

    public function findByPalabra(Palabra $palabra) {
        if( $palabra->getId() !== null ) {
            $q = 'SELECT * FROM palabras WHERE palabra = :palabra  AND id != :id';
            $statement = $this->conn->prepare($q);
            $this->executeStatement($statement, [':palabra' => $palabra->getPalabra(), ':id' => $palabra->getId(),]);
        } else {
            $q = 'SELECT * FROM palabras WHERE palabra = :palabra';
            $statement = $this->conn->prepare($q);
            $this->executeStatement($statement, [':palabra' => $palabra->getPalabra()]);
        }
        $row = $statement->fetch();
        if (!$row) {
            return null;
        }
        $palabra = new Palabra();
        PalabraMapper::map($palabra, $row);
        return $palabra;
    }

    public function save(Palabra $palabra) {
        if ($palabra->getId() === null) {
            return $this->insert($palabra);
        }
        return $this->update($palabra);
    }

    public function delete($id) {
        $q = 'UPDATE palabras SET deleted = :deleted WHERE id = :id;';
        $statement = $this->conn->prepare($q);
        $this->executeStatement($statement, [
            ':deleted' => true,
            ':id' => $id,
        ]);
        return $statement->rowCount() == 1;
    }

    public function update(Palabra $palabra) {
        $q = 'UPDATE palabras set palabra = :palabra, significado = :significado, ejemplo = :ejemplo, deleted = :deleted WHERE id = :id;';
        return $this->execute($q, $palabra);
    }

    public function insert(Palabra $palabra) {
        $q = 'INSERT INTO palabras (id, palabra, significado, ejemplo, deleted) VALUES(:id, :palabra, :significado, :ejemplo, :deleted);';
        return $this->execute($q, $palabra);
    }

    private function execute($sql, Palabra $palabra) {
        $statement = $this->conn->prepare($sql);
        $this->executeStatement($statement, $this->getParams($palabra));

        if (!$palabra->getId()) {
            return $this->findById($this->conn->lastInsertId());
        }
        if (!$statement->rowCount()) {
            throw new NotFoundException('Palabra con ID "' . $palabra->getId() . '" no existe.');
        }
        return $palabra;
    }

    private function executeStatement(PDOStatement $statement, array $params) {
        // XXX
        //echo str_replace(array_keys($params), $params, $statement->queryString) . PHP_EOL;
        if ($statement->execute($params) === false) {
            self::throwDbError($this->conn->errorInfo());
        }
    }

    private static function throwDbError(array $errorInfo) {
        // TODO log error, send email, etc.
        throw new Exception('DB error [' . $errorInfo[0] . ', ' . $errorInfo[1] . ']: ' . $errorInfo[2]);
    }

    private function getParams(Palabra $palabra) {
        $params = [
            ':id' => $palabra->getId(),
            ':palabra' => $palabra->getPalabra(),
            ':significado' => $palabra->getSignificado(),
            ':ejemplo' => $palabra->getEjemplo(),
            ':deleted' => self::formatBoolean( $palabra->getDeleted() ),
        ];
        return $params;
    }

    private static function formatBoolean($bool) {
        return $bool ? 1 : 0;
    }

    public function getAll() {
        $rows = $this->query('SELECT * FROM palabras WHERE deleted = 0 ORDER BY palabra;');
        $result = [];
        foreach ($rows as $row) {
            $palabra = new Palabra();
            PalabraMapper::map($palabra, $row);

            // Los ids de palabras comienzan en 1
            $result[ $palabra->getId() ] = $palabra;
        }
        // Devolvemos un array de objetos
        return $result;
    }

    private function query($sql) {
        $statement = $this->conn->query($sql, PDO::FETCH_ASSOC);
        if ($statement === false) {
            self::throwDbError($this->conn->errorInfo());
        }
        return $statement;
    }
}