<?php

final class Processo {

    public $name;
    public $cpu1;
    public $es1;
    public $cpu2;
    public $es2;
    public $prioridade;
    public $status;

    public function __construct($name, $cpu1, $es1, $cpu2, $es2, $prioridade = null) {
        $this->name = $name;
        $this->cpu1 = $cpu1;
        $this->es1 = $es1;
        $this->cpu2 = $cpu2;
        $this->es2 = $es2;
        $this->prioridade = $prioridade;
        $this->status = 'cpu1';
    }

    public function getName() {
        return $this->name;
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
    
    public function getStatus() {
        return $this->status;
    }

    public function setName($name) {
        $this->name = $name;
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

    public function setStatus($status) {
        $this->status = $status;
    }
    
    /*
     * Retorna o tamanho do processamento atual, baseado no status
     */
    public function getValorProcessamentoAtual(){
        switch ($this->getStatus()) {
            case "cpu1":
                return $this->getCpu1();
            case "cpu2":
                return $this->getCpu2();
            case "es1":
                return $this->getEs1();
            case "es2":
                return $this->getEs2();
            default:
                return 0;
        }
    }

}
