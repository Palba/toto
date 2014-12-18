<?php 
    defined('__FRAMEWORK3IL__') or die('Acces interdit');

    class Configuration {
        private static $_instance = null;
        private $data = null;
        
        private function __construct($fichierIni) {
            if (!is_readable($fichierIni)) {
                die("Fichier de configuration manquant");
            }
            $this->data = parse_ini_file($fichierIni);
            if (!$this->data) {
                die("Fichier de configuration invalide");
            }
        }
        
        /**
         * Retourne l'instance de Configuration
         * 
         * @param string $fichierIni
         * @return Configuration
         */
        public static function getInstance($fichierIni = "") {
            if (is_null(self::$_instance)) {
                self::$_instance = new Configuration($fichierIni);
            }
            return self::$_instance;
        }
        
        /**
         * Retourne une propriété de la configuration
         * 
         * @param type $propriete
         * @return type
         * @throws Erreur
         */
        public function __get($propriete) {
            if (!isset($this->data[$propriete])) {
                throw new Erreur('Propriété de configuration inconnue : '.$propriete);
            }
            return $this->data[$propriete];
        }
    }