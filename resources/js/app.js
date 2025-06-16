import './bootstrap';
// Import GSAP dan ScrollTrigger
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

document.addEventListener('DOMContentLoaded', () => {

    // ===================================
    // 1. LOGIKA UNTUK HEADER & DROPDOWNS
    // ===================================
    const header = document.getElementById('main-header');
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');
    const megaMenuTrigger = document.getElementById('mega-menu-trigger');
    const mobileLangSwitcher = document.getElementById('mobile-lang-switcher');

    // Efek scroll pada header
    if (header) {
        const handleHeaderScroll = () => {
            const isHomePage = window.location.pathname === '/';
            if (window.scrollY > 50 || !isHomePage) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        };
        window.addEventListener('scroll', handleHeaderScroll);
        handleHeaderScroll(); // Jalankan sekali saat halaman dimuat
    }
    
    // Buka/Tutup Menu Mobile (Off-canvas)
    if (mobileMenuToggle && mobileMenuOverlay) {
        mobileMenuToggle.addEventListener('click', () => {
            const isOpen = mobileMenuToggle.classList.toggle('is-open');
            mobileMenuOverlay.classList.toggle('is-open', isOpen);
            document.body.style.overflow = isOpen ? 'hidden' : '';
        });
    }

    // ↓↓↓ LOGIKA DROPDOWN DIPERBARUI TOTAL ↓↓↓
    const dropdowns = [
        { trigger: megaMenuTrigger, container: document.querySelector('.nav-item.has-megamenu') },
        { trigger: mobileLangSwitcher?.querySelector('.lang-selected'), container: mobileLangSwitcher }
    ];

    dropdowns.forEach(dropdown => {
        if (dropdown.trigger && dropdown.container) {
            dropdown.trigger.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                // Tutup semua dropdown LAIN terlebih dahulu
                dropdowns.forEach(otherDropdown => {
                    if (otherDropdown.container !== dropdown.container) {
                        otherDropdown.container?.classList.remove('is-open');
                    }
                });

                // Buka atau tutup dropdown yang diklik (toggle)
                dropdown.container.classList.toggle('is-open');
            });
        }
    });

    // Event listener untuk menutup semua dropdown saat mengklik di luar
    document.addEventListener('click', (e) => {
        dropdowns.forEach(dropdown => {
            if (dropdown.container && !dropdown.container.contains(e.target)) {
                dropdown.container.classList.remove('is-open');
            }
        });
    });

    // Logic untuk Akordeon di Menu Mobile
    const accordionToggles = document.querySelectorAll('.mobile-accordion-toggle');
    accordionToggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            toggle.parentElement.classList.toggle('is-open');
        });
    });
    // ↑↑↑ AKHIR LOGIKA DROPDOWN DIPERBARUI ↑↑↑


// ==========================================
    // LOGIKA ANIMASI GSAP BARU ("STUNNING")
    // ==========================================

    // 1. Hero Section Animation
    if (document.querySelector('.hero-v2')) {
        // gsap.to('.hero-v2-bg-image', {
        //     scale: 1, duration: 2, ease: 'power2.out'
        // });

        const heroTl = gsap.timeline({defaults: { duration: 1.2, ease: 'power3.out' }});
        heroTl
            .to('.hero-main-title .line span', { y: 0, stagger: 0.15, delay: 0.5 })
            .to('.hero-sub-title', { opacity: 1, y: 0, duration: 1 }, "-=0.8")
            .to('.hero-flight-finder', { opacity: 1, y: 0, duration: 1 }, "-=0.9");
    }

    // 2. Live Flights Ticker Animation
    gsap.from('.flight-ticker', {
        scrollTrigger: { trigger: '.live-flights-section', start: 'top 80%', toggleActions: 'play none none none' },
        opacity: 0, y: 50, duration: 1, stagger: 0.2, ease: 'power2.out'
    });

    // 3. Journey Guide Animation
    ScrollTrigger.batch(".journey-step", {
        start: "top 80%",
        onEnter: batch => gsap.fromTo(batch, { y: 60, opacity: 0 }, { y: 0, opacity: 1, duration: 1, stagger: 0.15, ease: 'power3.out' })
    });

    // 4. News Section Animation
    ScrollTrigger.batch(".news-card-v2", {
        start: "top 85%",
        onEnter: batch => gsap.fromTo(batch, { y: 50, opacity: 0 }, { y: 0, opacity: 1, duration: 0.8, stagger: 0.1, ease: 'power2.out' })
    });
    
    // 5. Transport Hub Animation
    gsap.from('.transport-option', {
        scrollTrigger: { trigger: '.transport-hub-section', start: 'top 80%' },
        opacity: 0, scale: 0.8, y: 40, duration: 0.6, stagger: 0.1
    });
    
    // ===================================
    // 3. LOGIKA AJAX UNTUK HALAMAN JADWAL
    // ===================================
    const scheduleContainer = document.getElementById('schedule-container');
    if (scheduleContainer) {
        const tabLoader = document.getElementById('tab-loader');
        const searchInput = document.getElementById('search');
        const statusSelect = document.getElementById('status');
        const tabs = document.querySelectorAll('.schedule-tabs .tab-button');
        const resetButton = document.getElementById('reset-search-btn');
        let currentDirection = document.querySelector('.schedule-tabs .tab-button.active')?.dataset.direction || 'departure';
        let debounceTimer;

        const fetchFlights = async (page = 1) => {
            if (tabLoader) tabLoader.classList.add('active');
            if (scheduleContainer) scheduleContainer.style.opacity = '0.5';

            const search = searchInput.value;
            const status = statusSelect.value;
            const params = new URLSearchParams({ direction: currentDirection, search, status, page });
            const url = `/flights?${params.toString()}`;

            try {
                const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                const html = await response.text();
                scheduleContainer.innerHTML = html;
                history.pushState({ path: url }, '', url);
            } catch (error) {
                console.error('Error fetching flights:', error);
                scheduleContainer.innerHTML = '<p class="no-data">Gagal memuat data. Silakan coba lagi.</p>';
            } finally {
                if (tabLoader) tabLoader.classList.remove('active');
                if (scheduleContainer) scheduleContainer.style.opacity = '1';
            }
        };

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                if (e.currentTarget.classList.contains('active')) return;
                tabs.forEach(t => t.classList.remove('active'));
                e.currentTarget.classList.add('active');
                currentDirection = e.currentTarget.dataset.direction;
                fetchFlights(1);
            });
        });

        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => fetchFlights(1), 500);
        });

        statusSelect.addEventListener('change', () => fetchFlights(1));
        
        if (resetButton) {
            resetButton.addEventListener('click', () => {
                searchInput.value = '';
                fetchFlights(1);
            });
        }

        scheduleContainer.addEventListener('click', (e) => {
            const pageLink = e.target.closest('.pagination a.page-link');
            if (pageLink && !pageLink.parentElement.classList.contains('disabled')) {
                e.preventDefault();
                const url = new URL(pageLink.href);
                const page = url.searchParams.get('page');
                fetchFlights(page);
            }
        });
    }
});
