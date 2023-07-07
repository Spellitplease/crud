<?php
include('head.php');
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Mon Site</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <?php
            if (isset($_SESSION['utilisateur_nom']) && isset($_SESSION['utilisateur_mail'])) {
                // Utilisateur connecté
                echo '
                    <li class="nav-item">
                        <a class="nav-link" href="liste.php">Ma liste</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Mon profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                ';
            } else {
                // Utilisateur non connecté
                echo '
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">Inscription</a>
                    </li>
                ';
            }
            ?>
        </ul>
    </div>
</nav>
