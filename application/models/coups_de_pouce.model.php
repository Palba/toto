<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');

    class Coups_De_PouceModel extends Model {
        
        /**
         * Retourne les données d'un coup de pouce depuis la base de données
         * 
         * @param type $id
         * @return array
         * @throws Erreur
         */
        public function detail($id) {
            if ($id == 0) {
                throw new Erreur('Mauvais identifiant : '.$id);
            }
            
            $sql = "SELECT coups_de_pouce.id, titre, accroche, description, coups_de_pouce.utilisateur_id, "
                    . "coups_de_pouce.date, salle, places, coups_de_pouce.formation, nom, prenom, "
                    . "count(inscriptions.utilisateur_id) as inscrits "
                    . "FROM coups_de_pouce "
                    . "INNER JOIN utilisateurs ON coups_de_pouce.utilisateur_id = utilisateurs.id "
                    . "INNER JOIN inscriptions on coups_de_pouce.id = inscriptions.coup_de_pouce_id "
                    . "WHERE coups_de_pouce.id = :id";
            $req = $this->db->prepare($sql);
            
            $req->bindValue(':id', $id);
            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL : '.$ex->getMessage());
            }
            
            return $req->fetch(PDO::FETCH_ASSOC);
        }
        
        /**
         * Enregistre un coup de pouce en base de données
         * 
         * @param type $titre
         * @param type $accroche
         * @param type $description
         * @param type $utilisateur_id
         * @param type $date
         * @param type $salle
         * @param type $places
         * @param type $formation
         * @throws Erreur
         */
        public function sauver($titre, $accroche, $description, $utilisateur_id, $date, $salle, $places, $formation) {
            $sql = "INSERT INTO coups_de_pouce "
                    . "SET titre = :titre, accroche = :accroche, "
                    . "description = :description, utilisateur_id = :utilisateur_id, date = :date, salle = :salle, "
                    . "places = :places, formation = :formation, creation = :creation";
            $req = $this->db->prepare($sql);
            
            $req->bindValue(':titre', $titre);
            $req->bindValue(':accroche', $accroche);
            $req->bindValue(':description', $description);
            $req->bindValue(':utilisateur_id', $utilisateur_id);
            $req->bindValue(':date', $date->format('Y-m-d H:i:s'));
            $req->bindValue(':salle', $salle);
            $req->bindValue(':places', $places);
            $req->bindValue(':formation', $formation);
            $req->bindValue(':creation', date('Y-m-d H:i:s'));
            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL : '.$ex->getMessage());
            }
        }
        
        /**
         * Modifie les données d'un coup de pouce dans la base de données
         * 
         * @param type $id
         * @param type $titre
         * @param type $accroche
         * @param type $description
         * @param type $date
         * @param type $salle
         * @param type $places
         * @param type $formation
         * @throws Erreur
         */
        public function modifier($id, $titre, $accroche, $description, $date, $salle, $places, $formation) {
            $sql = "UPDATE coups_de_pouce "
                    . "SET titre = :titre, accroche = :accroche, description = :description, "
                    . "date = :date, salle = :salle, places = :places, formation = :formation WHERE id = :id";
            $req = $this->db->prepare($sql);
            
            $req->bindValue(':id', $id);
            $req->bindValue(':titre', $titre);
            $req->bindValue(':accroche', $accroche);
            $req->bindValue(':description', $description);
            $req->bindValue(':date', $date->format('Y-m-d H:i:s'));
            $req->bindValue(':salle', $salle);
            $req->bindValue(':places', $places);
            $req->bindValue(':formation', $formation);
            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL : '.$ex->getMessage());
            }
        }
        
        /**
         * Retourne la liste des coups de pouce depuis la base de données
         * 
         * @param type $ordre
         * @param type $direction
         * @return \DataSet
         * @throws Erreur
         */
        public function lister($ordre = 'date', $direction = 'desc') { 
            if (!in_array($ordre, array('titre', 'formation', 'date', 'nom'))) {
                throw new Erreur("L'ordre n'existe pas : ".$ordre);
            }
            if (!in_array($direction, array('asc', 'desc'))) {
                throw new Erreur("La direction n'existe pas : ".$ordre);
            }
            
            $sql = "SELECT coups_de_pouce.id, titre, accroche, description, utilisateur_id, date, salle, places, coups_de_pouce.formation, nom, prenom FROM coups_de_pouce INNER JOIN utilisateurs on coups_de_pouce.utilisateur_id = utilisateurs.id ORDER BY ".$ordre." ".$direction;
            
            $req = $this->db->prepare($sql);              
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL ".$ex->getMessage());
            }
            return new DataSet($req->fetchAll(PDO::FETCH_ASSOC), $ordre, $direction);
        }
        
        /**
         * Supprime un coup de pouce dans la base de donnée
         * 
         * @param type $id
         * @throws Erreur
         */
        public function supprimer($id){
            $sql = "DELETE FROM coups_de_pouce WHERE id = :id";
            $req = $this->db->prepare($sql);
            
            $req->bindValue(':id', $id);
            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL ".$ex->getMessage());
            }
        }
    }

