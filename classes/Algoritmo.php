<?php

abstract class Algoritmo {

    protected $cpu;
    protected $es;

    public function __construct() {
        $this->cpu = array();
        $this->es = array();
    }

    public function getCpu() {
        return $this->cpu;
    }

    public function getEs() {
        return $this->es;
    }

    public function setCpu($cpu) {
        $this->cpu = $cpu;
    }

    public function setEs($es) {
        $this->es = $es;
    }

    public function executar(array $processos);
}
