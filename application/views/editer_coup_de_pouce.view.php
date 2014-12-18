<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    Page::getInstance()->listeFormations = array_merge(array("---"), Page::getInstance()->listeFormations);
 ?>
<section id="editer-coup-de-pouce">
    <div class="conteneur">
        <fieldset>
            <legend>
                <h2 class="titre">
                    <?php
                    switch($this->action) {
                        case "ajouter" : 
                            ?> Ajouter un coup de pouce <?php
                            break;
                        case "editer" : 
                            ?> Editer un coup de pouce <?php
                            break;
                    }
                    ?>
                </h2>
            </legend>
            <form method="POST" action="?controller=coups_de_pouce&action=<?php echo $this->action;?>">
                <?php FormHelper::cleCSRF(); ?>
                <p class="erreur-form"> 
                    <?php echo $this->formMessage;?>
                </p>
                <input type="hidden" name="id" value="<?php echo $this->id;?>" />    
                <dl>
                    <dt>
                        <label for="titre">Titre :</label>
                    </dt>
                    <dd>
                        <input id="titre" name="titre" type="text" maxlenght="256" value="<?php echo $this->titre;?>"/>
                    </dd>

                    <dt>
                        <label for="accroche">Accroche :</label>
                    </dt>
                    <dd>
                        <input id="accroche" name="accroche" type="text" maxlenght="256" value="<?php echo $this->accroche;?>"/>
                    </dd>
                    <dt>
                        <label for="description">Description :</label>
                    </dt>
                    <dd>
                        <textarea id="description" name="description" rows="12" cols="50"></textarea> 
                    </dd>
                    <dt>
                        <label for="date">Date :</label>
                    </dt>
                    <dd>
                        <input id="date" name="date" type="text" placeholder="jj/mm/aaaa hh:mm" value="<?php echo $this->date;?>"/>
                    </dd>
                    <dt>
                        <label for="salle">Salle :</label>
                    </dt>
                    <dd>
                        <input id="salle" name="salle" type="text" maxlenght="32" value="<?php echo $this->salle;?>"/>
                    </dd>
                    <dt>
                        <label for="places">Nombre de places : </label>
                    </dt>
                    <dd>
                        <select id="places" name="places">
                            <?php
                            for ($i = 1; $i <= 10; $i++) {
                                if ($i == $this->places) {
                                    HTMLHelper::option($i, null, $i);
                                } else {
                                    HTMLHelper::option($i);
                                }
                            }
                            ?>
                        </select>
                    </dd>
                    <dt>
                        <label for="formation">Formation : </label>
                    </dt>
                    <dd>
                        <select id="formation" name="formation">
                            <?php
                            foreach (Page::getInstance()->listeFormations as $formation) {
                                if ($formation == $this->formation) {
                                    HTMLHelper::option($formation, null, $formation);
                                } else {
                                    HTMLHelper::option($formation);
                                }
                            }
                            ?>
                        </select>
                    </dd>
                    <dt></dt>
                    <dd>
                        <button id="envoyer" class="btn" name="envoyer" type="submit" value="1">Envoyer</button>
                    </dd>
                </dl>
            </form>           
        </fieldset>
    </div>
</section>   