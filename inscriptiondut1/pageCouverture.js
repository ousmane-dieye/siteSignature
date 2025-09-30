document.getElementById('start-challenge').addEventListener('click', function() {
            const welcomeContainer = document.querySelector('.welcome-container');
            const coverPage = document.querySelector('.cover-page');
            
            welcomeContainer.style.transform = 'translateX(100vw) scale(0.8)';
            welcomeContainer.style.opacity = '0';
            coverPage.style.opacity = '0';
            
            setTimeout(() => {
                window.location.href = 'inscriptionDut1.html';
            }, 800);
        });