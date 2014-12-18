<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    Application::useModele('coups_de_pouce');
    Application::useModele('formations');
    Application::useModele('inscriptions');
    
    class Coups_De_PouceController extends Controller {
        
        function __construct() {
            $this->setActionParDefaut('lister');
        }
        
        public function afficherAction() {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('afficher_coup_de_pouce');
            Page::ajouterCSS("afficher_coup_de_pouce");
            Page::ajouterCSS("datagrid");
            $page->utilisateur_id = 0;
            if (Authentification::estConnecte()) {
                $page->utilisateur_id = Authentification::getUtilisateurId();
            }

            $id = filter_var(HTTPHelper::get('id'), FILTER_SANITIZE_NUMBER_INT);
            
            if (!filter_var($id, FILTER_VALIDATE_INT)) {
                throw new Erreur("Id non conforme : ".$id);
            }
            
            $modelCdp = new Coups_De_PouceModel();
            $cdp = $modelCdp->detail($id);
            
            $modelInsc = new InscriptionsModel();
            $page->dejaInscrit = $modelInsc->dejaInscrit($cdp['id'], $page->utilisateur_id);
            $page->inscrits = $modelInsc->lister($cdp['id']);
            
            if (!$cdp) {
                throw new Erreur("Coup de pouce introuvable : ".$id);
            }
            
            $page->cdp = $cdp;
        }
        
        public function listerAction() {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('lister_coup_de_pouce');
            Page::ajouterCSS("datagrid");
            Page::ajouterScript("jquery-2.1.1");
            Page::ajouterScript("cdp_datagrid");
            
            $ordre = HTTPHelper::get('ordre', 'date');
            $direction = HTTPHelper::get('direction', 'desc');
            $model = new Coups_De_PouceModel();
            $page->coups_de_pouce = $model->lister($ordre, $direction);
        }
        
        public function supprimerAction() {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                HTTPHelper::rediriger('?controller=erreur', 'Action non autorisée');
            }

            if (!Authentification::estConnecte()){
                HTTPHelper::rediriger('?contoller=erreur', 'Vous devez être authentifié');
            }

            $cdp_id = filter_var(HTTPHelper::post('id', 0), FILTER_SANITIZE_NUMBER_INT);
            if ($cdp_id == 0 || empty($cdp_id)){
                HTTPHelper::rediriger('?controller=erreur', 'Suppression impossible');
            }

            $model = new Coups_De_PouceModel();
            $cdp = $model->detail($cdp_id);
            if ($cdp['utilisateur_id'] != Authentification::getUtilisateurId()){
                HTTPHelper::rediriger('?controller=erreur', 'Vous ne pouvez pas supprimer ce coup de pouce');
            }

            $model->supprimer($cdp_id);
            HTTPHelper::rediriger('?controller=coups_de_pouce&action=lister', 'Coup de pouce supprimé');
        }

        
        public function ajouterAction() {
            if (!Authentification::estConnecte()) {
                HTTPHelper::rediriger('?controller=erreur', 'Vous devez être connecté');
            } 
            $this->_recuperation();
            $this->_formulaire('ajouter');
        }

        public function editerAction() {
            if (!Authentification::estConnecte()) {
                HTTPHelper::rediriger("?controller=erreur", "Vous devez être connecté");
            } 
            
            $id = HTTPHelper::post('id', 0);
            if ($id == 0) {
                HTTPHelper::rediriger("?controller=erreur", "Erreur édition coup de pouce");
            }
            
            $modelCoupsDePouce = new Coups_De_PouceModel(); 
            $coup_de_pouce = $modelCoupsDePouce->detail($id);
            
            
            if (is_null($coup_de_pouce)) {
                HTTPHelper::rediriger("?controller=erreur", "Erreur édition coup de pouce");
            }
            
            if ($coup_de_pouce['utilisateur_id'] != Authentification::getUtilisateurId()) {
                HTTPHelper::rediriger("?controller=erreur", "Vous n'êtes pas le propriétaire du coup de pouce");
            }
            
            if (is_null(HTTPHelper::post('envoyer'))) {
                $page = Application::getPage();
                $page->id = $coup_de_pouce['id'];
                $page->titre = $coup_de_pouce['titre'];
                $page->accroche = $coup_de_pouce['accroche'];
                $page->description = $coup_de_pouce['description'];
                $page->date = date("d/m/Y h:i", strtotime($coup_de_pouce['date']));
                $page->salle = $coup_de_pouce['salle'];
                $page->places = $coup_de_pouce['places'];
                $page->formation = $coup_de_pouce['formation'];
            } else {
                $this->_recuperation();
            }
                  
            $this->_formulaire('editer');
        }
    
        private function _recuperation() {
            $page = Application::getPage();
            
            $page->id = HTTPHelper::post('id', 0);
            
            $page->titre = filter_var(HTTPHelper::post('titre', ''), FILTER_SANITIZE_STRING);
            $page->titre = trim($page->titre);
            
            $page->titre = filter_var(HTTPHelper::post('titre', ''), FILTER_SANITIZE_STRING);
            $page->titre = trim($page->titre);
            
            $page->accroche = filter_var(HTTPHelper::post('accroche', ''), FILTER_SANITIZE_STRING);
            $page->accroche = trim($page->accroche);
            
            $page->description = HTTPHelper::post('description', '');
            
            $page->date = filter_var(HTTPHelper::post('date', ''), FILTER_SANITIZE_STRING);
            $page->date = trim($page->date);
            
            $page->salle = filter_var(HTTPHelper::post('salle', ''), FILTER_SANITIZE_STRING);
            $page->salle = trim($page->salle);
            
            $page->places = filter_var(HTTPHelper::post('places', ''), FILTER_SANITIZE_NUMBER_INT);
            
            $page->formation = filter_var(HTTPHelper::post('formation', ''), FILTER_SANITIZE_STRING);
        }
    
        private function _formulaire($action) {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('editer_coup_de_pouce');
            Page::ajouterCSS("editer_coup_de_pouce");
            Page::ajouterCSS("form");
            $page->action = $action;
            
            $modelFormations = new FormationsModel();
            $page->listeFormations = $modelFormations->lister();        
            
            if (is_null(HTTPHelper::post('envoyer'))) {
                return;
            } 
                
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "GET") {
                return;
            }
            
            if (!FormHelper::validerCleCSRF()) {
                throw new Erreur("Session invalide");
            }
            
            if (empty($page->titre)) {
                $page->formMessage = "Il faut saisir un titre"; return;
            }
            
            if (strlen($page->titre) > 256) {
                $page->formMessage = "Le titre doit être composé d'au plus 256 caractères"; return;
            }
            
            if (empty($page->accroche)) {
                $page->formMessage = "Il faut saisir une accroche"; return;
            }
            
            if (strlen($page->accroche) > 256) {
                $page->formMessage = "L'accroche doit être composé d'au plus 256 caractères"; return;
            }
            
            if (empty($page->description)) {
                $page->formMessage = "Il faut saisir une description"; return;
            }
            
            if (strlen($page->description) > 2048) {
                $page->formMessage = "La description doit être composé d'au plus 2048 caractères"; return;
            }
            
            if (!DateTime::createFromFormat("d/m/Y H:i", $page->date)) {
                $page->formMessage = "La date n'a pas été correctement saisie"; return;
            }
            
            if (empty($page->salle)) {
                $page->formMessage = "Il faut saisir une salle"; return;
            }
            
            if (strlen($page->salle) > 32) {
                $page->formMessage = "La salle doit être composé d'au plus 32 caractères"; return;
            }
            
            if ($page->places < 1 || $page->places > 10) {
                $page->formMessage = "Le nombre de places doit être compris entre 1 et 10"; return;
            }
            
            if ($page->formation == "---") {
                $page->formMessage = "Il faut choisir une formation"; return;
            }
            
            if (!$modelFormations->estValide($page->formation)) {
                $page->formMessage = "Cette formation n'existe pas"; return;
            }
            
            $modelCoupsDePouce = new Coups_De_PouceModel();  
            switch($page->action) {
                case 'ajouter':
                    $modelCoupsDePouce->sauver($page->titre, $page->accroche, $page->description, Authentification::getUtilisateurId(), DateTime::createFromFormat("d/m/Y H:i", $page->date), $page->salle, $page->places, $page->formation);
                    break;
                case 'editer':
                    $modelCoupsDePouce->modifier($page->id, $page->titre, $page->accroche, $page->description, DateTime::createFromFormat("d/m/Y H:i", $page->date), $page->salle, $page->places, $page->formation);
                    break;
            }
                   
            HTTPHelper::rediriger("?controller=coups_de_pouce&action=lister");       
        }
    }
    
    
        
