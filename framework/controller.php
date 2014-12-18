<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');

    abstract class Controller {   
        protected $actionParDefaut = "";
        
        /**
         * Execute la méthode correspondant à l'action passée en paramètre
         * 
         * @param string $nomAction
         * @throws Erreur
         */
        public function executer($nomAction) {
            $methode = $nomAction.'Action';
            if (!method_exists($this, $methode)) {
                throw new Erreur('Méthode inexistante : '.$methode);
            } 
            $this->$methode();
        }     
        
        /**
         * Modifie l'action par défaut
         * 
         * @param string $nomAction
         * @throws Erreur
         */
        public function setActionParDefaut($nomAction) {
            $methode = $nomAction.'Action';
            if (!method_exists($this, $methode)) {
                throw new Erreur('Méthode inexistante : '.$methode);
            }  
            $this->actionParDefaut = $nomAction;
        }
        
        /**
         * Retourne l'action par défaut
         * 
         * @return string
         */
        public function getActionParDefaut() {
            return $this->actionParDefaut;
        }
    }