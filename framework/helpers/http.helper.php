<?php
    abstract class HTTPHelper {
        
        /**
         * Renvoie la valeur contenu dans le tableau 'source' à l'emplacement 'clé'
         * 
         * @param type $source
         * @param type $cle
         * @param type $defaut
         * @return String
         */
        private static function fetch($source, $cle, $defaut = null) {
            return isset($source[$cle]) ? $source[$cle] : $defaut;
        }
        
        /**
         * Renvoie la valeur contenu dans le tableau $_GET à l'emplacement 'clé'.
         * 
         * @param type $cle
         * @param type $defaut
         * @return type
         */
        public static function get($cle, $defaut = null) {
            return self::fetch($_GET, $cle, $defaut);
        }
        
        /**
         * Renvoie la valeur contenue dans le tableau $_POST à l'emplacement 'clé'
         * 
         * @param type $cle
         * @param type $defaut
         * @return type
         */
        public static function post($cle, $defaut = null) {
            return self::fetch($_POST, $cle, $defaut);
        }
        
        /**
         * Renvoie les paramètres contenus dans l'url sous forme de tableau
         * 
         * @return type
         */
        public static function getParametresURL() {
            $url = parse_str(filter_input(INPUT_SERVER, 'QUERY_STRING'));
            if (!isset($url['controller'])) {
                $url['controller'] = Application::getControleurCourant();
            }
            if (!isset($url['action'])) {
                $url['action'] = Application::getActionCourante();
            }
            return $url;
        }   
        
        /**
         * Renvoie l'utilisateur vers l'url entrée en paramètre.
         * 
         * @param type $url
         * @param type $message
         */
        public static function rediriger($url, $message = null) { 
            if ($message != null) {
                Message::deposer($message);
            }
            if (!headers_sent()) {                        
                header('Location:'.$url);  
                die();
            } else {                
                ?>
                <script type="text/javascript">
                    window.location = "<?php echo $url; ?>";
                </script>
                <?php
            }
        }
    }
    