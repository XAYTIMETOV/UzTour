<section id="home-section">
    <article id="home">
        <h1><?= $lang_texts['home_text'] ?></h1>
        <p><?= $lang_texts['home_body'] ?></p>
        <form action="search_results.php" method="GET" id="search">
            <input type="text" name="q" placeholder="<?= $lang_texts['home_search'] ?>" required />
            <button type="submit">
                <img src="../assets/images/icons/search.ico" alt="Search">
            </button>
        </form>
    </article>
</section>