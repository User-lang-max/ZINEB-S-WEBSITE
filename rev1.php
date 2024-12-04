<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>formulaire</title>
</head>
<body>

    <!-- Menu de sélection -->
    <h1>Choisissez une action :</h1>
    <form method="GET">
        <label for="action">Sélectionner une fonction :</label>
        <select name="action" id="action">
            <option value="etudiant">Afficher les informations de l'étudiant</option>
            <option value="produits">Afficher les produits</option>
            <option value="moyenne">Afficher la moyenne des étudiants</option>
            <option value="tri_pays">Afficher les pays triés</option>
        </select><br><br>
        <button type="submit">Exécuter</button>
    </form>

    <!-- Formulaire pour les informations -->
    <form method="POST">
        <h1 style="font-size: x-large; text-align: center;">Informations</h1>
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="name" placeholder="Entrez votre nom" required><br><br>

        <label for="age">Âge :</label>
        <input type="number" id="age" name="age" placeholder="Entrez votre âge" required><br><br>
        
        <label for="couleur">Choisissez votre couleur préférée :</label>
        <select name="couleur" id="couleur">
            <option value="Rouge" style="color: red;">Rouge</option>
            <option value="Vert" style="color: green;">Vert</option>
            <option value="Bleu" style="color: blue;">Bleu</option>
        </select>
        <br><br>
        <label for="choix">Administrateur ou Utilisateur :</label>
        <select name="choix" id="choix">
            <option value="administrateur">Administrateur</option>
            <option value="Utilisateur">Utilisateur</option>
        </select><br><br>
        <button type="submit">Soumettre</button>
    </form>

    <br><br>

    <h1>Saisir deux nombres</h1>
    <form method="GET">
        <label for="num1">Premier nombre :</label>
        <input type="number" id="num1" name="num1" required><br><br>

        <label for="num2">Deuxième nombre :</label>
        <input type="number" id="num2" name="num2" required><br><br>

        <button type="submit">Soumettre</button>
    </form>

    <br><br>

    <?php
    // Fonction pour afficher les informations de l'étudiant
    function afficherEtudiant() {
        $etudiant = array("nom" => "Alaoui", "prenom" => "zineb", "matricule" => "1000", "note" => "18");
        echo "<h3>Informations sur l'étudiant</h3>";
        foreach ($etudiant as $key => $value) {
            echo "<td> $value <td>";
        }
        echo "<br>";

        // Modification de la note
        foreach ($etudiant as $key => $value) {
            if ($key == "note") {
                $value = "19";
            }
            echo "<td> $value <td>";
        }
        echo "<br><br>";
    }

    // Fonction pour afficher les produits
    function afficherProduits() {
        $produits = array(
            "Produit1" => array("nom" => "tlou2", "prix" => "50$"),
            "Produit2" => array("nom" => "RE8", "prix" => "60$"),
            "Produit3" => array("nom" => "RDR2", "prix" => "30$")
        );

        echo "<h3>Liste des produits</h3>";
        foreach ($produits as $key => $value) {
            echo "<tr> Clé: $key  : </tr>";
            foreach ($value as $k => $v) {
                if ($k == "prix") {
                    echo "Prix: " . $v . "<br>";
                }
            }
            echo "<br>";
        }
        echo "<br>";
    }

    // Fonction pour calculer la moyenne des étudiants
    function afficherMoyenne() {
        $etudiants = array("etudiant1" => "80", "etudiant2" => "90", "etudiant3" => "70", "etudiant4" => "30", "etudiant5" => "20");

        $S = 0;
        foreach ($etudiants as $k => $v) {
            $S = $S + $v;
        }
        $moy = $S / 5;
        echo "La moyenne des étudiants est " . $moy;
        echo "<br><br>";
    }

    // Fonction pour trier et afficher les pays
    function afficherTriPays() {
        $pays = array("Maroc" => "46", "France" => "60", "USA" => "100", "Italy" => "33", "Egypte" => "90");
        $keys = array_keys($pays);
        $values = array_values($pays);

        for ($i = 0; $i < count($pays) - 1; $i++) {
            for ($j = $i + 1; $j < count($pays); $j++) {
                if ($values[$i] < $values[$j]) {
                    $tmp = $values[$i];
                    $values[$i] = $values[$j];
                    $values[$j] = $tmp;

                    $tmp = $keys[$i];
                    $keys[$i] = $keys[$j];
                    $keys[$j] = $tmp;
                }
            }
        }

        echo "<h3>Pays triés</h3>";
        for ($i = 0; $i < count($pays); $i++) {
            echo $keys[$i] . " => " . $values[$i] . "<br>";
        }
    }

    // Gestion des actions selon la sélection
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        if ($action == 'etudiant') {
            afficherEtudiant();
        } elseif ($action == 'produits') {
            afficherProduits();
        } elseif ($action == 'moyenne') {
            afficherMoyenne();
        } elseif ($action == 'tri_pays') {
            afficherTriPays();
        }
    }

    // Traitement des informations du formulaire POST pour l'utilisateur
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['name'], $_POST['age'], $_POST['couleur'], $_POST['choix'])) {
            $name = $_POST['name'];  
            $age = $_POST['age'];
            $color = $_POST['couleur'];
            $type_compte = $_POST['choix'];

            if (!filter_var($age, FILTER_VALIDATE_INT)) {
                echo "L'âge doit être un entier valide.<br>";
            } elseif ($age <= 0) {
                echo "L'âge doit être supérieur à 0.<br>";
            } else {
                echo "Bienvenue " . htmlspecialchars($name) . ", vous avez " . htmlspecialchars($age) . " ans !<br>";
            }
            echo "Votre couleur préférée est le " . htmlspecialchars($color) . ".<br>";

            if ($type_compte == 'administrateur') {
                echo 'Bienvenue, administrateur !';
            } elseif ($type_compte == 'Utilisateur') {
                echo 'Bienvenue, utilisateur simple !';
            } else {
                echo 'Sélectionnez un type de compte valide.<br>';
            }
        } else {
            echo "Veuillez remplir tous les champs requis.<br>";
        }
    }

    // Traitement des informations du formulaire GET pour les deux nombres
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET['num1']) && isset($_GET['num2'])) {
            $num1 = $_GET['num1'];
            $num2 = $_GET['num2'];

            if (is_numeric($num1) && is_numeric($num2)) {
                $S = $num1 + $num2;
                echo "La somme des deux nombres est : " . $S . "<br>";
            } else {
                echo "Veuillez entrer des nombres valides.<br>";
            }
        }
    }
    ?>

</body>
</html>
