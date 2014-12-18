<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class ErreurController extends Controller {
        
        function __construct() {
            $this->setActionParDefaut('erreur');
        }
        
        public function erreurAction() {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('erreur');
            $page->message = Message::retirer();
        }
    }
