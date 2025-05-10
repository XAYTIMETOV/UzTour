    <?php
    // Barcha xatoliklarni ko'rsatish uchun
    error_reporting(E_ALL);  // Barcha xatoliklarni ko'rsatish
    ini_set('display_errors', 1);  // Xatoliklarni brauzerda ko'rsatish

    $limit = 8; // Number of places per page
        $pagination = isset($_GET['pagination']) ? (int)$_GET['pagination'] : 1;
        if ($pagination < 1) {
            $pagination = 1;
        }

        $offset = ($pagination - 1) * $limit;
        
        // Get total places count
        $total_sql = "SELECT COUNT(*) FROM Places";
        $total_result = $conn->query($total_sql);
        $total_places = $total_result->fetch_array()[0];
        $total_pages = ceil($total_places / $limit);

        // Fetch places with pagination
        $sql = "SELECT id, title, main_image FROM Places ORDER BY id DESC LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);
    ?>

    <section id="places-section">
        <article id="places">
            <h1 id="places-title"><?= $lang_texts['places'] ?></h1>
            <div id="places-list">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <a href="this_place.php?id=<?= $row['id'] ?>&pagination=<?= $pagination ?>" class="places-list-item" style="background-image: url('<?= $row['main_image'] ?>');">
                        <h3><?= $row['title'] ?></h3>
                    </a>
                <?php endwhile; ?>
            </div>
        </article>
    </section>

    <!-- Pagination -->
    <div id="places-pagination">
        <?php if ($total_pages > 1): ?>
            <?php if ($pagination > 1): ?>
                <!-- Previous Page Link -->
                <a href="?page=places&pagination=<?= $pagination - 1 ?>">&laquo;</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <!-- Active page link -->
                <a href="?page=places&pagination=<?= $i ?>" class="<?= ($i == $pagination) ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($pagination < $total_pages): ?>
                <!-- Next Page Link -->
                <a href="?page=places&pagination=<?= $pagination + 1 ?>">&raquo;</a>
            <?php endif; ?>
        <?php endif; ?>
    </div>