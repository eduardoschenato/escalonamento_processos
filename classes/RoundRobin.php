<?php

final class RoundRobin extends Algoritmo {

    private $quantum;

    function __construct($quantum) {
        parent::__construct();
        $this->quantum = $quantum;
    }

    public function getQuantum() {
        return $this->quantum;
    }

    public function setQuantum($quantum) {
        $this->quantum = $quantum;
    }

    public function executar(array $processos) {
        //TODO Eduardo
    }

    public function inicializarFilas(array $processos) {
        foreach ($processos as $processo) {
            $this->filaCpu->adicionar($processo);
        }
    }

    public function reordenarFilas() {
        
    }

}
