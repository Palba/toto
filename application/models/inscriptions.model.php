<?php
    defined('__COUPDEPOUCE__') or die ('Acces interdit');
    
    class InscriptionsModel extends Model {
        
        /**
         * Liste les inscriptions classées par date
         * 
         * @param int $cdp_id : id du coup de pouce
         * @return array
         * @throws Erreur
         */
        public function lister($cdp_id) {
            $sql = "SELECT U.id, U.nom, U.prenom, U.formation, I.date FROM utilisateurs AS U ".
                   "JOIN inscriptions AS I ON U.id = I.utilisateur_id ".
                   "WHERE I.coup_de_pouce_id = :coup_de_pouce_id ORDER BY I.date";
            $req = $this->db->prepare($sql);            
            $req->bindValue('coup_de_pouce_id',$cdp_id);            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL '.$ex->getMessage());
            }
            return $req->fetchAll(PDO::FETCH_ASSOC);
        }
        
        
        /**
         * Ajoute une inscription
         * 
         * @param int $cdp_id : id du coup de pouce
         * @param int $utilisateur_id : id de l'utilisateur
         * @throws Erreur
         */
        public function ajouter($cdp_id, $utilisateur_id) {
            $sql = "INSERT INTO inscriptions SET ".
                   "utilisateur_id = :utilisateur_id, ".
                   "coup_de_pouce_id = :coup_de_pouce_id, ".
                   "date = :date";
            
            $req = $this->db->prepare($sql);
            $req->bindValue('utilisateur_id',$utilisateur_id);
            $req->bindValue('coup_de_pouce_id',$cdp_id);
            $req->bindValue('date', date('Y-m-d H:i:s'));
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL '.$ex->getMessage());
            }
        }
        
        
        /**
         * 
         * Supprimer l'inscription
         * 
         * @param id $cdp_id : id du coup de pouce
         * @param id $utilisateur_id : id de l'utilisateur
         * @throws Erreur
         */
        public function supprimer($cdp_id, $utilisateur_id) {
            $sql = "DELETE FROM inscriptions ".
                   "WHERE coup_de_pouce_id = :coup_de_pouce_id ".
                     "AND utilisateur_id = :utilisateur_id";
            $req = $this->db->prepare($sql);
            $req->bindValue('utilisateur_id',$utilisateur_id);
            $req->bindValue('coup_de_pouce_id',$cdp_id);            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL '.$ex->getMessage());
            }
        }
        
        
        /**
         * 
         * Indique si un utilisateur est déjà inscript pour un coup de pouce
         * 
         * @param int $cdp_id : id du coup de pouce
         * @param int $utilisateur_id : id de l'utilisateur
         * @return boolean
         * @throws Erreur
         */
        public function dejaInscrit($cdp_id, $utilisateur_id) {
            $sql = "SELECT COUNT(*) FROM inscriptions ".
                   "WHERE coup_de_pouce_id = :coup_de_pouce_id ".
                    "AND utilisateur_id = :utilisateur_id";
            $req = $this->db->prepare($sql);
            $req->bindValue('utilisateur_id',$utilisateur_id);
            $req->bindValue('coup_de_pouce_id',$cdp_id);            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL '.$ex->getMessage());
            }
            return ($req->fetchColumn() == 1);
        }
        
        
        /**
         * Indique si un coup de pouce est complet
         * 
         * @param int $cdp_id : id du coup de pouce
         * @return boolean
         * @throws Erreur
         */
        public function complet($cdp_id){
            $sql = "SELECT COUNT(*) AS inscrits, C.places FROM coups_de_pouce AS C ".
                   "JOIN inscriptions AS I ON I.coup_de_pouce_id = C.id ".
                    "WHERE C.id = :id";
            $req = $this->db->prepare($sql);            
            $req->bindValue(':id',$cdp_id);            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL '.$ex->getMessage());
            }
            $data = $req->fetch(PDO::FETCH_ASSOC);
            return ($data['inscrits'] == $data['places']);
        }
    }
