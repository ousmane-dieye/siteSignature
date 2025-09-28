
  let motDePasse = document.getElementById("mot-de-passe");
  let confirmer = document.getElementById("confirmer-mdp");
  let message = document.getElementById("message");

  // Chaque fois que l'utilisateur tape dans le champ
  confirmer.addEventListener("input", function() {
    if (motDePasse.value === confirmer.value) {
      message.style.color = "green";
      message.textContent = "✅ Les mots de passe correspondent";
    } else {
      message.style.color = "red";
      message.textContent = "❌ Les mots de passe ne correspondent pas";
    }
  });
