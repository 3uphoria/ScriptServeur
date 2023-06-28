<?php
session_start();

// Vérification si l'utilisateur est connecté
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

require_once 'config.php';

$user_id = $_SESSION["user_id"];
$sql = "SELECT * FROM `user` WHERE `id` = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $username = $row["username"];
        $email = $row["email"];
        $created = $row["created"];
        $lastlogin = $row["lastlogin"];
        $admin = ($row["admin"] == 1) ? "Oui" : "Non";
    }

    $stmt->close();
} else {
    die("Une erreur s'est produite lors de la récupération des informations de profil.");
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Profil</h1>
        <table>
            <tr>
                <th>Identifiant</th>
                <td><?php echo $username; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $email; ?></td>
            </tr>
            <tr>
                <th>Création</th>
                <td><?php echo $created; ?></td>
            </tr>
            <tr>
                <th>Dernière visite</th>
                <td><?php echo $lastlogin; ?></td>
            </tr>
            <tr>
                <th>Admin</th>
                <td><?php echo $admin; ?></td>
            </tr>
        </table>
        <p><a href="logout.php">Se déconnecter</a></p>
    </div>
</body>
</html>
