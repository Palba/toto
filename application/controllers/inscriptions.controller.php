<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    Application::useModele('inscriptions');
    
    class InscriptionsController extends Controller {                
        
        public function ajouterAction() {
            // Si on n'est pas en POST : on bloque poliment
            if($_SERVER['REQUEST_METHOD']=="GET") {
                HTTPHelper::rediriger("?controller=erreur","Action interdite");
            }
            // Si on n'est pas connecté : on bloque
            if(!Authentification::estConnecte()){
                HTTPHelper::rediriger("?controller=erreur", "Action non autorisée");
            }            
            $utilisateur_id = Authentification::getUtilisateurId();
            
            // Récupértion de l'id du Coup de Pouce
            $cdp_id = filter_var(HTTPHelper::post("coup_de_pouce_id", 0),FILTER_SANITIZE_NUMBER_INT);
            if(!filter_var($cdp_id,FILTER_VALIDATE_INT)){
                throw new Erreur("Valeur inapropriée");
            }
            
            // Vérification si c'est complet
            $inscriptions = new InscriptionsModel();
            if($inscriptions->complet($cdp_id)){
                HTTPHelper::rediriger("?controller=coups_de_pouce&action=afficher&id=".$cdp_id, "Désolé, c'est complet");
            }
            
            // Inscription et redirection vers la page du Coup de Pouce
            $inscriptions->ajouter($cdp_id, $utilisateur_id);
            HTTPHelper::rediriger("?controller=coups_de_pouce&action=afficher&id=".$cdp_id, "Inscription ajoutée");            
        }
        
        public function supprimerAction() {
            // Si on n'est pas en POST : c'est pas bon
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                HTTPHelper::rediriger("?controller=erreur", "Action interdite");
            }
            
            // Si on n'est pas connecté : on ne peut rien faire
            if (!Authentification::estConnecte()){
                HTTPHelper::rediriger("?controller=erreur", "Action non autorisée");
            }            
            $utilisateur_id = Authentification::getUtilisateurId();
            
            // Récupération de l'id du coup de pouce
            $cdp_id = filter_var(HTTPHelper::post('coup_de_pouce_id', 0), FILTER_SANITIZE_NUMBER_INT);
            if (!filter_var($cdp_id,FILTER_VALIDATE_INT)){
                throw new Erreur("Valeur inapropriée");
            }
            
            // Désinscription et redirection
            $inscriptions = new InscriptionsModel();
            $inscriptions->supprimer($cdp_id, $utilisateur_id);
            HTTPHelper::rediriger("?controller=coups_de_pouce&action=afficher&id=".$cdp_id, "Inscription annulée");
        }
    }

