<?php

abstract class Algoritmo {

    protected $cpu;
    protected $es;
    protected $filaCpu;
    protected $filaEs;

    public function __construct() {
        $this->cpu = array();
        $this->es = array();
        $this->filaCpu = new Fila();
        $this->filaEs = new Fila();
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

    public function executar(array $processos) {
        $finish = false;
        $time = 0;
        
        $this->inicializarFilas($processos);

        while (!$finish) {
            if (!$this->filaCpu->vazio()) {
                $cpu = $this->filaCpu->getPrimeiro();
                $this->cpu[$time] = $cpu->name;

                if ($cpu->getStatus() == "cpu1") {
                    $cpu->cpu1--;

                    if ($cpu->getCpu1() == 0) {
                        $cpu->setStatus("es1");
                        $this->moverProcessoParaEs();
                    } else {
                        $this->filaCpu->setPrimeiro($cpu);
                    }
                } elseif ($cpu->getStatus() == "cpu2") {
                    $cpu->cpu2--;

                    if ($cpu->getCpu1() == 0) {
                        $cpu->setStatus("es2");
                        $this->moverProcessoParaEs();
                    } else {
                        $this->filaCpu->setPrimeiro($cpu);
                    }
                }
            }

            if (!$this->filaEs->vazio()) {
                $es = $this->filaEs->getPrimeiro();
                $this->es[$time] = $es->name;

                if ($es->getStatus() == "es1") {
                    $es->es1--;

                    if ($es->getEs1() == 0) {
                        $es->setStatus("cpu2");
                        $this->moverProcessoParaCpu();
                    } else {
                        $this->filaEs->setPrimeiro($es);
                    }
                } elseif ($es->getStatus() == "es2") {
                    $es->es2--;

                    if ($es->getEs1() == 0) {
                        $es->setStatus("end");
                        $this->finalizarProcesso();
                    } else {
                        $this->filaEs->setPrimeiro($es);
                    }
                }
            }

            $finish = $this->filaCpu->vazio() && $this->filaEs->vazio();
            $time++;
        }
    }

    abstract public function inicializarFilas(array $processos);

    abstract public function moverProcessoParaCpu();

    abstract public function moverProcessoParaEs();

    abstract public function finalizarProcesso();
}
