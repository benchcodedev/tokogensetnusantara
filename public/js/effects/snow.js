/**
 * Efek Background: Falling Snow (Salju Lembut)
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

    const SNOW_COUNT = 25;
    const flakes = [];

    class Snowflake {
        constructor() {
            this.reset(true);
        }

        reset(initial = false) {
            this.x = Math.random() * width;
            this.y = initial ? Math.random() * height : -10;
            this.radius = 1.0 + Math.random() * 2.5;
            this.speedY = 0.5 + Math.random() * 1.2;
            this.speedX = -0.3 + Math.random() * 0.6;
            this.alpha = 0.4 + Math.random() * 0.5;
        }

        update() {
            this.y += this.speedY;
            this.x += this.speedX;

            if (this.y > height + 10 || this.x < -10 || this.x > width + 10) {
                this.reset();
            }
        }

        draw() {
            ctx.save();
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(255, 255, 255, ${this.alpha})`;
            ctx.fill();
            ctx.restore();
        }
    }

    for (let i = 0; i < SNOW_COUNT; i++) {
        flakes.push(new Snowflake());
    }

    function loop() {
        if (!isVisible) return;

        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < flakes.length; i++) {
            flakes[i].update();
            flakes[i].draw();
        }

        animationFrameId = requestAnimationFrame(loop);
    }

    loop();
})();
