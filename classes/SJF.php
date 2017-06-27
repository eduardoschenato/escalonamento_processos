<?php

final class SJF extends Algoritmo {

    public function __construct() {
        parent::__construct();
    }

    public function executar(array $processos) {
        parent::executar($processos);
    }

    public function inicializarFilas(array $processos) {
        usort($processos, function($a, $b) {
            if ($a->getCpu1() == $b->getCpu1())
                return 0;
            return ( ( $a->getCpu1() < $b->getCpu1() ) ? -1 : 1 );
        });

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
        $this->reordenarFilas();
    }

    public function moverProcessoParaEs() {
        $filaCPU = $this->getFilaCpu();
        $filaES = $this->getFilaEs();
        $filaES->adicionar($filaCPU->remover());
        $this->setFilaCpu($filaCPU);
        $this->setFilaEs($filaES);
        $this->reordenarFilas();
    }

    public function finalizarProcesso() {
        $filaES = $this->getFilaEs();
        $filaES->remover();
        $this->setFilaEs($filaES);
        $this->reordenarFilas();
    }

    private function reordenarFilas() {
        //Fila CPU
        $filaCPU = $this->getFilaCpu()->getData();
        
        usort($filaCPU, function($a, $b) {
            if ($a->getValorProcessamentoAtual() == $b->getValorProcessamentoAtual())
                return 0;
            return ( ( $a->getValorProcessamentoAtual() < $b->getValorProcessamentoAtual() ) ? -1 : 1 );
        });
        
        $this->setFilaCpu(new Fila($filaCPU));
        
        //Fila E/S
        $filaES = $this->getFilaEs()->getData();
        
        usort($filaES, function($a, $b) {
            if ($a->getValorProcessamentoAtual() == $b->getValorProcessamentoAtual())
                return 0;
            return ( ( $a->getValorProcessamentoAtual() < $b->getValorProcessamentoAtual() ) ? -1 : 1 );
        });
        
        $this->setFilaEs(new Fila($filaES));
    }

}
