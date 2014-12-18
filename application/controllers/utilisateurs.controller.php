<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');

    Application::useModele('utilisateurs');
    Application::useModele('formations');
    
    class UtilisateursController extends Controller {
        
        public function ajouterAction() {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('ajouter_utilisateur');
            Page::ajouterCSS("ajouter_utilisateur");
            Page::ajouterCSS("form");
            Page::ajouterScript("jquery-2.1.1");
            Page::ajouterScript("ajouter_utilisateur");
            
            $modelUtilisateurs = new UtilisateursModel();           
            $modelFormations = new FormationsModel();
            
            $page->listeFormations = $modelFormations->lister();
            
            $page->nom = filter_var(HTTPHelper::post('nom', ''), FILTER_SANITIZE_STRING);
            $page->nom = trim($page->nom);
            
            $page->prenom = filter_var(HTTPHelper::post('prenom', ''), FILTER_SANITIZE_STRING);
            $page->prenom = trim($page->prenom);
            
            $page->login = filter_var(HTTPHelper::post('login', ''), FILTER_SANITIZE_STRING);
            $page->login = trim($page->login);
            
            $page->mot_de_passe = filter_var(HTTPHelper::post('mot_de_passe', ''), FILTER_UNSAFE_RAW);
            
            $page->verification = filter_var(HTTPHelper::post('verification', ''), FILTER_UNSAFE_RAW);
            
            $page->email = filter_var(HTTPHelper::post('email', ''), FILTER_SANITIZE_STRING);
            $page->email = trim($page->email);
            
            $page->formation = filter_var(HTTPHelper::post('formation', ''), FILTER_SANITIZE_STRING);
            
            if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "GET") {
                return;
            }
            
            if (!FormHelper::validerCleCSRF()) {
                throw new Erreur("Session invalide");
            }
            
            if (empty($page->nom)) {
                $page->formMessage = "Il faut saisir un nom"; return;
            }
            
            if (strlen($page->nom) > 256) {
                $page->formMessage = "Le nom doit être composé d'au plus 256 caractères"; return;
            }
            
            if (empty($page->prenom)) {
                $page->formMessage = "Il faut saisir un prénom"; return;
            }
            
            if (strlen($page->prenom) > 256) {
                $page->formMessage = "Le prénom doit être composé d'au plus 256 caractères"; return;
            }
            
            if (empty($page->login)) {
                $page->formMessage = "Il faut saisir un login"; return;
            }
            
            if (strlen($page->login) < 4) {
                $page->formMessage = "Le login doit être composé d'au moins 4 caractères"; return;
            }
            
            if (strlen($page->login) > 32) {
                $page->formMessage = "Le login doit être composé d'au plus 256 caractères"; return;
            }
            
            if (strpos($page->login, ' ')) {
                $page->formMessage = "Le login ne doit pas être composé d'espaces"; return;
            }
            
            if ($modelUtilisateurs->loginExiste($page->login)) {
                $page->formMessage = "Ce login existe déjà"; return;
            }
            
            if (strlen($page->mot_de_passe) < 5) {
                $page->formMessage = "Le mot de passe doit être composé d'au moins 5 caractères"; return;
            }
            
            if ($page->mot_de_passe != $page->verification) {
                $page->formMessage = "Le mot de passe ne correspond pas"; return;
            }
            
            if (empty($page->email)) {
                $page->formMessage = "Il faut saisir un email"; return;
            }
            
            if (!filter_var($page->email, FILTER_VALIDATE_EMAIL)) {
                $page->formMessage = "Cet email est incorrect"; return;
            }
            
            if (strlen($page->email) > 256) {
                $page->formMessage = "L'email doit être composé d'au plus 256 caracteres"; return;
            }
            
            if ($page->formation == "---") {
                $page->formMessage = "Il faut choisir une formation"; return;
            }
            
            if (!$modelFormations->estValide($page->formation)) {
                $page->formMessage = "Cette formation n'existe pas"; return;
            }
            
            if ($page->formMessage == "") {
                $modelUtilisateurs->enregistrer($page->nom, $page->prenom, $page->login, $page->mot_de_passe, $page->email, $page->formation);
                HTTPHelper::rediriger("?controller=utilisateurs&action=enregistrer");
            }
            
        }
    
        public function seconnecterAction() {
            if (Authentification::estConnecte()) {
                HTTPHelper::rediriger("?controller=index&action=index");
            } else {
                $page = Application::getPage();
                $page->setTemplate('application');
                $page->setVue('seconnecter');
                Page::ajouterCSS("seconnecter");
                Page::ajouterCSS("form");
                Page::ajouterScript("seconnecter");

                $page->login = filter_var(HTTPHelper::post('login', ''), FILTER_SANITIZE_STRING);
                $page->login = trim($page->login);

                $page->mot_de_passe = filter_var(HTTPHelper::post('mot_de_passe', ''), FILTER_UNSAFE_RAW);
                
                if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') == "GET") {
                    return;
                }
                
                if (!FormHelper::validerCleCSRF()) {
                    throw new Erreur("Session invalide");
                }

                if (empty($page->login)) {
                    $page->formMessage = "Veuillez entrer un login"; return;
                }

                if (empty($page->mot_de_passe)) {
                    $page->formMessage = "Veuillez entrer un mot de passe"; return;
                }

                if (!Authentification::authentifier($page->login, $page->mot_de_passe)) {
                    $page->formMessage = "Le login et le mot de passe sont incorrects";
                } else { 
                    HTTPHelper::rediriger("index.php");
                }          
            }
        }
        
        public function deconnecterAction() {
            Authentification::deconnecter();
            HTTPHelper::rediriger("index.php");
        }
        
        public function enregistrerAction() {
            $page = Application::getPage();
            $page->setTemplate('application');
            $page->setVue('utilisateur_enregistre');
        }
    }
