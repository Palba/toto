<?php
    defined('__FRAMEWORK3IL__') or die('Acces interdit');
    
    abstract class Message {
        const SESSION_KEY = 'framework3il.message';
        
        /**
         * Méthode de dépot d'un message dans la session
         * 
         * @param string $message
         */
        public static function deposer($message) {
            $_SESSION[self::SESSION_KEY] = htmlspecialchars($message);
        }        
        
        /**
         *  Méthode de retrait du message dans la session
         * 
         *  @return string
         */
        public static function retirer() {
            if (self::hasMessage()) {
                $message = $_SESSION[self::SESSION_KEY];
                unset($_SESSION[self::SESSION_KEY]);
                return $message;
            } else {
                return "";
            }
        }
        
        /**
         * Méthode indiquant la présence d'un message
         * 
         * @return boolean
         */
        public static function hasMessage() {
            return isset($_SESSION[self::SESSION_KEY]) ? true : false;
        }
    }