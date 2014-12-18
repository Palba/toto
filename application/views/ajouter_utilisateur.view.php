<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    Page::getInstance()->listeFormations = array_merge(array("---"), Page::getInstance()->listeFormations);
 ?>
<section id="ajouter-utilisateur">
    <div class="conteneur">
        <fieldset>
            <legend>
                <h2 class="titre">S'inscrire</h2>
            </legend>
            <form method="POST" action="?controller=utilisateurs&action=ajouter">
                <?php FormHelper::cleCSRF(); ?>
                <p class="erreur-form">
                    <?php echo Page::getInstance()->formMessage ?>
                </p>        
                <dl>
                    <dt>
                        <label for="nom">Nom : </label>
                    </dt>
                    <dd>
                        <input id="nom" name="nom" type="text" maxlenght="256" value="<?php echo $this->nom ?>"/>
                    </dd>

                    <dt>
                        <label for="prenom">Prénom : </label>
                    </dt>
                    <dd>
                        <input id="prenom" name="prenom" type="text" maxlenght="256" value="<?php echo $this->prenom ?>"/>
                    </dd>
                    
                    <dt>
                        <label for="login">Login : </label>
                    </dt>
                    <dd>
                        <input id="login" name="login" type="text" maxlenght="256" value="<?php echo $this->login ?>"/>
                    </dd>
                    
                    <dt>
                        <label for="mot_de_passe">Mot de passe : </label>
                    </dt>
                    <dd>
                        <input id="mot_de_passe" name="mot_de_passe" type="password" maxlenght="256" value="<?php echo $this->mot_de_passe ?>"/>
                    </dd>
                    
                    <dt>
                        <label for="verification">Verification : </label>
                    </dt>
                    <dd>
                        <input id="verification" name="verification" type="password" maxlenght="256" value="<?php echo $this->verification ?>"/>
                    </dd>
                    
                    <dt>
                        <label for="email">Email : </label>
                    </dt>
                    <dd>
                        <input id="email" name="email" type="text" maxlenght="256" value="<?php echo $this->email ?>"/>
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
                        <button id="envoyer" name="envoyer" class="btn" type="submit">Envoyer</button>
                    </dd>
                </dl>    
            </form>
        </fieldset>
    </div>
</section>                    
    
