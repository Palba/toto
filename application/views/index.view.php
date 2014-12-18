<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
?>

<section id="concept" class="clear">
    <div class="conteneur">
        <h2>Pour partager<br/>bien plus que des cours</h2>
        <div id="gros-liens">
            <?php 
            if (Authentification::estConnecte()) {
                ?>
                <a href="?controller=utilisateurs&action=deconnecter">Se deconnecter</a>
                <?php
            } else {
                ?>
                <a href="?controller=utilisateurs&action=ajouter">S'inscrire</a>
                <a href="?controller=utilisateurs&action=seconnecter">S'identifier</a>
                <?php
            }      
            ?>
        </div>
    </div>
</section>
        
<section id="informations">
    <div id="description" class="fond-gris">
        <div class="conteneur">
            <h2 class="titre">Bienvenue sur Coup de Pouce</h2>
            <p>Coup de Pouce est une plateforme collaborative libre de l'école d'ingénieurs 3IL.<br/>
               Elle vise à valoriser l'entraide entre élèves par l'organisation de sessions de tutorat.</p>
        </div>
    </div>
    <div id="etapes">
        <div class="conteneur">
            <ul>
                <li class="etape">
                    <div>
                        <h2>Etape 1</h2>
                        <div>
                            <img src="images/pen.png" alt="pen.png"/>
                        </div>
                        <h3>Créer un compte</h3>
                    </div>
                </li>
                <li class="etape">
                    <div>
                        <h2>Etape 2</h2>
                        <div>
                            <img src="images/calendar.png" alt="calendar.png"/>
                        </div>
                        <h3>S'inscrire à une session</h3>
                    </div>
                </li>
                <li class="etape">
                    <div>
                        <h2>Etape 3</h2>
                        <div>
                            <img src="images/thumb.png" alt="thumb.png"/>
                        </div>
                        <h3>Assister à la session</h3>
                    </div>
                </li>
            </ul>

        </div>
        <div class="clear"></div>
    </div>
    <div id="temoignage" class="fond-gris">
        <div class="conteneur">
            <h2 class="titre">Un vrai plus dans mon cursus</h2>
            <p>Grâce à Coup de Pouce j'ai enfin pu comprendre le TP de Web.<br/>
               Les explications des camarades sont souvent bien plus claires que 
               celles du prof !<span class="signature">Kévin S.</span></p>
        </div>
    </div>
    <div id="en-vedette">
        <div class="conteneur">
            <div id="la-selection">
                <div>
                    <img src="images/web.jpg" alt="web.jpg"/>
                    <div id="legende">Mieux que tout</div>
                </div>
                <div>
                    <div>
                        <h2 class="titre">En vedette</h2>
                        <h3>I2 - Web TP 1</h3>
                        <p>Pour tout comprendre du premier TP de Web, le HTML, le CSS, la mise
                            en page ainsi que les astuces de base à connaître du développement Web.</p>
                    </div>
                </div>
            </div>
            <div id="prochaines-sessions">
                <h2 class="titre">Prochaines sessions</h2>
                <ul>
                    <li>
                        <h3><a href="#">I2 Web - CSS</a></h3>
                        <p>Fonctionnement des sélecteurs</p>
                        <div class="infos">
                            <p>Date : 22/09/2014 à 17h00</p>
                            <p>Lieu : Salle 202</p>
                            <p>Places : 3/6</p>
                        </div>
                    </li>
                    <li>
                        <h3><a href="#">I1 POO - Héritage</a></h3>
                        <p>Pour aller plus loin avec les classes avec l'ajout et/ou redéfinition</p>
                        <div class="infos">
                            <p>Date : 22/09/2014 à 17h00</p>
                            <p>Lieu : Salle 202</p>
                            <p>Places : 3/6</p>
                        </div>
                    </li>
                    <li>
                        <h3><a href="#">I3 Robotique - Faire parler Nao</a></h3>
                        <p>Utiliser la synthèse vocale du robot</p>
                        <div class="infos">
                            <p>Date : 22/09/2014 à 17h00</p>
                            <p>Lieu : Salle 202</p>
                            <p>Places : 3/6</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>          
</section>