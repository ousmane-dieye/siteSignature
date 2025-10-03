// Éléments DOM
const userNameElement = document.getElementById('user-name');
const signatureCountElement = document.getElementById('signature-count');
const currentSignaturesElement = document.getElementById('current-signatures');
const progressFillElement = document.getElementById('progress-fill');
const getSignatureBtn = document.getElementById('get-signature-btn');
const signatureModal = document.getElementById('signature-modal');
const closeModalBtn = document.getElementById('close-modal');
const usernameInput = document.getElementById('username-input');
const phoneInput = document.getElementById('phone-input');
const usernameError = document.getElementById('username-error');
const successMessage = document.getElementById('success-message');
const signatureForm = document.getElementById('signature-form');

// Ouvrir le modal 
function openSignatureModal() {
    signatureModal.style.display = 'flex';
    usernameInput.value = '';
    phoneInput.value = '';
    usernameError.style.display = 'none';
    successMessage.style.display = 'none';
    usernameInput.focus();
}

// Fermer le modal
function closeSignatureModal() {
    signatureModal.style.display = 'none';
}

// Valider les infos
function validateSignatureInfo(username, telephone) {
    if (username.trim() === '' || telephone.trim() === '') {
        return { isValid: false, message: 'Veuillez remplir tous les champs' };
    }
    
    // Validation du tél
    const phoneRegex = /^[\+]?[0-9\s\-\(\)]{10,}$/;
    if (!phoneRegex.test(telephone)) {
        return { isValid: false, message: 'Format de téléphone invalide' };
    }
    
    return { isValid: true, message: '' };
}

// Traiter la soumission du formulaire
function handleFormSubmit(event) {
    event.preventDefault();
    
    const username = usernameInput.value.trim();
    const telephone = phoneInput.value.trim();
    const validation = validateSignatureInfo(username, telephone);
    
    if (!validation.isValid) {
        usernameError.textContent = validation.message;
        usernameError.style.display = 'block';
        return;
    }
    
    // Soumettre le formulaire via AJAX
    const formData = new FormData(signatureForm);
    
    fetch('traiter_signature.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        if (result.startsWith('success:')) {
            // Signature réussie
            usernameError.style.display = 'none';
            successMessage.textContent = result.replace('success:', '');
            successMessage.style.display = 'block';
            
            // Recharger la page pour mettre à jour les données
            setTimeout(() => {
                window.location.reload();
            }, 2000);
        } else if (result.startsWith('error:')) {
            // Erreur
            usernameError.textContent = result.replace('error:', '');
            usernameError.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        usernameError.textContent = 'Erreur de connexion';
        usernameError.style.display = 'block';
    });
}

// Initialisation
function initApp() {
    // Événements
    getSignatureBtn.addEventListener('click', openSignatureModal);
    closeModalBtn.addEventListener('click', closeSignatureModal);
    signatureForm.addEventListener('submit', handleFormSubmit);
    
    // Fermer le modal en cliquant en dehors
    window.addEventListener('click', (event) => {
        if (event.target === signatureModal) {
            closeSignatureModal();
        }
    });
    
    // Validation 
    usernameInput.addEventListener('input', () => {
        usernameError.style.display = 'none';
    });
    
    phoneInput.addEventListener('input', () => {
        usernameError.style.display = 'none';
    });
}

// Démarrer l'appli
document.addEventListener('DOMContentLoaded', initApp);