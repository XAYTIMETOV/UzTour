<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../../includes/connect.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user['email'];
            $_SESSION['user_firstname'] = $user['firstname'] ?? '';
            $_SESSION['user_lastname'] = $user['lastname'] ?? '';
            header("Location: ../main.php");
            exit();
        } else {
            $error = "Parol noto‘g‘ri!";
        }
    } else {
        $error = "Email topilmadi!";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirish</title>
    <link rel="stylesheet" href="../../assets/css/login.css">
</head>
<body>
<main>
    <section>
        <form action="login.php" method="POST">
            <p>Login</p>
            <?php if (!empty($error)): ?>
                <div style="color: red; margin-bottom: 10px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <input type="email" name="email" placeholder="Elektron pochta" required />
            <input type="password" name="password" placeholder="Parol" required />
            <a href="reset.php" id="help-login-btn">Help login</a>
            <div id="form-btns">
                <input type="submit" value="Kirish">
            </div>
            <p id="register-btn">Akkaunt yo'qmi? <a href="register.php">Ro'yxatdan o'tish</a></p>
        </form>
    </section>
</main>
</body>
</html>
