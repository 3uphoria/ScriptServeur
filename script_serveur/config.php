<?php
$servername = "localhost";
$username = "root";
$password = "votre_mot_de_passe_mysql";
$dbname = "script_serveur";
$socket = "/Applications/MAMP/tmp/mysql/mysql.sock";

// Création de la connexion
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Vérification de la connexion
if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}
?>

