/**
 * Efek Background: Glowing Fireflies (Kunang-Kunang Berpendar)
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

    const FIREFLY_COUNT = 16;
    const fireflies = [];

    class Firefly {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.size = 1.8 + Math.random() * 2.2;
            this.vx = (Math.random() - 0.5) * 0.6;
            this.vy = (Math.random() - 0.5) * 0.6;
            this.angle = Math.random() * Math.PI * 2;
            this.glow = 0.2 + Math.random() * 0.7;
            this.glowSpeed = 0.02 + Math.random() * 0.03;
            this.glowDir = 1;
        }

        update() {
            this.angle += 0.03;
            this.x += this.vx + Math.cos(this.angle) * 0.3;
            this.y += this.vy + Math.sin(this.angle) * 0.3;

            this.glow += this.glowSpeed * this.glowDir;
            if (this.glow >= 0.95) this.glowDir = -1;
            if (this.glow <= 0.1) this.glowDir = 1;

            if (this.x < -10) this.x = width + 10;
            if (this.x > width + 10) this.x = -10;
            if (this.y < -10) this.y = height + 10;
            if (this.y > height + 10) this.y = -10;
        }

        draw() {
            ctx.save();
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);

            const gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, this.size * 3.5);
            gradient.addColorStop(0, `rgba(230, 255, 120, ${this.glow})`);
            gradient.addColorStop(0.4, `rgba(180, 240, 70, ${this.glow * 0.6})`);
            gradient.addColorStop(1, 'rgba(180, 240, 70, 0)');

            ctx.fillStyle = gradient;
            ctx.shadowColor = 'rgba(210, 255, 80, 0.6)';
            ctx.shadowBlur = 8;
            ctx.fill();
            ctx.restore();
        }
    }

    for (let i = 0; i < FIREFLY_COUNT; i++) {
        fireflies.push(new Firefly());
    }

    function loop() {
        if (!isVisible) return;

        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < fireflies.length; i++) {
            fireflies[i].update();
            fireflies[i].draw();
        }

        animationFrameId = requestAnimationFrame(loop);
    }

    loop();
})();
