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

    public function getTimeCPUProcess($time) {
        if (isset($this->cpu[$time])) {
            return $this->cpu[$time];
        } else {
            return null;
        }
    }

    public function getTimeESProcess($time) {
        if (isset($this->es[$time])) {
            return $this->es[$time];
        } else {
            return null;
        }
    }

    public function executar(array $processos) {
        $finish = false;
        $moverParaES = false;
        $moverParaCPU = false;
        $moverFinalizar = false;

        $this->inicializarFilas($processos);

        while (!$finish && $this->time < 100) {
            if (!$this->filaCpu->vazio()) {
                $cpu = $this->filaCpu->getPrimeiro();
                $this->cpu[$this->time] = $cpu->name;

                if ($cpu->getStatus() == "cpu1") {
                    $cpu->cpu1--;

                    if ($cpu->getCpu1() == 0) {
                        $cpu->setStatus("es1");
                        $moverParaES = true;
                    }

                    $this->filaCpu->setPrimeiro($cpu);
                } elseif ($cpu->getStatus() == "cpu2") {
                    $cpu->cpu2--;

                    if ($cpu->getCpu2() == 0) {
                        $cpu->setStatus("es2");
                        $moverParaES = true;
                    }

                    $this->filaCpu->setPrimeiro($cpu);
                }
            }

            if (!$this->filaEs->vazio()) {
                $es = $this->filaEs->getPrimeiro();
                $this->es[$this->time] = $es->name;

                if ($es->getStatus() == "es1") {
                    $es->es1--;

                    if ($es->getEs1() == 0) {
                        $es->setStatus("cpu2");
                        $moverParaCPU = true;
                    }

                    $this->filaEs->setPrimeiro($es);
                } elseif ($es->getStatus() == "es2") {
                    $es->es2--;

                    if ($es->getEs2() == 0) {
                        $es->setStatus("end");
                        $moverFinalizar = true;
                    }

                    $this->filaEs->setPrimeiro($es);
                }
            }

            //Move para a Fila de E/S
            if ($moverParaES) {
                $this->moverProcessoParaEs();
                $moverParaES = false;
            }

            //Move para a Fila de CPU
            if ($moverParaCPU) {
                $this->moverProcessoParaCpu();
                $moverParaCPU = false;
            }

            //Move o Processo para Finalizado
            if ($moverFinalizar) {
                $this->finalizarProcesso();
                $moverFinalizar = false;
            }

            $finish = $this->filaCpu->vazio() && $this->filaEs->vazio();
            $this->time++;
        }
    }

    abstract public function inicializarFilas(array $processos);

    abstract public function moverProcessoParaCpu();

    abstract public function moverProcessoParaEs();

    abstract public function finalizarProcesso();
}
