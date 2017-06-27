<?php

include_once 'classes/Algoritmo.php';
include_once 'classes/FCFS.php';
include_once 'classes/Fila.php';
include_once 'classes/ListaProcessos.php';
include_once 'classes/Prioridade.php';
include_once 'classes/Processo.php';
include_once 'classes/RoundRobin.php';
include_once 'classes/SJF.php';

if (isset($_POST["algoritmo"])) {
    switch ($_POST["algoritmo"]) {
        case "fcfs":
            $algoritmo = new FCFS();
            $algoritmo->executar(ListaProcessos::getListaProcessos());
            break;
        case "sjf":
            $algoritmo = new SJF();
            $algoritmo->executar(ListaProcessos::getListaProcessos());
            break;
        case "rr":
            $algoritmo = new RoundRobin();
            $algoritmo->executar(ListaProcessos::getListaProcessos());
            break;
        case "p":
            $algoritmo = new Prioridade();
            $algoritmo->executar(ListaProcessos::getListaProcessos());
            break;
        default:
            break;
    }
}

echo "<pre>";
var_dump($algoritmo->getCpu());
var_dump($algoritmo->getEs());

//https://www.w3schools.com/cssref/css3_pr_overflow-y.asp