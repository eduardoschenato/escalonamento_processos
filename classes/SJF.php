<?php

final class SJF extends Algoritmo {

    public function __construct() {
        parent::__construct();
    }

    public function executar(array $processos) {
        parent::executar($processos);
    }

    public function inicializarFilas(array $processos) {
        //Ordena o Array dos Processos pelo menor tamanho da CPU1
        usort($processos, function($a, $b) {
            if ($a->getCpu1() == $b->getCpu1())
                return 0;
            return ( ( $a->getCpu1() < $b->getCpu1() ) ? -1 : 1 );
        });

        foreach ($processos as $processo) {
            //Adiciona na fila
            $this->filaCpu->adicionar($processo);
        }
    }

    public function reordenarFilas() {
        //Fila CPU
        $filaCPU = $this->getFilaCpu()->getData();
        
        //Ordena pelo menor tamanho
        usort($filaCPU, function($a, $b) {
            if ($a->getValorProcessamentoAtual() == $b->getValorProcessamentoAtual())
                return 0;
            return ( ( $a->getValorProcessamentoAtual() < $b->getValorProcessamentoAtual() ) ? -1 : 1 );
        });
        
        $this->setFilaCpu(new Fila($filaCPU));
        
        //Fila E/S
        $filaES = $this->getFilaEs()->getData();
        
        //Ordena pelo menor tamanho
        usort($filaES, function($a, $b) {
            if ($a->getValorProcessamentoAtual() == $b->getValorProcessamentoAtual())
                return 0;
            return ( ( $a->getValorProcessamentoAtual() < $b->getValorProcessamentoAtual() ) ? -1 : 1 );
        });
        
        $this->setFilaEs(new Fila($filaES));
    }

}
