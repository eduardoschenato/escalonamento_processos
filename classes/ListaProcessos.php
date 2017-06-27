<?php

final class ListaProcessos {
    
    /*
     * Cria os Processos
     */
    public static function getListaProcessos(){
        $processos = array();
        
        foreach($_POST["cpu1"] as $key => $value){
        	array_push($processos, new Processo($key, $_POST["cpu1"][$key], $_POST["es1"][$key], $_POST["cpu2"][$key], $_POST["es2"][$key], $_POST["prioridade"][$key]));
        }
        
        return $processos;
    }
    
}
