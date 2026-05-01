<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Calm Mouse Flow 🌙</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #0b0f14;
            cursor: none;
            font-family: Arial, sans-serif;
        }

        .title {
            position: absolute;
            top: 20px;
            width: 100%;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
            font-size: 18px;
            letter-spacing: 1px;
        }

        canvas {
            display: block;
        }
    </style>
</head>

<body>

    <div class="title">Move slowly… relax 🌙</div>
    <canvas id="canvas"></canvas>

    <script>
        const canvas = document.getElementById("canvas");
        const ctx = canvas.getContext("2d");

        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        let particles = [];

        window.addEventListener("resize", () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        });

        class Particle {
            constructor(x, y) {
                this.x = x;
                this.y = y;
                this.size = Math.random() * 3 + 1;
                this.speedX = (Math.random() - 0.5) * 1.5;
                this.speedY = (Math.random() - 0.5) * 1.5;
                this.opacity = 0.6;
                this.life = 120;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                this.life--;
                this.opacity -= 0.005;
                this.size *= 0.98;
            }

            draw() {
                ctx.beginPath();
                ctx.fillStyle = `rgba(180, 200, 255, ${this.opacity})`;
                ctx.shadowBlur = 8;
                ctx.shadowColor = "rgba(180, 200, 255, 0.5)";
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fill();
            }
        }

        canvas.addEventListener("mousemove", (e) => {
            for (let i = 0; i < 4; i++) {
                particles.push(new Particle(e.clientX, e.clientY));
            }
        });

        function animate() {
            ctx.fillStyle = "rgba(11, 15, 20, 0.15)";
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            particles.forEach((p, index) => {
                p.update();
                p.draw();

                if (p.life <= 0 || p.opacity <= 0) {
                    particles.splice(index, 1);
                }
            });

            requestAnimationFrame(animate);
        }

        animate();
    </script>

</body>

</html>