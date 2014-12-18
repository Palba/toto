<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    class Authentification {
        protected $authTable;
        protected $authColId;
        protected $authColLogin;
        protected $authColMotDePasse;
        protected $authColSel;        
        protected $utilisateur = null;
        
        private static $_instance = null;
        
        const SESSION_KEY = 'framework3il.authentification';
                
        private function __construct($authTable, $authColId, $authColLogin, $authColMotDePasse, $authColSel){
            $this->authTable            = $authTable;
            $this->authColId            = $authColId;
            $this->authColLogin         = $authColLogin;
            $this->authColMotDePasse    = $authColMotDePasse;
            $this->authColSel           = $authColSel;
        }
        
        /**
         * Retourne l'instance de Authentification
         * 
         * @param string $authTable
         * @param string $authColId
         * @param string $authColLogin
         * @param string $authColMotDePasse
         * @param string $authColSel
         * @return Authentification
         */
        public static function getInstance($authTable=null,$authColId=null,$authColLogin=null,$authColMotDePasse=null,$authColSel=null){
            if(is_null(self::$_instance)){                
                self::$_instance = new Authentification($authTable, $authColId, $authColLogin, $authColMotDePasse,$authColSel);                
            }
            return self::$_instance;
        }
        
        /**
         * retourne vrai et stocke l'id de l'utilisateur dans la session si le mot de passe correspond au login, retourne faux sinon
         * 
         * @param string $login
         * @param string $motDePasse
         * @return boolean
         * @throws Erreur
         */
        public static function authentifier($login, $motDePasse){
            $db = Application::getDB();
            $sql = 'SELECT '.self::getInstance()->authColId.', '.self::getInstance()->authColMotDePasse.', '.self::getInstance()->authColSel
                    .' FROM '.self::getInstance()->authTable.' WHERE '.self::getInstance()->authColLogin.' = :login';
            $req = $db->prepare($sql);      
            $req->bindValue(':login', $login); 
            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL ".$ex->getMessage());
            }
            
            $res = $req->fetch(PDO::FETCH_ASSOC);
            
            if (is_null($res)) {
                return false;
            }
            
            if (Authentification::encoder($motDePasse, $res["creation"]) != $res["mot_de_passe"]) {
                return false;
            }
            
            unset($motDePasse);
            $_SESSION[self::SESSION_KEY] = $res["id"];
            return true;
        }
        
        /**
         * Récupère dans la base de donnée les informations de l'utilisateur connecté
         * 
         * @throws Erreur
         */
        public function chargerUtilisateur() {
            if (!isset($_SESSION[self::SESSION_KEY])) {
                throw new Erreur("Utilisateur non connecté");
            }
            
            $db = Application::getDB();
            $sql = 'SELECT * FROM '.self::getInstance()->authTable.' WHERE '.self::getInstance()->authColId.' = '.$_SESSION[self::SESSION_KEY];
            $req = $db->prepare($sql);  
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL ".$ex->getMessage());
            }
            
            $this->utilisateur = $req->fetch(PDO::FETCH_ASSOC);
            unset($this->utilisateur['mot_de_passe']);
        }
        
        /**
         * Retourne vrai si l'utilisateur est connecté, faux sinon
         * 
         * @return boolean
         */
        public static function estConnecte() {
            return isset($_SESSION[self::SESSION_KEY]) ? true : false;
        }
        
        /**
         * Retourne un tableau contenant les informations de l'utilisateur connecté
         * 
         * @return Array
         */
        public static function getUtilisateur() {
            if (is_null(self::$_instance->utilisateur)) {
                self::$_instance->chargerUtilisateur();
            }
            return self::$_instance->utilisateur;
        }
        
        /**
         * Retourne l'identifiant de l'utilisateur connecté
         * 
         * @return Integer
         * @throws Erreur
         */
        public static function getUtilisateurId() {
            if (!isset($_SESSION[self::SESSION_KEY])) {
                throw new Erreur("Utilisateur non connecte");
            }
            return $_SESSION[self::SESSION_KEY];
        }
        
        /**
         * Détruit la session courante
         */
        public static function deconnecter() {
            self::getInstance()->utilisateur = null;
            unset($_SESSION[self::SESSION_KEY]);
            session_destroy();
        }
        
        /**
         * Encode un mot de passe
         * 
         * @param String $motDePasse
         * @param String $sel
         * @return String
         */
        public static function encoder($motDePasse, $sel) {
            $selEncode = hash('sha256', $sel);
            $motDePasse = $motDePasse.$selEncode;
            $motDePasseEncode = hash('sha256', $motDePasse);
            return $motDePasseEncode;
        }   
    }