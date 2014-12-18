<?php 
    session_start();
    define('__FRAMEWORK3IL__', '');
    
    require_once('authentification.php');
    require_once('configuration.php');
    require_once('controller.php');
    require_once('datagrid.php');
    require_once('dataset.php');
    require_once('erreur.php');
    require_once('message.php');
    require_once('model.php');
    require_once('page.php');
    require_once('helpers/http.helper.php');
    require_once('helpers/html.helper.php');
    require_once('helpers/form.helper.php');

    class Application {    
        protected $controleurParDefaut = "";
        
        private static $_instance = null;
        private $configuration = null; 
        private $base = null;
        private $cheminAbsolu = null;
        private $controleurCourant = null;
        private $actionCourante = null;
        
        private function __construct($fichierIni) {
           $this->configuration = Configuration::getInstance($fichierIni);
           $this->base = new PDO('mysql:host='.$this->configuration->db_hostname.';dbname='.$this->configuration->db_database, 'root', '');
           $this->base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           $this->cheminAbsolu = realpath('.');
        }
        
        /**
         * Appelle le contrôleur et l'action correspondants puis demande l'affichage de la page
         * 
         * @throws Erreur
         */
        public function executer() {
            $nomController = HTTPHelper::get("controller", $this->controleurParDefaut);
            
            $fichierController = 'application/controllers/'.$nomController.'.controller.php';
            if (!is_readable($fichierController)) {
                throw new Erreur('Fichier de contrôleur introuvable '.$fichierController);
            }
            
            require_once($fichierController);
            
            $classeController = $nomController.'Controller';
            if (!class_exists($classeController)) {
                throw new Erreur('Classe introuvable '.$classeController);
            }
            
            $controleur = new $classeController();
            $nomAction = HTTPHelper::get("action", $controleur->getActionParDefaut());
            
            $this->controleurCourant = $nomController;
            $this->actionCourante = $nomAction;
            $controleur->executer($nomAction);
            
            Page::afficher();
        }
        
        /**
         * Inclut un helper
         * 
         * @param string $nomHelper
         * @throws Erreur
         */
        public static function useHelper($nomHelper) {
            $fichierHelper = 'application/helpers/'.$nomHelper.'.helper.php';
            if (!is_readable($fichierHelper)) {
                throw new Erreur('Fichier helper introuvable : '.$fichierHelper);
            }
            require_once($fichierHelper);
        } 
        
        /**
         * Inclut un modèle
         * 
         * @param string $nomModele
         * @throws Erreur
         */
        public static function useModele($nomModele) {
            $fichierModele = 'application/models/'.$nomModele.'.model.php';
            if (!is_readable($fichierModele)) {
                throw new Erreur('Fichier de modèle introuvable : '.$fichierModele);
            }
            require_once($fichierModele);   
        }
        
        /**
         * Modifie le contrôleur par defaut
         * 
         * @param string $nomControleur
         * @throws Erreur
         */
        public function setControleurParDefaut($nomControleur) {
            $fichierControleur = 'application/controllers/'.$nomControleur.'.controller.php';
            if (!is_readable($fichierControleur)) {
                throw new Erreur('Fichier de contrôleur introuvable '.$fichierControleur);
            }
            
            require_once($fichierControleur);
            
            $classeController = $nomControleur.'Controller';
            if (!class_exists($classeController)) {
                throw new Erreur('Controleur introuvable '.$classeController);
            }
            
            $this->controleurParDefaut = $nomControleur;            
        }
        
        /**
         * Retourne l'instance de la classe Application
         * 
         * @param string $fichierIni
         * @return Application
         */
        public static function getInstance($fichierIni = "") {
            if (is_null(self::$_instance)) {
                self::$_instance = new Application($fichierIni);
            }
            return self::$_instance;
        }
        
        /**
         * Retourne l'instance de la classe Configuration
         * 
         * @return Configuration
         */
        public static function getConfig() {
            return self::$_instance->configuration;
        }
        
        /**
         * Retourne l'objet d'accès à la base de donnée
         * 
         * @return PDO
         */
        public static function getDB() {
            return self::$_instance->base;
        }
        
        /**
         * Retourne l'instance de la classe Page
         * 
         * @return Page
         */
        public static function getPage() {
            return Page::getInstance();
        }
        
        /**
         * Retourne le chemin absolu de l'application
         * 
         * @return string
         */
        public static function getCheminAbsolu() {
            return self::$_instance->cheminAbsolu;
        }
        
        /**
         * Retourne le contrôleur courant
         * 
         * @return string
         */
        public static function getControleurCourant() {
            return self::$_instance->controleurCourant;
        }
        
        /**
         * Retourne l'action courante
         * 
         * @return string
         */
        public static function getActionCourante() {
            return self::$_instance->actionCourante;
        }    
        
        /**
         * Construit l'instance de la classe Authentification
         */
        public function utiliserAuthentification() {
            Authentification::getInstance($this->configuration->auth_table, $this->configuration->auth_col_id, $this->configuration->auth_col_login, $this->configuration->auth_col_mot_de_passe, $this->configuration->auth_col_sel);
        }
    }