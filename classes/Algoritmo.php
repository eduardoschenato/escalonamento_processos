<?php

abstract class Algoritmo {

    protected $cpu;
    protected $es;
    protected $filaCpu;
    protected $filaEs;
    protected $time;

    public function __construct() {
        $this->cpu = array();
        $this->es = array();
        $this->filaCpu = new Fila();
        $this->filaEs = new Fila();
        $this->time = 0;
    }

    public function getCpu() {
        return $this->cpu;
    }

    public function getEs() {
        return $this->es;
    }

    public function getFilaCpu() {
        return $this->filaCpu;
    }

    public function getFilaEs() {
        return $this->filaEs;
    }

    public function getTime() {
        return $this->time;
    }

    public function setCpu($cpu) {
        $this->cpu = $cpu;
    }

    public function setEs($es) {
        $this->es = $es;
    }

    public function setFilaCpu($filaCpu) {
        $this->filaCpu = $filaCpu;
    }

    public function setFilaEs($filaEs) {
        $this->filaEs = $filaEs;
    }

    public function setTime($time) {
        $this->time = $time;
    }

    /*
     * Retorna o Processamento da CPU no tempo 
     */

    public function getTimeCPUProcess($time) {
        if (isset($this->cpu[$time])) {
            return $this->cpu[$time];
        } else {
            return null;
        }
    }

    /*
     * Retorna o Processamento da E/S no tempo 
     */

    public function getTimeESProcess($time) {
        if (isset($this->es[$time])) {
            return $this->es[$time];
        } else {
            return null;
        }
    }

    public function executar(array $processos) {
        //Inicializa as Variáveis
        $finish = false;
        $moverParaES = false;
        $moverParaCPU = false;
        $moverFinalizar = false;

        //Inicializa as Filas
        $this->inicializarFilas($processos);

        //Executa enquanto não terminar o processamento
        while (!$finish) {
            //Verifica se a Fila CPU está vazia
            if (!$this->filaCpu->vazio()) {
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

            //Verifica se precisa mover o primeiro processo da fila para E/S
            if ($moverParaES) {
                //Move para a Fila de E/S
                $this->moverProcessoParaEs();
                //Reordena a Fila
                $this->reordenarFilas();
                //Reseta a variável
                $moverParaES = false;
            }

            //Verifica se precisa mover o primeiro processo da fila para CPU
            if ($moverParaCPU) {
                //Move para a Fila de CPU
                $this->moverProcessoParaCpu();
                //Reordena a Fila
                $this->reordenarFilas();
                //Reseta a variável
                $moverParaCPU = false;
            }

            //Verifica se precisa mover o primeiro processo da fila para Finalizado
            if ($moverFinalizar) {
                //Finaliza o Processo
                $this->finalizarProcesso();
                //Reordena a Fila
                $this->reordenarFilas();
                //Reseta a variável
                $moverFinalizar = false;
            }

            //Verifica se Finalizou todo o Processamento
            $finish = $this->filaCpu->vazio() && $this->filaEs->vazio();
            //Incrementa o Tempo de Execução
            $this->time++;
        }
    }

    abstract public function inicializarFilas(array $processos);

    abstract public function reordenarFilas();

    /*
     * Adiciona no fim da Fila do CPU o primeiro elemento da Fila de E/S, removendo de lá
     */
    public function moverProcessoParaCpu() {
        $filaCPU = $this->getFilaCpu();
        $filaES = $this->getFilaEs();
        $filaCPU->adicionar($filaES->remover());
        $this->setFilaCpu($filaCPU);
        $this->setFilaEs($filaES);
    }

     /*
     * Adiciona no fim da Fila de E/S o primeiro elemento da Fila do CPU, removendo de lá
     */
    public function moverProcessoParaEs() {
        $filaCPU = $this->getFilaCpu();
        $filaES = $this->getFilaEs();
        $filaES->adicionar($filaCPU->remover());
        $this->setFilaCpu($filaCPU);
        $this->setFilaEs($filaES);
    }

    /*
     * Remove o primeiro elemento da Fila de E/S, pois está finalizado
     */
    public function finalizarProcesso() {
        $filaES = $this->getFilaEs();
        $filaES->remover();
        $this->setFilaEs($filaES);
    }

}
