<?php

final class Processo {

    private $cpu1;
    private $es1;
    private $cpu2;
    private $es2;
    private $prioridade;

    public function __construct($cpu1, $es1, $cpu2, $es2, $prioridade = null) {
        $this->cpu1 = $cpu1;
        $this->es1 = $es1;
        $this->cpu2 = $cpu2;
        $this->es2 = $es2;
        $this->prioridade = $prioridade;
    }

    public function getCpu1() {
        return $this->cpu1;
    }

    public function getEs1() {
        return $this->es1;
    }

    public function getCpu2() {
        return $this->cpu2;
    }

    public function getEs2() {
        return $this->es2;
    }
    
    public function getPrioridade() {
        return $this->prioridade;
    }

    public function setCpu1($cpu1) {
        $this->cpu1 = $cpu1;
    }

    public function setEs1($es1) {
        $this->es1 = $es1;
    }

    public function setCpu2($cpu2) {
        $this->cpu2 = $cpu2;
    }

    public function setEs2($es2) {
        $this->es2 = $es2;
    }

    public function setPrioridade($prioridade) {
        $this->prioridade = $prioridade;
    }

}
