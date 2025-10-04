document.getElementById('start-challenge').addEventListener('click', function() {
    const coverPage = document.querySelector('.cover-page');
    const welcomeContainer = document.querySelector('.welcome-container');


    welcomeContainer.style.transition = 'opacity 0.5s, transform 0.5s';
    welcomeContainer.style.opacity = '0';
    welcomeContainer.style.transform = 'scale(0.8)';

    
    const canvas = document.createElement('canvas');
    canvas.id = 'matrix-canvas';
    document.body.appendChild(canvas);
    const ctx = canvas.getContext('2d');

    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    const fontSize = 16;
    const columns = Math.floor(canvas.width / fontSize);
    const drops = Array(columns).fill(0);

    function drawMatrix() {
        ctx.fillStyle = 'rgba(0, 0, 0, 0.05)'; 
        ctx.fillRect(0, 0, canvas.width, canvas.height);

        ctx.fillStyle = '#0F0';
        ctx.font = fontSize + 'px monospace';

        for (let i = 0; i < drops.length; i++) {
            const text = Math.random() > 0.5 ? '0' : '1';
            ctx.fillText(text, i * fontSize, drops[i] * fontSize);

            if (drops[i] * fontSize > canvas.height && Math.random() > 0.975) {
                drops[i] = 0;
            }
            drops[i]++;
        }
    }

    const matrixInterval = setInterval(drawMatrix, 50);

    
    setTimeout(() => {
        clearInterval(matrixInterval);
        window.location.href= "./inscriptiondut1/inscriptiondut1.html";
    }, 2000);
});
