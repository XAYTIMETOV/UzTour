<!DOCTYPE html>
<html lang="uz">
<head>
  <meta charset="UTF-8">
  <title>Flex to Grid with Pagination</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    #container {
      display: flex;
      overflow-x: auto;
      gap: 10px;
      transition: all 0.3s ease;
      flex-wrap: nowrap;
    }

    .grid-view {
      display: grid !important;
      grid-template-columns: repeat(4, 1fr);
      gap: 15px;
      overflow: visible;
    }

    .item {
      background: #f0f0f0;
      padding: 20px;
      min-width: 100px;
      text-align: center;
      border-radius: 8px;
      border: 1px solid #ccc;
    }

    #showMore {
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
    }

    #paginationControls {
      margin-top: 20px;
      display: none;
      align-items: center;
      gap: 10px;
    }

    #paginationControls button {
      padding: 5px 10px;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <h2>Elementlar ro‘yxati</h2>

  <div id="container" class="scroll-view">
    <?php
      for ($i = 1; $i <= 20; $i++) {
        echo "<div class='item'>Element $i</div>";
      }
    ?>
  </div>

  <button id="showMore">Show More</button>

  <div id="paginationControls">
    <button id="prev">⟨ Prev</button>
    <span id="pageInfo"></span>
    <button id="next">Next ⟩</button>
  </div>

  <script>
    const container = document.getElementById('container');
    const items = Array.from(container.children);
    const showMoreBtn = document.getElementById('showMore');
    const paginationControls = document.getElementById('paginationControls');
    const prevBtn = document.getElementById('prev');
    const nextBtn = document.getElementById('next');
    const pageInfo = document.getElementById('pageInfo');

    let currentPage = 1;
    const itemsPerPage = 8;

    function showPage(page) {
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;

      items.forEach((item, index) => {
        item.style.display = (index >= start && index < end) ? 'block' : 'none';
      });

      pageInfo.textContent = `Sahifa ${page}`;
      prevBtn.disabled = page === 1;
      nextBtn.disabled = end >= items.length;
    }

    showMoreBtn.addEventListener('click', () => {
      container.classList.remove('scroll-view');
      container.classList.add('grid-view');
      showMoreBtn.style.display = 'none';
      paginationControls.style.display = 'flex';
      showPage(currentPage);
    });

    prevBtn.addEventListener('click', () => {
      if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
      }
    });

    nextBtn.addEventListener('click', () => {
      if ((currentPage * itemsPerPage) < items.length) {
        currentPage++;
        showPage(currentPage);
      }
    });
  </script>

</body>
</html>
