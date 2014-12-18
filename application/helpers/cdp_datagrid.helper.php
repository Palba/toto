<?php

defined('__COUPDEPOUCE__') or die('Acces interdit');

class CDP_DataGridHelper extends Datagrid {
    public function titreRenderer($coup_de_pouce) {
        ?> <a href="?controller=coups_de_pouce&action=afficher&id=<?php echo $coup_de_pouce['id']; ?>" id="<?php echo 'cdp'.$coup_de_pouce['id']; ?>"><?php echo $coup_de_pouce['titre']; ?></a> <?php
    } 
    
    public function dateRenderer($coup_de_pouce) {
        return date("d/m/Y H:i", strtotime($coup_de_pouce['date']));
    } 
    
    public function nomRenderer($coup_de_pouce) {
        return $coup_de_pouce['nom'].' '.$coup_de_pouce['prenom'];
    }
    
    public function commandesRenderer($coup_de_pouce) {
        if (!Authentification::estConnecte()) {
            return;
        }
        $visibilite = "disabled";
        if (Authentification::getUtilisateurId() == $coup_de_pouce['utilisateur_id']) {
            $visibilite = "";
        }
        ?>
        <button class="cmd_button cmd_editer" title="editer" <?php echo $visibilite; ?>><img src="images/icone_edit.png"/></button>
        <button class="cmd_button cmd_supprimer orange" title="supprimer" <?php echo $visibilite; ?>><img src="images/icone_delete.png"/></button>
        <input type="hidden" name="id" value="<?php echo $coup_de_pouce['id']; ?>" />   
        <?php
    } 
}
