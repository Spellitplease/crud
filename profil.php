<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_nom']) || !isset($_SESSION['utilisateur_mail'])) {
    header('Location: connexion.php');
    exit;
}

// Inclure la connexion à la base de données
require_once('connect.php');

// Récupérer les informations de l'utilisateur connecté depuis la base de données
$utilisateur_id = $_SESSION['utilisateur_id'];
$sql = 'SELECT * FROM utilisateur WHERE id = :id';
$query = $db->prepare($sql);
$query->bindParam(':id', $utilisateur_id, PDO::PARAM_INT);
$query->execute();
$utilisateur = $query->fetch(PDO::FETCH_ASSOC);

// Traitement du formulaire de modification du profil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des données envoyées
    if (
        isset($_POST['nom']) && !empty($_POST['nom']) &&
        isset($_POST['mail']) && !empty($_POST['mail'])
    ) {
        // Nettoyage des données
        $nom = strip_tags($_POST['nom']);
        $mail = strip_tags($_POST['mail']);
        $avatar = $_POST['avatar'];

        // Mise à jour des informations de l'utilisateur dans la base de données
        $sql = 'UPDATE utilisateur SET nom = :nom, mail = :mail, avatar = :avatar WHERE id = :id';
        $query = $db->prepare($sql);
        $query->bindParam(':nom', $nom, PDO::PARAM_STR);
        $query->bindParam(':mail', $mail, PDO::PARAM_STR);
        $query->bindParam(':avatar', $avatar, PDO::PARAM_STR);
        $query->bindParam(':id', $utilisateur_id, PDO::PARAM_INT);

        if ($query->execute()) {
            // Mettre à jour les informations de session avec les nouvelles valeurs
            $_SESSION['utilisateur_nom'] = $nom;
            $_SESSION['utilisateur_mail'] = $mail;

            $_SESSION['message'] = "Profil mis à jour avec succès.";
        } else {
            $_SESSION['erreur'] = "Une erreur est survenue lors de la mise à jour du profil.";
        }
    } else {
        $_SESSION['erreur'] = "Veuillez remplir tous les champs obligatoires.";
    }

    // Rediriger vers la page profil.php après la soumission du formulaire
    header('Location: profil.php');
    exit;
}


// Traitement de la suppression du profil
if (isset($_POST['supprimer_profil'])) {
    $utilisateur_id = $_POST['utilisateur_id']; // Récupérer la valeur de utilisateur_id depuis le champ caché

    // Supprimer l'utilisateur de la base de données
    $sql = 'DELETE FROM utilisateur WHERE id = :id';
    $query = $db->prepare($sql);
    $query->bindParam(':id', $utilisateur_id, PDO::PARAM_INT);

    if ($query->execute()) {
        // Détruire la session et rediriger vers la page d'accueil
        session_destroy();
        header('Location: index.php');
        exit;
    } else {
        $_SESSION['erreur'] = "Une erreur est survenue lors de la suppression du profil.";
    }
}


require_once('close.php');
?>

<!DOCTYPE html>
<html lang="fr">
<?php
include('head.php');
?>
<body>
    <?php
    include('header.php');
    ?>

    <main class="container">
        <div class="row">
            <section class="col-12">
                <?php
                if (!empty($_SESSION['erreur'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['erreur'] . '</div>';
                    $_SESSION['erreur'] = "";
                }
                ?>
                <?php
                if (!empty($_SESSION['message'])) {
                    echo '<div class="alert alert-success" role="alert">' . $_SESSION['message'] . '</div>';
                    $_SESSION['message'] = "";
                }
                ?>
                <h1>Profil</h1>
                <form method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" id="nom" name="nom" class="form-control" value="<?php echo $utilisateur['nom']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="mail">Email</label>
                        <input type="email" id="mail" name="mail" class="form-control" value="<?php echo $utilisateur['mail']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar (URL)</label>
                        <input type="text" id="avatar" name="avatar" class="form-control" value="<?php echo $utilisateur['avatar']; ?>">

                    </div>
                    <!-- Code pour afficher l'avatar -->
                    <div class="avatar-container m-5">
                        <div class="avatar-container m-5">
    <?php if (!empty($utilisateur['avatar'])) : ?>
        <img src="<?php echo $utilisateur['avatar']; ?>" alt="Avatar" style="width:300px; border-radius: 50%;">
    <?php else : ?>
        <img src="images/neutre.jpg" alt="Avatar par défaut" style="width:300px; border-radius: 50%;">
    <?php endif; ?>
</div>
                    </div>
                    <div class="form-group">
                        <label for="mot_de_passe">Mot de passe</label>
                        <input type="password" id="mot_de_passe" name="mot_de_passe" class="form-control">
                        <small class="form-text text-muted">Laissez ce champ vide si vous ne souhaitez pas changer de mot de passe.</small>
                    </div>
                    <button class="btn btn-primary" type="submit">Enregistrer</button>
                </form>
                    <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre profil?');">
                        <input type="hidden" name="utilisateur_id" value="<?php echo $utilisateur_id; ?>">
                        <button type="submit" name="supprimer_profil" class="btn btn-danger">Supprimer mon profil</button>
                    </form>

            </section>
        </div>
    </main>
</body>
</html>
