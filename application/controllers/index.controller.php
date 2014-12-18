<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class IndexController extends Controller {
        
        function __construct() {
            $this->setActionParDefaut('index');
        }
        
        public function indexAction() {
            $page = Application::getPage();
            $page->setTemplate('index');
            $page->setVue('index');
            $page->ajouterCSS('index');
        }
    }
