(function () {
    "use strict";

    // Fungsi untuk menambahkan kelas .scrolled ke body saat halaman digulir ke bawah
    function toggleScrolled() {
        const body = document.querySelector("body");
        const header = document.querySelector("#header");
        if (
            !header ||
            (!header.classList.contains("scroll-up-sticky") &&
            !header.classList.contains("sticky-top") &&
            !header.classList.contains("fixed-top"))
        ) return;

        if (window.scrollY > 100) {
            body.classList.add("scrolled");
        } else {
            body.classList.remove("scrolled");
        }
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
            if (document.querySelector(".mobile-nav-active") && navmenu.hash && navmenu.hash !== "#") {
                mobileNavToggle();
            }
        });
    });

    // Toggle dropdown navigasi mobile
    document.querySelectorAll(".navmenu .toggle-dropdown").forEach((dropdownToggle) => {
        dropdownToggle.addEventListener("click", (e) => {
            e.preventDefault();
            const parent = dropdownToggle.parentNode;
            parent.classList.toggle("active");
            const nextDropdown = parent.nextElementSibling;
            if (nextDropdown) {
                nextDropdown.classList.toggle("dropdown-active");
            }
            e.stopImmediatePropagation();
        });
    });

    // Menangani klik pada menu dropdown
    document.querySelectorAll(".dropdownmenu").forEach((dropdownLink) => {
        dropdownLink.addEventListener("click", (e) => {
            if (window.innerWidth <= 992) {
                e.preventDefault();
                const parent = dropdownLink.parentNode;
                parent.classList.toggle("active");
                const nextDropdown = dropdownLink.nextElementSibling;
                if (nextDropdown) {
                    nextDropdown.classList.toggle("dropdown-active");
                }
            }
        });
    });

    // Mengarahkan sesuai href pada item dropdown dan menambahkan kelas aktif
    document.querySelectorAll(".dropdownitemm").forEach((dropdownItem) => {
        dropdownItem.addEventListener("click", (e) => {
            // Hapus kelas aktif dari semua item
            document.querySelectorAll(".dropdownitemm").forEach((item) => {
                item.classList.remove("active");
            });

            // Tambahkan kelas aktif pada item yang diklik
            dropdownItem.classList.add("active");

            // Tutup dropdown pada desktop
            if (window.innerWidth > 992) {
                const parentDropdown = dropdownItem.closest(".dropdown");
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
    document.addEventListener("DOMContentLoaded", () => {
        const loginButton = document.querySelector("#login-button");
        if (loginButton) {
            loginButton.addEventListener("click", () => {
                window.location.href = "/login"; // Arahkan ke halaman login
            });
        }
    });

    // Tombol scroll ke atas
    const scrollTop = document.querySelector(".scroll-top");

    function toggleScrollTop() {
        if (scrollTop) {
            if (window.scrollY > 100) {
                scrollTop.classList.add("active");
            } else {
                scrollTop.classList.remove("active");
            }
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
    GLightbox({
        selector: ".glightbox",
    });

    // Inisialisasi swiper sliders
    function initSwiper() {
        document.querySelectorAll(".init-swiper").forEach((swiperElement) => {
            let config = JSON.parse(swiperElement.querySelector(".swiper-config").textContent.trim());

            // Pastikan pagination hanya muncul satu kali per slide
            config.pagination = {
                el: '.swiper-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '"></span>';
                },
            };

            const swiper = new Swiper(swiperElement, config);

            // Menangani sinkronisasi antara slide dan pagination
            swiper.on('slideChange', function () {
                const bullets = document.querySelectorAll('.swiper-pagination .swiper-pagination-bullet');
                const activeIndex = swiper.activeIndex;
                bullets.forEach((bullet, index) => {
                    if (index === activeIndex) {
                        bullet.classList.add('swiper-pagination-bullet-active');
                    } else {
                        bullet.classList.remove('swiper-pagination-bullet-active');
                    }
                });
            });
        });
    }

    window.addEventListener("load", initSwiper);

    // Inisialisasi Pure Counter
    new PureCounter();

    // Inisialisasi isotope layout
    document.querySelectorAll(".isotope-layout").forEach((isotopeItem) => {
        let layout = isotopeItem.getAttribute("data-layout") || "masonry";
        let filter = isotopeItem.getAttribute("data-default-filter") || "*";
        let sort = isotopeItem.getAttribute("data-sort") || "original-order";

        let iso;
        imagesLoaded(isotopeItem.querySelectorAll(".isotope-item"), () => {
            iso = new Isotope(isotopeItem.querySelector(".isotope-container"), {
                itemSelector: ".isotope-item",
                layoutMode: layout,
                filter: filter,
                sortBy: sort,
            });

            // Filter handler
            const filterSelect = document.getElementById('filter-select');
            if (filterSelect) {
                filterSelect.addEventListener('change', () => {
                    const filterValue = filterSelect.value;
                    iso.arrange({ filter: filterValue });
                });
            }
        });

        // Filter handler untuk item filter (jika ada)
        isotopeItem.querySelectorAll(".isotope-filters li").forEach((filterItem) => {
            filterItem.addEventListener("click", () => {
                isotopeItem.querySelector(".isotope-filters .filter-active").classList.remove("filter-active");
                filterItem.classList.add("filter-active");
                iso.arrange({
                    filter: filterItem.getAttribute("data-filter"),
                });

                if (typeof aosInit === "function") {
                    aosInit();
                }
            });
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
            if (window.scrollY > 100) {
                highlight.classList.add("active");
            } else {
                highlight.classList.remove("active");
            }
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
