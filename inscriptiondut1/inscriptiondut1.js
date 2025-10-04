document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('inscription-form');
    const inputs = form.querySelectorAll('input');
    const fileInput = document.getElementById('photo');
    const fileText = document.querySelector('.file-text');
    const passwordInput = document.getElementById('mot-de-passe');
    const confirmPasswordInput = document.getElementById('confirmer-mdp');

    function showError(input, message) {
        const existingError = input.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        input.classList.remove('input-success');
        input.classList.add('input-error');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
    }
    
    function showSuccess(input) {
        const existingError = input.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        input.classList.remove('input-error');
        input.classList.add('input-success');
    }
    
    function validateRequired(value) {
        return value.trim() !== '';
    }
    
    function validateName(name) {
        const nameRegex = /^[a-zA-ZÀ-ÿ\s\-']+$/;
        return nameRegex.test(name);
    }
    
    function validatePhone(phone) {
        const phoneRegex = /^[0-9]{9,}$/;
        return phoneRegex.test(phone.replace(/\s/g, ''));
    }
    
    function validatePassword(password) {
        if (password.length < 5) {
            return 'too_short';
        }
        if (!/[0-9]/.test(password) || !/[a-zA-Z]/.test(password)) {
            return 'no_letter_number';
        }
        return 'valid';
    }
    
    function validateField(field) {
        const value = field.value.trim();
        
        if (!validateRequired(value)) {
            showError(field, 'Ce champ est obligatoire');
            return false;
        }
        
        switch(field.id) {
            case 'prenom':
            case 'nom':
                if (!validateName(value)) {
                    showError(field, 'Doit contenir seulement des lettres');
                    return false;
                }
                break;
                
            case 'num-tel':
                if (!validatePhone(value)) {
                    showError(field, 'Le numéro doit contenir au moins 9 chiffres');
                    return false;
                }
                break;
                
            case 'mot-de-passe':
                const passwordValidation = validatePassword(value);
                if (passwordValidation === 'too_short') {
                    showError(field, 'Le mot de passe est trop court (min 5 caractères)');
                    return false;
                }
                if (passwordValidation === 'no_letter_number') {
                    showError(field, 'Le mot de passe doit contenir des lettres et des chiffres');
                    return false;
                }
                break;
                
            case 'confirmer-mdp':
                if (value !== passwordInput.value) {
                    showError(field, 'Les mots de passe ne correspondent pas');
                    return false;
                }
                break;
                
            case 'photo':
                if (field.files.length === 0) {
                    showError(field, 'Veuillez sélectionner une photo');
                    return false;
                }
                break;
        }
        
        showSuccess(field);
        return true;
    }
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('input-error')) {
                validateField(this);
            }
        });
    });
    
    passwordInput.addEventListener('input', function() {
        if (confirmPasswordInput.value !== '' && confirmPasswordInput.value !== this.value) {
            showError(confirmPasswordInput, 'Les mots de passe ne correspondent pas');
        } else if (confirmPasswordInput.value !== '' && confirmPasswordInput.value === this.value) {
            showSuccess(confirmPasswordInput);
        }
    });
    
    confirmPasswordInput.addEventListener('input', function() {
        if (this.value !== passwordInput.value) {
            showError(this, 'Les mots de passe ne correspondent pas');
        } else {
            showSuccess(this);
        }
    });
    
    fileInput.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            fileText.textContent = 'Photo sélectionnée';
            validateField(this);
        } else {
            fileText.textContent = 'Veuillez sélectionner une photo';
        }
    });
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let isValid = true;
        inputs.forEach(input => {
            if (!validateField(input)) {
                isValid = false;
            }
        });
        
        if (isValid) {
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Inscription en cours...';
            
            setTimeout(() => {
                alert('Inscription réussie !');
                submitBtn.disabled = false;
                submitBtn.textContent = 'S\'inscrire';
                form.reset();
                fileText.textContent = 'Veuillez sélectionner une photo';
                
                inputs.forEach(input => {
                    input.classList.remove('input-success', 'input-error');
                });
            }, 2000);
        }
    });
});
