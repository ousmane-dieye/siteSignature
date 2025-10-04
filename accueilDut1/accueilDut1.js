// ---------------------------
// Éléments DOM
// ---------------------------
const userNameElement = document.getElementById('user-name');
const signatureCountElement = document.getElementById('signature-count');
const getSignatureBtn = document.getElementById('get-signature-btn');
const signatureModal = document.getElementById('signature-modal');
const closeModalBtn = document.getElementById('close-modal');
const usernameInput = document.getElementById('username-input');
const phoneInput = document.getElementById('phone-input');
const usernameError = document.getElementById('username-error');
const successMessage = document.getElementById('success-message');
const signatureForm = document.getElementById('signature-form');
const themeToggle = document.getElementById('theme-toggle');

// ---------------------------
// Gestion du thème
// ---------------------------
function initTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);
}

function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute('data-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    
    document.documentElement.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon(newTheme);
}

function updateThemeIcon(theme) {
    const icon = themeToggle.querySelector('i');
    if (theme === 'dark') {
        icon.className = 'fas fa-sun';
        themeToggle.title = 'Passer en mode clair';
    } else {
        icon.className = 'fas fa-moon';
        themeToggle.title = 'Passer en mode sombre';
    }
}

// ---------------------------
// Fonctions utilitaires
// ---------------------------
const openSignatureModal = () => {
    signatureModal.style.display = 'flex';
    signatureModal.classList.add('modal-open');
    usernameInput.value = '';
    phoneInput.value = '';
    usernameError.style.display = 'none';
    successMessage.style.display = 'none';
    usernameInput.focus();
};

const closeSignatureModal = () => {
    signatureModal.classList.remove('modal-open');
    setTimeout(() => signatureModal.style.display = 'none', 300); // Laisser l'animation se finir
};

const validateSignatureInfo = (username, telephone) => {
    if (!username || !telephone) {
        return { isValid: false, message: 'Veuillez remplir tous les champs' };
    }

    const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
    if (!phoneRegex.test(telephone)) {
        return { isValid: false, message: 'Format de téléphone invalide' };
    }

    return { isValid: true, message: '' };
};

// ---------------------------
// Soumission du formulaire
// ---------------------------
const handleFormSubmit = async (event) => {
    event.preventDefault();

    const username = usernameInput.value.trim();
    const telephone = phoneInput.value.trim();
    const validation = validateSignatureInfo(username, telephone);

    if (!validation.isValid) {
        usernameError.textContent = validation.message;
        usernameError.style.display = 'block';
        return;
    }

    try {
        const formData = new FormData(signatureForm);
        const response = await fetch('traiter_signature.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.text();

        if (result.startsWith('success:')) {
            usernameError.style.display = 'none';
            successMessage.textContent = result.replace('success:', '');
            successMessage.style.display = 'block';

            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else if (result.startsWith('error:')) {
            usernameError.textContent = result.replace('error:', '');
            usernameError.style.display = 'block';
        }
    } catch (error) {
        console.error('Erreur:', error);
        usernameError.textContent = 'Erreur de connexion';
        usernameError.style.display = 'block';
    }
};

// ---------------------------
// Initialisation
// ---------------------------
function initApp() {
    // Initialiser le thème
    initTheme();

    // Événements
    themeToggle.addEventListener('click', toggleTheme);
    getSignatureBtn.addEventListener('click', openSignatureModal);
    closeModalBtn.addEventListener('click', closeSignatureModal);
    signatureForm.addEventListener('submit', handleFormSubmit);

    window.addEventListener('click', (event) => {
        if (event.target === signatureModal) closeSignatureModal();
    });

    usernameInput.addEventListener('input', () => usernameError.style.display = 'none');
    phoneInput.addEventListener('input', () => usernameError.style.display = 'none');
}

// ---------------------------
// Démarrer l'appli
// ---------------------------
document.addEventListener('DOMContentLoaded', initApp);
