<?php

class Palabra {
    
    private $id;
    private $palabra;
    private $significado;
    private $ejemplo;
    private $deleted;

    public function __contruct() {

    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setPalabra($palabra) {
        $this->palabra = $palabra;
    }

    public function getPalabra() {
        return $this->palabra;
    }

    public function setSignificado($significado) {
        $this->significado = $significado;
    }

    public function getSignificado() {
        return $this->significado;
    }

    public function setEjemplo($ejemplo) {
        $this->ejemplo = $ejemplo;
    }

    public function getEjemplo() {
        return $this->ejemplo;
    }

    public function setDeleted($deleted) {
        $this->deleted = $deleted;
    }

    public function getDeleted() {
        return $this->deleted;
    }
}