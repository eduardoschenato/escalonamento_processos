<?php

final class ListaProcessos {
    
    public static function getListaProcessos(){
        $processos = array();
        
        foreach($_POST["cpu1"] as $key => $value){
            array_push($processos, new Processo($_POST["cpu1"][$key], $_POST["es1"][$key], $_POST["cpu2"][$key], $_POST["es2"][$key]));
        }
        
        return $processos;
    }
    
}
