<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

// Récupération de la liste des cours depuis la base de données
$sql = "SELECT * FROM `course`";
$result = mysqli_query($conn, $sql);

$courses = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $courses[] = $row;
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des cours</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Liste des cours</h1>
        <table>
            <tr>
                <th>Nom du cours</th>
                <th>Code</th>
            </tr>
            <?php foreach ($courses as $course) : ?>
                <tr>
                    <td><?php echo $course['name']; ?></td>
                    <td><?php echo $course['code']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="logout.php">Se déconnecter</a></p>
    </div>
</body>
</html>
