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
            $this->filaCpu->add($processo);
        }
    }

    public function moverProcessoParaCpu() {
        $filaCPU = $this->getFilaCpu();
        $filaES = $this->getFilaEs();
        $filaCPU->adicionar($filaES->remover());
        $this->setFilaCpu($filaCPU);
        $this->setFilaEs($filaES);
    }

    public function moverProcessoParaEs() {
        $filaCPU = $this->getFilaCpu();
        $filaES = $this->getFilaEs();
        $filaES->adicionar($filaCPU->remover());
        $this->setFilaCpu($filaCPU);
        $this->setFilaEs($filaES);
    }

    public function finalizarProcesso() {
        $filaES = $this->getFilaEs();
        $filaES->remover();
        $this->setFilaEs($filaES);
    }

}
