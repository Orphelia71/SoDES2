document.addEventListener("DOMContentLoaded", () => {
    const counters = document.querySelectorAll('.impact-number');

    const formatNumber = (num, hasPad) => {
        if (hasPad && num < 10) return '0' + num;
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    };

    const startCounting = (counter) => {
        const target = +counter.getAttribute('data-target');
        const suffix = counter.getAttribute('data-suffix') || '';
        const hasPad = counter.getAttribute('data-pad') === 'true';

        let currentCount = 0;
        counter.innerText = formatNumber(currentCount, hasPad) + suffix;

        const duration = 1500;
        const frameRate = 1000 / 60;
        const totalFrames = Math.round(duration / frameRate);
        const increment = target / totalFrames;

        let frame = 0;

        const updateScore = () => {
            frame++;
            currentCount = Math.ceil(increment * frame);

            if (currentCount < target) {
                counter.innerText = formatNumber(currentCount, hasPad) + suffix;
                requestAnimationFrame(updateScore);
            } else {
                counter.innerText = formatNumber(target, hasPad) + suffix;
            }
        };

        requestAnimationFrame(updateScore);
    };

    if (typeof IntersectionObserver !== 'undefined' && counters.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    startCounting(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        counters.forEach(counter => observer.observe(counter));
    } else {
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const suffix = counter.getAttribute('data-suffix') || '';
            const hasPad = counter.getAttribute('data-pad') === 'true';
            counter.innerText = formatNumber(target, hasPad) + suffix;
        });
    }

    const openBtn = document.getElementById('burger-open-btn');
    const closeBtn = document.getElementById('burger-close-btn');
    const menuDrawer = document.getElementById('mobile-drawer-menu');

    if (openBtn && closeBtn && menuDrawer) {
        const closeMenu = () => menuDrawer.classList.remove('is-open');
        const openMenu = () => menuDrawer.classList.add('is-open');

        openBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            openMenu();
        });

        closeBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            closeMenu();
        });

        document.addEventListener('click', (e) => {
            if (!menuDrawer.contains(e.target) && !openBtn.contains(e.target)) {
                closeMenu();
            }
        });

        menuDrawer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', closeMenu);
        });
    }
});