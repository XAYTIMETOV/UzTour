document.addEventListener("DOMContentLoaded", function () {
    const menuItems = document.querySelectorAll("#menu li a");
    const sections = document.querySelectorAll("section");

    // Add a function to match the section id with the menu item href
    function isMenuItemForSection(menuItem, sectionId) {
        return menuItem.getAttribute('href').includes(sectionId);
    }

    // Function to set the active menu item with color
    function setActiveMenuItem(activeItem) {
        menuItems.forEach(item => {
            item.classList.remove("active");
            item.style.color = "black";
            item.style.borderBottom = "solid 4px white";
        });

        activeItem.classList.add("active");
        activeItem.style.color = "orange"; // Active color
        activeItem.style.borderBottom = "solid 4px orange"; // Active bottom border color
    }

    // Function to update active menu based on scroll
    function updateActiveMenu() {
        let scrollPosition = window.scrollY + 100; // Adjust for better accuracy

        let activeFound = false;
        sections.forEach(section => {
            const article = section.querySelector("article");
            if (!article) return;

            const sectionId = article.getAttribute("id");

            const sectionTop = article.offsetTop;
            const sectionHeight = article.offsetHeight;

            if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                // Find the corresponding menu link
                const activeLink = Array.from(menuItems).find(item => isMenuItemForSection(item, sectionId));

                // If the section is About or Contact, remove active state
                if (sectionId === "about" || sectionId === "contact") {
                    menuItems.forEach(item => {
                        item.classList.remove("active");
                        item.style.color = "black";
                        item.style.borderBottom = "solid 4px white";
                    });
                }

                // Only set active if there's a corresponding menu item and section isn't About/Contact
                if (activeLink && sectionId !== "about" && sectionId !== "contact") {
                    setActiveMenuItem(activeLink);
                    activeFound = true;
                }
            }
        });

        // If no section is found active, default to home
        if (!activeFound) {
            const homeLink = document.querySelector(`#menu li a[href="#home"]`);
            if (homeLink) {
                setActiveMenuItem(homeLink);
            }
        }
    }

    // Run the function on scroll
    window.addEventListener("scroll", updateActiveMenu);

    // Run the function immediately on page load
    updateActiveMenu();

    // Add hover effect with a single color (orange)
    menuItems.forEach(item => {
        item.addEventListener("mouseover", function () {
            // Apply a single hover color for all menu items
            item.style.color = "orange";
            item.style.borderBottom = "solid 4px orange";
        });

        item.addEventListener("mouseout", function () {
            // Revert to default color unless it's active
            if (!item.classList.contains("active")) {
                item.style.color = "black";
                item.style.borderBottom = "solid 4px white";
            }
        });
    });
});

// 

function changeLanguage(lang) {
    const form = document.createElement('form');
    form.action = '../lang/set_lang.php'; // Your language setting handler
    form.method = 'POST';

    const langInput = document.createElement('input');
    langInput.type = 'hidden';
    langInput.name = 'lang';
    langInput.value = lang;

    form.appendChild(langInput);
    document.body.appendChild(form);
    form.submit();
}

// for show more buttons

window.onload = function () {
    // Places sahifasiga tegishli kod
    if (window.location.search.indexOf('page=places') !== -1) {
        // Paginationni ko'rsatish darhol
        document.getElementById('places-pagination').style.display = 'flex'; // flex bilan ko'rsatilmoqda
    }

    // Show More tugmasi bosilganda (Places)
    const placesShowMoreBtn = document.getElementById('places-show-more-btn');
    if (placesShowMoreBtn) {
        placesShowMoreBtn.addEventListener('click', function() {
            // Paginationni ko'rsatish darhol
            document.getElementById('places-pagination').style.display = 'flex';
            // URLni yangilash va sahifani qayta yuklash
            window.location.href = '?page=places';  // Sahifa URLni yangilash
        });
    }

    // Artifacts sahifasiga tegishli kod
    const paginationEl = document.getElementById('artifacts-pagination');
    const artifactsList = document.getElementById('artifacts-list');
    const showMoreBtn = document.getElementById('artifacts-show-more-btn');

    // URLda artifacts sahifasi bo'lsa - paginationni ko'rsatamiz
    if (window.location.search.indexOf('page=artifacts') !== -1) {
        paginationEl.style.display = 'flex';  // Paginationni ko'rsatish

        // Artifacts listini grid formatida ko'rsatish
        artifactsList.classList.add('grid-view');
        artifactsList.style.display = 'grid';
        artifactsList.style.gridTemplateColumns = 'repeat(4, 1fr)';
        artifactsList.style.gap = '40px';
    }

    // Show More tugmasi bosilganda (Artifacts)
    if (showMoreBtn) {
        showMoreBtn.addEventListener('click', function () {
            window.location.href = '?page=artifacts';  // URLni yangilash
        });
    }
};

// for map
document.addEventListener("DOMContentLoaded", function () {
    const markers = document.querySelectorAll(".marker");
    const areaInfo = document.getElementById("area-info");
    const areaImage = areaInfo.querySelector("img");
    const areaTitle = areaInfo.querySelector("h1");
    const areaText = areaInfo.querySelector("p");

    const placesData = {
        "Tashkent": {
            img: "../assets/images/tashkent.jpg",
            title: "Tashkent",
            text: "Tashkent is the capital of Uzbekistan, known for its modern architecture and rich history."
        },
        "Samarkand": {
            img: "../assets/images/samarkand.jpg",
            title: "Samarkand",
            text: "Samarkand is one of the oldest inhabited cities in Central Asia, famous for its Registan Square."
        },
        "Bukhara": {
            img: "../assets/images/bukhara.jpg",
            title: "Bukhara",
            text: "Bukhara is a historic city with well-preserved Islamic architecture and ancient sites."
        },
        "Khorezm": {
            img: "../assets/images/khorezm.jpg",
            title: "Khorezm",
            text: "Khorezm is known for its ancient fortresses and the city of Khiva, a UNESCO World Heritage site."
        },
        "Surkhandarya": {
            img: "../assets/images/surkhandarya.jpg",
            title: "Surkhandarya",
            text: "Surkhandarya is a southern region with beautiful mountains and rich cultural heritage."
        },
        "Kashkadarya": {
            img: "../assets/images/kashkadarya.jpg",
            title: "Kashkadarya",
            text: "Kashkadarya is known for its historical sites and beautiful landscapes."
        },
        "Navoi": {
            img: "../assets/images/navoi.jpg",
            title: "Navoi",
            text: "Navoi is an industrial and cultural hub of Uzbekistan."
        },
        "Jizzakh": {
            img: "../assets/images/jizzakh.jpg",
            title: "Jizzakh",
            text: "Jizzakh is famous for its natural beauty and historical importance."
        },
        "Sirdarya": {
            img: "../assets/images/sirdarya.jpg",
            title: "Sirdarya",
            text: "Sirdarya region is located in the central part of Uzbekistan."
        },
        "Fergana": {
            img: "../assets/images/fergana.jpg",
            title: "Fergana",
            text: "Fergana Valley is known for its fertile lands and rich culture."
        },
        "Andijan": {
            img: "../assets/images/andijan.jpg",
            title: "Andijan",
            text: "Andijan is one of the most ancient cities of Uzbekistan."
        },
        "Namangan": {
            img: "../assets/images/namangan.jpg",
            title: "Namangan",
            text: "Namangan is famous for its gardens and historical sites."
        },
        "Karakalpakstan": {
            img: "../assets/images/karakalpakstan.jpg",
            title: "Karakalpakstan",
            text: "Karakalpakstan is an autonomous republic within Uzbekistan, known for its unique culture."
        }
    };

    markers.forEach(marker => {
        marker.addEventListener("click", function () {
            const placeName = marker.getAttribute("title");
            if (placesData[placeName]) {
                areaImage.style = "width: 100%; max-width: 700px; height: 400px;";
                areaImage.src = placesData[placeName].img;
                areaTitle.textContent = placesData[placeName].title;
                areaText.textContent = placesData[placeName].text;
            }
        });
    });
}); 