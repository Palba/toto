<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');

    class Page {
        public $formMessage = "";

        protected $vue = null;
        protected $template = null;
        protected $CSS = array();
        protected $scripts = array();

        private static $_instance = null;

        /**
         * Retourne l'instance de Page
         * 
         * @return Page
         */
        public static function getInstance() {
            if (is_null(self::$_instance)) {
                self::$_instance = new Page();
            }
            return self::$_instance;
        }

        /**
         * Modifie le template
         * 
         * @param string $nomTemplate
         * @throws Erreur
         */
        public function setTemplate($nomTemplate) {
            $fichierTemplate = 'application/templates/'.$nomTemplate.'.template.php';
            if (!is_readable($fichierTemplate)) {
                throw new Erreur('Fichier de template introuvable : '.$fichierTemplate);
            }
            $this->template = $fichierTemplate;
        }

        /**
         * Modifie la vue
         * 
         * @param string $nomVue
         * @throws Erreur
         */
        public function setVue($nomVue) {
            $fichierVue = 'application/views/'.$nomVue.'.view.php';
            if (!is_readable($fichierVue)) {
                throw new Erreur('Fichier de vue introuvable : '.$fichierVue);
            }
            $this->vue = $fichierVue;
        }

        /**
         * Ajoute un fichier CSS à la liste des fichiers CSS à utiliser
         * 
         * @param string $nomCSS
         * @throws Erreur
         */
        public static function ajouterCSS($nomCSS) {
            $fichierCSS = 'styles/'.$nomCSS.'.css';
            if (!is_readable($fichierCSS)) {
                throw new Erreur('Fichier CSS introuvable : '.$fichierCSS);
            }
            array_push(self::$_instance->CSS, $fichierCSS);
        }

        /**
         * Inclut les fichiers CSS 
         */
        public static function enteteCSS() {
            foreach (self::$_instance->CSS as $fichierCSS) {
                ?> <link rel="stylesheet" type="text/css" href="<?php echo $fichierCSS; ?>"> <?php
            }
        }

        /**
         * Ajoute un fichier JavaScript à la liste des fichiers JavaScript de la page
         * 
         * @param string $nomScript
         * @throws Erreur
         */
        public static function ajouterScript($nomScript) {
            $fichierScript = 'javascript/'.$nomScript.'.js';
            if (!is_readable($fichierScript)) {
                throw new Erreur('Fichier de script introuvable : '.$fichierScript);
            }
            array_push(self::$_instance->scripts, $fichierScript);
        }

        /**
         * Inclut les fichiers JavaScript
         */
        public static function inclureJS() {
            foreach (self::$_instance->scripts as $fichierScript) {
                ?> <script type="text/javascript" src="<?php echo $fichierScript ?>"></script> <?php
            }
        }

        /**
         * Affiche la page
         * 
         * @throws Erreur
         */
        public static function afficher() {
            if (empty(self::$_instance->template)) {
                throw new Erreur("Template non renseigné");
            }
            require_once(self::$_instance->template);       
        }

        /**
         * Test si la vue est initialisée puis demande son insertion
         * 
         * @throws Erreur
         */
        public static function afficherVue() {
            if (empty(self::$_instance->vue)) {
                throw new Erreur("Vue non renseignée");
            }
            self::$_instance->insererVue();
        }

        /**
         * Insère la vue 
         */
        private function insererVue() {
            require_once($this->vue);
        }
    }