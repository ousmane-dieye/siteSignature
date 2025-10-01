const form = document.getElementById("signinForm");

form.addEventListener("submit", function(e) {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const phone = document.getElementById("phone").value.trim();

  if (username === "" || phone === "") {
    alert("Veuillez remplir tous les champs !");
  } else if (!/^[0-9]{8,15}$/.test(phone)) {
    alert("Numéro de téléphone invalide!");
  } else {
    alert("Bienvenue " + username + "");
  }
});