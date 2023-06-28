<?php
session_start();

require_once 'config.php';

// Vérification si l'utilisateur est déjà connecté
if (isset($_SESSION["user_id"])) {
    header("Location: profil.php");
    exit();
}

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Requête pour récupérer les informations utilisateur
    $stmt = $conn->prepare("SELECT * FROM `user` WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row["password"];

        // Vérification du mot de passe
        if (password_verify($password, $stored_password)) {
            // Informations de connexion valides
            $_SESSION["user_id"] = $row["id"];
            header("Location: profil.php");
            exit();
        } else {
            // Mot de passe incorrect
            $error_message = "Mot de passe incorrect.";
        }
    } else {
        // Nom d'utilisateur incorrect
        $error_message = "Nom d'utilisateur incorrect.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (!empty($error_message)) : ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div>
                <label for="username">Nom d'utilisateur :</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div>
                <label for="password">Mot de passe :</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <button type="submit">Se connecter</button>
            </div>
        </form>
    </div>
</body>
</html>
