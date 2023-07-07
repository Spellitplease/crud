<?php
// On démarre une session
session_start();

//Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
// if (!isset($_SESSION['utilisateur_nom']) && !isset($_SESSION['utilisateur_mail']) && $_SESSION['utilisateur_role'] !== 'admin') {
//     header('Location: index.php');
//     exit;
// }
function logged_only(){
    if (session_status() == PHP_SESSION_NONE) {
       
    }
    if (!isset($_SESSION['utilisateur_id']) && !isset($_SESSION['admin'])) {
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: index.php');
        exit();
    }
    if(isset($_SESSION['utilisateur_id']) && !isset($_SESSION['admin'])){
        
        if($_SESSION ['utilisateur_id']->id !=$_GET['id']){
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: index.php');
        exit();
    }
    }
}
    
    // On inclut la connexion à la base
require_once('connect.php');

$sql = 'SELECT * FROM `liste`';

// On prépare la requête
$query = $db->prepare($sql);

// On exécute la requête
$query->execute();

// On stocke le résultat dans un tableau associatif
$result = $query->fetchAll(PDO::FETCH_ASSOC);

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
                    echo '<div class="alert alert-danger" role="alert">
                            ' . $_SESSION['erreur'] . '
                        </div>';
                    $_SESSION['erreur'] = "";
                }
                ?>
                <?php
                if (!empty($_SESSION['message'])) {
                    echo '<div class="alert alert-success" role="alert">
                            ' . $_SESSION['message'] . '
                        </div>';
                    $_SESSION['message'] = "";
                }
                
                ?>
                <h1>Liste des produits</h1>
                <table class="table">
                    <thead>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Nombre</th>
                        <th>Actif</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $produit) : ?>
                            <tr>
                               
                                <td><?= $produit['produit'] ?></td>
                                <td><?= $produit['prix'] ?></td>
                                <td><?= $produit['nombre'] ?></td>
                                <td>
                                
                                        <a href="disable.php?id=<?= $produit['id'] ?>">A/D</a>
                                        <a href="details.php?id=<?= $produit['id'] ?>">Voir</a>
                                        <a href="edit.php?id=<?= $produit['id'] ?>">Modifier</a>
                                        <a href="delete.php?id=<?= $produit['id'] ?>">Supprimer</a>
                                    
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="add.php" class="btn btn-primary">Ajouter un produit</a>
            </section>
        </div>
    </main>
</body>
</html>
