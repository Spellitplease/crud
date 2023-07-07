<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des données envoyées
    if (
        isset($_POST['mail']) && !empty($_POST['mail']) &&
        isset($_POST['mot_de_passe']) && !empty($_POST['mot_de_passe'])
    ) {
        // On inclut la connexion à la base de données
        require_once('connect.php');

        // Nettoyage des données
        $mail = strip_tags($_POST['mail']);
        $mot_de_passe = $_POST['mot_de_passe'];

        // Requête SQL pour récupérer l'utilisateur correspondant aux informations de connexion
        $sql = 'SELECT * FROM utilisateur WHERE mail = :mail';
        $query = $db->prepare($sql);
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->execute();

        // Vérification du mot de passe
        if ($query->rowCount() > 0) {
        $utilisateur = $query->fetch(PDO::FETCH_ASSOC);
        
if (password_verify($mot_de_passe, $utilisateur['mp'])) {
    $_SESSION['utilisateur_id'] = $utilisateur['id'];
    $_SESSION['utilisateur_nom'] = $utilisateur['nom'];
    $_SESSION['utilisateur_mail'] = $utilisateur['mail'];
    $_SESSION['utilisateur_role'] = $utilisateur['role'];

    // Message de connexion
    $_SESSION['message'] = "Bonjour ".$utilisateur['nom']." (".$utilisateur['mail']."), Quel plaisir de vous voir.";
    


    if ($utilisateur['role'] == 'admin') {
        // Utilisateur avec le rôle d'administrateur
        header('Location: admin.php');
    } else {
        // Autres utilisateurs
        header('Location: index.php');
    }
    exit;


        } else {
            $_SESSION['erreur'] = "Mot de passe incorrect.";
        }
    } else {
        $_SESSION['erreur'] = "Aucun utilisateur trouvé avec cette adresse e-mail.";
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
    include_once('header.php');
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
                <h1>Connexion</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="email" id="mail" name="mail" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control">
                    </div>
                    <button class="btn btn-primary" type="submit">Se connecter</button>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
