<?php

final class Fila {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function getData() {
        return $this->data;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function adicionar($item) {
        array_unshift($this->data, $item);
    }

    public function remover() {
        return array_shift($this->data);
    }

    public function getPrimeiro() {
        return $this->data[0];
    }

    public function setPrimeiro($primeiro) {
        $this->data[0] = $primeiro;
    }
    
    public function vazio(){
        return empty($data);
    }

}
