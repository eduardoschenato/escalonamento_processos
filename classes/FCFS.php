<?php

final class FCFS extends Algoritmo {

    public function __construct() {
        parent::__construct();
    }

    public function executar(array $processos) {
        parent::executar($processos);
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
