<?php
// On démarre une session
session_start();
if (!empty($_SESSION['message'])) {
    echo '<div class="alert alert-success" role="alert">
            ' . $_SESSION['message'] . '
        </div>';
    $_SESSION['message'] = ""; // Réinitialise le message
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des données envoyées
    if (
        isset($_POST['nom']) && !empty($_POST['nom']) &&
        isset($_POST['mail']) && !empty($_POST['mail']) &&
        isset($_POST['mot_de_passe']) && !empty($_POST['mot_de_passe'])
    ) {
        // On inclut la connexion à la base de données
        require_once('connect.php');

        // Nettoyage des données
        $nom = strip_tags($_POST['nom']);
        $mail = strip_tags($_POST['mail']);
        $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT); // Cryptage du mot de passe

        // Requête SQL pour insérer un nouvel utilisateur
        $sql = 'INSERT INTO utilisateur (nom, mail, mp) VALUES (:nom, :mail, :mot_de_passe)';
        $query = $db->prepare($sql);
        $query->bindParam(':nom', $nom, PDO::PARAM_STR);
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);

        if ($query->execute()) {
            $_SESSION['message'] = "Inscription réussie. Vous pouvez maintenant vous connecter.";
            header('Location: inscription.php');
            exit;
        } else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
        }

        require_once('close.php');
    } else {
        $_SESSION['erreur'] = "Veuillez remplir tous les champs du formulaire.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<?php
include('head.php');
?>
<body>
    <?php
  include('header.php')
  ?>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">
                            ' . $_SESSION['erreur'] . '
                        </div>';
                    $_SESSION['erreur'] = "";
                }
                ?>
                <h1>Inscription</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="email" id="mail" name="mail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control">
                    </div>
                    <button class="btn btn-primary" type="submit">S'inscrire</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
