/**
 * Efek Background: Shimmering Gold Particles (Partikel Emas Berkilau)
 * Ringan, hemat baterai, auto-pause saat background
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

    const PARTICLE_COUNT = 24;
    const particles = [];

    class GoldParticle {
        constructor() {
            this.reset(true);
        }

        reset(initial = false) {
            this.x = Math.random() * width;
            this.y = initial ? Math.random() * height : height + 10;
            this.radius = 1.2 + Math.random() * 2.2;
            this.speedY = -0.4 - Math.random() * 0.8;
            this.speedX = (Math.random() - 0.5) * 0.4;
            this.alpha = 0.2 + Math.random() * 0.6;
            this.alphaSpeed = 0.015 + Math.random() * 0.02;
            this.alphaDir = 1;
        }

        update() {
            this.y += this.speedY;
            this.x += this.speedX;

            this.alpha += this.alphaSpeed * this.alphaDir;
            if (this.alpha >= 0.85) {
                this.alphaDir = -1;
            } else if (this.alpha <= 0.15) {
                this.alphaDir = 1;
            }

            if (this.y < -10 || this.x < -10 || this.x > width + 10) {
                this.reset();
            }
        }

        draw() {
            ctx.save();
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);

            const gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.radius * 2);
            gradient.addColorStop(0, `rgba(255, 235, 150, ${this.alpha})`);
            gradient.addColorStop(0.5, `rgba(212, 175, 55, ${this.alpha * 0.7})`);
            gradient.addColorStop(1, 'rgba(212, 175, 55, 0)');

            ctx.fillStyle = gradient;
            ctx.shadowColor = 'rgba(255, 215, 0, 0.4)';
            ctx.shadowBlur = 6;
            ctx.fill();
            ctx.restore();
        }
    }

    for (let i = 0; i < PARTICLE_COUNT; i++) {
        particles.push(new GoldParticle());
    }

    function loop() {
        if (!isVisible) return;

        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < particles.length; i++) {
            particles[i].update();
            particles[i].draw();
        }

        animationFrameId = requestAnimationFrame(loop);
    }

    loop();
})();
