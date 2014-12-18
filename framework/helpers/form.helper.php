<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    abstract class FormHelper {
        private static $cle = null;      
        
        const SESSION_KEY = 'framework3il.csrfToken';  
        
        private static function getCle() {  
            if (!isset($_SESSION[self::SESSION_KEY])) {
                self::$cle = hash('sha256', uniqid());
                $_SESSION[self::SESSION_KEY] = self::$cle;
            }
            return self::$cle;
        }
        
        public static function cleCSRF() {   
            ?>
            <input type="hidden" name="<?php echo self::getCle();?>" value="0"/>
            <?php
        }
        
        public static function validerCleCSRF() {       
            if (!isset($_SESSION[self::SESSION_KEY])) {
                return false;
            }
            $cle = HTTPHelper::post($_SESSION[self::SESSION_KEY], "");
            return ($cle != 0) ? false : true;
        }   
    }

