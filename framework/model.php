<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    abstract class Model {
        protected $db = null;
        
        public function __construct() {
            $this->db = Application::getDB();
        }
    }