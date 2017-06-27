<?php

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

//https://www.w3schools.com/cssref/css3_pr_overflow-y.asp