<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
?>
<a href="?controller=coups_de_pouce&action=ajouter"><button>Ajouter</button></a>
<?php
    if (Message::hasMessage()) {
        ?>
        <div class="message">
            <p><?php echo Message::retirer(); ?></p>
        </div>
        <?php
    }
?>
<?php
    Application::useHelper('cdp_datagrid');
    $helper = new CDP_DataGridHelper($this->coups_de_pouce, array(
                                                                array("titre" => "Titre", "data" => "titre", "rendu" => "titreRenderer", "triable" => true),
                                                                array("titre" => "Date", "data" => "date", "rendu" => "dateRenderer", "triable" => true),
                                                                array("titre" => "Proposé par", "data" => "nom", "rendu" => "nomRenderer", "triable" => true),
                                                                array("titre" => "Commandes", "data" => "id", "rendu" => "commandesRenderer")
                                                            ));
    $helper->afficher();
?>  
    <form id="commande-form" method="POST">
        <input type="hidden" id="id" name="id"/>
    </form>


  