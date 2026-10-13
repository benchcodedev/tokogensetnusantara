/**
 * Efek Background: Falling Flower Petals (Kelopak Bunga Gugur)
 * Ringan, dioptimalkan untuk HP mid-range (maks 20 partikel, auto-pause saat background/reduced-motion)
 */
(function () {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        return;
    }

    const canvas = document.getElementById('bg-effect-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d', { alpha: true });
    let width = (canvas.width = window.innerWidth);
    let height = (canvas.height = window.innerHeight);

    let animationFrameId = null;
    let isVisible = true;

    window.addEventListener('resize', function () {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }, { passive: true });

    document.addEventListener('visibilitychange', function () {
        if (document.hidden) {
            isVisible = false;
            if (animationFrameId) cancelAnimationFrame(animationFrameId);
        } else {
            isVisible = true;
            loop();
        }
    });

    const PETAL_COUNT = 18;
    const petals = [];

    // Warna kelopak bunga mawar / sakura lembut
    const petalColors = [
        'rgba(244, 187, 199, 0.75)',
        'rgba(251, 206, 218, 0.7)',
        'rgba(235, 160, 178, 0.65)',
        'rgba(255, 228, 235, 0.8)',
    ];

    class Petal {
        constructor() {
            this.reset(true);
        }

        reset(initial = false) {
            this.x = Math.random() * width;
            this.y = initial ? Math.random() * height : -20;
            this.size = 10 + Math.random() * 12;
            this.speedY = 0.8 + Math.random() * 1.4;
            this.speedX = -0.5 + Math.random() * 1.0;
            this.angle = Math.random() * Math.PI * 2;
            this.angleSpeed = 0.01 + Math.random() * 0.02;
            this.swaySpeed = 0.02 + Math.random() * 0.03;
            this.swayAngle = Math.random() * Math.PI * 2;
            this.color = petalColors[Math.floor(Math.random() * petalColors.length)];
            this.opacity = 0.6 + Math.random() * 0.35;
        }

        update() {
            this.y += this.speedY;
            this.swayAngle += this.swaySpeed;
            this.x += this.speedX + Math.sin(this.swayAngle) * 0.8;
            this.angle += this.angleSpeed;

            if (this.y > height + 20 || this.x < -30 || this.x > width + 30) {
                this.reset();
            }
        }

        draw() {
            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate(this.angle);
            ctx.globalAlpha = this.opacity;
            ctx.fillStyle = this.color;

            // Gambar bentuk kelopak bunga dengan kurva bezier
            ctx.beginPath();
            ctx.moveTo(0, 0);
            ctx.bezierCurveTo(this.size / 2, -this.size / 2, this.size, 0, 0, this.size);
            ctx.bezierCurveTo(-this.size, 0, -this.size / 2, -this.size / 2, 0, 0);
            ctx.fill();

            ctx.restore();
        }
    }

    for (let i = 0; i < PETAL_COUNT; i++) {
        petals.push(new Petal());
    }

    function loop() {
        if (!isVisible) return;

        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < petals.length; i++) {
            petals[i].update();
            petals[i].draw();
        }

        animationFrameId = requestAnimationFrame(loop);
    }

    loop();
})();
