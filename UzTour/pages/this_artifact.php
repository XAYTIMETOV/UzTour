<?php
    include '../includes/connect.php';

    $lang = $_SESSION['lang'] ?? 'uz';
    $lang_texts = include "../lang/$lang.php";

    $artifact_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    // Artifactni olish
    $sql = "SELECT id, place_id, title, description, main_image FROM Artifacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $artifact_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $artifact = $result->fetch_assoc();

    if (!$artifact) {
        die("Artifact not found");
    }

    $place_id = $artifact['place_id'];

    // O'ng panel: shu place_id ga tegishli boshqa artifactlar
    $related_sql = "SELECT id, title, main_image FROM Artifacts WHERE place_id = ? AND id != ? LIMIT 4";
    $related_stmt = $conn->prepare($related_sql);
    $related_stmt->bind_param("ii", $place_id, $artifact_id);
    $related_stmt->execute();
    $related_result = $related_stmt->get_result();

    // Chap panel: tasodifiy 4 ta place
    $places_sql = "SELECT id, title, main_image FROM Places ORDER BY RAND() LIMIT 4";
    $places_result = $conn->query($places_sql);
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UzTour | <?= htmlspecialchars($artifact['title']) ?></title>
    <link rel="stylesheet" href="../assets/css/this-artifact.css">
</head>
<body>
    
<main>
    <div class="container">
        <!-- Chap panel -->
        <aside class="left-panel">
            <h3><?= $lang_texts['places'] ?? 'Joylar' ?></h3>
            <div class="places-list">
                <?php while ($place = $places_result->fetch_assoc()): ?>
                    <a href="this_place.php?id=<?= $place['id'] ?>" class="place-card">
                        <img src="<?= $place['main_image'] ?>" alt="<?= htmlspecialchars($place['title']) ?>">
                        <p><?= htmlspecialchars($place['title']) ?></p>
                    </a>
                <?php endwhile; ?>
            </div>
        </aside>

        <!-- Asosiy artifact -->
        <section class="artifact-section">
            <img src="<?= htmlspecialchars($artifact['main_image']) ?>" alt="<?= htmlspecialchars($artifact['title']) ?>" onclick="openFullScreen(this)">
            <h1><?= htmlspecialchars($artifact['title']) ?></h1>
            <p><?= nl2br(htmlspecialchars($artifact['description'])) ?></p>
        </section>

        <!-- O'ng panel -->
        <aside class="right-panel">
            <h3><?= $lang_texts['artifacts'] ?? 'Artifaktlar' ?></h3>
            <div class="artifact-list">
                <?php while ($item = $related_result->fetch_assoc()): ?>
                    <a href="this_artifact.php?id=<?= $item['id'] ?>" class="artifact-card">
                        <img src="<?= $item['main_image'] ?>" alt="<?= htmlspecialchars($item['title']) ?>">
                    </a>
                <?php endwhile; ?>
            </div>
        </aside>
    </div>

    <?php include '../includes/footer.php'; ?>
</main>
<script src="../assets/js/script.js" defer></script>
</body>
</html>
