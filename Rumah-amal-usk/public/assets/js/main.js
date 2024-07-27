(function () {
    "use strict";

    // Fungsi untuk menambahkan kelas .scrolled ke body saat halaman digulir ke bawah
    function toggleScrolled() {
        const selectBody = document.querySelector("body");
        const selectHeader = document.querySelector("#header");
        if (
            !selectHeader ||
            (!selectHeader.classList.contains("scroll-up-sticky") &&
            !selectHeader.classList.contains("sticky-top") &&
            !selectHeader.classList.contains("fixed-top"))
        ) return;
        window.scrollY > 100
            ? selectBody.classList.add("scrolled")
            : selectBody.classList.remove("scrolled");
    }

    document.addEventListener("scroll", toggleScrolled);
    window.addEventListener("load", toggleScrolled);

    // Toggle navigasi mobile
    const mobileNavToggleBtn = document.querySelector(".mobile-nav-toggle");

    function mobileNavToggle() {
        document.querySelector("body").classList.toggle("mobile-nav-active");
        if (mobileNavToggleBtn) {
            mobileNavToggleBtn.classList.toggle("bi-list");
            mobileNavToggleBtn.classList.toggle("bi-x");
        }
    }

    if (mobileNavToggleBtn) {
        mobileNavToggleBtn.addEventListener("click", mobileNavToggle);
    }

    // Menyembunyikan navigasi mobile pada link halaman yang sama
    document.querySelectorAll("#navmenu a").forEach((navmenu) => {
        navmenu.addEventListener("click", (e) => {
            if (document.querySelector(".mobile-nav-active")) {
                if (navmenu.hash && navmenu.hash !== "#") {
                    mobileNavToggle();
                }
            }
        });
    });

    // Toggle dropdown navigasi mobile
    document.querySelectorAll(".navmenu .toggle-dropdown").forEach((dropdownToggle) => {
        dropdownToggle.addEventListener("click", function (e) {
            e.preventDefault(); // Mencegah perilaku default
            this.parentNode.classList.toggle("active");
            const nextDropdown = this.parentNode.nextElementSibling;
            if (nextDropdown) {
                nextDropdown.classList.toggle("dropdown-active");
            }
            e.stopImmediatePropagation();
        });
    });

    // Menangani klik pada menu dropdown
    document.querySelectorAll(".dropdownmenu").forEach((dropdownLink) => {
        dropdownLink.addEventListener("click", function (e) {
            if (window.innerWidth <= 992) { // Periksa apakah dalam mode mobile
                e.preventDefault(); // Mencegah perilaku default
                this.parentNode.classList.toggle("active");
                const nextDropdown = this.nextElementSibling;
                if (nextDropdown) {
                    nextDropdown.classList.toggle("dropdown-active");
                }
            }
        });
    });

    // Mengarahkan sesuai href pada item dropdown dan menambahkan kelas aktif
    document.querySelectorAll(".dropdownitemm").forEach((dropdownItem) => {
        dropdownItem.addEventListener("click", function (e) {
            // Hapus kelas aktif dari semua item
            document.querySelectorAll(".dropdownitemm").forEach((item) => {
                item.classList.remove("active");
            });

            // Tambahkan kelas aktif pada item yang diklik
            this.classList.add("active");

            // Tutup dropdown pada desktop
            if (window.innerWidth > 992) {
                const parentDropdown = this.closest(".dropdown");
                if (parentDropdown) {
                    parentDropdown.classList.remove("active");
                    const dropdownActive = parentDropdown.querySelector(".dropdown-active");
                    if (dropdownActive) {
                        dropdownActive.classList.remove("dropdown-active");
                    }
                }
            }

            if (document.querySelector(".mobile-nav-active")) {
                mobileNavToggle();
            }
        });
    });

    // Preloader
    const preloader = document.querySelector("#preloader");
    if (preloader) {
        window.addEventListener("load", () => {
            preloader.remove();
        });
    }

    // Tombol login
    document.addEventListener("DOMContentLoaded", function() {
        const loginButton = document.querySelector("#login-button");
        if (loginButton) {
            loginButton.addEventListener("click", function() {
                window.location.href = "/login"; // Arahkan ke halaman login
            });
        }
    });

    // Tombol scroll ke atas
    const scrollTop = document.querySelector(".scroll-top");

    function toggleScrollTop() {
        if (scrollTop) {
            window.scrollY > 100
                ? scrollTop.classList.add("active")
                : scrollTop.classList.remove("active");
        }
    }

    if (scrollTop) {
        scrollTop.addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    window.addEventListener("load", toggleScrollTop);
    document.addEventListener("scroll", toggleScrollTop);

    // Inisialisasi animasi pada scroll
    function aosInit() {
        AOS.init({
            duration: 600,
            easing: "ease-in-out",
            once: true,
            mirror: false,
        });
    }
    window.addEventListener("load", aosInit);

    // Inisialisasi GLightbox
    const glightbox = GLightbox({
        selector: ".glightbox",
    });

    // Inisialisasi swiper sliders
    function initSwiper() {
        document.querySelectorAll(".init-swiper").forEach(function (swiperElement) {
            let config = JSON.parse(swiperElement.querySelector(".swiper-config").innerHTML.trim());

            if (swiperElement.classList.contains("swiper-tab")) {
                initSwiperWithCustomPagination(swiperElement, config);
            } else {
                new Swiper(swiperElement, config);
            }
        });
    }

    window.addEventListener("load", initSwiper);

    // Inisialisasi Pure Counter
    new PureCounter();

    // Inisialisasi isotope layout
    document.querySelectorAll(".isotope-layout").forEach(function (isotopeItem) {
        let layout = isotopeItem.getAttribute("data-layout") ?? "masonry";
        let filter = isotopeItem.getAttribute("data-default-filter") ?? "*";
        let sort = isotopeItem.getAttribute("data-sort") ?? "original-order";

        let iso;
        imagesLoaded(isotopeItem.querySelectorAll(".isotope-item"), function () {
            iso = new Isotope(isotopeItem.querySelector(".isotope-container"), {
                itemSelector: ".isotope-item",
                layoutMode: layout,
                filter: filter,
                sortBy: sort,
            });

            // Filter handler
            const filterSelect = document.getElementById('filter-select');
            if (filterSelect) {
                filterSelect.addEventListener('change', function () {
                    const filterValue = this.value;
                    iso.arrange({ filter: filterValue });
                });
            }
        });

        // Filter handler untuk item filter (jika ada)
        isotopeItem.querySelectorAll(".isotope-filters li").forEach(function (filterItem) {
            filterItem.addEventListener("click", function () {
                isotopeItem.querySelector(".isotope-filters .filter-active").classList.remove("filter-active");
                this.classList.add("filter-active");
                iso.arrange({
                    filter: this.getAttribute("data-filter"),
                });

                if (typeof aosInit === "function") {
                    aosInit();
                }
            }, false);
        });
    });

    // Accordion
    document.querySelectorAll(".faq-item h3, .faq-item .faq-toggle").forEach((faqItem) => {
        faqItem.addEventListener("click", () => {
            faqItem.parentNode.classList.toggle("faq-active");
        });
    });

    // Indikator carousel hero
    const heroCarouselIndicators = document.querySelector("#hero-carousel-indicators");
    const heroCarouselItems = document.querySelectorAll('#heroCarousel .carousel-item');

    if (heroCarouselIndicators) {
        heroCarouselItems.forEach((item, index) => {
            heroCarouselIndicators.innerHTML += `<li data-bs-target='#heroCarousel' data-bs-slide-to='${index}' ${index === 0 ? "class='active'" : ""}></li>`;
        });
    }

    // Highlight pada scroll
    const highlight = document.querySelector(".highlight");

    function toggleHighlight() {
        if (highlight) {
            window.scrollY > 100
                ? highlight.classList.add("active")
                : highlight.classList.remove("active");
        }
    }
    if (highlight) {
        highlight.addEventListener("click", (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: "smooth",
            });
        });
    }

    window.addEventListener("load", toggleHighlight);
    document.addEventListener("scroll", toggleHighlight);

    /**
     * Navmenu Scrollspy
     */
    const navmenuLinks = document.querySelectorAll(".navmenu a");

    function navmenuScrollspy() {
        navmenuLinks.forEach((navmenuLink) => {
            if (!navmenuLink.hash) return;
            const section = document.querySelector(navmenuLink.hash);
            if (!section) return;
            const position = window.scrollY + 200;
            if (
                position >= section.offsetTop &&
                position <= section.offsetTop + section.offsetHeight
            ) {
                document
                    .querySelectorAll(".navmenu a.active")
                    .forEach((link) => link.classList.remove("active"));
                navmenuLink.classList.add("active");
            } else {
                navmenuLink.classList.remove("active");
            }
        });
    }
    window.addEventListener("load", navmenuScrollspy);
    document.addEventListener("scroll", navmenuScrollspy);

})();
