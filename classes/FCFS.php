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
            //Apenas adiciona na fila conforme a ordem de chegada
            $this->filaCpu->adicionar($processo);
        }
    }

    public function reordenarFilas() {
        //Sem reordenação, a ordem de chegada na fila define
    }

}
