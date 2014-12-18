<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    
    class UtilisateursModel extends Model {

        /**
         * Enregistre un utilisateur en base de données
         * 
         * @param type $nom
         * @param type $prenom
         * @param type $login
         * @param type $mot_de_passe
         * @param type $email
         * @param type $formation
         * @throws Erreur
         */
        public function enregistrer($nom, $prenom, $login, $mot_de_passe, $email, $formation) {     
            $sql = 'INSERT INTO utilisateurs '
                 . 'SET nom = :nom, prenom = :prenom, login = :login, mot_de_passe = :mot_de_passe, email = :email, formation = :formation, creation = :creation';           
            $req = $this->db->prepare($sql);
            
            $creation = date('Y-m-d H:i:s');
            $req->bindValue(':nom', $nom);      
            $req->bindValue(':prenom', $prenom);       
            $req->bindValue(':login', $login);      
            $req->bindValue(':mot_de_passe', Authentification::encoder($mot_de_passe, $creation));      
            $req->bindValue(':email', $email);      
            $req->bindValue(':formation', $formation);  
            $req->bindValue(':creation', $creation);
            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur('Erreur SQL '.$ex->getMessage());
            }
        }
        
        /**
         * Renvoie true si le login entrée en paramètre est déjà utilisé par un utilisateur
         * 
         * @param type $login
         * @return boolean
         * @throws Erreur
         */
        public function loginExiste($login) {                        
            $sql = 'SELECT count(*) FROM utilisateurs WHERE login = :login';
            $req = $this->db->prepare($sql);
            
            $req->bindValue(':login', $login);
            
            try {
                $req->execute();
            } catch (PDOException $ex) {
                throw new Erreur("Erreur SQL ".$ex->getMessage());
            }
            
            return $req->fetchColumn(PDO::FETCH_ASSOC); //1 si existe, 0 sinon
        }
    }
    
