<?php
    defined('__COUPDEPOUCE__') or die('Acces interdit');
    Application::useHelper('navigation');
?>
<html>
    <head>
        <title>Coup De Pouce</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="styles/reset.css">
        <link rel="stylesheet" type="text/css" href="styles/coupdepousse.css">
        <?php Page::enteteCSS(); ?>  
    </head>
    <body>
        <header id="page-header">
            <div class="conteneur">
                <div id="bloc-logo">
                    <a href="index.php"><img src="images/coupdepouce_logo.png" alt="logo coup de pouce"/></a>
                </div>
                <nav id="bloc-navigation">
                    <?php NavigationHelper::afficher(); ?>    
                </nav>
            </div>
        </header>
        
        <main><?php Page::afficherVue(); ?></main>
        
        <footer id="page-footer" class="clear">        
            <div class="conteneur">
                <ul>
                    <li class="footer-links">
                        <h2>Plan du site</h2>
                        <ul>
                            <li><a href="index.php">Accueil</a></li>
                            <li><a href="?controller=coups_de_pouce&action=lister">Prochaines Sessions</a></li>
                            <li><a href="?controller=utilisateurs&action=seconnecter">S'identifier</a></li>
                        </ul>
                    </li>
                    <li class="footer-links">
                        <h2>Liens Externes</h2>
                        <ul>
                            <li><a href="http://www.3il-ingenieurs.fr/index.php/fr/">3IL Ecole d'Ingénieurs</a></li>
                            <li><a href="http://www.cs2i-limoges.fr/index.php/fr/">CS2I</a></li>
                            <li><a href="https://exnet.3il.fr">Espace Elèves</a></li>
                        </ul>
                    </li>
                    <li class="footer-links">
                        <h2>Inspiration</h2>
                        <ul>
                            <li><a href="http://www.rockettheme.com/joomla/templates/anacron">Template Anacron de RocketThemes</a></li>
                            <li><a href="http://www.joomla.org/">Joomla</a></li>
                            <li><a href="http://framework.zend.com/">Zend Framework</a></li>
                            <li><a href="http://kudakurage.com/ligature_symbols/">Ligature Symboles (icônes)</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </footer>
        <?php Page::inclureJS(); ?>  
    </body>
</html>
