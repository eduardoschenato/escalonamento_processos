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
        //Inicializa as Variáveis
        $finish = false;
        $moverParaES = false;
        $moverParaCPU = false;
        $moverFinalizar = false;
        $permiteTrocaQuantumCPU = false;
        $permiteTrocaQuantumES = false;
        $moveuCPU = false;
        $moveuES = false;
        $currentQuantum = $this->quantum;

        //Inicializa as Filas
        $this->inicializarFilas($processos);

        //Executa enquanto não terminar o processamento
        while (!$finish) {
            //Verifica se a Fila CPU está vazia
            if (!$this->filaCpu->vazio()) {
                //Como a fila da CPU não está vazia, ele permite alterar a fila no Quantum
                $permiteTrocaQuantumCPU = true;
                //Obtém o primeiro item da fila
                $cpu = $this->filaCpu->getPrimeiro();
                //Seta no Processamento
                $this->cpu[$this->time] = $cpu->name;

                //Verifica se é CPU 1 ou CPU 2
                if ($cpu->getStatus() == "cpu1") {
                    //Decrementa o Processamento
                    $cpu->cpu1--;

                    //Verifica se chegou ao fim
                    if ($cpu->getCpu1() == 0) {
                        //Passa o Processo pro próximo estágio
                        $cpu->setStatus("es1");
                        //Seta a variável para mover para E/S
                        $moverParaES = true;
                    }

                    //Recoloca o processo no início da fila, independente de ter acabado ou não
                    $this->filaCpu->setPrimeiro($cpu);
                } elseif ($cpu->getStatus() == "cpu2") {
                    //Decrementa o Processamento
                    $cpu->cpu2--;

                    //Verifica se chegou ao fim
                    if ($cpu->getCpu2() == 0) {
                        //Passa o Processo pro próximo estágio
                        $cpu->setStatus("es2");
                        //Seta a variável para mover para E/S
                        $moverParaES = true;
                    }

                    //Recoloca o processo no início da fila, independente de ter acabado ou não
                    $this->filaCpu->setPrimeiro($cpu);
                }
            }

            //Verifica se a Fila E/S está vazia
            if (!$this->filaEs->vazio()) {
                //Como a fila da CPU não está vazia, ele permite alterar a fila no Quantum
                $permiteTrocaQuantumES = true;
                //Obtém o primeiro item da fila
                $es = $this->filaEs->getPrimeiro();
                //Seta no Processamento
                $this->es[$this->time] = $es->name;

                //Verifica se é E/S 1 ou E/S 2
                if ($es->getStatus() == "es1") {
                    //Decrementa o Processamento
                    $es->es1--;

                    //Verifica se chegou ao fim
                    if ($es->getEs1() == 0) {
                        //Passa o Processo pro próximo estágio
                        $es->setStatus("cpu2");
                        //Seta a variável para mover para CPU
                        $moverParaCPU = true;
                    }

                    //Recoloca o processo no início da fila, independente de ter acabado ou não
                    $this->filaEs->setPrimeiro($es);
                } elseif ($es->getStatus() == "es2") {
                    //Decrementa o Processamento
                    $es->es2--;

                    //Verifica se chegou ao fim
                    if ($es->getEs2() == 0) {
                        //Seta o Processo como finalizado
                        $es->setStatus("end");
                        //Seta a variável para mover para Finalizado
                        $moverFinalizar = true;
                    }

                    //Recoloca o processo no início da fila, independente de ter acabado ou não
                    $this->filaEs->setPrimeiro($es);
                }
            }

            //Decrementa o Quantum
            $currentQuantum--;

            //Verifica se precisa mover o primeiro processo da fila para E/S
            if ($moverParaES) {
                //Move para a Fila de E/S
                $this->moverProcessoParaEs();
                //Reordena a Fila
                $this->reordenarFilas();
            }

            //Verifica se precisa mover o primeiro processo da fila para CPU
            if ($moverParaCPU) {
                //Move para a Fila de CPU
                $this->moverProcessoParaCpu();
                //Reordena a Fila
                $this->reordenarFilas();
            }

            //Verifica se precisa mover o primeiro processo da fila para Finalizado
            if ($moverFinalizar) {
                //Finaliza o Processo
                $this->finalizarProcesso();
                //Reordena a Fila
                $this->reordenarFilas();
            }

            if ($currentQuantum <= 0) {
                //Atualiza a Fila da CPU por causa do Quantum
                $this->atualizarFilaCPUQuantum();

                //Atualiza a Fila da CPU por causa do Quantum
                $this->atualizarFilaESQuantum();

                //Atualiza o Valor do Quantum
                $currentQuantum = $this->quantum;
            }

            //Reseta as Variáveis
            $moverParaCPU = false;
            $moverParaES = false;
            $moverFinalizar = false;
            $permiteTrocaQuantumCPU = false;
            $permiteTrocaQuantumES = false;

            //Verifica se Finalizou todo o Processamento
            $finish = $this->filaCpu->vazio() && $this->filaEs->vazio();
            //Incrementa o Tempo de Execução
            $this->time++;
        }
    }

    public function inicializarFilas(array $processos) {
        foreach ($processos as $processo) {
            $this->filaCpu->adicionar($processo);
        }
    }

    public function reordenarFilas() {
        
    }

    public function atualizarFilaCPUQuantum() {
        $filaCPU = $this->getFilaCpu();
        $cpu = $filaCPU->remover();
        
        if (!empty($cpu)) {
            $filaCPU->adicionar($cpu);
        }
        
        $this->setFilaCpu($filaCPU);
    }

    public function atualizarFilaESQuantum() {
        $filaES = $this->getFilaEs();
        $es = $filaES->remover();
        
        if (!empty($es)) {
            $filaES->adicionar($es);
        }
        
        $this->setFilaEs($filaES);
    }

}
