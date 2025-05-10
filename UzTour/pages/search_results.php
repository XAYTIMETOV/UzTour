<?php
// search_result.php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Connect to your database
include '../includes/connect.php'; // adjust as needed

// Get the search query
$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

// Initialize empty arrays
$places = [];
$artifacts = [];

if ($search_query !== '') {
    // Search in Places
    $stmt_places = $conn->prepare("SELECT * FROM Places WHERE title LIKE ? OR description LIKE ?");
    $likeQuery = '%' . $search_query . '%';
    $stmt_places->bind_param("ss", $likeQuery, $likeQuery);
    $stmt_places->execute();
    $places = $stmt_places->get_result()->fetch_all(MYSQLI_ASSOC);

    // Search in Artifacts
    $stmt_artifacts = $conn->prepare("SELECT * FROM Artifacts WHERE title LIKE ? OR description LIKE ?");
    $stmt_artifacts->bind_param("ss", $likeQuery, $likeQuery);
    $stmt_artifacts->execute();
    $artifacts = $stmt_artifacts->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="../assets/css/search_results.css"> <!-- your CSS -->
</head>
<body>
    <h1>Search Results for "<?= htmlspecialchars($search_query) ?>"</h1>

    <section>
        <h2>Places</h2>
        <?php if (!empty($places)): ?>
            <ul>
                <?php foreach ($places as $place): ?>
                    <li>
                        <h3><?= htmlspecialchars($place['title']) ?></h3>
                        <p><?= htmlspecialchars($place['description']) ?></p>
                        <a href="this_place.php?id=<?= $place['id'] ?>">View Details</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No places found.</p>
        <?php endif; ?>
    </section>

    <section>
        <h2>Artifacts</h2>
        <?php if (!empty($artifacts)): ?>
            <ul>
                <?php foreach ($artifacts as $artifact): ?>
                    <li>
                        <h3><?= htmlspecialchars($artifact['title']) ?></h3>
                        <p><?= htmlspecialchars($artifact['description']) ?></p>
                        <a href="this_artifact.php?id=<?= $artifact['id'] ?>">View Details</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No artifacts found.</p>
        <?php endif; ?>
    </section>

</body>
</html>
