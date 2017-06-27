<?php

final class Prioridade extends Algoritmo {

    public function __construct() {
        parent::__construct();
    }

    public function executar(array $processos) {
        parent::executar($processos);
    }

    public function inicializarFilas(array $processos) {
        //Ordena pela Prioridade
        usort($processos, function($a, $b) {
            if ($a->getPrioridade() == $b->getPrioridade())
                return 0;
            return ( ( $a->getPrioridade() < $b->getPrioridade() ) ? -1 : 1 );
        });

        foreach ($processos as $processo) {
            //Adiciona na Fila
            $this->filaCpu->adicionar($processo);
        }
    }

    public function reordenarFilas() {
        //Fila CPU
        $filaCPU = $this->getFilaCpu()->getData();
        
        //Ordena pela Prioridade
        usort($filaCPU, function($a, $b) {
            if ($a->getPrioridade() == $b->getPrioridade())
                return 0;
            return ( ( $a->getPrioridade() < $b->getPrioridade() ) ? -1 : 1 );
        });
        
        $this->setFilaCpu(new Fila($filaCPU));
        
        //Fila E/S
        $filaES = $this->getFilaEs()->getData();
        
        //Ordena pela Prioridade
        usort($filaES, function($a, $b) {
            if ($a->getPrioridade() == $b->getPrioridade())
                return 0;
            return ( ( $a->getPrioridade() < $b->getPrioridade() ) ? -1 : 1 );
        });
        
        $this->setFilaEs(new Fila($filaES));
    }

}
