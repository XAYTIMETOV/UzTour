<?php
    // Database connection
    include '../includes/connect.php';

    // Tilni aniqlash
    $lang = $_SESSION['lang'] ?? 'uz';
    $lang_texts = include "../lang/$lang.php"; 

    // place_id ni URL orqali olish
    $place_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // So'rov: place haqida ma'lumot olish
    $sql = "SELECT main_image, title, description FROM Places WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $place_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $place = $result->fetch_assoc();

    // Agar o'sha joy topilmasa
    if (!$place) {
        die("Place not found");
    }
    // Artifactsdan place_id bo'yicha 5 ta tavsiya qilingan element olish
    $artifact_sql = "SELECT id, main_image, title FROM Artifacts WHERE place_id = ? LIMIT 4";
    $artifact_stmt = $conn->prepare($artifact_sql);
    $artifact_stmt->bind_param("i", $place_id);
    $artifact_stmt->execute();
    $artifacts_result = $artifact_stmt->get_result();


?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/this-place.css">
    <title>UzTour | <?= htmlspecialchars($place['title']) ?></title>
    <link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
</head>
<body>
<main>

    <section id="this-place">
        <article>
            <!-- Image -->
            <img src="<?= htmlspecialchars($place['main_image']) ?>" alt="<?= htmlspecialchars($place['title']) ?>" onclick="openFullScreen(this)">
            <h1><?= htmlspecialchars($place['title']) ?></h1>
            <p><?= nl2br(htmlspecialchars($place['description'])) ?></p>
        </article>


        <div id="recommended-artifacts">
            <h3>Artifaktlar</h3> <!-- Sarlavha -->
            <?php while ($artifact = $artifacts_result->fetch_assoc()): ?> <!-- Har bir artifact uchun -->
                <a href="this_artifact.php?id=<?= $artifact['id'] ?>" class="artifact-item">
                    <img src="<?= $artifact['main_image'] ?>" alt="<?= htmlspecialchars($artifact['title']) ?>">
                </a>
            <?php endwhile; ?>
        </div>

        <div id="imageModal" onclick="closeModal()">
            <span id="closeModal">&times;</span>
            <img id="modalImage" src="" alt="">
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
</main>
<script src="../assets/js/script.js" defer></script>
</body>
</html>
