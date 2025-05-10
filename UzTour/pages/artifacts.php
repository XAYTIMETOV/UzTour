<?php
// Barcha xatoliklarni ko'rsatish uchun
error_reporting(E_ALL);  // Barcha xatoliklarni ko'rsatish
ini_set('display_errors', 1);  // Xatoliklarni brauzerda ko'rsatish

    // Paginaция uchun o‘lchov
    $limit = 8;
    $pagination = isset($_GET['pagination']) ? (int)$_GET['pagination'] : 1;
    if ($pagination < 1) {
        $pagination = 1;
    }

    $offset = ($pagination - 1) * $limit;

    // Barcha artifacts sonini olish
    $total_sql = "SELECT COUNT(*) FROM Artifacts";
    $total_result = $conn->query($total_sql);
    $total_artifacts = $total_result->fetch_array()[0];
    $total_pages = ceil($total_artifacts / $limit);

    // Paginaция bilan artifacts ma'lumotlarini olish
    $sql = "SELECT id, title, main_image FROM Artifacts ORDER BY id DESC LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);
?>


<section id="artifacts-section">
    <article id="artifacts">
        <h1 id="places-title"><?= $lang_texts['artifacts'] ?></h1>
        <div id="artifacts-list" class="scroll-view">
            <?php while ($row = $result->fetch_assoc()): ?>
                <a href="this_artifact.php?id=<?= $row['id'] ?>&pagination=<?= $pagination ?>" class="artifats-list-item" style="background-image: url('../uploads/images/artifacts/<?= $row['main_image'] ?>');">
                    <p><?= htmlspecialchars($row['title']) ?></p>
                </a>
            <?php endwhile; ?>
        </div>
    </article>
</section>

<!-- Pagination -->
<div id="artifacts-pagination">
  <?php if ($total_pages > 1): ?>
    <?php if ($pagination > 1): ?>
      <a href="?page=artifacts&pagination=<?= $pagination - 1 ?>">&laquo;</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
      <a href="?page=artifacts&pagination=<?= $i ?>" class="<?= ($i == $pagination) ? 'active' : '' ?>">
        <?= $i ?>
      </a>
    <?php endfor; ?>

    <?php if ($pagination < $total_pages): ?>
      <a href="?page=artifacts&pagination=<?= $pagination + 1 ?>">&raquo;</a>
    <?php endif; ?>
  <?php endif; ?>
</div>