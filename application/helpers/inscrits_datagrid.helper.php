<?php

defined('__COUPDEPOUCE__') or die('Acces interdit');

class Inscrits_DataGridHelper extends Datagrid {
    
    public function dateRenderer($inscrit) {
        return date("d/m/Y H:i", strtotime($inscrit['date']));
    } 
}