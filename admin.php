<?php
session_start();

// Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
if (!isset($_SESSION['utilisateur_nom']) || !isset($_SESSION['utilisateur_mail']) || $_SESSION['utilisateur_role'] !== 'admin') {
    header('Location: logout.php');
    exit;
}

// Inclure la connexion à la base de données
require_once('connect.php');

// Récupérer la liste des utilisateurs depuis la base de données
$sql = 'SELECT * FROM utilisateur';
$query = $db->prepare($sql);
$query->execute();
$utilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);

// Traitement de la modification d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['modifier_utilisateur'])) {
    $utilisateur_id = $_POST['utilisateur_id'];
    $nouveau_nom = $_POST['nouveau_nom'];
    $nouveau_role = $_POST['nouveau_role'];

    $sql = 'UPDATE utilisateur SET nom = :nom, role = :role WHERE id = :id';
    $query = $db->prepare($sql);
    $query->bindParam(':nom', $nouveau_nom, PDO::PARAM_STR);
    $query->bindParam(':role', $nouveau_role, PDO::PARAM_INT);
    $query->bindParam(':id', $utilisateur_id, PDO::PARAM_INT);
    $query->execute();

    // Redirection vers la page d'administration après la modification
    header('Location: admin.php');
    exit;
}

// Traitement de la suppression d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['supprimer_utilisateur'])) {
    $utilisateur_id = $_POST['utilisateur_id'];

    $sql = 'DELETE FROM utilisateur WHERE id = :id';
    $query = $db->prepare($sql);
    $query->bindParam(':id', $utilisateur_id, PDO::PARAM_INT);
    $query->execute();

    // Redirection vers la page d'administration après la suppression
    header('Location: admin.php');
    exit;
}
// Traitement de l'ajout d'un utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_utilisateur'])) {
    $nouveau_nom = $_POST['nouveau_nom'];
    $nouveau_mail = $_POST['nouveau_mail'];
    $nouveau_role = $_POST['nouveau_role'];
    $nouveau_mp = password_hash($_POST['mp'], PASSWORD_DEFAULT);


    // Effectuez les validations nécessaires sur les données (par exemple, vérification de la validité de l'adresse email)

    // Insérez les données dans la base de données
    $sql = 'INSERT INTO utilisateur (nom, mail, role, mp) VALUES (:nom, :mail, :role, :mp)';
    $query = $db->prepare($sql);
    $query->bindParam(':nom', $nouveau_nom, PDO::PARAM_STR);
    $query->bindParam(':mail', $nouveau_mail, PDO::PARAM_STR);
    $query->bindParam(':role', $nouveau_role, PDO::PARAM_STR);
    $query->bindParam(':mp', $nouveau_mp, PDO::PARAM_STR);
    $query->execute();

    // Redirection vers la page d'administration après l'ajout
    header('Location: admin.php');
    exit;
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
    <h1>Page d'administration</h1>
    
    <!-- Formulaire d'ajout d'utilisateur -->
    <form method="post" action="admin.php">
        <div class="form-group">
            <label for="nouveau_nom">Nom</label>
            <input type="text" id="nouveau_nom" name="nouveau_nom" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nouveau_mail">Email</label>
            <input type="email" id="nouveau_mail" name="nouveau_mail" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mp" name="mp" class="form-control">
                    </div>
        <div class="form-group">
            <label for="nouveau_role">Role</label>
            <input type="text" id="nouveau_role" name="nouveau_role" class="form-control" required>
        </div>
        <button type="submit" name="ajouter_utilisateur" class="btn btn-primary">Ajouter</button>
    </form>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($utilisateurs as $utilisateur) : ?>
                            <tr>
                                <td><?= $utilisateur['nom']; ?></td>
                                <td><?= $utilisateur['mail']; ?></td>
                                <td><?= $utilisateur['role']; ?></td>
                                <td>
                                <div class="d-flex">
                                    <form method="post" action="admin.php" class="mr-2">
                                        <input type="hidden" name="utilisateur_id" value="<?= $utilisateur['id']; ?>">
                                        <input type="text" name="nouveau_nom" value="<?= $utilisateur['nom']; ?>">
                                        <input type="text" name="nouveau_role" value="<?= $utilisateur['role']; ?>">
                                        <button type="submit" name="modifier_utilisateur" class="btn btn-primary">Modifier</button>
                                    </form>
                                    <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                        <input type="hidden" name="utilisateur_id" value="<?= $utilisateur['id']; ?>">
                                        <button type="submit" name="supprimer_utilisateur" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>
</html>
