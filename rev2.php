<?php
session_start(); // Ajout de session_start() au début du fichier

$employés = array(
    "employé1" => array("nom" => "Salim", "poste" => "manager", "salaire" => "30000"),
    "employé2" => array("nom" => "Ali", "poste" => "consultant", "salaire" => "40000"),
    "employé3" => array("nom" => "Farid", "poste" => "développeur", "salaire" => "35000"),
    "employé4" => array("nom" => "Amir", "poste" => "docteur", "salaire" => "60000"),
    "employé5" => array("nom" => "Ghali", "poste" => "professeur", "salaire" => "30000"),
);

function moyenne() : float {
    global $employés;  // Utilisation de la variable globale $employés
    $S = 0;
    
    foreach($employés as $key => $value) {
        foreach($value as $k => $v) {
            if($k == 'salaire') {
                $S += (int)$v;  // Ajoute le salaire à la somme
            }
        }
    }

    // Calcul de la moyenne des salaires
    $M = $S / count($employés); 

    // Afficher et retourner la moyenne
    echo "La moyenne des salaires est : " . $M . "<br>";
    return $M;
}

moyenne();

function afficher() {
    global $employés;  
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $nom = $_POST['name'];
        
        if (isset($nom)) {
            foreach ($employés as $key => $value) {
                foreach ($value as $k => $v) {
                    if ($k == 'nom' && $v == $nom) {
                        echo "Bienvenue " . $nom . " !<br>";
                        break;  
                    }
                }
            }
        }
    }
}

afficher();

$utilisateurs = array(
    "user1" => array("email" => "user1@example.com", "password" => "pass123"),
    "user2" => array("email" => "user2@example.com", "password" => "pass456"),
    "user3" => array("email" => "user3@example.com", "password" => "pass789")
);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
   
    $email = $_POST['email'];
    $password = $_POST['pass']; // Correction ici (le champ "pass" est maintenant utilisé)
    $connexionValide = false;

    foreach ($utilisateurs as $key => $utilisateur) {
        if ($utilisateur['email'] == $email && $utilisateur['password'] == $password) {
            $connexionValide = true;
            $utilisateurTrouve = $key;
            break;
        }
    }

    if ($connexionValide) {
        echo "Bienvenue, " . $utilisateurTrouve . "! Vous êtes connecté.";
    } else {
        echo "Erreur : email ou mot de passe incorrect.";
    }
}

// Panier en session
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array(); 
}

function ajouterAuPanier() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nomProduit = $_POST['nom'];
        $quantiteProduit = $_POST['quantite'];
        $prixProduit = $_POST['prix'];

        $_SESSION['panier'][] = array(
            "nomProduit" => $nomProduit,
            "quantiteProduit" => $quantiteProduit,
            "prixProduit" => $prixProduit
        );
    }
    // Supprimer les éléments vides du panier
    $_SESSION['panier'] = array_filter($_SESSION['panier'], function($item) {
        return !empty($item['nomProduit']) && !empty($item['quantiteProduit']) && !empty($item['prixProduit']);
    });

    if (!empty($_SESSION['panier'])) {
        echo "<table border='1'>
                <tr>
                    <th>Nom du produit</th>
                    <th>Quantité</th>
                    <th>Prix Unitaire</th>
                    <th>Total</th>
                </tr>";

        $totalPanier = 0;

        foreach ($_SESSION['panier'] as $val) {
            $totalProduit = $val['quantiteProduit'] * $val['prixProduit'];
            $totalPanier += $totalProduit; 

            echo "<tr>
                    <td>{$val['nomProduit']}</td>
                    <td>{$val['quantiteProduit']}</td>
                    <td>{$val['prixProduit']} €</td>
                    <td>{$totalProduit} €</td>
                  </tr>";
        }
        echo "</table>";

        echo "<h3>Total du panier : {$totalPanier} €</h3>";
    } else {
        echo "<p>Votre panier est vide.</p>";
    }
}

ajouterAuPanier();

// Commentaires
if (!isset($_SESSION['commentaires'])) {
    $_SESSION['commentaires'] = array(); 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['com'])) {
    $commentaire = $_POST['com'];
    $timestamp = date("Y-m-d H:i:s");

         $_SESSION['commentaires'][] = array("comment" => $commentaire, "date" => $timestamp);

      foreach ($_SESSION['commentaires'] as $value) {
          echo $value['comment'] . " - " . $value['date'] . "<br>";
      }
}

$villes_temperature = array(
    "Paris" => 12,  
    "Londres" => 8,
    "New York" => 15,
    "Tokyo" => 22,
    "Berlin" => 10
);
function maximum(){ 
    global $villes_temperature;
    $MAX = reset($villes_temperature);
    $ville = key($villes_temperature);
foreach($villes_temperature as $key => $value) {
    if($MAX < $value)
    { 
     $MAX = $value;
     $ville = $key;
    }
}
echo "la ville avec la plus haute temperature est ". $ville. " avec " . $MAX . "°C";
}
maximum();



// Liste des produits avec leur prix
$produits = array(
    "Produit 1" => 50,
    "Produit 2" => 60,
    "Produit 3" => 30,
    "Produit 4" => 40,
);

$total = 0;  // Initialisation du total

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['produit'])) {
    $produits_selectionnes = $_POST['produit'];  // Récupère les produits sélectionnés
    echo "<h2>Produits sélectionnés :</h2><ul>";

    foreach ($produits_selectionnes as $produit) {
        // Affiche le produit et son prix
        echo "<li>$produit - " . $produits[$produit] . "$</li>";
        $total += $produits[$produit];  // Additionne le prix au total
    }

    echo "</ul>";
    echo "<h3>Total : $total$</h3>";  // Affiche le total
} else {
    // Si le formulaire n'est pas soumis, affiche ce message
    echo "<h2>Veuillez sélectionner des produits.</h2>";
}
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['file'])) {

    if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {

        $filepath = $_FILES['file']['tmp_name'];

        if (($fichier = fopen($filepath, "r")) !== FALSE) {

            $en_tete = fgetcsv($fichier, 1000, ",");

      
            $produits = array();


            while (($data = fgetcsv($fichier, 1000, ",")) !== FALSE) {
                if (count($data) == 3) {

                    $produits[] = array(
                        'nom' => $data[0],
                        'prix' => $data[1],
                        'quantite' => $data[2]
                    );
                }
            }

            fclose($fichier);

            // Afficher les produits dans un tableau HTML
            echo "<h2>Liste des produits</h2>";
            echo "<table border='1'>
                    <tr>
                        <th>Nom du produit</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                    </tr>";

            foreach ($produits as $produit) {
                echo "<tr>
                        <td>{$produit['nom']}</td>
                        <td>{$produit['prix']}</td>
                        <td>{$produit['quantite']}</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Erreur lors de l'ouverture du fichier CSV.</p>";
        }
    } else {
        echo "<p>Erreur lors du téléchargement du fichier.</p>";
    }

}
echo "<br></br>";
$Etudiants = array("Etudiant 1" => array("matiere 1" => "20" ,"matiere 2" => "10", "matiere 3" => "17"),
"Etudiant 2" => array("matiere 1" => "14" ,"matiere 2" => "13", "matiere 3" => "15"),
"Etudiant 3" => array("matiere 1" => "19" ,"matiere 2" => "15", "matiere 3" => "17"));

function moyEt()
{global $Etudiants ;
    foreach($Etudiants as $Et => $note)
    {$S = 0;
        foreach($note as $key => $value)
        {
            $S = $S + $value ;
        }
        echo "la moyenne de " . $Et . " est " . $S/sizeof($Etudiants) . "<br>" ;
    }
}
moyEt();
session_start();
if (!isset($_SESSION['Users'])) {
    $_SESSION['Users'] = array();
}

function gererUser()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['ajouter'])) { 
        $nom = $_POST['name'];
        $age = $_POST['age'];
        $mdp = $_POST['pass'];

        $_SESSION['Users'][] = array("nom" => $nom, "age" => $age, "password" => $mdp);

        foreach ($_SESSION['Users'] as $user) { 
            echo $user['nom'] . " - " . $user['age'] . " - " . $user['password'] . "<br>";
        }
    }
}
function modifier()
{ 
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['modifier'])) {
        $nom_saisi = $_POST['nameM'];
        foreach ($_SESSION['Users'] as &$user) {
            if ($user['nom'] == $nom_saisi) {
                $user['age'] = $_POST['age'];
                $user['password'] = $_POST['pass'];
                break;
            }
        }

        foreach ($_SESSION['Users'] as $user) { 
            echo $user['nom'] . " - " . $user['age'] . " - " . $user['password'] . "<br>";
        }
    }
}

function supprimer()
{
    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['supprimer'])) {
        $nom_saisi = $_POST['nameM'];
        foreach ($_SESSION['Users'] as $key => $user) {
            if ($user['nom'] == $nom_saisi) {
                unset($_SESSION['Users'][$key]);  
                break;
            }
        }

        foreach ($_SESSION['Users'] as $user) { 
            echo $user['nom'] . " - " . $user['age'] . " - " . $user['password'] . "<br>";
        }
    }
}
gererUser();
modifier();
supprimer();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection des produits</title>
</head>
<body>
    <h1>Choisissez vos produits</h1>
    <form method="POST">
        <label><input type="checkbox" name="produit[]" value="Produit 1"> Produit 1 (50$)</label><br>
        <label><input type="checkbox" name="produit[]" value="Produit 2"> Produit 2 (60$)</label><br>
        <label><input type="checkbox" name="produit[]" value="Produit 3"> Produit 3 (30$)</label><br>
        <label><input type="checkbox" name="produit[]" value="Produit 4"> Produit 4 (40$)</label><br><br>
        <button type="submit">Soumettre</button>
    </form>
    <br><br>
    <h1>fichier CSV contenant des informations sur des produits</h1>

    <form action="import_csv.php" method="POST" enctype="multipart/form-data">
        <label for="file">Choisir un fichier CSV :</label>
        <input type="file" name="file" id="file" accept=".csv" required><br><br>
        <button type="submit" name="submit">Importer</button>
    </form>
    <br><br>
        <form method="POST">
        <label>Nom :</label>
        <input type="text" id="nom" name="name" placeholder="Entrez votre nom" required><br><br>
        <label>Age :</label>
        <input type="number" id="age" name="age" placeholder="Entrez votre âge" required><br><br>
        <label>Mot de passe :</label>
        <input type="password" id="pass" name="pass" placeholder="Entrez votre mot de passe" required><br><br>
        <button type="submit" name="ajouter">Ajouter</button><br><br>

        <label>Nom de l'utilisateur à modifier :</label>
        <input type="text" id="nomM" name="nameM" placeholder="Entrez le nom" required><br><br>
        <label>Age :</label>
        <input type="number" id="ageM" name="age" placeholder="Entrez le nouvel âge" required><br><br>
        <label>Mot de passe :</label>
        <input type="password" id="passM" name="pass" placeholder="Entrez le nouveau mot de passe" required><br><br>
        <button type="submit" name="modifier">Modifier</button> <br><br>
        <button type="submit" name="supprimer">Supprimer</button>
    </form>
</body>
</html>

